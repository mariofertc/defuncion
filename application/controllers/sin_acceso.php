<?php

/**
 * Archivo Controlador Sin_Acceso, Ecuadorinmobile 
 * 
 * @author Mario Torres <mariofertc@mixmail.com>
 * @version 1.0
 * @package FrontEnd
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Clase Sin_Acceso
 * 
 * Controlador que permite indicar el acceso restringido al sitio.
 * @package FrontEnd
 */
class Sin_acceso extends CI_Controller {

    /**
     * Constructor de la clase
     * @access public
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Pagina indicando que no tiene acceso al uri solicitado.
     * @access public
     * @param string $modulo_id
     * @return string Vista de Usuario
     */
    function index($modulo_id = '') {
        $data['modulo_nombre'] = $this->Modulo->get_modulo_nombre($modulo_id);
        $this->load->view('no_access', $data);
    }

}

/* End of file Sin_Acceso.php */
/* Location: ./application/controllers/Sin_Acceso.php */