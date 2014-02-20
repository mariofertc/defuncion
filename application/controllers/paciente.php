<?php

/**
 * Archivo Controlador Empleados, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Administrador
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once ("persona_controller.php");

/**
 * Clase de Empleados
 * 
 * Controlador para manipular a los Usuarios.
 * @package Administrador
 */
class Paciente extends Persona_controller {

    /**
     * Constructor de la clase
     * @access public
     */
    function __construct() {
        parent::__construct('paciente');
    }

    /**
     * Listado de Empleados.
     * @access public
     */
    function index() {
        $data['controller_name'] = strtolower($this->uri->segment(1));
        $data['admin_table'] = get_persona_admin_table();
        $data['form_width'] = $this->get_form_width();
        $data['form_height'] = $this->get_form_height();
        $this->load->view('personas/manage', $data);
    }

    function search() {
        
    }

    function suggest() {
        
    }

    /**
     * Editar o Crear Nuevo Empleado.
     * @access public
     * @param type $empleado_id
     */
    function view($empleado_id = -1) {
        $empleado_id = $this->input->get('id');
        $data['persona_info'] = $this->paciente_model->get_info($empleado_id);
        $data['all_modulos'] = $this->Modulo->get_all_modules();
        $this->load->view("paciente/form", $data);
    }

    /**
     * Retorna los empleado.
     * @access public
     * @return string JSON con los datos de los empleados
     */
    function mis_datos() {
        $aColumns = array(
            'persona_id' => array('checked' => true, 'es_mas' => true),
            'nombre' => array('limit' => 13),
            'apellido' => array('limit' => 30),
            'email' => array('limit' => 15),
            'telefono' => array('limit' => 15)
        );
        //Eventos Tabla
        $cllAccion = array(
            '0' => array(
                'function' => "view",
                'comun_language' => "comun_edit",
                'language' => "_update",
                'width' => $this->get_form_width(),
                'height' => $this->get_form_height(),
                'class' => 'thickbox'),
            '1' => array(
//                'function' => "../consulta",
                'function' => "consulta",
                'comun_language' => "comun_edit",
                'language' => "_update",
                'width' => $this->get_form_width(),
                'height' => $this->get_form_height(),
                'class' => 'boton_admin'),
            );
        echo getData('paciente_model', $aColumns, $cllAccion);
    }
    
    function consulta()
    {
//        redirect("consulta", "index?id=$id_paciente");
        $id_paciente = $this->input->get('id', TRUE);
//        die($id_paciente);
        redirect("consulta/index/$id_paciente");
    }

    /**
     * Almacena o Edita un Empleado
     * @param int $id
     * @access public
     * @return string JSON Indicando si se guardo o no.
     */
    function save($id = -1) {
        $persona_data = array(
            'nombre' => $this->input->post('nombre'),
            'apellido' => $this->input->post('apellido'),
            'email' => $this->input->post('email'),
            'telefono' => $this->input->post('telefono'),
            'direccion' => $this->input->post('direccion'),
            'ciudad' => $this->input->post('ciudad'),
            'pais' => $this->input->post('pais'),
            'comentarios' => $this->input->post('comentarios')
        );
        $empleado_data = array('usuario' => $this->input->post('usuario'));
        if ($this->paciente_model->save($persona_data, $empleado_data, $permiso_data, $id)) {
            //New employee
            if ($id == -1) {
                echo json_encode(array('success' => true, 'message' => $this->lang->line('empelados_successful_adding') . ' ' .
                    $persona_data['nombre'] . ' ' . $persona_data['apellido'], 'persona_id' => $empleado_data['persona_id']));
            } else { //previous employee
                echo json_encode(array('success' => true, 'message' => $this->lang->line('empelados_successful_updating') . ' ' .
                    $persona_data['nombre'] . ' ' . $persona_data['apellido'], 'persona_id' => $id));
            }
        } else {//failure
            echo json_encode(array('success' => false, 'message' => $this->lang->line('empelados_error_adding_updating') . ' ' .
                $persona_data['nombre'] . ' ' . $persona_data['apellido'], 'persona_id' => -1));
        }
    }

    /**
     * Elimina los items seleccionados
     * @return string JSON Indicando si se elimino o no el objeto.
     * @access public
     */
    function delete() {
        $empelados_to_delete = $this->input->post('ids');

        if ($_SERVER['HTTP_HOST'] == 'demo.phppointofsale.com' && in_array(1, $empelados_to_delete)) {
            //failure
            echo json_encode(array('success' => false, 'message' => $this->lang->line('empelados_error_deleting_demo_admin')));
        } elseif ($this->paciente_model->delete_list($empelados_to_delete)) {
            echo json_encode(array('success' => true, 'message' => $this->lang->line('empelados_successful_deleted') . ' ' .
                count($empelados_to_delete) . ' ' . $this->lang->line('empelados_one_or_multiple')));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->lang->line('empelados_cannot_be_deleted')));
        }
    }

    /**
     * Display form: Import data from an excel file
     * @author: Nguyen OJB, Mario T.
     * @since: 10.1
     */
    function excel_import() {
        $this->load->view("empelados/excel_import", null);
    }

    /**
     * Read data from excel file -> save it to databse
     * @author: Nguyen OJB, Mario T.
     * @since: 10.1
     */
    function do_excel_import() {
        $msg = "do_excel_import";
        $failCodes = null;
        $successCode = null;
        if ($_FILES['file_path']['error'] != UPLOAD_ERR_OK) {
            $msg = $this->lang->line('items_excel_import_failed');
            echo json_encode(array('success' => false, 'message' => $msg));
            return;
        } else {
            try {
                $this->load->library('spreadsheetexcelreader');
                $this->spreadsheetexcelreader->store_extended_info = false;
                $success = $this->spreadsheetexcelreader->read($_FILES['file_path']['tmp_name']);

                $rowCount = $this->spreadsheetexcelreader->rowcount(0);
                if ($rowCount > 2) {
                    for ($i = 3; $i <= $rowCount; $i++) {
                        $user_name = $this->spreadsheetexcelreader->val($i, 'A');
                        $id = $this->Employee->get_employee_id($user_name);
                        if ($id <> false) {
                            $failCodes[] = $this->spreadsheetexcelreader->val($i, 'A');
                            continue;
                        }
                        $employee_data = array(
                            'username' => $user_name,
                            'password' => md5($this->spreadsheetexcelreader->val($i, 'B'))
                        );
                        $person_data = array(
                            'first_name' => $this->spreadsheetexcelreader->val($i, 'C'),
                            'last_name' => $this->spreadsheetexcelreader->val($i, 'D'),
                            'phone_number' => $this->spreadsheetexcelreader->val($i, 'E'),
                            'email' => $this->spreadsheetexcelreader->val($i, 'F'),
                            'address_1' => $this->spreadsheetexcelreader->val($i, 'G'),
                            'address_2' => $this->spreadsheetexcelreader->val($i, 'H'),
                            'city' => $this->spreadsheetexcelreader->val($i, 'I'),
                            'state' => $this->spreadsheetexcelreader->val($i, 'J'),
                            'zip' => $this->spreadsheetexcelreader->val($i, 'K'),
                            'country' => $this->spreadsheetexcelreader->val($i, 'L'),
                            'comments' => $this->spreadsheetexcelreader->val($i, 'M')
                        );
                        $permissions = null;
                        if ($this->Employee->save($person_data, $employee_data, $permissions, false)) {
                            
                        } else {//insert or update item failure
                            $failCodes[] = $this->spreadsheetexcelreader->val($i, 'A');
                            //echo json_encode( array('success'=>true,'message'=>'Your upload file has no data or not in supported format.') );
                        }
                    }
                } else {
                    // rowCount < 2
                    echo json_encode(array('success' => true, 'message' => 'Your upload file has no data or not in supported format.'));
                    return;
                }
            } catch (Exception $e) {
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
                // echo json_encode( array('success'=>false,'message'=>$e->getMessage()) );
                echo json_encode(array('success' => false, 'message' => 'vamos'));
            }
        }

        $success = true;
        if (count($failCodes) > 1) {
            $msg = "Most suppliers imported. But some were not, here is list of their CODE (" . count($failCodes) . "): " . implode(", ", $failCodes);
            $success = false;
        } else {
            $msg = "Import suppliers successful";
        }

        echo json_encode(array('success' => $success, 'message' => $msg));
    }

    /**
     * Valor del Ancho de la Forma Modal
     * @access public
     * @return int
     */
    function get_form_width() {
        return 650;
    }

    /**
     * Valor del Alto de la Forma Modal
     * @access public
     * @return int
     */
    function get_form_height() {
        return 400;
    }

}

/* End of file empleados.php */
/* Location: ./application/controllers/empleados.php */