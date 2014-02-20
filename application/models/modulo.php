<?php

/**
 * Archivo Modelo Modulo, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Modelo
 */

/**
 * Clase de Modulo
 * 
 * Modelo para acceder a los Modulos del Sistema.
 * @package Modelo
 */
class Modulo extends CI_Model {

    /**
     * Devuelve el Nombre del Modulo
     * @param int $modulo_id
     * @return string
     */
    function get_modulo_nombre($modulo_id) {
        $query = $this->db->get_where('modulo', array('modulo_id' => $modulo_id), 1);

        if ($query->num_rows() == 1) {
            $row = $query->row();
            return $this->lang->line($row->name_lang_key);
        }

        return $this->lang->line('error_desconocido');
    }

    /**
     * Devuelve la Descripcion del Modulo
     * @param int $module_id
     * @return string
     */
    function get_module_desc($module_id) {
        $query = $this->db->get_where('modules', array('module_id' => $module_id), 1);
        if ($query->num_rows() == 1) {
            $row = $query->row();
            return $this->lang->line($row->desc_lang_key);
        }

        return $this->lang->line('error_unknown');
    }

    /**
     * Devuelve todos los items almacenados.
     * @return type
     */
    function get_all_modules() {
        $this->db->from('modulo');
        $this->db->order_by("orden", "asc");
        return $this->db->get();
    }

    /**
     * Devuelve todos los modulos a los que la persona tiene acceso.
     * @return type
     * @param string $person_id Identificador de la Persona
     */
    function get_allowed_modulos($person_id) {
        $this->db->from('modulo');
        $this->db->join('permiso', 'permiso.modulo_id=modulo.modulo_id');
        $this->db->where("permiso.persona_id", $person_id);
        $this->db->order_by("orden", "asc");
        return $this->db->get();
    }

}

/* End of file modulo.php */
/* Location: ./application/models/modulo.php */