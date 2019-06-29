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
class Map extends CI_Controller {
   
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
        $this->load->model('category');

        $status = filter($this->input->get('status', TRUE), 'int', 2);
        $status = ($status && in_array($status, array(STATUS_INWORK, STATUS_DONE))) ? $status : "''";

        $this->TPLVAR['category'] = $this->category->get_all();
        $this->TPLVAR['title']    = 'Карта города Оренбурга';
        $this->TPLVAR['status']   = $status;

        $this->load->view('map', $this->TPLVAR);
    } // function index()

    
    /**
     * Create new object in map
     */
    function create() {
        if ( ! $this->input->is_ajax_request() || ! $this->auth->is_login()) {
            return redirect(config_item('site_url'));
        }

        $point = array(
            'item_category'    => filter($this->input->post('category', TRUE), 'str', 30),
            'item_subcategory' => filter($this->input->post('subcat', TRUE), 'str', 30),
            'item_latitude'    => filter($this->input->post('latitude', TRUE), 'float'),
            'item_longitude'   => filter($this->input->post('longitude', TRUE), 'float')
        );

        if ( ! $point['item_category'] || ! $point['item_subcategory'] ||
             ! $point['item_latitude'] || ! $point['item_longitude']) {
            log_write(LOG_WARNING, 'Point object create error, USER: ' . $this->auth->get_user_id(), __METHOD__);

            return $this->output->set_output(json_encode(array(
                'code' => 'error',
                'text' => 'Произошла ошибка при сохранении проблемного места. Пожалуйста, обратитесь к администратору веб-ресурса.'
            )));
        }

        $this->load->library('Location');

        $geocode = $this->location->get_address($point['item_latitude'], $point['item_longitude']);

        $point['item_address'] = $geocode['address'];

        $point_id = $this->point->create($point);

        $this->point->update_status($point_id, STATUS_DRAFT);

        log_write(LOG_INFO, 'Point object created, ID: ' . $point_id . ', USER: ' . $this->auth->get_user_id(), __METHOD__);

        return $this->output->set_output(json_encode(array('code' => 'luck', 'item' => $point_id)));
    } // function create()


    /**
     * Get short info from object
     * @return type
     */
    function get_info() {
        if ( ! $this->input->is_ajax_request()) {
            return redirect(config_item('site_url'));
        }

        $item = filter($this->uri->segment(3), 'str', 30);

        if ( ! $item) {
            redirect(config_item('site_url'));
        }

        $this->TPLVAR['point'] = $this->point->get_by_id($item);

        return $this->output->set_output($this->load->view('dialog/object', $this->TPLVAR, TRUE));
    } // function get_info()


    /**
     * Create new object in map
     */
    function get_create_form() {
        if ( ! $this->input->is_ajax_request() || ! $this->auth->is_login()) {
            return redirect(config_item('site_url'));
        }

        $this->load->model('category');

        $this->TPLVAR['category'] = $this->category->get_all();
 
        return $this->output->set_output($this->load->view('dialog/create', $this->TPLVAR, TRUE));
    } // function get_create_form()

    
    /**
     * Return JSON Geocode data for map
     * @return type
     */
    function get_geojson() {
        if ( ! $this->input->is_ajax_request()) {
            return redirect(config_item('site_url'));
        }

        $status = filter($this->input->get('status', TRUE), 'int', 2);
        $param  = array('statuses' => array(STATUS_INWORK, STATUS_DONE, STATUS_PLANNED));
        $param  = array('statuses' => (in_array((int) $status, $param['statuses']) ? array($status) : $param['statuses']));

        if ($this->input->get('minlat') && $this->input->get('minlon')) {
            $param['minlat'] = floatval($this->input->get('minlat'));
            $param['maxlat'] = floatval($this->input->get('maxlat'));
            $param['minlon'] = floatval($this->input->get('minlon'));
            $param['maxlon'] = floatval($this->input->get('maxlon'));
        }

        $point_list = $this->point->get_geojson_list($param);

        if (empty($point_list) || ! is_array($point_list)) {
            return ;
        }

        $objects = array('type' => 'FeatureCollection');

        foreach ($point_list as $val) {
            $objects['features'][] = array(
                'type' => 'Feature',
                'geometry' => array(
                    'type' => 'Point',
                    'coordinates' => array($val->item_longitude, $val->item_latitude),
                ),
                'properties' => array(
                    'hintContent' => html_entity_decode($val->item_category),
                    'objectType'  => $val->item_category,
                    'objectid'    => $val->item_id
                ),
                'options' => array(
                    'iconImageHref' => '/assets/img/points/' . $val->item_icon,
                ),
            );
        }
        
        return $this->output->set_output(json_encode($objects));
    } // function get_geojson()

    
    /**
     * Return JSON subcategory array
     * @return type
     */
    function get_subcategory() {
        if ( ! $this->input->is_ajax_request() || ! $this->auth->is_login()) {
            return redirect(config_item('site_url'));
        }
        
        $item = filter($this->uri->segment(3), 'str', 20);

        $this->load->model('category');

        return $this->output->set_output(json_encode(array(
            'data' => $this->category->get_subcategory($item)
        )));
    } // function get_subcategory()
}

/* End of file Map.php */
/* Location: /controllers/Map.php */
