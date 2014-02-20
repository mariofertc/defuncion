<?php

/**
 * Archivo Modelo Foto, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Modelo
 */

/**
 * Clase de Foto
 * 
 * Modelo para acceder a las Fotos.
 * @package Modelo
 */
class Foto extends CI_Model {

    var $title = '';
    var $content = '';
    var $date = '';

    /**
     * Lista de Fotografias por el Lugar indicado.
     * @param int $lugar_id
     * @return null|array
     */
    function get_by_lugar($lugar_id = null) {
        if ($lugar_id == null)
            return null;
        $this->db->where('id_lugar', $lugar_id);
        $this->db->from('fotos');
        $this->db->where('deleted', 0);
        $query = $this->db->get();

        return $query;
    }

    /**
     * Devuelve todos los items almacenados.
     * @return type
     */
    function getall() {
        $this->db->from('fotos');
        $this->db->where('deleted', 0);
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
    function get_all($num = 0, $offset = 0, $where = null, $order = null) {
        if ($order == null)
            $order = "id";
        $this->db->select('fotos.id as id, fotos.nombre as nombre, lugar.nombre_enlace as nombre_enlace, fotos.imagen_path as imagen_path, fotos.descripcion as descripcion, fotos.orden as orden', false);
        $this->db->from('fotos,lugar');
        if ($where != "")
            $this->db->where($where);
        $this->db->where('fotos.id_lugar = lugar.id and fotos.deleted = 0');
        $this->db->order_by($order);
        $this->db->limit($offset + $num, $offset);

        return $this->db->get();
    }

    /**
     * Sumatoria de Fotos almacenados
     * @param string $where
     * @return type
     */
    function get_total($where = "") {
        $this->db->select("count(*) as total");
        $this->db->from("fotos,lugar,categoria");
        $this->db->where("fotos.deleted = 0 and fotos.id_lugar=lugar.id and categoria.id=lugar.categoria_id");
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
        $this->db->select('fotos.id as id, fotos.nombre as nombre, lugar.nombre_enlace as nombre_enlace, fotos.imagen_path as imagen_path, fotos.descripcion as descripcion, id_lugar, fotos.orden as orden', false);
        $this->db->from('fotos, lugar');
        $this->db->where('fotos.id', $id);
        $this->db->where('fotos.id_lugar = lugar.id');
        $this->db->order_by('fotos.orden');
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $obj = new stdClass();
            $fields_lugar = $this->db->list_fields('lugar');
            $fields_fotos = $this->db->list_fields('fotos');
            $fields = (object) array_merge((array) $fields_lugar, (array) $fields_fotos);
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
            if ($this->db->insert('fotos', $data)) {
                $data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }

        $this->db->where('id', $id);
        if ($this->db->update('fotos', $data)) {
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
        $this->db->from('fotos');
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
            $success = $this->db->update('fotos', array('deleted' => 1));
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

/* End of file foto.php */
/* Location: ./application/models/foto.php */