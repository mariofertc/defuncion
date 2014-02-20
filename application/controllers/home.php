<?php

/**
 * Archivo Controlador Home, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Administrador
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once ("secure_area.php");

/**
 * Clase Home
 * 
 * Controlador Inicial del BackEnd del Sitio.
 * @package Administrador
 */
class Home extends Secure_area {

    /**
     * Constructor de la clase
     * @access public
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Inicio del Modulo de Administracion.
     * @access public
     */
    function index() {
        $this->load->view("home");
    }

    /**
     * Cierra la sesion en el Administrador
     * @access public
     */
    function logout() {
        $this->Empleado->logout();
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */