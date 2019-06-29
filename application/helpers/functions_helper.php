<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Other helper functions
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   config
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */


if ( ! function_exists('str_cut')) {
    function str_cut($text, $maxlen) {
        $len = (mb_strlen($text) > $maxlen)? mb_strripos(mb_substr($text, 0, $maxlen), ' ') : $maxlen;
        $cutStr = mb_substr($text, 0, $len);
        $temp = (mb_strlen($text) > $maxlen)? $cutStr. '...' : $cutStr;
        return $temp;
    }
}

if ( ! function_exists('filter')) {
    /**
     * Метод фильтрует данные, удаляет невидимые символы, пробелы, HTML сущности,
     * экранирует кавычки, приводит данные к типу, указанному в параметре $type.
     * 
     * @param mixed входные данные
     * @param string тип данных (int - целое число, str - строка без html, txt - экранирует html, url - ссылки, date - дата)
     * @param integer (опционально) максимальная длинна
     * @return mixed преобразованные данные
     */
    function filter($data = '', $type = 'str', $len = NULL) {
        if (is_array($data))
            return $data;

        $data = trim($data);
        $data = ($len && is_string($data) ? substr($data, 0, intval($len)) : $data);

        switch ($type) {
            case 'int' : (int) $data = intval($data);
                break;
            case 'float' : (float) $data = floatval($data);
                break;
            case 'str' : case 'txt' :
                $data = addslashes(urldecode($data));
                $data = strip_tags($data);
                //$data = str_replace(array('"', "'"), '', $data);            
                $data = htmlspecialchars(stripslashes($data), ENT_QUOTES);
                break;
            case 'url' :
                $data = addslashes(strip_tags(urldecode($data)));
                
                // Разрешить скобки (временный хак)
                $data = str_replace(array('&#40;', '&#41;'), array('(', ')'), $data);
                break;
            case 'date':
                $data = addslashes(strip_tags(urldecode($data)));
                //$data = ( $this->_validateDate($data) ? $data : FALSE );
                break;
        }

        return $data;
    } // function filter($data = '', $type = 'str', $len = NULL)
}

if ( ! function_exists('guid')) {
    function guid() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}

if ( ! function_exists('get_domain')) {
    /**
     * Return current domain name and protocol
     * @return string
     */
    function get_domain() {
        $protocol = ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domain   = $_SERVER['HTTP_HOST'] . '/';
        
        return $protocol . $domain;
    } // function get_domain()
}

if ( ! function_exists('calc_age')) {
    /**
     * Calculate age on input date
     * @param mixed(int|string) $date
     * @return int
     */
    function calc_age($date) {
        if (is_int($date)) {
            $date = date('Y-m-d', $date);
        }

        $from = new DateTime(date('Y-m-d', strtotime($date)));
        $to   = new DateTime('today');

        return $from->diff($to)->y;
    } // function calc_age($date)
}

if ( ! function_exists('num2word')) {
    /**
     * Function for determining the end of a word by a numeral
     * @param int $num
     * @param array $words
     * @return string
     */
    function num2word($num, $words) {
        $num = $num % 100;

        if ($num > 19) {
            $num = $num % 10;
        }

        switch ($num) {
            case 1: {
                return $words[0];
            }
            case 2: case 3: case 4: {
                return $words[1];
            }
            default: {
                return $words[2];
            }
        }
    } // function num2word($num, $words)
}

if ( ! function_exists('format_bytes')) {
    /**
     * Filesize coversion
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function format_bytes($bytes, $precision = 2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
        $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow]; 
    } // function format_bytes($bytes, $precision = 2)
}


if ( ! function_exists('formatdate')) {
    /**
     * Date format function
     * @param mixed(string|integer) $date
     * @return string
     */
    function formatdate($date, $format = 'd.m.Y H:i') {
        $ru_month = array('Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек');
        $en_month = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

        $date = is_string($date) ? strtotime($date) : $date;

        if ( ! is_int($date)) {
            return $date;
        }

        return str_replace($en_month, $ru_month, date($format, $date));
    } // function formatdate($date, $format = 'd.m.Y i:H')
}

if ( ! function_exists('create_password')) {
    /**
     * Create random user password
     * @param integer $length
     * @return string
     */
    function create_password($length = 8) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    } // function create_password($length = 8)
}

if ( ! function_exists('convert_status')) {
    /**
     * Replace point status
     * @param int $code
     * @return array
     */
    function convert_status($code) {
        switch ((int) $code) {
            case STATUS_DRAFT    : return array('code' => 'light', 'text' => 'черновик');
            case STATUS_CREATED  : return array('code' => 'primary', 'text' => 'новая');
            case STATUS_SENT     : return array('code' => 'warning', 'text' => 'проверка');
            case STATUS_INWORK   : return array('code' => 'warning', 'text' => 'в работе');
            case STATUS_DONE     : return array('code' => 'success', 'text' => 'выполнено');
            case STATUS_REJECTED : return array('code' => 'danger', 'text' => 'отклонено');
            case STATUS_DENIAL   : return array('code' => 'danger', 'text' => 'отказано');
            case STATUS_PLANNED  : return array('code' => 'purple', 'text' => 'запланировано');
            case STATUS_DELETED  : return array('code' => 'danger', 'text' => 'удалено');
        }
    } // function convert_status($code)
}

if ( ! function_exists('convert_log_status')) {
    /**
     * Replace advert log status
     * @param int $code
     * @return array
     */
    function convert_log_status($code) {
        switch ((int) $code) {
            case AD_LOG_CREATE : return array('code' => 'light', 'text' => 'создано');
            case AD_LOG_EDITED : return array('code' => 'purple', 'text' => 'отредактировано');
            case AD_LOG_ONPAY  : return array('code' => 'warning', 'text' => 'отправлено на оплату');
            case AD_LOG_PAID   : return array('code' => 'success', 'text' => 'оплачено');
            case AD_LOG_CHECK  : return array('code' => 'primary', 'text' => 'проверено модератором');
            case AD_LOG_STATUS : return array('code' => 'purple', 'text' => 'изменен статус');
            case AD_LOG_DELETE : return array('code' => 'danger', 'text' => 'удалено');
            case AD_LOG_REJECT : return array('code' => 'danger', 'text' => 'отклонено');
        }
    } // function convert_status($code)
}

if ( ! function_exists('convert_user_roles')) {
    /**
     * Replace user roles to array string (for badges)
     * @param int $code
     * @return array
     */
    function convert_user_roles($code) {
        switch ((int) $code) {
            case ROLE_DEVELOPER : return array('code' => 'danger', 'text' => 'разработчик');
            case ROLE_ADMIN     : return array('code' => 'warning', 'text' => 'администратор');
            case ROLE_MODERATOR : return array('code' => 'success', 'text' => 'модератор');
            case ROLE_USER      : return array('code' => 'info', 'text' => 'пользователь');
        }
    } // function convert_user_roles($code)
}

if ( ! function_exists('log_write')) {
    /**
     * Logging write function
     * @staticvar type $_log
     * @param string $level
     * @param string $message
     * @param string $method
     * @param string $prefix
     */
    function log_write($level, $message, $method, $prefix = 'log') {
        static $_logging;

        if ($_logging === NULL) {
            $_logging[0] =& load_class('Logging');
	}

        $_logging[0]->write($level, $message, $method, $prefix);
    } // function log_write($level, $message, $method, $prefix = '')
}

if ( ! function_exists('json_escape')) {
    /**
     * Clears an array of objects from special characters, which can break the JSON array
     * @param atrray $array
     * @return array
     */
    function json_escape($array) {
        if ( ! is_array($array)) {
            return $array;
        }
        
        $escapers     = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
        
        foreach ($array as $key1 => $object) {
            if ( ! is_object($object)) {
                continue;
            }

            foreach ($object as $key2 => $value) {
                if ( ! is_string($value)) {
                    continue;
                }

                $array[$key1]->$key2 = htmlspecialchars(str_replace($escapers, $replacements, $value), ENT_QUOTES, 'UTF-8');
            }
        }

        return $array;
    } // function json_escape($array)
}

if ( ! function_exists('debug')) {
    /**
     * Функция использует метод var_dump для отладки
     *
     * @param mixed
     * @return string
     */
    function debug($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    } // function debug($data)
}

/* End of file functions_helper.php */
/* Location: /helpers/functions_helper.php */