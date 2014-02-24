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
     * Verifica si esta almacenado el item especificado.
     * @param int $persona_id
     * @return boolean
     */
    function exists_inter($accidente_id, $defuncion_id) {
        $this->db->from('defuncion_accidente');
        $this->db->where('defuncion_id', $defuncion_id);
        $this->db->where('accidente_id', $accidente_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }
    /**
     * Eliminta el item especificado.
     * @param int $persona_id
     * @return boolean
     */
    function delete_inter($defuncion_id) {
        $this->db->where('defuncion_id', $defuncion_id);
        $query = $this->db->delete('defuncion_accidente');

        return ($query);
    }

    /**
     * Almacena los items que coincidan con los parametros dados
     * @return type
     */
    function save_inter($accidente_id, $defuncion_id) {
        if (!$this->exists_inter($accidente_id, $defuncion_id)) {
            //$empleado_data['persona_id'] = $empleado_id = $persona_data['persona_id'];
            $success = $this->db->insert('defuncion_accidente', array('defuncion_id'=>(int)$defuncion_id,'accidente_id'=>(int)$accidente_id));
        }
        return;
    }

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
    function get_all_inter($id) {

        $this->db->select('accidente.id, accidente.nombre as nombre FROM defuncion, accidente,defuncion_accidente where defuncion.id = defuncion_accidente.defuncion_id and defuncion_accidente.accidente_id=accidente.id and defuncion.id = '.$id);
        $this->db->order_by('id');
        $db = $this->db->get();
        return $db;
    }

}

/* End of file empleado.php */
/* Location: ./application/models/empleado.php */