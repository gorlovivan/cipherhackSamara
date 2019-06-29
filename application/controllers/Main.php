<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page controller
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   controller
 * @author     Mikhail Topchilo (Mik™) <http://miksrv.ru> <miksoft.tm@gmail.com>
 */
class Main extends CI_Controller {
   
    /**
     * Global view template array
     * @var array
     */
    var $TPLVAR = array();


    function __construct() {
        parent::__construct();

        $this->auth->check();
        
        $this->load->model('point');
        $this->load->model('media');
        
        $this->TPLVAR['user'] = $this->auth->get_user();
    } // function __construct()


    /**
     * Main page
     */
    function index() {     
        $param = array(
            'statuses' => array(STATUS_INWORK, STATUS_DONE, STATUS_PLANNED)
        );

        $this->TPLVAR['title']  = 'Активный гражданин - портал обращений граждан';
        $this->TPLVAR['points'] = $this->point->get_list(8, 0, $param);

        $this->TPLVAR['count_user']    = $this->user->get_count();
        $this->TPLVAR['count_point']   = $this->point->get_count($param['statuses']);
        $this->TPLVAR['count_process'] = $this->point->get_count(array(STATUS_INWORK));
        $this->TPLVAR['count_done']    = $this->point->get_count(array(STATUS_DONE));
        $this->TPLVAR['count_photo']   = $this->media->get_count();

        $this->load->view('main', $this->TPLVAR);
    } // function index()
}

/* End of file Main.php */
/* Location: /controllers/Main.php */
