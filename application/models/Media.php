<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Media datatable model
 *
 * @package    codeigniter
 * @subpackage project
 * @category   model
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class Media extends CI_Model {

    function __construct() {
        parent::__construct();
    } // function __construct()

    
    function get_count() {
        return $this->db->count_all(DB_PHOTO); 
    }
    
    
    function get_by_id($item_id) {
        return $this->db->where('item_id', $item_id)->get(DB_PHOTO)->row();
    }


    function get_by_point($point_id) {
        return $this->db->where('item_point', $point_id)->get(DB_PHOTO)->result();
    }
    
    function remove($item_id) {
        return $this->db->delete(DB_PHOTO, array('item_id' => $item_id)); 
    }

    /**
     * Create new media object
     * @param array $data
     * @return $this->_insert();
     */
    function create($data) {
        $ID = uniqid();

        if ($this->_insert($ID, $data)) {
            return $ID;
        }

        return FALSE;
    } // function create($data)


    /**
     * Insert photo
     * @access protected
     * @param string $item_id
     * @param array $save array for save in DB
     * @return boolean
     */
    protected function _insert($item_id, $save) {
        $save['item_timestamp'] = time();
        $save['item_author']    = $this->auth->get_user_id();

        return $this->db->set('item_id', $item_id)->insert(DB_PHOTO, $save);
    } // protected function _insert($user_id, $save)
}

/* End of file Point.php */
/* Location: /models/Point.php */
