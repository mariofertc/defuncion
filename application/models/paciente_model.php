<?php

/**
 * Archivo Modelo Empleado, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package Modelo
 */

/**
 * Clase de Empleado
 * 
 * Modelo para acceder a los Usuarios.
 * @package Modelo
 */
class Paciente_model extends Persona {

    /**
     * Verifica si esta almacenado el item especificado.
     * @param int $persona_id
     * @return boolean
     */
    function exists($persona_id) {
        $this->db->from('paciente');
        $this->db->join('persona', 'persona.persona_id = paciente.persona_id');
        $this->db->where('paciente.persona_id', $persona_id);
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
    function get_all($num = 0, $offset = 0, $where = null, $order = '') {
        $this->db->select('persona.*, persona.persona_id as paciente_id FROM paciente, persona where persona.persona_id = paciente.persona_id and paciente.deleted = 0 ' .
                $where);
        $this->db->order_by($order);
        $this->db->limit($offset + $num, $offset);

        return $this->db->get();
    }

    /**
     * Sumatoria de Empleados
     * @return type
     */
    function get_total() {
        $this->db->select("count(*) as total");
        $this->db->from("paciente");
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
    function get_info($empleado_id) {
        $this->db->from('paciente');
        $this->db->join('persona', 'persona.persona_id = paciente.persona_id');
        $this->db->where('paciente.persona_id', $empleado_id);
        $this->db->where('deleted', 0);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $employee_id is NOT an employee
            $persona_obj = parent::get_info(-1);

            //Get all the fields from employee table
            $fields = $this->db->list_fields('paciente');

            //append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field) {
                $persona_obj->$field = '';
            }

            return $persona_obj;
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

    /**
     * Inserta o guarda un item
     * @param type $persona_data
     * @param type $empleado_data
     * @param type $permiso_data
     * @param type $empleado_id
     * @return type
     */
    function save(&$persona_data, &$empleado_data, &$permiso_data, $empleado_id = false) {
        $success = false;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();
        try {
            if (parent::save($persona_data, $empleado_id)) {
                if (!$empleado_id or !$this->exists($empleado_id)) {
                    $empleado_data['persona_id'] = $empleado_id = $persona_data['persona_id'];
                    $success = $this->db->insert('paciente', $empleado_data);
                } else {
                    $this->db->where('persona_id', $empleado_id);
                    $success = $this->db->update('paciente', $empleado_data);
                }

                //We have either inserted or updated a new employee, now lets set permissions. 
                if ($success) {
                    //First lets clear out any permissions the employee currently has.
                    $success = $this->db->delete('permiso', array('persona_id' => $empleado_id));

                    //Now insert the new permissions
                    if ($success) {
                        if ($permiso_data <> null) {
                            foreach ($permiso_data as $allowed_module) {
                                $success = $this->db->insert('permiso', array(
                                    'modulo_id' => $allowed_module,
                                    'persona_id' => $empleado_id));
                            }
                        }
                    }
                }
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