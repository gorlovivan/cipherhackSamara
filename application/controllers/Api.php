<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API controller
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   controller
 * @author     Mikhail Topchilo (Mik™) <http://miksrv.ru> <miksoft.tm@gmail.com>
 */
class Api extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('point');
    } // function __construct()
    
    
    function set_status() {
        $data = json_decode(file_get_contents('php://input'));

        if ( ! $data || ! is_object($data)) {
            return $this->output->set_output(json_encode(array(
                'status'   => false,
                'response' => 'ERROR',
                'error'    => 'No data input'
            )));
        }

        if ( ! isset($data->accessToken) || $data->accessToken != config_item('backend_token')) {
            log_write(LOG_CRIT, 'No data, item: ' . $item . ', status: ' . $status, __METHOD__);
            
            return $this->output->set_output(json_encode(array(
                'status'   => false,
                'response' => 'ERROR',
                'error'    => 'API Invalid'
            )));
        }

        $item   = $data->appeal->id;
        $status = $data->appeal->state->type;
        $text   = $data->appeal->state->text;
        $descr  = $data->appeal->state->description;

        switch ($status) {
            case 'REGISTRED' :
                $status = STATUS_INWORK;
                break;

            case 'REJECTED' :
                $status = STATUS_REJECTED;
                break;

            case 'INTERMEDIATE_RESULT' :
                $status = STATUS_DENIAL;
                break;

            case 'CLOSED' : 
                $status = STATUS_DONE;
                break;

            default:
                log_write(LOG_ERR, 'Invalid status, item: ' . $item . ', status: ' . $status, __METHOD__);

                return $this->output->set_output(json_encode(array(
                    'status'   => false,
                    'response' => 'ERROR',
                    'error'    => 'Invalid status: ' . $status
                )));
        }

        $status_array = array(STATUS_INWORK, STATUS_DONE, STATUS_REJECTED, STATUS_DENIAL, STATUS_PLANNED);

        if ( ! $item || ! $status) {
            log_write(LOG_ERR, 'No data, item: ' . $item . ', status: ' . $status, __METHOD__);
            
            return $this->output->set_output(json_encode(array(
                'status'   => false,
                'response' => 'ERROR',
                'error'    => 'No correct ITEM or STATUS'
            )));
        }
        
        if ( ! in_array($status, $status_array)) {
            log_write(LOG_ERR, 'Invalid status, item: ' . $item . ', status: ' . $status, __METHOD__);
            
            return $this->output->set_output(json_encode(array(
                'status'   => false,
                'response' => 'ERROR',
                'error'    => 'Invalid status: ' . $status
            )));
        }

        $point = $this->point->get_by_id($item);

        if ( ! is_object($point) || empty($point)) {
            log_write(LOG_ERR, 'Item not exist, item: ' . $item . ', status: ' . $status, __METHOD__);

            return $this->output->set_output(json_encode(array(
                'status'   => false,
                'response' => 'ERROR',
                'error'    => 'Item width ID ' . $item . ' not exist'
            )));
        }

        log_write(LOG_INFO, 'Status update, item: ' . $item . ', status: ' . $status, __METHOD__);

        $this->point->update($point->item_id, array('item_status' => $status));
        $this->point->update_status($point->item_id, $status, $text, $descr);

        return $this->output->set_output(json_encode(array(
            'status'   => true,
            'urn'      => config_item('backend_urn'),
            'response' => 'OK',
            'type'     => 'TERMINAL',
            'description' => ''
        )));
    }
}

/* End of file Api.php */
/* Location: /controllers/Api.php */
