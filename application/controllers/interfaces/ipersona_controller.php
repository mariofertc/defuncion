<?php
/**
 * Archivo Interfaz ipersona_controller, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Interfaz
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Interfaz de Personas Archivo, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Interfaz
 */
/**
 * Include de la Interfaz idata_controller
 */
require_once("idata_controller.php");

/**
 * Interfaz de personas.
 */
interface iPersona_controller extends iData_controller {

    public function mailto();
}

/* End of file iPersona_controller.php */
/* Location: ./application/controllers/interfaces/iPersona_controller.php */