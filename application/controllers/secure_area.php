<?php

/**
 * Archivo Controlador Secure_Area, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package secure_area
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Seguridad para el Sistema de Administración.
 * 
 * Los controladores que desean tener seguridad deben extender la Clase Secure_area
 * @package Secure_Area
 */
class Secure_area extends CI_Controller {

    /**
     * Constructor
     * @param string $module_id: Identificador del módulo.
     * @access public
     */
    function __construct($module_id = null) {
        parent::__construct();
        //Si no esta loggein, le ponemos usuario invitado
        if (!$this->Empleado->is_logged_in()) {
            redirect('login');
        }

        if (!$this->Empleado->has_permission($module_id, $this->Empleado->get_logged_in_empleado_info()->persona_id)) {
            redirect('sin_acceso/' . $module_id);
        }
        //load up global data
        $logged_in_empleado_info = $this->Empleado->get_logged_in_empleado_info();
        $data['allowed_modules'] = $this->Modulo->get_allowed_modulos($logged_in_empleado_info->persona_id);
        $data['user_info'] = $logged_in_empleado_info;
        $this->load->vars($data);
    }

}

/* End of file Secure_area.php */
/* Location: ./application/controllers/Secure_area.php */