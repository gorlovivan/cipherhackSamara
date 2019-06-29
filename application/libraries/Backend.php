<?php
 
/**
 * Backend library
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   library
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class Backend {

    private $backend_url;
    private $backend_token;
    private $backend_urn;
    private $backend_source;

    /**
     * ENDPOINT
     * @param string $name
     * @param array $data
     * @return string
     * @throws Exception
     */
    function endpoint($name, $data = array()) {
        if (empty($this->backend_url)) {
            throw new Exception('No module authorization URL address');
        }

        return $this->_curl($this->backend_url . $name, $data);
    } // function endpoint($name, $data)


    function init($config = array()) {
        if (isset($config['backend_url'])) {
            $this->backend_url = $config['backend_url'];
        }
        if (isset($config['backend_token'])) {
            $this->backend_token = $config['backend_token'];
        }
        if (isset($config['backend_urn'])) {
            $this->backend_urn = $config['backend_urn'];
        }
        if (isset($config['backend_source'])) {
            $this->backend_source = $config['backend_source'];
        }
    } // function init($config = array())
    
    
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
        $this->backend_url = $url;
    }

    function set_token($token) {
        $this->backend_token = $token;
    }

    function set_urn($urn) {
        $this->backend_urn = $urn;
    }

    function set_source($source) {
        $this->backend_source = $source;
    }


    /**
     * Curl function
     * @param string $url
     * @param array $post
     * @return string
     */
    protected function _curl($url, array $post) {
        $curl = curl_init($url);

        $post['urn']         = $this->backend_urn;
        $post['accessToken'] = $this->backend_token;
        $post['source']      = $this->backend_source;

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

// END Backend library class

/* End of file Backend.php */
/* Location: /application/libraries/Backend.php */