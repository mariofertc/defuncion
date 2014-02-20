<?php

/**
 * Archivo Controlador Comentarios, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Administrador
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once ("secure_area.php");

/**
 * Clase de Comentarios
 * 
 * Controlador para acceder a los Comentarios
 * @package Administrador
 */
class Comentarios extends Secure_area {

    /**
     * Constructor de la clase
     * @access public
     */
    function __construct() {
        parent::__construct('comentarios');
    }

    /**
     * Listado de Comentarios.
     * @access public
     */
    public function index() {
        $data['controller_name'] = strtolower($this->uri->segment(1));
        $data['admin_table'] = get_comentario_admin_table();
        $data['form_width'] = $this->get_form_width();
        $data['form_height'] = $this->get_form_height();
        $this->load->view('comentario/manage', $data);
    }

    /**
     * Retorna los comentarios.
     * @access public
     * @return string JSON con los datos de los comentarios
     */
    function mis_datos() {
        $aColumns = array(
            'id' => array('checked' => true, 'es_mas' => true),
            'nombre_comentario' => array('limit' => 13),
            'titulo' => array('limit' => 30),
            'email' => array('limit' => 30));
        //Eventos Tabla
        $cllAccion = array(
            '1' => array(
                'function' => "view",
                'comun_language' => "comun_edit",
                'language' => "_update",
                'width' => $this->get_form_width(),
                'height' => $this->get_form_height(),
                'class' => 'thickbox')
        );
        echo getData('Comentario', $aColumns, $cllAccion, null);
    }

    /**
     * Editar o Crear Nuevo Comentario.
     * @access public
     * @param type $id
     * @param type $categoria_id
     */
    function view($id = -1, $categoria_id = -1) {
        //echo $categoria_id . $id;
        $data['info'] = $this->Comentario->get_info($id);
        $this->load->view("comentario/form", $data);
    }

    /**
     * Almacena el Comentario
     * @param int $id
     * @access public
     * @return string JSON Indicando si se guardo o no.
     */
    function save($id = -1) {
        $coordenadas = json_encode(array('latitud' => $this->input->post('latitud'), 'longitud' => $this->input->post('longitud')));

        $data = array(
            'nombre' => $this->input->post('lugar'),
            'direccion' => $this->input->post('direccion'),
            'coordenadas' => $coordenadas,
            'descripcion' => $this->input->post('descripcion'),
            'interes' => $this->input->post('interes'),
            'sector' => $this->input->post('sector'),
            'nombre_enlace' => $this->input->post('enlace'),
            'fecha_actualizacion' => date('Y-m-d h:i:s')
        );
//        echo json_encode(array('success' => false, 'message' => $_FILES['userfile']));
//        return;

        if (isset($_FILES['userfile'])) {
            //Subir Imagenes
            $resp_upload = $this->do_upload($this->input->post('enlace'));
            if (gettype($resp_upload) == "string") {
                $resp = array('success' => 'fail_upload', 'message' => 'Error al cargar la foto ' .
                    $data['nombre'] . '. ' . $resp_upload, 'id' => -1);
                echo json_encode($resp);
                return;
            } else {
                $data['imagen_path'] = $resp_upload['file_name'];
            }
        }

        if ($this->input->post('categoria_id') != -1)
            $data['categoria_id'] = $this->input->post('categoria_id');
        $this->db->trans_start();
        try {
            if ($this->Lugar->save($data, $id)) {
                //Nuevo lug Insert
                if ($id == -1) {
                    echo json_encode(array('success' => true, 'message' => 'Lugar ' .
                        $data['nombre'] . ' creado.', 'id' => $data['id']));
                    $id = $data['id'];
                } else { //update incidencia
                    echo json_encode(array('success' => true, 'message' => 'Lugar ' .
                        $data['nombre'] . ' actualizado.', 'id' => $id));
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    echo json_encode(array('success' => false, 'message' => 'Error al actualizar el Lugar ' .
                        $data['nombre'], 'id' => -1));
                } else {
                    $this->db->trans_commit();
                }
            } else {//failure
                echo json_encode(array('success' => false, 'message' => 'Error al Actualizar el Lugar ' .
                    $data['nombre'], 'id' => -1));
            }
        } catch (Exception $e) {
            $this->db->trans_off();
        }
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
        if ($this->Comentario->delete_list($data_to_delete)) {
            echo json_encode(array('success' => true, 'message' => $this->lang->line('lugares_successful_deleted') . ' ' .
                count($data_to_delete) . ' ' . $this->lang->line('lugares_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->lang->line('lugares_cannot_be_deleted')));
        }
    }

    /**
     * Obtiene la fila del datatable.
     * @access public
     * @return string Para actualizar o insertar en el datatable.
     */
    function get_row() {
        $id = $this->input->post('row_id');
        $data_row = get_lugar_data_row($this->Lugar->get_info($id), $this);
        echo $data_row;
    }

    /**
     * Valor del Ancho de la Forma Modal
     * @access public
     * @return int
     */
    function get_form_width() {
        return 380;
    }

    /**
     * Valor del Alto de la Forma Modal
     * @access public
     * @return int
     */
    function get_form_height() {
        return 300;
    }
}

/* End of file comentarios.php */
/* Location: ./application/controllers/comentarios.php */