<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Category datatable model
 *
 * @package    codeigniter
 * @subpackage project
 * @category   model
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class Category extends CI_Model {

    function __construct() {
        parent::__construct();
    } // function __construct()

    function get_subcategory($parent_id) {
        return $this->db->where('item_category', $parent_id)->get(DB_SUBCAT)->result();
    } // function get_subcategory($parent_id)

    /**
     * Return array all category
     * @return array
     */
    function get_all() {
        return $this->db->get(DB_CATEGORY)->result();
    } // function get_all()


    /**
     * Return array all SUB-category
     * @return array
     */
    function get_all_subcategory() {
        return $this->db->get(DB_SUBCAT)->result();
    } // function get_all_subcategory()
}

/* End of file Category.php */
/* Location: /models/Category.php */
