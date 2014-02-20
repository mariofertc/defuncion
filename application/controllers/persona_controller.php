<?php

/**
 * Archivo Controlador persona_controller, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Administrador
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once ("interfaces/ipersona_controller.php");
require_once ("secure_area.php");

/**
 * Clase de Persona_controller
 * 
 * Controlador para manipular Personas
 * @package Administrador
 */
abstract class Persona_controller extends Secure_area implements iPersona_controller {

    /**
     * Constructor de la clase
     * @access public
     */
    function __construct($module_id = null) {
        parent::__construct($module_id);
    }

    /**
     * Retorna el enlace del emial a la persona con el Identificador. Ajax Call
     * @access public
     * @return string Con el enlace
     */
    function mailto() {
        $people_to_email = $this->input->post('ids');

        if ($people_to_email != false) {
            $mailto_url = 'mailto:';
            foreach ($this->Person->get_multiple_info($people_to_email)->result() as $person) {
                $mailto_url.=$person->email . ',';
            }
            //remove last comma
            $mailto_url = substr($mailto_url, 0, strlen($mailto_url) - 1);

            echo $mailto_url;
            exit;
        }
        echo '#';
    }

    /**
     * Coje una fila para el datatable.
     * @return string Estructura HTML "<tr>" para el datatable.
     */
    function get_row() {
        $person_id = $this->input->post('row_id');
        $data_row = get_persona_data_row($this->Persona->get_info($person_id), $this);
        echo $data_row;
    }

}

/* End of file persona_controller.php */
/* Location: ./application/controllers/persona_controller.php */