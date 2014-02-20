<?php

/**
 * Archivo Modelo Empleado, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Modelo
 */

/**
 * Clase de Consulta
 * 
 * Modelo para acceder a los Usuarios.
 * @package Modelo
 */
class Accidente_model extends CI_Model {

  
    /**
     * Devuelve los items que coincidan con los parametros dados
     * @return type
     */
    function get_all() {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('accidente');
        return $query;
    }
  
    /**
     * Devuelve los items que coincidan con los parametros dados
     * @return type
     */
    function get_all_inter() {

        $this->db->select('accidente.id, accidente.nombre as nombre FROM paciente, persona,accidente,paciente_accidente where persona.persona_id = paciente.persona_id and paciente.persona_id = paciente_accidente.paciente_id and paciente_accidente.accidente_id=accidente.id ');
        $this->db->order_by('id');
        $db = $this->db->get();
        return $db;
    }
}

/* End of file empleado.php */
/* Location: ./application/models/empleado.php */