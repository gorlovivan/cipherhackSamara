<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Authorization Controller
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   controller
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class Login extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check();
    } // function __construct()


    /**
     * login page
     */
    function index() {
        if ($this->auth->is_login()) {
            return redirect(config_item('site_url'));
        }

        $this->load->view('login');
    } // function index()


    /**
     * Authorization
     * @return void
     */
    function auth() {
        if ( ! $this->input->is_ajax_request()) {
            return redirect(config_item('site_url'));
        }

        session_regenerate_id();

        $login = filter($this->input->post('login', TRUE), 'str', 40);
        $passw = filter($this->input->post('passw', TRUE), 'str', 40);

        if ($this->user->login($login, $passw)) {
            $this->auth->login();

            log_write(LOG_INFO, 'Login user: ' . $login, __METHOD__);

            return $this->output->set_output(json_encode(array(
                'state' => true,
                'link'  => '/'
            )));
        }

        log_write(LOG_INFO, 'Invalid user password: ' . $login, __METHOD__);

        return $this->output->set_output(json_encode(array(
            'state' => false,
            'link'  => '',
            'text'  => 'Ошибка авторизации: неверный логин или пароль'
        )));
    } // function auth()
}

/* End of file Login.php */
/* Location: /controllers/Login.php */
