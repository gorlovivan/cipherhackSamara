<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Recovery passsword controller
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   controller
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class Recovery extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check();
    } // function __construct()


    /**
     * login page
     */
    function index() {
        if ($this->auth->is_login()) {
            return redirect('/');
        }

        $this->load->view('recovery');
    } // function index()
    
    
    function code() {
        $pass = filter($this->input->get('pass', TRUE), 'str', 50);
        $mail = filter($this->input->get('user', TRUE), 'str', 50);
        
        if ($this->auth->is_login() || ! $pass || ! $mail) {
            return redirect('/');
        }
        
        $user = $this->user->get_by_email($mail);
        
        if ( ! isset($user->user_id) || empty($user->user_id)) {
            log_write(LOG_WARNING, 'No user found (' . $mail . ')', __METHOD__);
            redirect('/');
        }
        
        if ($pass !== $this->auth->generate_user_hash($user->user_password . date('d') . date('m'))) {
            log_write(LOG_WARNING, 'No user code does not match (' . $mail . ')', __METHOD__);
            redirect('/');
        }

        $password = create_password();

        log_write(LOG_INFO, 'User change password, ID ' . $user->user_id, __METHOD__);

        $this->_email($user->user_email, $user->user_password, $password);

        $this->user->edit($user->user_id, array('user_password' => $this->auth->crypt_password($password)));
        $this->load->view('recovery_success');
    } // function code()

    
    /**
     * Create and send recovery mail
     * @return type
     */
    function send() {
        $email = filter($this->input->get('email', TRUE), 'str', 50);

        if ($this->auth->is_login() || ! $this->input->is_ajax_request()) {
            return redirect('/');
        }

        $user = $this->user->get_by_email($email);

        if ( ! isset($user->user_id) || empty($user->user_id)) {
            return $this->output->set_output(json_encode(array(
                'state' => false,
                'text'  => 'Пользователь с таким email-адресом не зарегистрирован'
            )));
        }

        $this->_email($user->user_email, $user->user_password, FALSE);

        return $this->output->set_output(json_encode(array(
            'state' => true,
            'text'  => 'На ваш email адрес отправлено письмо с инструкцией по восстановлению пароля. Пожалуйста, проверьте свой адрес электронной почты через несколько минут.'
        )));
    } // function send()


    /**
     * Create and send email
     * @access protected
     * @param string $user_email
     * @param string $password
     * @param mixed(boolean|string) $send_password
     * @param boolean $ajax
     */
    protected function _email($user_email, $password, $send_password = FALSE) {
        $recovery = get_domain() . 'recovery/code?pass=' . $this->auth->generate_user_hash($password . date('d') . date('m')) . '&user=' . $user_email;
        $config   = array(
            'protocol'    => 'smtp',
            'smtp_host'   => config_item('smtp_host'),
            'smtp_port'   => config_item('smtp_port'),
            'smtp_user'   => config_item('smtp_user'),
            'smtp_pass'   => config_item('smtp_pass'),
            'smtp_crypto' => config_item('smtp_crypto'),
            'mailtype'    => 'html'
        );
        $this->load->library('email', $config);

        if ( ! $send_password) {
            $content = 'Это письмо отправлено с сайта ' . get_domain() . '<br><br>'
                . 'Вы получили это письмо, так как этот e-mail адрес был использован при регистрации на сайте. Если вы не регистрировались на этом сайте, просто проигнорируйте это письмо и удалите его. Вы больше не получите такого письма.<br><br>'
                . 'Кто-то, возможно и вы, запросил на сайте ' . get_domain() . ' восстановление пароля. Если это были не вы, просто проигнорируйте это письмо.<br><br>'
                . 'Для восстановления пароля вашего профиля, перейдите по следующей ссылке:<br><br>'
                . '<a href="' . $recovery . '">' . $recovery . '</a><br><br>'
                . 'Если при этих действиях ничего не получилось - обратитесь к Администратору сайта, для разрешения проблемы. Это письмо отправлено роботом, отвечать на него - не нужно.<br><br>'
                . 'С уважением, Администрация ' . get_domain();
        } else {
            $content = 'Ваш пароль для аккунта на сайте ' . get_domain() . ' был изменен. Пожалуйста, запомните его.<br><br>'
                . 'Логин: ' . $user_email .'<br>'
                . 'Пароль: ' . $send_password .'<br><br>'
                . 'С уважением, Администрация ' . get_domain();
        }

        $this->email->from(config_item('smtp_mail'), config_item('smtp_name'));
        $this->email->to($user_email);
        $this->email->subject('Восстановление пароля');
        $this->email->message($this->load->view('email', array('content' => $content), TRUE));

        $send = $this->email->send();

        if ( ! $send) {
            log_write(LOG_WARNING, 'Send email error (' . $user_email . ')', __METHOD__);
        } else {
            log_write(LOG_INFO, 'Email sent (' . $user_email . ')', __METHOD__);
        }

        return $send;
    } // protected function _email($user_email)
}

/* End of file Recovery.php */
/* Location: /controllers/Recovery.php */
