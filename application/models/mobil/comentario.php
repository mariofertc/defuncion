<?php
/**
 * Archivo Modelo Comentario, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Modelo
 */
/**
 * Clase de Categoria
 * 
 * Modelo para acceder a los Comentarios.
 * @package Modelo
 */
class Comentario extends CI_Model {

    var $title = '';
    var $content = '';
    var $date = '';

    /**
     * Devuelve todos los Comentarios almacenados en el Lugar.
     * @return type
     * @param string $lugar_id Identificdor del Lugar
     */
    function getall($lugar_id) {
        $this->db->where('id_lugar', $lugar_id);
        $this->db->order_by('fecha', 'desc');
        $this->db->where('deleted', 0);
        $query = $this->db->get('comentario');
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
    function get_all($num = 0, $offset = 0, $where, $order = null) {
        if ($order == null)
            $order = "id";
        //$this->db->select('id','nombre');
        $this->db->from('comentario');
        if ($where != "")
            $this->db->where($where);
        $this->db->where('deleted', 0);
        $this->db->order_by($order);
        $this->db->limit($offset + $num, $offset);

        return $this->db->get();
    }

    /**
     * Sumatoria de Comentarios almacenados por Lugar
     * @param string $lugar_id
     * @return type
     */
    function get_total($lugar_id) {
        $this->db->select("count(*) as total");
        $this->db->from("comentario");
        $this->db->where("deleted", 0);
        $this->db->where("id_lugar", $lugar_id);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Devuelve la informacion de un item en particular
     * @param string $id
     * @return \stdClass
     */
    function get_info($id) {
        $this->db->from('comentario');
        $this->db->where('id', $id);
        // $this->db->where('items.deleted',0);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $obj = new stdClass();
            $fields = $this->db->list_fields('comentario');
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

        if ($this->db->insert('comentario', $data)) {
            $data['id'] = $this->db->insert_id();
            return true;
        }
        return false;
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
            $success = $this->db->update('comentario', array('deleted' => 1));
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

/* End of file comentario.php */
/* Location: ./application/models/mobil/comentario.php */