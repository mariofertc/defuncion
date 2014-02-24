<?php

/**
 * Archivo Controlador Categorias, AmbatoSystem 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Administrador
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once ("persona_controller.php");

/**
 * Clase de Categorias
 * 
 * Controlador para acceder a las Categorías.
 * @package Administrador
 */
class Centro_salud extends Secure_area {

    /**
     * Constructor de la clase
     * @access public
     */
    function __construct() {
        parent::__construct('centro_salud');
    }

    /**
     * Listado de Categorías, CRUD.
     * @access public
     */
    public function index() {
        $data['controller_name'] = strtolower($this->uri->segment(1));
        $data['admin_table'] = get_centro_salud_admin_table();
        $data['form_width'] = $this->get_form_width();
        $data['form_height'] = $this->get_form_height();
        //$this->output->enable_profiler(TRUE);
        $this->load->view('centro_salud/manage', $data);
    }

    /**
     * Obtiene los datos formateados para el datatable.
     * @access public
     * @return string JSON que permite cargar los datos.
     */
    function mis_datos() {
        $aColumns = array(
            'id' => array('checked' => true, 'es_mas' => true),
            'nombre' => array('limit' => 13),
            'descripcion' => array('limit' => 30),
            'order' => array('limit' => 3));
        //Eventos Tabla
        $cllAccion = array(
            '1' => array(
                'function' => "view",
                'comun_language' => "comun_edit",
                'language' => "_update",
                'width' => $this->get_form_width(),
                'height' => $this->get_form_height(),
                'class' => 'thickbox'),
            '2' => array('function' => "../doctor",
                'comun_language' => "doctor_doctores",
                'language' => "_muestra",
                'height' => 200,
                'class' => "boton_admin"));
        echo getData('centro_salud_model', $aColumns, $cllAccion);
    }

    /**
     * Redirige a los lugares de la categoria.
     * @access public
     * @param int $id Identificador de la categoria.
     */
    function lugares($id = -1) {
        if ($id == -1)
            return;
        redirect('lugares/index/' . $id);
        $this->Lugares->index($id);
    }

    /**
     * Editar o Crear Nueva Categoria.
     * @access public
     * @param type $id
     */
    function view($id = -1) {
        $id = $this->input->get('id');
        $data['info'] = $this->centro_salud_model->get_info($id);
        $this->load->view("centro_salud/form", $data);
    }

    /**
     * Almacena la Categoria
     * @param int $id
     * @access public
     * @return string JSON Indicando si se guardo o no.
     */
    function save($id = -1) {
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('direccion'),
            'order' => $this->input->post('order')
        );
        $this->db->trans_start();
        try {
            if ($this->centro_salud_model->save($data, $id)) {
                //Nueva Cat Insert
                if ($id == -1) {
                    echo json_encode(array('success' => true, 'message' => 'Categoria ' .
                        $data['nombre'] . ' creada.', 'id' => $data['id']));
                    $id = $data['id'];
                } else { //update incidencia
                    echo json_encode(array('success' => true, 'message' => 'Categoría ' .
                        $data['nombre'] . ' actualizada.', 'id' => $id));
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    echo json_encode(array('success' => false, 'Error al actualizar la  Categoría ' .
                        $data['nombre'], 'id' => -1));
                } else {
                    $this->db->trans_commit();
                }
            } else {//failure
                echo json_encode(array('success' => false, 'message' => 'Error al Actualizar la Categoría ' .
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
        if ($this->centro_salud_model->delete_list($data_to_delete)) {
            echo json_encode(array('success' => true, 'message' => $this->lang->line('categorias_successful_deleted') . ' ' .
                count($data_to_delete) . ' ' . $this->lang->line('categorias_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->lang->line('categorias_cannot_be_deleted')));
        }
    }

    function mailto() {
        
    }

    /**
     * Obtiene la fila del datatable.
     * @access public
     * @return string Para actualizar o insertar en el datatable.
     */
    function get_row() {
        $id = $this->input->post('row_id');
        $data_row = get_centro_salud_data_row($this->centro_salud_model->get_info($id), $this);
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
        return 360;
    }

}

/* End of file categorias.php */
/* Location: ./application/controllers/categorias.php */