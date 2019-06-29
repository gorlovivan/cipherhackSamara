<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * User datatable model
 *
 * @package    codeigniter
 * @subpackage project
 * @category   model
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class User extends CI_Model {

    function __construct() {
        parent::__construct();
    } // function __construct()


    /**
     * Return user data by session ID
     * @param string $session_id
     * @return object
     */
    function get_by_session($session_id) {
        return $this->db->where('user_session', $session_id)->get(DB_USERS)->row();
    } // function get_by_session($session_id)


    /**
     * Return user data by email
     * @param string $email
     * @return object
     */
    function get_by_email($email) {
        return $this->db->where('user_email', $email)->get(DB_USERS)->row();
    } // function get_by_email($email)

    
    /**
     * Return user data by ID
     * @param string $user_id
     * @return object
     */
    function get_by_id($user_id) {
        return $this->db->where('user_id', $user_id)->get(DB_USERS)->row();
    } // function get_by_id($user_id)

    
    function get_count() {
        return $this->db->count_all(DB_USERS); 
    }


    /**
     * Return array all users
     * @return array
     */
    function get_all() {
        //return $this->db->get(DB_USERS)->result();

        return $this->db
            ->select(DB_USERS . '.*, COUNT(' . DB_ADVERT . '.item_id) as advert_count')
            ->join(DB_ADVERT, DB_ADVERT . '.item_user = ' . DB_USERS . '.user_id', 'left')
            ->group_by('user_id')
            ->get(DB_USERS)->result();
    } // function get_all()


    /**
     * Return TRUE if user with set email exists in DB
     * @param string $user_email
     * @return boolean
     */
    function is_exists($user_email) {
        if ($this->db->select('user_id')->from(DB_USERS)->where('user_email', $user_email)->get()->num_rows() >= 1) {
            return TRUE;
        }

        return FALSE;
    } // function is_exists($user_email)


    /**
     * Return TRUE if user exist by email and password
     * @param string $user_email
     * @param string $user_password
     * @return boolean
     */
    function login($user_email, $user_password) {
        if ($this->db->select('*')->from(DB_USERS)
                 ->where('user_active', 1)
                 ->where('user_email', $user_email)
                 ->where('user_password', $this->auth->crypt_password($user_password))->get()->num_rows() >= 1) {

            $this->load->library('user_agent');

            $save = array(
                'user_lastlogin' => time(),
                'user_session'   => session_id(),
                'user_ip'        => $this->input->ip_address(),
                'user_agent'     => $this->agent->agent_string(),
            );

            $this->db->where('user_email', $user_email)->update(DB_USERS, $save);

            return TRUE;
        }

        return FALSE;
    } // function login($user_email, $user_password)

    
    /**
     * Deactivate user
     * @param string $user_id
     * @param boolean $action
     */
    function deactivate($user_id, $action = TRUE) {
        return $this->_update($user_id, array('user_active' => ($action ? 1 : 0)));
    } // unction deactivate($user_id, $action = TRUE)


    /**
     * Create new user
     * @param array $data
     * @return $this->_insert();
     */
    function create($data) {
        return $this->_insert(uniqid(), $data);
    } // function create($data)


    /**
     * Edit user data by ID
     * @param string $user_id
     * @param array $data
     * @return $this->_insert();
     */
    function edit($user_id, $data) {
        return $this->_update($user_id, $data);
    } // function edit($user_id, $data)


    /**
     * Clear session for current user
     */
    function clear_session() {
        $this->db->where('user_id', $this->auth->get_user_id())->update(DB_USERS, array('user_session' => ''));
    } // function clear_session()


    /**
     * Update user
     * @access protected
     * @param string $user_id
     * @param array $save array for save in DB
     * @return boolean
     */
    protected function _update($user_id, $save) {
        return $this->db->where('user_id', $user_id)->update(DB_USERS, $save);
    } // protected function _update($user_id, $save)


    /**
     * Insert user
     * @access protected
     * @param string $user_id
     * @param array $save array for save in DB
     * @return boolean
     */
    protected function _insert($user_id, $save) {
        $save['user_created'] = time();

        return $this->db->set('user_id', $user_id)->insert(DB_USERS, $save);
    } // protected function _insert($user_id, $save)
}

/* End of file User.php */
/* Location: /models/User.php */
