<?php
/**
 * User helper class
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   library
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class Auth {

    protected $CI;
    
    /**
     * Current login state
     * @var boolean
     */
    protected $_is_login = FALSE;
    
    /**
     * Current user data object
     * @var object
     */
    protected $_user_data;

    function __construct() {
        $this->CI =& get_instance();
    } // function __construct()


    /**
     * Check current user auth
     */
    function check() {
        $session_id = $this->CI->session->session_id;

        if ( ! $session_id) {
            return $this->_is_login = FALSE;
        }

        $this->_user_data = $this->CI->user->get_by_session($session_id);
        
        if (empty($this->_user_data)) {
            $this->CI->session->set_userdata('session_id', '');

            return $this->_is_login = FALSE;
        }

        return $this->_is_login = TRUE;
    } // function check_login()


    /**
     * Return current auth state
     * @var boolean
     */
    function is_login() {
        return $this->_is_login;
    } // function is_login()


    /**
     * If current user developer - send TRUE
     * @return boolean
     */
    function is_developer() {
        if ($this->is_login() && in_array($this->_user_data->user_id, config_item('users_developer'))) {
            return TRUE;
        }
        
        return FALSE;
    } // function is_developer()


    /**
     * If current user admin - send TRUE
     * @return boolean
     */
    function is_admin() {
        if ($this->is_login() && $this->_user_data->user_role === ROLE_ADMIN) {
            return TRUE;
        }

        return FALSE;
    } // function is_admin()


    /**
     * If current user moderator - send TRUE
     * @return boolean
     */
    function is_moderator() {
        if ($this->is_login() && $this->_user_data->user_role === ROLE_MODERATOR) {
            return TRUE;
        }

        return FALSE;
    } // function is_moderator()

    
    /**
     * Return role ID of current user
     * @return string
     */
    function my_role() {
        if ( ! $this->is_login()) {
            return FALSE;
        }

        if ($this->is_developer()) {
            return ROLE_DEVELOPER;
        }

        if ($this->is_admin()) {
            return ROLE_ADMIN;
        }
        
        if ($this->is_moderator()) {
            return ROLE_MODERATOR;
        }

        return ROLE_USER;
    } // function my_role()

    
    /**
     * Set session ID for current user
     */
    function login() {
        $this->CI->session->set_userdata('session_id', session_id());
    } // function login()


    /**
     * Clear session ID for current user
     */
    function logout() {
        $this->CI->session->set_userdata('session_id', '');
    } // function logout()

    
    /**
     * Return currrent user array
     * @return array
     */
    function get_user() {
        return $this->_user_data;
    } // function get_current_user()

    
    /**
     * Return currrent user id
     * @return string
     */
    function get_user_id() {
        return $this->_user_data->user_id;
    } // function get_user_id()


    /**
     * Generate userID
     * @return string
     */
    function create_id() {
        return uniqid();
    } // function create_id()
    
    
    /**
     * Create user MD5 hash for activation email
     * @param string $user_email
     * @return string
     */
    function generate_user_hash($user_email) {
        return md5(UNIQSALT . $user_email);
    } // function generate_user_hash($user_email)


    /**
     * Uses a small encryption algorithm to encrypt the password.
     * @param type $password
     */
    function crypt_password($password) {
        return md5(UNIQSALT . $password);
    } // function crypt_password($password)
}

// END Auth library class

/* End of file Auth.php */
/* Location: /application/libraries/Auth.php */