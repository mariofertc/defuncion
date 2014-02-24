<?php

/**
 * Archivo Controlador Lugares, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Administrador
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once ("persona_controller.php");

/**
 * Clase de Lugares
 * 
 * Controlador para manipular los Lugares
 * @package Administrador
 */
class Defuncion extends Secure_area {

    /**
     * Constructor de la clase
     * @access public
     */
    function __construct() {
        parent::__construct('defuncion');
    }

    /**
     * Listado de Lugares.
     * @access public
     * @param int $id Identificador de la Categoria
     */
    public function index($id = -1) {

        $data['controller_name'] = strtolower($this->uri->segment(1));
        $data['admin_table'] = get_defuncion_admin_table();
        $data['form_width'] = $this->get_form_width();
        $data['form_height'] = $this->get_form_height();
        $data['id_item'] = $id;
//        var_dump($data);
//        die($data);
        $this->load->view('defuncion/manage', $data);
    }

    /**
     * Retorna los lugares de acuerdo al identificador de la categoria dado.
     * @param int $id_categoria
     * @access public
     * @return string JSON con los datos de los lugares
     */
    function mis_datos($id_paciente = null) {
        $aColumns = array(
            'id' => array('checked' => true, 'es_mas' => true),
            'observaciones' => array('limit' => 13),
            'motivo' => array('limit' => 30),
            'fecha_actualizacion' => array('limit' => 30));
        //Eventos Tabla
        $cllAccion = array(
            '1' => array(
                'function' => "view",
                'comun_language' => "comun_edit",
                'language' => "_update",
                'width' => $this->get_form_width(),
                'height' => $this->get_form_height(),
                'class' => 'thickbox'));
        $cllWhere = isset($id_paciente) ? 'and persona.persona_id = ' . $id_paciente : null;
        echo getData('defuncion_model', $aColumns, $cllAccion, $cllWhere);
    }

    /**
     * Editar o Crear Nuevo Lugar.
     * @access public
     * @param int $id
     * @param int $categoria_id
     */
    function view($id = -1, $paciente_id = -1) {
        $id = $this->input->get('id');
        $data['info'] = $this->defuncion_model->get_info($id);
        $doctores = $this->doctor_model->get_all();
        $data['doctor'] = -1;
        foreach ($doctores->result_array() as $doctor) {
            $data['doctores'][$doctor['id']] = $doctor['nombre'];
            if ($doctor['id'] == $data['info']->doctor_id)
                $data['doctor'] = $doctor['id'];
        }
        //Accidentes
        $accidentes = $this->accidente_model->get_all();
        foreach ($accidentes->result_array() as $accidente) {
            $data['accidentes'][$accidente['id']] = $accidente['nombre'];
        }

        $accidentes_inter = $this->accidente_model->get_all_inter($id);
        $data['accidente_db'] = array();
        foreach ($accidentes_inter->result_array() as $accidente_inter) {
            $data['accidente_db'][] = $accidente_inter['id'];
//            $data['accidente_db'][$accidente_inter['id']] = $accidente_inter['nombre'];
        }
//        var_dump($data);

        $data['paciente_id'] = $paciente_id;
        $this->load->view("defuncion/form", $data);
    }

    /**
     * Almacena o Edita un Lugar
     * @param int $id
     * @access public
     * @return string JSON Indicando si se guardo o no.
     */
    function save($id = -1, $paciente_id = -1) {
        $data = array(
            'motivo' => $this->input->post('motivo'),
            'observaciones' => $this->input->post('observaciones'),
            'aliento_etilico' => 1,
            'valor_alcochek' => $this->input->post('valor_alcochek'),
            'factores_agravantes' => $this->input->post('factores_agravantes'),
            'doctor_id' => $this->input->post('doctor'),
            'fecha_actualizacion' => date('Y-m-d h:i:s')
        );
        $this->db->trans_start();
        try {
            if ($this->defuncion_model->save($data, $id)) {
                //Nuevo lug Insert
                if ($id == -1) {
                    echo json_encode(array('success' => true, 'message' => 'Item ' .
                        $data['motivo'] . ' creado.', 'id' => $data['id']));
                    $id = $data['id'];
                } else { //update incidencia
                    echo json_encode(array('success' => true, 'message' => 'Item ' .
                        $data['motivo'] . ' actualizado.', 'id' => $id));
                }
                $accidentes = $this->input->post('accidente');
//        if ($this->input->post('paciente_id') != -1 && $this->input->post('paciente_id'))
//                if ($this->input->post('paciente_id'))
//                    $paciente_id = $this->input->post('paciente_id');
                $this->accidente_model->delete_inter($id);
                if ($accidentes)
                    foreach ($accidentes as $accidente) {
                        $this->accidente_model->save_inter($accidente, $id);
                    }
                $data_inter = array(
                    'paciente_id' => $this->input->post('paciente_id'),
                    'accidente_id' => $this->input->post('accidente')
                );

                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    echo json_encode(array('success' => false, 'message' => 'Error al actualizar el Doctor ' .
                        $data['motivo'], 'id' => -1));
                } else {
                    $this->db->trans_commit();
                }
            } else {//failure
                echo json_encode(array('success' => false, 'message' => 'Error al Actualizar el Doctor ' .
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
        if ($this->Lugar->delete_list($data_to_delete)) {
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
        $data_row = get_defuncion_data_row($this->defuncion_model->get_info($id), $this);
        echo $data_row;
    }

    /**
     * Valor del Ancho de la Forma Modal
     * @access public
     * @return int
     */
    function get_form_width() {
        return 900;
    }

    /**
     * Valor del Alto de la Forma Modal
     * @access public
     * @return int
     */
    function get_form_height() {
        return 380;
    }

    /**
     * Almacena la Fotografia del Lugar.
     * @param string $path
     * @return mixed Con el estado del proceso de conversion.
     */
    function do_upload($path) {
        $this->gallery_path = realpath(APPPATH . '../images/imglugar/') . '/' . $path;
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
        return $this->upload->data();
    }

}

/* End of file lugares.php */
/* Location: ./application/controllers/lugares.php */