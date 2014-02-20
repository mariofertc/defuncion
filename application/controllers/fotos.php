<?php

/**
 * Archivo Controlador Fotos, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Administrador
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once ("secure_area.php");

/**
 * Clase de Fotos
 * 
 * Controlador para manipular las fotografias.
 * @package Administrador
 */
class Fotos extends Secure_area {

    var $gallery_path;
    var $gallery_path_url;

    /**
     * Constructor de la clase
     * @access public
     */
    function __construct() {
        parent::__construct('fotos');
    }

    /**
     * Listado de Fotos.
     * @access public
     * @param int $id Identificador del Lugar
     */
    public function index($id = -1) {
        $data['controller_name'] = strtolower($this->uri->segment(2));
        $data['admin_table'] = get_foto_admin_table();
        $data['form_width'] = $this->get_form_width();
        $data['form_height'] = $this->get_form_height();
        $data['id_lugar'] = $id;
        $this->load->view('fotos/manage', $data);
    }

    public function regresar($id = -1) {
        $lugar = $this->Lugar->get_info($id);
        redirect("lugares/index/$lugar->categoria_id", 'refresh');
    }

    /**
     * Retorna las fotos de acuerdo al identificador del Lugar dado.
     * @param int $id_lugar
     * @access public
     * @return string JSON con los datos de las fotografias.
     */
    function mis_datos($id_lugar) {
        $aColumns = array(
            'id' => array('checked' => true, 'es_mas' => true),
            'nombre' => array('limit' => 13),
            'imagen_path' => array('limit' => 30),
            'descripcion' => array('limit' => 30),
            'orden' => array('limit' => 30)
        );
        //Eventos Tabla
        $cllAccion = array(
            '1' => array(
                'function' => "view",
                'comun_language' => "comun_edit",
                'language' => "_update",
                'width' => $this->get_form_width(),
                'height' => $this->get_form_height(),
                'class' => 'thickbox'));
        $cllWhere = 'id_lugar = ' . $id_lugar;
        echo getData('Foto', $aColumns, $cllAccion, $cllWhere);
    }

    /**
     * Editar o Crear Nueva Foto.
     * @access public
     * @param int $id
     * @param int $lugar_id
     */
    function view($id = -1, $lugar_id = -1) {
        $data['info'] = $this->Foto->get_info($id);
        $data['id_lugar'] = $lugar_id;
        $this->load->view("fotos/form", $data);
    }

    /**
     * Almacena o Edita una Fotografia
     * @param int $id
     * @access public
     * @return string JSON Indicando si se guardo o no.
     */
    function save($id = -1) {
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'orden' => $this->input->post('orden'),
            'descripcion' => $this->input->post('descripcion')
        );

        $post_lugar_id = $this->input->post('lugar_id');
        if ($post_lugar_id != -1)
        //Cuando es new pasamos lugar
            $data['id_lugar'] = $this->input->post('lugar_id');
        else
        //cuando es edit
            $data['id_lugar'] = $this->Foto->get_info($id)->id_lugar;
        $nom_enlace = $this->Lugar->get_info($data['id_lugar'])->nombre_enlace;
        //Cuando es Insert, cuidamos que suba una imagen.
        if ($post_lugar_id != -1 && count($_FILES) == 0) {
            echo json_encode(array('success' => 'fail_upload', 'message' => 'Selecciona una foto para subir al servidor'));
            return;
        }
        if (count($_FILES) == 1 && $id != -1)
            $this->delete_files(array($id));

        //Cuando es Edit, no es necesario actualizar la imagen.
        if (count($_FILES) == 1) {
            //Upload image
            $resp_upload = $this->do_upload($nom_enlace);
            if (gettype($resp_upload) == "string") {
                $resp = array('success' => 'fail_upload', 'message' => 'Error al cargar la foto ' .
                    $data['nombre'] . '. ' . $resp_upload, 'id' => -1);
                echo json_encode($resp);
                return;
            } else {
                $data['imagen_path'] = $resp_upload['file_name'];
            }
        }

        $this->db->trans_start();
        try {
            if ($this->Foto->save($data, $id)) {


                $resp = array();
                //Nuevo lug Insert
                if ($id == -1) {
                    $resp = array('success' => true, 'message' => 'Foto ' .
                        $data['nombre'] . ' almacenada.', 'id' => $data['id']);
                    $id = $data['id'];
                } else { //update incidencia
                    $resp = array('success' => true, 'message' => 'Foto ' .
                        $data['nombre'] . ' actualizada.', 'id' => $id);
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    echo json_encode(array('success' => false, 'Error al actualizar la Fotografía ' .
                        $data['nombre'], 'id' => -1));
                } else {
                    $this->db->trans_commit();
                    echo json_encode($resp);
                }
            } else {//failure
                echo json_encode(array('success' => false, 'message' => 'Error al Actualizar la Fotografía ' .
                    $data['nombre'], 'id' => -1));
            }
        } catch (Exception $e) {
            $this->db->trans_off();
        }
    }

    /**
     * Almacena la Fotografia del Lugar y crea su respectivo thumbnail.
     * @param string $path
     * @return mixed Con el estado del proceso de conversion.
     */
    function do_upload($path) {
        $this->gallery_path = realpath(APPPATH . '../images/imglugar/') . "/" . $path;
        if (!file_exists($this->gallery_path)) {
            mkdir($this->gallery_path, 0777);
        }

        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => $this->gallery_path,
            'max_size' => 2000
        );


        $this->upload->initialize($config);
        if (!$this->upload->do_upload())
            return $this->upload->display_errors();
        $image_data = $this->upload->data();
        if (!file_exists($this->gallery_path . '/thumbs')) {
            mkdir($this->gallery_path . '/thumbs', 0777, true);
        }
        $config = array(
            'source_image' => $image_data['full_path'],
            'new_image' => './images/imglugar/' . $path . '/thumbs',
            'maintain_ratio' => TRUE,
            'width' => 150,
            'height' => 150,
            'image_library' => 'GD2'
        );
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
        $this->image_lib->clear();
        return $image_data;
    }

    function search() {
        
    }

    function suggest() {
        
    }

    /**
     * Elimina los items seleccionados
     * @return string JSON Indicando si se elimino o no el objeto.
     * @access public
     */
    function delete() {
        $data_to_delete = $this->input->post('ids');
        if (!$this->delete_files($data_to_delete)) {
            echo json_encode(array('success' => false, 'message' => $this->lang->line('fotos_cannot_be_deleted')));
            return;
        }
        if ($this->Foto->delete_list($data_to_delete)) {
            echo json_encode(array('success' => true, 'message' => $this->lang->line('fotos_successful_deleted') . ' ' .
                count($data_to_delete) . ' ' . $this->lang->line('fotos_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->lang->line('fotos_cannot_be_deleted')));
        }
    }

    /**
     * Permite eliminar los archivos subidos.
     * @param mixed[] $data_to_delete Array con los datos a borrar.
     * @return boolean
     */
    function delete_files($data_to_delete) {
        $gallery_path = realpath(APPPATH . '../images/imglugar/');
        foreach ($data_to_delete as $id) {
            $foto = $this->Foto->get_info($id);
            $nom_enlace = $this->Lugar->get_info($foto->id_lugar)->nombre_enlace;
            if (!file_exists($gallery_path . '/' . $nom_enlace . '/' . $foto->imagen_path) || !file_exists($gallery_path . '/' . $nom_enlace . '/thumbs/' . $foto->imagen_path))
                return true;
            if (!(unlink($gallery_path . '/' . $nom_enlace . '/' . $foto->imagen_path) && unlink($gallery_path . '/' . $nom_enlace . '/thumbs/' . $foto->imagen_path)))
                return false;
        }
        return true;
    }

    /**
     * Obtiene la fila del datatable.
     * @access public
     * @return string Para actualizar o insertar en el datatable.
     */
    function get_row() {
        $id = $this->input->post('row_id');
        $data_row = get_foto_data_row($this->Foto->get_info($id), $this);
        echo $data_row;
    }

    /**
     * Valor del Ancho de la Forma Modal
     * @access public
     * @return int
     */
    function get_form_width() {
        return 400;
    }

    /**
     * Valor del Alto de la Forma Modal
     * @access public
     * @return int
     */
    function get_form_height() {
        return 330;
    }

}

/* End of file fotos.php */
/* Location: ./application/controllers/fotos.php */