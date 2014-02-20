<?php

/**
 * Archivo Controlador Login, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package FrontEnd
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Clase Login
 * 
 * Controlador para acceder al Administrador del Sitio.
 * @package FrontEnd
 */
class Login extends CI_Controller {

    /**
     * Valida el Formulario del Login.
     * @access public
     */
    function index() {
        if ($this->Empleado->is_logged_in()) {
            redirect('home');
        } else {
            $this->form_validation->set_rules('username', 'Usuario', 'callback_login_check');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->form_validation->run();
            $this->form_validation->set_rules('username', 'lang:login_username', 'callback_login_check');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('login');
            } else {
                redirect('home');
            }
        }
    }

    /**
     * Chequea si esta logiado un usuario.
     * @param string $username
     * @return boolean
     */
    function login_check($username) {
        $password = $this->input->post("password");

        if (!$this->Empleado->login($username, $password)) {
            $this->form_validation->set_message('login_check', 'Clave o Usuario Incorrectos');
            return false;
        }
        return true;
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */