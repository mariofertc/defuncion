<?php

/**
 * Archivo Modelo Lugar, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Modelo
 */

/**
 * Clase de Lugar
 * 
 * Modelo para acceder a los Lugares.
 * @package Modelo
 */
class Doctor_model extends Persona {

    var $title = '';
    var $content = '';
    var $date = '';

    /**
     * Devuelve lista de Lugares por la Categoria dada.
     * @param int $categoria_id
     * @return null|array
     */
    function get_by_centro_salud($categoria_id = null) {
        if ($categoria_id == null)
            return null;
        $this->db->where('categoria_id', $categoria_id);
        $this->db->from('doctor');
        $this->db->where('deleted', 0);
        $query = $this->db->get();

        return $query;
    }

    /**
     * Lista de Fotografias del Lugar.
     * @param int $lugar_id
     * @return null
     */
    function get_pacientes($lugar_id = null) {
        if ($lugar_id == null)
            return null;
        $this->db->where('id_lugar', $lugar_id);
        $this->db->where('deleted', 0);
        $this->db->from('fotos');
        $this->db->order_by('orden');
//        $this->db->limit(10);
        $query = $this->db->get();

        return $query;
    }

    /**
     * Devuelve los items que coincidan con los parametros dados
     * @param int $num
     * @param int $offset
     * @param string $where
     * @param string $order
     * @return type
     */
    function get_all($num = 100, $offset = 0, $where=null, $order = null) {
        if ($order == null)
            $order = "id";
        $this->db->from('doctor');
        if ($where != "")
            $this->db->where($where);
        $this->db->where('deleted', 0);
        $this->db->order_by($order);
        $this->db->limit($offset + $num, $offset);

        return $this->db->get();
    }

    /**
     * Sumatoria de Lugares almacenados
     * @param string $where
     * @return type
     */
    function get_total($where = "") {
        $this->db->select("count(*) as total");
        $this->db->from("doctor");
        $this->db->where("deleted", 0);
        if ($where != "")
            $this->db->where($where);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Devuelve la informacion de un item en particular
     * @param string $id
     * @return \stdClass
     */
    function get_info($id) {
        $this->db->from('doctor');
        $this->db->where('id', $id);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $obj = new stdClass();
            $fields = $this->db->list_fields('doctor');
            foreach ($fields as $field) {
                $obj->$field = '';
            }

            return $obj;
        }
    }

    /**
     * Inserta o guarda un item
     * @param type $data
     * @param type $id
     * @return boolean
     */
    function save(&$data, $id = false) {
        if (!$id or !$this->exists($id)) {
            if ($this->db->insert('doctor', $data)) {
                $data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }

        $this->db->where('id', $id);
        if ($this->db->update('doctor', $data)) {
            return true;
        }
        return false;
    }

    /**
     * Verifica si esta almacenado el item especificado.
     * @param int $id
     * @return boolean
     */
    function exists($id) {
        //Bug php or mysql version, if it is char explicit convert to number.
        if (!is_numeric($id))
            return false;
        $this->db->from('doctor');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    /**
     * Elimina items deacuerdo a los identificadores dados.
     * @param array $ids
     * @return boolean
     */
    function delete_list($ids) {
        $success = false;

        //Run these queries as a transaction, we want to make sure we do all or nothing

        $this->db->where_in('id', $ids);
        try {
            $success = $this->db->update('doctor', array('deleted' => 1));
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } catch (Exception $e) {
            $this->db->trans_off();
        }
        return $success;
    }

}

/* End of file doctor.php */
/* Location: ./application/models/doctor.php */