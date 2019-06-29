<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Authorization Controller
 * 
 * @package    cideigniter
 * @subpackage project
 * @category   controller
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class Logout extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check();
    } // function __construct()


    /**
     * Logout action
     */
    function index() {
        if ( ! $this->auth->is_login()) {
            return redirect(config_item('site_url'));
        }

        log_write(LOG_INFO, 'User: ' . $this->auth->get_user_id(), __METHOD__);

        $this->auth->logout();
        $this->user->clear_session();

        redirect(config_item('site_url'));
    } // function index()
}

/* End of file Logout.php */
/* Location: /controllers/Logout.php */
