<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Custom library log
 * 
 * define('LOG_EMERG',   'EMERGENCY'); // system is unusable
 * define('LOG_ALERT',   'ALERT');     // action must be taken immediately
 * define('LOG_CRIT',    'CRITICAL');  // critical conditions
 * define('LOG_ERR',     'ERROR');     // error conditions
 * define('LOG_WARNING', 'WARNING');   // warning conditions
 * define('LOG_NOTICE',  'NOTICE');    // normal, but significant, condition
 * define('LOG_INFO',    'INFO');      // informational message
 * define('LOG_DEBUG',    'DEBUG');    // debug-level message
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   library
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class MY_Logging {

    /**
     * CONSTRUCTOR
     */
    function __construct() {
         $this->ci =& get_instance();
    } // function __construct()


    /**
     * Write message to log
     * 
     * @param string $level
     * @param string $message
     * @param string $component
     * @param string $file_prefix file name prefix
     */
    function write($level = LOG_NOTICE, $message, $component = '', $file_prefix = 'log') {
        $level    = ' | ' . self::debug_level($level) . ' | ';
        $filepath = FCPATH . 'logs/' . $file_prefix . '-' . date('Y-m-d') . '.log';

        if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE)) {
            show_error('Does not a create log file');
        }

        $line = date('M d H:i:s') . $level . ($component ? $component : 'framework') . ' | ' . $message . "\n";

        flock($fp, LOCK_EX);
        fwrite($fp, $line);
        flock($fp, LOCK_UN);
        fclose($fp);

        @chmod($filepath, FILE_WRITE_MODE);
    } // function write($level = LOG_NOTICE, $message, $component = '')


    /**
     * The function of converting the level of the syslog message
     * 
     * @static
     * @link http:// nl3.php.net/syslog log levels
     * @param string $level
     * @return string
     */
    static function debug_level($level) {
        switch($level) {
            case LOG_EMERG:   return "EMERGENCY"; break; // system is unusable
            case LOG_ALERT:   return "ALERT";     break; // action must be taken immediately
            case LOG_CRIT:    return "CRITICAL";  break; // critical conditions
            case LOG_ERR:     return "ERROR";     break; // error conditions
            case LOG_WARNING: return "WARNING";   break; // warning conditions
            case LOG_NOTICE:  return "NOTICE";    break; // normal, but significant, condition
            case LOG_INFO:    return "INFO";      break; // informational message
            case LOG_DEBUG:   return "DEBUG";     break; // debug-level message
        }
    } // static function debug_level($level)
}

// END MY_Logging library class

/* End of file MY_Logging.php */
/* Location: /application/libraries/MY_Logging.php */