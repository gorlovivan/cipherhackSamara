<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users page controller
 *
 * @package    codeigniter
 * @subpackage project
 * @category   controller
 * @author     Mikhail Topchilo (Mik™) <http://miksrv.ru> <miksoft.tm@gmail.com>
 */
class Users extends CI_Controller {

    /**
     * Global view template array
     * @var array
     */
    var $TPLVAR = array();


    function __construct() {
        parent::__construct();

        if ( ! $this->auth->check()) {
            return redirect('/login');
        }
        
        if ($this->auth->my_role() < ROLE_MODERATOR) {
            redirect('/');
        }
        
        $this->load->model('advert');
        $this->load->model('user');

        $this->advert->renew_advert();

        $this->TPLVAR['new_adverts'] = $this->advert->get_count_new();
    } // function __construct()


    /**
     * Main page
     */
    function index() {
        $this->TPLVAR['title'] = 'Управление пользователями';
        $this->TPLVAR['users'] = $this->user->get_all();

        $this->load->view('users', $this->TPLVAR);
    } // function index()


    /**
     * Create new user form
     */
    function create() {
      if ( ! $this->input->is_ajax_request()) {
          return redirect('/');
      }

      return $this->output->set_output(json_encode(array(
          'content'  => $this->load->view('dialog/user_create', $this->TPLVAR, TRUE)
      )));
    } // function create()


    /**
     * Show dialog page with user adverts
     */
    function adverts() {
        if ( ! $this->input->is_ajax_request()) {
            return redirect('/');
        }
      
        $user = filter($this->uri->segment(3), 'str', 20);

        if ( ! $user) {
            log_write(LOG_WARNING, 'No user ID (' . $user . ')', __METHOD__);

            return $this->output->set_output(json_encode(array(
                'state' => false,
                'text'  => 'Произошла ошибка при загрузке объявлений пользователя. Попробуйте обновить страницу. При повторной ошибке обратитесь к администратору.'
            )));
        }

        $this->load->model('advert');

        $this->TPLVAR['advert'] = $this->advert->get_by_user($user);

        return $this->output->set_output(json_encode(array(
            'content' => $this->load->view('dialog/user_advert', $this->TPLVAR, TRUE)
        )));
    } // function adverts()


    /**
     * Activate and diactivate user
     */
    function deactivate() {
        if ( ! $this->input->is_ajax_request()) {
            return redirect('/');
        }

        $user   = filter($this->uri->segment(3), 'str', 20);
        $action = filter($this->uri->segment(4), 'str', 5);

        if ( ! $user) {
            log_write(LOG_WARNING, 'No user ID (' . $user . ')', __METHOD__);

            return $this->output->set_output(json_encode(array(
                'state' => false,
                'text'  => 'Произошла ошибка при загрузке объявлений пользователя. Попробуйте обновить страницу. При повторной ошибке обратитесь к администратору.'
            )));
        }
        
        if (in_array($user, config_item('users_developer')) || $this->auth->get_user_id() == $user) {
            log_write(LOG_WARNING, 'Disable the developer or yourself (' . $user . ')', __METHOD__);

            return $this->output->set_output(json_encode(array(
                'state' => false,
                'text'  => 'Невозможно отключить этого пользователя'
            )));
        }

        log_write(LOG_INFO, ($action == 'false' ? 'Deactivate' : 'Activate') . ': ' . $user . ', ID: ' . $this->auth->get_user_id(), __METHOD__);

        $this->user->deactivate($user, ($action == 'false' ? FALSE : TRUE));

        return $this->output->set_output(json_encode(array(
            'state' => TRUE
        )));
    } // function deactivate()


    /**
     * Add new account
     * @return void
     */
    function add() {
        if ( ! $this->input->is_ajax_request()) {
            return redirect('/');
        }

        $login = filter($this->input->post('login', TRUE), 'str', 40);
        $passw = filter($this->input->post('passw', TRUE), 'str', 40);
        $name  = filter($this->input->post('name', TRUE), 'str');
        $phone = filter($this->input->post('phone', TRUE), 'str');

        if ( ! $login || ! $passw || ! $name || ! $phone) {
            log_write(LOG_WARNING, 'Data entry error', __METHOD__);

            return $this->output->set_output(json_encode(array(
                'state' => false,
                'link'  => '',
                'text'  => 'Произошла ошибка при добавлении нового пользователя. Попробуйте обновить страницу. При повторной ошибке обратитесь к администратору.'
            )));
        }

        if ($this->user->is_exists($login)) {
            return $this->output->set_output(json_encode(array(
                'state' => false,
                'link'  => '',
                'text'  => 'Пользователь с таким email-адресом уже зарегистрирован.'
            )));
        }

        $user = array(
            'user_email'    => $login,
            'user_password' => $this->auth->crypt_password($passw),
            'user_phone'    => $phone,
            'user_name'     => $name,
        );

        log_write(LOG_INFO, 'Registration user: ' . $login, __METHOD__);

        $this->user->create($user);

        return $this->output->set_output(json_encode(array(
            'state' => true,
            'link'  => '/users'
        )));
    } // function add()
}

/* End of file Users.php */
/* Location: /controllers/Users.php */
