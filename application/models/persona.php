<?php
/**
 * Archivo Modelo Persona, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Modelo
 */
/**
 * Clase de Persona
 * 
 * Modelo para acceder a las Personas.
 * @package Modelo
 */
class Persona extends CI_Model {

    /**
     * Verifica si esta almacenado el item especificado.
     * @param int $persona_id
     * @return boolean
     */
    function exists($persona_id) {
        $this->db->from('persona');
        $this->db->where('persona.persona_id', $persona_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    /**
     * Devuelve los items que coincidan con los parametros dados
     * @param int $num
     * @param int $offset
     * @param string $where
     * @param string $order
     * @return type
     */
    function get_all($num = 0, $offset = 0, $where = null, $order = null) {
        if ($order == null)
            $order = "persona_id";
        $this->db->from('persona');
        if ($where != "")
            $this->db->where($where);
        $this->db->order_by($order);
        $this->db->limit($offset + $num, $offset);

        return $this->db->get();
    }

    /**
     * Sumatoria de Personas almacenados
     * @return type
     */
    function get_total() {
        $this->db->select("count(*) as total");
        $this->db->from("persona");
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Devuelve la informacion de un item en particular
     * @param string $id
     * @return \stdClass
     */
    function get_info($persona_id) {
        $query = $this->db->get_where('persona', array('persona_id' => $persona_id), 1);

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //create object with empty properties.
            $fields = $this->db->list_fields('persona');
            $persona_obj = new stdClass;

            foreach ($fields as $field) {
                $persona_obj->$field = '';
            }

            return $persona_obj;
        }
    }

    /**
     * Inserta o guarda un item
     * @param type $persona_data
     * @param type $persona_id
     * @return boolean
     */
    function save(&$persona_data, $persona_id = false) {
        if (!$persona_id or !$this->exists($persona_id)) {
            if ($this->db->insert('persona', $persona_data)) {
                $persona_data['persona_id'] = $this->db->insert_id();
                return true;
            }

            return false;
        }

        $this->db->where('persona_id', $persona_id);
        return $this->db->update('persona', $persona_data);
    }

    /**
     * Elimina una Persona
     * @param string $person_id
     * @return boolean
     */
    function delete($person_id) {
        return true;
    }

    /**
     * Elimina items deacuerdo a los identificadores dados.
     * @param array $ids
     * @return boolean
     */
    function delete_list($person_ids) {
        return true;
    }

}

/* End of file persona.php */
/* Location: ./application/models/persona.php */