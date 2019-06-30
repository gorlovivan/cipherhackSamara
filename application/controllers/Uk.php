<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Uk page controller
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   controller
 * @author     Mikhail Topchilo (Mik™) <http://miksrv.ru> <miksoft.tm@gmail.com>
 */
class Uk extends CI_Controller {
   
    /**
     * Global view template array
     * @var array
     */
    var $TPLVAR = array();


    function __construct() {
        parent::__construct();

        $this->auth->check();
        $this->load->model('point');
        
        $this->TPLVAR['user'] = $this->auth->get_user();
    } // function __construct()

    
    /**
     * Main page
     */
    function index() {
        $this->TPLVAR['title'] = 'Рейтинг управляющих компаний';

        $this->load->view('uk', $this->TPLVAR);
    } // function index()
}

/* End of file Uk.php */
/* Location: /controllers/Uk.php */
