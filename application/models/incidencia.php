<?php
/**
 * Archivo Modelo Incidencia, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Modelo
 */
/**
 * Clase de Incidencia
 * No Implementado
 * Modelo para acceder a las Incidencias.
 * @package Modelo
 */
class Incidencia extends CI_Model {
    /*
      Determines if a given item_id is an item
     */

    function exists($incidencia_id) {
        //Bug php or mysql version, if it is char explicit convert to number.
        if (!is_numeric($incidencia_id))
            return false;
        $this->db->from('incidencia');
        $this->db->where('id', $incidencia_id);
        // $this->db->where('deleted',0);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    /*
      Returns all the items
     */

    function get_all() {
        $this->db->from('incidencia');
        //$this->db->where('deleted',0);
        $this->db->order_by("id", "asc");
        return $this->db->get();
    }

    /*
      Returns all the usuarios
     */

    function get_incidencias($num = 0, $offset = 0, $where, $order = null) {
        if ($order == null)
            $order = "ORDER BY id desc";
        $this->db->select('* FROM ( SELECT *, ROW_NUMBER() OVER (' . $order . ') as row FROM incidencia ' .
                $where .
                ') a WHERE row > ' . $offset . ' and row <= ' . ($offset + $num)
        );
        return $this->db->get();
    }

    function get_total() {
        $this->db->select("count(*) as total");
        $this->db->from("incidencia");
        //$q = $this->db->query($sql);
        // return $this->db->get();
        $query = $this->db->get();
        return $query->row();
    }

    /*
      Gets information about a particular item
     */

    function get_info($incidencia_id) {
        $this->db->from('incidencia');
        $this->db->where('id', $incidencia_id);
        // $this->db->where('items.deleted',0);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $item_id is NOT an item
            $incidencia_obj = new stdClass();
            $fields = $this->db->list_fields('incidencia');
            foreach ($fields as $field) {
                $incidencia_obj->$field = '';
            }

            return $incidencia_obj;
        }
    }

    function get_multiple_info($incidencia_ids) {
        $this->db->from('incidencia');
        $this->db->where_in('id', $incidencia_ids);
        $this->db->order_by("nombre", "asc");
        return $this->db->get();
    }

    /*
      Inserts or updates a item
     */

    function save(&$incidencia_data, $incidencia_id = false) {
        if (!$incidencia_id or !$this->exists($incidencia_id)) {
            //No deber�a pasar nunca, pero queda implementado.
            if ($this->db->insert('incidencia', $incidencia_data)) {
                $incidencia_data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }

        $this->db->where('id', $incidencia_id);
        if ($this->db->update('incidencia', $incidencia_data)) {
            return true;
        }
        return false;
    }

    /*
      Get search suggestions to find items
     */

    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('incidencia');
        $this->db->like('nombre', $search);
        // $this->db->where('deleted',0);
        $this->db->order_by("nombre", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = $row->nombre;
        }

        $this->db->select('email');
        $this->db->from('incidencia');
        $this->db->distinct();
        $this->db->like('email', $search);
        $this->db->order_by("email", "asc");
        $by_category = $this->db->get();
        foreach ($by_category->result() as $row) {
            $suggestions[] = $row->email;
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Preform a search on items
     */

    function search($search) {
        $this->db->from('incidencia');
        $this->db->where("(nombre LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		email LIKE '%" . $this->db->escape_like_str($search) . "%')");
        $this->db->order_by("nombre", "asc");
        return $this->db->get();
    }

}

/* End of file incidencia.php */
/* Location: ./application/models/incidencia.php */