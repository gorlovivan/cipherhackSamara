<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Registration Controller
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   controller
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class Registration extends CI_Controller {

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

        $this->load->view('registration');
    } // function index()


    /**
     * Create activate user email
     */
    function activate() {
        $user = $this->auth->get_user();

        if ( ! $this->input->is_ajax_request() || $user->user_confirm) {
            return redirect(config_item('site_url'));
        }

        $this->load->helper('cookie');

        if (get_cookie('activate')) {
            return $this->output->set_output(json_encode(array(
                'state' => false,
                'code'  => 'warning',
                'text'  => 'Вы недавно уже запрашивали письмо активации аккаунта. Повторная отправка сообщения с кодом активации возможна через 15 минут.'
            )));
        }

        set_cookie('activate', time(), 900);

        return $this->_activation_email($user->user_id, $user->user_email, TRUE);
    } // function activate()


    /**
     * Confirm user account by activation code
     */
    function confirm() {
        $user  = filter($this->input->get('user', TRUE), 'str', 20);
        $code  = filter($this->input->get('code', TRUE), 'str', 40);
        
        if ( ! $user || ! $code) {
            log_write(LOG_WARNING, 'Entry code or user param (user: ' . $user . ')', __METHOD__);
            show_error('Неверный код активации пользователя');
        }

        $data = $this->user->get_by_id($user);

        if ($data->user_confirm) {
            redirect(config_item('site_url'));
        }

        if (empty($data) || ! $data->user_id) {
            log_write(LOG_WARNING, 'User not exist (user: ' . $user . ')', __METHOD__);
            show_error('Неверный код активации пользователя');
        }

        if ($this->auth->generate_user_hash($data->user_email) != $code) {
            log_write(LOG_WARNING, 'Activation code not valid (user: ' . $user . ')', __METHOD__);
            show_error('Неверный код активации пользователя');
        }

        $this->user->edit($data->user_id, array('user_confirm' => 1));

        log_write(LOG_INFO, 'Activate user (user: ' . $user . ')', __METHOD__);
        show_error('Ваша учетная запись подтверждена, спасибо!');
    } // function confirm()

    
    /**
     * Create new account
     * @return void
     */
    function create() {
        if ( ! $this->input->is_ajax_request() || $this->auth->is_login()) {
            return redirect(config_item('site_url'));
        }

        $login    = filter($this->input->post('login', TRUE), 'str', 40);
        $passw    = filter($this->input->post('passw', TRUE), 'str', 40);
        $name     = filter($this->input->post('name', TRUE), 'str');
        $lastname = filter($this->input->post('lastname', TRUE), 'str');
        $midname  = filter($this->input->post('name', TRUE), 'str');
        $phone    = filter($this->input->post('phone', TRUE), 'str');

        if ( ! $login || ! $passw || ! $name || ! $lastname || ! $phone) {
            log_write(LOG_WARNING, 'Data entry error', __METHOD__);

            return $this->output->set_output(json_encode(array(
                'state' => false,
                'link'  => '',
                'text'  => 'Произошла ошибка при регистрации. Попробуйте обновить страницу. При повторной ошибке обратитесь к администратору.'
            )));
        }

        if ($this->user->is_exists($login)) {
            return $this->output->set_output(json_encode(array(
                'state' => false,
                'link'  => '',
                'text'  => 'Пользователь с таким email-адресом уже зарегистрирован. Если вы уже регистрировались на сайте, просто <a href="/login">авторизуйтесь</a>'
            )));
        }

        $user = array(
            'user_email'    => $login,
            'user_password' => $this->auth->crypt_password($passw),
            'user_phone'    => $phone,
            'user_firstname' => $name,
            'user_lastname'  => $lastname,
            'user_midname'   => $midname,
        );

        log_write(LOG_INFO, 'Registration user: ' . $login, __METHOD__);

        session_regenerate_id();

        $this->user->create($user);
        $this->user->login($login, $passw);
        $this->auth->login();
        $this->auth->check();

        $data = $this->auth->get_user();

        $this->_activation_email($data->user_id, $data->user_email);

        return $this->output->set_output(json_encode(array(
            'state' => true,
            'link'  => '/'
        )));
    } // function create()
    
    
    /**
     * Create and send activation email
     * @access protected
     * @param string $user_id
     * @param string $user_email
     * @param boolean $ajax
     */
    protected function _activation_email($user_id, $user_email, $ajax = FALSE) {
        $activation = get_domain() . 'registration/confirm?code=' . $this->auth->generate_user_hash($user_email) . '&user=' . $user_id;
        $config     = array(
            'protocol'    => 'smtp',
            'smtp_host'   => config_item('smtp_host'),
            'smtp_port'   => config_item('smtp_port'),
            'smtp_user'   => config_item('smtp_user'),
            'smtp_pass'   => config_item('smtp_pass'),
            'smtp_crypto' => config_item('smtp_crypto'),
            'mailtype'    => 'html'
        );
        $this->load->library('email', $config);

        $content = 'Это письмо отправлено с сайта ' . get_domain() . '<br><br>'
            . 'Вы получили это письмо, так как этот e-mail адрес был использован при регистрации на сайте. Если вы не регистрировались на этом сайте, просто проигнорируйте это письмо и удалите его. Вы больше не получите такого письма.<br><br>'
            . 'Благодарим Вас за регистрацию. Мы просим вас подтвердить адрес электронной почты, для проверки того, что введённый e-mail адрес - реальный. Это требуется для защиты от нежелательных злоупотреблений и спама.<br><br>'
            . 'Для подтверждения вашего профиля, перейдите по следующей ссылке:<br><br>'
            . '<a href="' . $activation . '">' . $activation . '</a><br><br>'
            . 'Если и при этих действиях ничего не получилось - обратитесь к Администратору сайта, для разрешения проблемы. Это письмо отправлено роботом, отвечать на него - не нужно.<br><br>'
            . 'С уважением, Администрация ' . get_domain();

        $this->email->from(config_item('smtp_mail'), config_item('smtp_name'));
        $this->email->to($user_email);
        $this->email->subject('Подтверждение регистрации');
        $this->email->message($this->load->view('email', array('content' => $content), TRUE));

        $send = $this->email->send();
        
        if ( ! $send) {
            log_write(LOG_WARNING, 'Send email error (' . $user_email . ')', __METHOD__);

            if ($ajax) {
                return $this->output->set_output(json_encode(array(
                    'state' => false,
                    'code'  => 'error',
                    'text'  => 'Произошла ошибка при отправке почты. Попробуйте обновить страницу. При повторной ошибке обратитесь к администратору.'
                )));
            } else {
                return $send;
            }
        }

        log_write(LOG_INFO, 'Email sent (' . $user_email . ')', __METHOD__);

        if ($ajax) {
            return $this->output->set_output(json_encode(array(
                'state' => true,
                'code'  => 'information',
                'text'  => 'Письмо для подтверждения вашего адреса электронной почты отправлено, убедитесь в его получении. В случае возникновения проблем - свяжитесь с технической поддержкой'
            )));
        } else {
            return $send;
        }
    } // protected function _activation_email($user_id, $user_email, $ajax = FALSE)
}

/* End of file Registration.php */
/* Location: /controllers/Registration.php */
