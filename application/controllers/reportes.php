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
class Reportes extends CI_Controller {

    /**
     * Constructor de la clase
     * @access public
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Index page.
     * @access public
     * @param int $id Identificador del Lugar
     */
    public function index() {
        $this->load->view('front_end/reportes/show');
    }

    public function buscar() {

        $paciente = $this->paciente_model->get_by_carnet($this->input->post('carnet'));
        if ($paciente->num_rows() < 1)
            return $this->load->view('front_end/reportes/reporte_no_encontrado', null);
        $row = $paciente->row();
        $cllWhere = isset($row->usuario)?'and paciente.usuario = ' . $row->usuario: null;
        $data['paciente'] = $row;
        $result_db = $this->consulta_model->get_all(100,0,$cllWhere,null);
        $data['consultas'] = $result_db->result_array();
        $cllWhere = isset($row->persona_id) ? 'and persona.persona_id = ' . $row->persona_id : null;
        $result_db = $this->defuncion_model->get_all(100,0,$cllWhere,null);
        $data['defuncion'] = $result_db->row();
        $this->load->view('front_end/reportes/reporte', $data);
        
    }

}

/* End of file fotos.php */
/* Location: ./application/controllers/fotos.php */