<?php

/**
 * Archivo Modelo Voto, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Modelo
 */

/**
 * Clase de Voto
 * 
 * Modelo para acceder a las Votaciones.
 * @package Modelo
 */
class Voto extends CI_Model {

    /**
     * Sumatoria de votos por lugar
     * @param type $lugar_id
     * @return type
     */
    function get_total($lugar_id) {
        $this->db->select("count(*) as total");
        $this->db->from("votacion");
        $this->db->where("id_lugar", $lugar_id);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Inserta o guarda un item
     * @param type $data
     * @param type $id
     * @return boolean
     */
    function save(&$data, $id = false) {
        if ($this->db->insert('votacion', $data)) {
            $data['id'] = $this->db->insert_id();
            return true;
        }
        return false;
    }

}

/* End of file voto.php */
/* Location: ./application/models/mobil/voto.php */