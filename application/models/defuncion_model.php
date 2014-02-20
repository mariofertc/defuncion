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
class Defuncion_model extends CI_Model {

    /**
     * Verifica si esta almacenado el item especificado.
     * @param int $persona_id
     * @return boolean
     */
    function exists($item_id) {
        $this->db->from('defuncion');
        $this->db->where('id', $item_id);
        $this->db->where('deleted', 0);
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
//        $this->db->select('consulta.*, paciente.persona_id as paciente_id, doctor.id as doctor_id FROM paciente, persona,doctor,consulta where persona.persona_id = paciente.persona_id and paciente.persona_id = consulta.paciente_id and consulta.deleted = 0 ' .
        $this->db->select('defuncion.*, paciente.persona_id as paciente_id FROM paciente, persona,defuncion where persona.persona_id = paciente.persona_id and paciente.persona_id = defuncion.paciente_id and defuncion.deleted = 0 ' .
                $where);
        $this->db->order_by($order);
        $this->db->limit($offset + $num, $offset);
        $db = $this->db->get();
//        echo $this->db->last_query();
        return $db;
    }

    /**
     * Sumatoria de Empleados
     * @return type
     */
    function get_total() {
        $this->db->select("count(*) as total");
        $this->db->from("defuncion");
        $this->db->join('paciente', 'paciente.persona_id = defuncion.paciente_id');
        $this->db->join('persona', 'persona.persona_id=paciente.persona_id');
        $this->db->where('paciente.deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Devuelve la informacion de un item en particular
     * @param string $id
     * @return \stdClass
     */
    function get_info($consulta_id) {
        $this->db->from('defuncion');
        $this->db->join('paciente', 'paciente.persona_id = defuncion.paciente_id');
        $this->db->join('persona', 'persona.persona_id = paciente.persona_id');
        $this->db->where('defuncion.id', $consulta_id);
        $this->db->where('defuncion.deleted', 0);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //create object with empty properties.
            $fields = $this->db->list_fields('defuncion');
            $consulta_obj = new stdClass;

            foreach ($fields as $field) {
                $consulta_obj->$field = '';
            }

            return $consulta_obj;
        }
    }

    /**
     * Devuelve la Informacion de los Empleados.
     * @param array $empleado_ids
     * @return type
     */
    function get_multiple_info($empleado_ids) {
        $this->db->from('paciente');
        $this->db->join('persona', 'persona.id = paciente.persona_id');
        $this->db->where_in('paciente.persona_id', $empleado_ids);
        $this->db->where('deleted', 0);
        $this->db->order_by("apellido", "asc");
        return $this->db->get();
    }
    
    function save(&$data, $consulta_id = false) {
        $success = false;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();
        try {
            
                if (!$consulta_id or !$this->exists($consulta_id)) {
                    $success = $this->db->insert('defuncion', $data);
                    $data['id'] = $this->db->insert_id();
                } else {
                    $this->db->where('id', $consulta_id);
                    $success = $this->db->update('defuncion', $data);
                }
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

    /**
     * Elimina el Empleado con el identificador dado.
     * @param int $employee_id
     * @return boolean
     */
    function delete($employee_id) {
        $success = false;

        //Don't let employee delete their self
        if ($employee_id == $this->get_logged_in_empleado_info()->persona_id)
            return false;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();
        try {
            //Delete permissions
            if ($this->db->delete('permiso', array('persona_id' => $employee_id))) {
                $this->db->where('persona_id', $employee_id);
                $success = $this->db->update('paciente', array('deleted' => 1));
            }
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

    /**
     * Elimina items deacuerdo a los identificadores dados.
     * @param array $ids
     * @return boolean
     */
    function delete_list($empleado_ids) {
        $success = false;

        //Don't let employee delete their self
        if (in_array($this->get_logged_in_empleado_info()->persona_id, $empleado_ids))
            return false;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();
        $this->db->where_in('persona_id', $empleado_ids);
        try {
            //Delete permissions
            if ($this->db->delete('permiso')) {
                //delete from employee table
                $this->db->where_in('persona_id', $empleado_ids);
                $success = $this->db->update('paciente', array('deleted' => 1));
            }
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

    /**
     * No Implementado
     * @param type $search
     * @param type $limit
     * @return type
     */
    function get_search_suggestions($search, $limit = 5) {
        $suggestions = array();

        $this->db->from('paciente');
        $this->db->join('persona', 'paciente.persona_id=persona.persona_id');
        $this->db->where("(nombre LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		apellido LIKE '%" . $this->db->escape_like_str($search) .
                "%' or 
		nombre + ' ' + apellido LIKE '%" .
                $this->db->escape_like_str($search) . "%') and deleted=0");

        $this->db->order_by("apellido", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = $row->nombre . ' ' . $row->apellido;
        }

        $this->db->from('paciente');
        $this->db->join('persona', 'paciente.persona_id=persona.persona_id');
        $this->db->where('deleted', 0);
        $this->db->like("email", $search);
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            $suggestions[] = $row->email;
        }

        $this->db->from('paciente');
        $this->db->join('persona', 'paciente.persona_id=persona.persona_id');
        $this->db->where('deleted', 0);
        $this->db->like("username", $search);
        $this->db->order_by("username", "asc");
        $by_username = $this->db->get();
        foreach ($by_username->result() as $row) {
            $suggestions[] = $row->username;
        }


        $this->db->from('paciente');
        $this->db->join('persona', 'paciente.persona_id=persona.persona_id');
        $this->db->where('deleted', 0);
        $this->db->like("telefono", $search);
        $this->db->order_by("telefono", "asc");
        $by_phone = $this->db->get();
        foreach ($by_phone->result() as $row) {
            $suggestions[] = $row->telefono;
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /**
     * No Implementado
     * @param type $search
     * @return type
     */
    function search($search) {
        $this->db->from('paciente');
        $this->db->join('persona', 'paciente.persona_id=persona.persona_id');
        $this->db->where("(nombre LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		apellido LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		telefono LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		username LIKE '%" . $this->db->escape_like_str($search) .
                "%' or 
		nombre + ' ' + apellido LIKE '%"
                . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("apellido", "asc");

        return $this->db->get();
    }
}

/* End of file empleado.php */
/* Location: ./application/models/empleado.php */