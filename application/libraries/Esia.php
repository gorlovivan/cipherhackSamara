<?php
 
/**
 * Module Authorization
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   library
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class Esia {
    
    /**
     * ESIA auth module link
     * @var string
     */
    private $esia_ma_url;

    private $client_id;
    private $secret_key;
    private $redirect_url;
    private $scopes;
    private $session_id;

    /**
     * CURL response
     * @var string
     */
    protected $_response;

    
    /**
     * ENDPOINT
     * @param string $name
     * @param array $data
     * @return string
     * @throws Exception
     */
    function endpoint($name, $data = array()) {
        if (empty($this->esia_ma_url)) {
            throw new Exception('No module authorization URL address');
        }

        return $this->_curl($this->esia_ma_url . $name, $data);
    } // function endpoint($name, $data)


    /**
     * Return CURL response
     * @return string
     */
    function response() {
        return json_decode($this->_response);
    } // function response()


    /**
     * Set functions
     * @param string $url
     */
    function set_module_url($url) {
        $this->esia_ma_url = $url;
    } // function set_module_url($url)

    function set_clinet_id($client_id) {
        $this->client_id = $client_id;
    } // function set_clinet_id($client_id)

    function set_secret_key($secret_key) {
        $this->secret_key = $secret_key;
    } // function set_secret_key($secret_key)

    function set_redirect($url) {
        $this->redirect_url = $url;
    } // function set_redirect($url)

    function set_scopes($string) {
        $this->scopes = $string;
    } // function set_scopes($string)

    function set_session($id) {
        $this->session_id = $id;
    } // function set_session($id)
 

    /**
     * Curl function
     * @param string $url
     * @param array $post
     * @return string
     */
    protected function _curl($url, array $post) {
        $curl = curl_init($url);

        $post['client_id']    = $this->client_id;
        $post['secret_key']   = $this->secret_key;
        $post['session_id']   = $this->session_id;
        $post['redirect_url'] = $this->redirect_url;

        if ( ! is_null($this->scopes)) {
            $post['scopes'] = $this->scopes;
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_ENCODING , 'gzip, deflate');
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($curl, CURLOPT_POST, 1);

        $this->_response = curl_exec($curl);

        $err = intval(curl_errno($curl));

        curl_close($curl);

        return $err;
    } // protected function _curl($url, $post)
}

// END Esia library class

/* End of file Esia.php */
/* Location: /application/libraries/Esia.php */