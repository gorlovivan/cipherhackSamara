<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Map points datatable model
 *
 * @package    codeigniter
 * @subpackage project
 * @category   model
 * @author     Mikhail Topchilo (Mikā¢) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class Point extends CI_Model {

    function __construct() {
        parent::__construct();
    } // function __construct()


    /**
     * Return map point data by ID
     * @param string $item_id
     * @return object
     */
    function get_by_id($item_id) {
        return $this->db
                    ->select(DB_POINT . '.*, ' . DB_CATEGORY . '.item_id as category_id, ' . DB_CATEGORY . '.item_name, ' . DB_CATEGORY . '.item_icon, ' . DB_PHOTO . '.item_filename')
                    ->join(DB_CATEGORY, DB_CATEGORY . '.item_id = ' . DB_POINT . '.item_category', 'left')
                    ->join(DB_PHOTO, DB_PHOTO . '.item_point = ' . DB_POINT . '.item_id', 'left')
                    ->where(DB_POINT . '.item_id', $item_id)
                    ->get(DB_POINT)->row();
    } // function get_by_id($item_id)

    
    function get_subcat_list() {
        return $this->db->get(DB_SUBCAT)->result();
    }


    function get_states_list($item_point) {
        return $this->db->where('item_point', $item_point)->order_by('item_timestamp', 'DESC')->get(DB_STATE)->result();
    }


    function view_counter($item_id, $views) {
        return $this->db->where('item_id', $item_id)->update(DB_POINT, array('item_views' => $views+1));
    }
    
    function update_status($item_point, $status, $text = NULL, $decription = NULL) {
        $item_id = uniqid();

        $save['item_id']        = $item_id;
        $save['item_point']     = $item_point;
        $save['item_status']    = $status;
        $save['item_timestamp'] = time();
        $save['item_text']        = $text;
        $save['item_description'] = $decription;

        
        $this->db->insert(DB_STATE, $save);

        return $item_id;
    }
    

    /**
     * Update
     * @param string $item_id
     * @param array $save array for save in DB
     * @return boolean
     */
    function update($item_id, $save) {
        return $this->db
                    ->where('item_id', $item_id)
                    ->update(DB_POINT, $save);
    } // function update($item_id, $save)

    
    /**
     * Create new map point
     * @param array $data
     * @return $this->_insert();
     */
    function create($data) {
        $ID = guid();

        if ($this->_insert($ID, $data)) {
            return $ID;
        }

        return FALSE;
    } // function create($data)


    /**
     * Insert point
     * @access protected
     * @param string $item_id
     * @param array $save array for save in DB
     * @return boolean
     */
    protected function _insert($item_id, $save) {
        $save['item_timestamp'] = time();
        $save['item_author']    = $this->auth->get_user_id();
        $save['item_status']    = STATUS_DRAFT;

        return $this->db->set('item_id', $item_id)->insert(DB_POINT, $save);
    } // protected function _insert($user_id, $save)


    function get_list($limit = 20, $offset = 0, $param = array()) {
        $this->db
             ->select(DB_POINT . '.*, ' . DB_CATEGORY . '.item_id as category_id, ' . DB_CATEGORY . '.item_name, ' . DB_CATEGORY . '.item_icon, ' . DB_CATEGORY . '.item_short, ' . DB_PHOTO . '.item_filename')
             ->join(DB_CATEGORY, DB_CATEGORY . '.item_id = ' . DB_POINT . '.item_category', 'left')
             ->join(DB_PHOTO, DB_PHOTO . '.item_point = ' . DB_POINT . '.item_id', 'left');

        if (isset($param['statuses']) && is_array($param['statuses'])) {
            $this->db->where_in('item_status', $param['statuses']);
        }
        
        if (isset($param['author'])) {
            $this->db->where(DB_POINT . '.item_author', $param['author']);
        }
        
        return $this->db
                    ->group_by(DB_POINT . '.item_id')
                    ->order_by(DB_POINT . '.item_timestamp', 'desc')
                    ->get(DB_POINT, $limit, $offset)->result();
    }

    function get_count($param = array()) {
        if (isset($param['statuses']) && is_array($param['statuses']) && ! empty($param['statuses'])) {
            return $this->db->where_in('item_status', $param['statuses'])->count_all_results(DB_POINT);
        }
        
        if (isset($param['author'])) {
            $this->db->where(DB_POINT . '.item_author', $param['author']);
        }

        return $this->db->count_all(DB_POINT);
    }

    function get_geojson_list($param) {
        $this->db->select(DB_POINT . '.item_id, item_category, item_latitude, item_longitude, ' . DB_CATEGORY . '.item_name, ' . DB_CATEGORY . '.item_icon')
                 ->join(DB_CATEGORY, DB_CATEGORY . '.item_id = ' . DB_POINT . '.item_category', 'left');

        if (isset($param['minlat']) && isset($param['maxlat'])) {
            $where = array(
                'item_latitude >=' => $param['minlat'],
                'item_latitude <=' => $param['maxlat'],
                'item_longitude >=' => $param['minlon'],
                'item_longitude >=' => $param['maxlon']
            );

            $this->db->where($where);
        }
        
        if (isset($param['statuses']) && is_array($param['statuses'])) {
            $this->db->where_in('item_status', $param['statuses']);
        }

        $this->db->where('item_private', 0);
        
        return $this->db->get(DB_POINT)->result();
    }
}

/* End of file Point.php */
/* Location: /models/Point.php */
