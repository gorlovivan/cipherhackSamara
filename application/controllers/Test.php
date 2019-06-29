<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Map page controller
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   controller
 * @author     Mikhail Topchilo (Mik™) <http://miksrv.ru> <miksoft.tm@gmail.com>
 */
class Test extends CI_Controller {
   
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
        $this->TPLVAR['title']    = 'Карта города Оренбурга';
        
        $this->load->view('test', $this->TPLVAR);
    } // function index()
}

/* End of file Map.php */
/* Location: /controllers/Map.php */
