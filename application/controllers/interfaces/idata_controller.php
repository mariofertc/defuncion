<?php

/**
 * Archivo Interfaz idata_controller, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Interfaz
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Interfaz de Controlador Archivo, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Interfaz
 */

/**
  Interfaz de controladores para formularios.
 */
interface iData_controller {

    public function index();

    public function search();

    public function suggest();

    public function get_row();

    public function view($data_item_id = -1);

    public function save($data_item_id = -1);

    public function delete();

    public function get_form_width();
}

/* End of file iData_controller.php */
/* Location: ./application/controllers/interfaces/iData_controller.php */