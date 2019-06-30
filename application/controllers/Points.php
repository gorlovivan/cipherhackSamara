<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Point list and cards controller
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   controller
 * @author     Mikhail Topchilo (Mik™) <http://miksrv.ru> <miksoft.tm@gmail.com>
 */
class Points extends CI_Controller {

    /**
     * Global view template array
     * @var array
     */
    var $TPLVAR = array();


    function __construct() {
        parent::__construct();

        $this->auth->check();
        $this->load->model('point');
        $this->load->library('pagination');

        $this->TPLVAR['user'] = $this->auth->get_user();
    } // function __construct()

    
    /**
     * Index page redirect to points list page
     * @return type
     */
    function index() {
        return redirect(config_item('site_url') . 'points/list');
    } // function index()


    /**
     * Show current point
     */
    function id() {
        $item = filter($this->uri->segment(3), 'str', 40);

        if ( ! $item) {
            redirect(config_item('site_url') . 'points/list');
        }

        if ( ! $this->auth->is_login() && isset($_GET['admin'])) {
            redirect(config_item('site_url') . 'points/id/' . $item);
        }

        $this->load->model('media');
        $this->load->model('category');

        $subcat = $this->point->get_subcat_list();

        $this->TPLVAR['point']  = $this->point->get_by_id($item);
        
        if (empty($this->TPLVAR['point']) || ! is_object($this->TPLVAR['point'])) {
            log_write(LOG_WARNING, 'Point object not found, ID: ' . $this->TPLVAR['point'], __METHOD__);
            redirect(config_item('site_url') . '404');
        }

        $this->TPLVAR['title']  = $this->TPLVAR['point']->item_name;
        $this->TPLVAR['media']  = $this->media->get_by_point($item);
        $this->TPLVAR['states'] = $this->point->get_states_list($item);
        $this->TPLVAR['user']   = $this->user->get_by_id($this->TPLVAR['point']->item_author);
        $this->TPLVAR['subcat'] = array();
        $this->TPLVAR['item']   = $item;
        $this->TPLVAR['category'] = $this->category->get_all();

        $this->point->view_counter($this->TPLVAR['point']->item_id, $this->TPLVAR['point']->item_views);

        foreach ($subcat as $val) {
            $this->TPLVAR['subcat'][$val->item_id] = $val;
        }

        $this->load->view('point_page', $this->TPLVAR);
    } // function id()


    /**
     * Create points list page
     */
    function list() {
        $user_id = filter($this->input->get('user'), 'str', 40);
        $param   = $user_data = NULL;
        
        if ($user_id) {
            $user_data = $this->user->get_by_id($user_id);
            
            if (empty($user_data) || ! isset($user_data->user_id)) {
                redirect(config_item('site_url') . '404');
            }

            $param['author']   = $user_data->user_id;
            $param['statuses'] = NULL;
        } else {
            $param['statuses'] = array(STATUS_INWORK, STATUS_DONE, STATUS_PLANNED);
        }

        $config['first_link'] = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
        $config['last_link']  = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        $config['next_link']  = '<i class="fa fa-angle-right" aria-hidden="true"></i>';
        $config['prev_link']  = '<i class="fa fa-angle-left" aria-hidden="true"></i>';
        $config['total_rows'] = $this->point->get_count($param);
        $config['per_page']   = config_item('point_list_per_page');
        $config['base_url']   = config_item('site_url') . 'points/list' . (isset($param['author']) ? '?user=' . $param['author'] : NULL);
        $config['suffix']     = isset($param['author']) ? '?user=' . $param['author'] : NULL; 

        $page = ($this->uri->segment(3)) ? filter($this->uri->segment(3), 'int', 5) : 0;

        $this->load->model('media');
        $this->load->model('category');

        $this->pagination->initialize($config);

        $this->TPLVAR['title']  = 'Список всех проблем';
        $this->TPLVAR['points'] = $this->point->get_list(config_item('point_list_per_page'), $page, $param);
        $this->TPLVAR['pages']  = $this->pagination->create_links();
        $this->TPLVAR['author'] = $user_data;
        
        $this->TPLVAR['category'] = $this->category->get_all();

        $this->TPLVAR['count_user']    = $this->user->get_count();
        $this->TPLVAR['count_point']   = $this->point->get_count($param['statuses']);
        $this->TPLVAR['count_process'] = $this->point->get_count(array(STATUS_INWORK));
        $this->TPLVAR['count_done']    = $this->point->get_count(array(STATUS_DONE));
        $this->TPLVAR['count_photo']   = $this->media->get_count();

        $this->load->view('points', $this->TPLVAR);
    } // function list()
}

/* End of file Points.php */
/* Location: /controllers/Points.php */
