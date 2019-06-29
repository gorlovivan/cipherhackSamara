<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Point form page controller
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   controller
 * @author     Mikhail Topchilo (Mik™) <http://miksrv.ru> <miksoft.tm@gmail.com>
 */
class Form extends CI_Controller {
   
    /**
     * Global view template array
     * @var array
     */
    var $TPLVAR = array();

    function __construct() {
        parent::__construct();

        $this->auth->check();
        
        $this->load->model('point');
        $this->load->model('media');
        $this->load->model('category');

        $this->TPLVAR['user'] = $this->auth->get_user();
    } // function __construct()


    /**
     * edit page point form
     */
    function point() {
        $item = filter($this->uri->segment(3), 'str', 40);

        if ($this->input->is_ajax_request() && $item) {
            return $this->_save($item);
        }
        
        if ( ! $item) {
            redirect(config_item('site_url'));
        }

        $point = $this->point->get_by_id($item);

        if ( ! $point || empty($point)) {
            log_write(LOG_WARNING, 'Point object not found, ID: ' . $item . ', USER: ' . $this->auth->get_user_id(), __METHOD__);
            redirect(config_item('site_url'));
        }

        if ($point->item_author != $this->auth->get_user_id() || $point->item_status != STATUS_DRAFT) {
            log_write(LOG_WARNING, 'Point object form access error, ID: ' . $item . ', USER: ' . $this->auth->get_user_id(), __METHOD__);
            redirect(config_item('site_url'));
        }

        $this->TPLVAR['title']    = 'Редактирование проблемы';
        $this->TPLVAR['data']     = $point;
        $this->TPLVAR['photos']   = $this->media->get_by_point($point->item_id);
        $this->TPLVAR['category'] = $this->category->get_all();
        
        $this->load->view('form', $this->TPLVAR);
    } // function point()
    
    
    /**
     * Photo remove action
     * @return JSON
     */
    function photo_remove() {
        if ( ! $this->input->is_ajax_request() || ! $this->auth->is_login()) {
            return redirect(config_item('site_url'));
        }
        
        $item  = filter($this->uri->segment(3), 'str', 40);
        $photo = $this->media->get_by_id($item);
        
        if ( ! $photo || empty($photo)) {
            log_write(LOG_WARNING, 'Photo not found, ID: ' . $item . ', USER: ' . $this->auth->get_user_id(), __METHOD__);
            return $this->output->set_output(json_encode(array(
                'code'  => 'error'
            )));
        }
        
        if ($photo->item_author != $this->auth->get_user_id()) {
            log_write(LOG_ERR, 'User is not the author of the photo, ID: ' . $item . ', USER: ' . $this->auth->get_user_id(), __METHOD__);
            return $this->output->set_output(json_encode(array(
                'code'  => 'error'
            )));
        }

        $image = explode('.', $photo->item_filename);

        unlink(FCPATH . '/uploads/' . $photo->item_point . '/' . $image[0] . '_thumb.' . $image[1]);
        unlink(FCPATH . '/uploads/' . $photo->item_point . '/' . $image[0] . '.' . $image[1]);

        $this->media->remove($item);
        
        return $this->output->set_output(json_encode(array(
            'code'  => 'luck'
        )));
    } // function photo_remove()

    
    /**
     * Photo upload action
     * @return JSON
     */
    function upload() {
        $item   = filter($this->uri->segment(3), 'str', 40);
        $point  = $this->point->get_by_id($item);

        if ( ! $point || empty($point)) {
            log_write(LOG_WARNING, 'Point object not found, ID: ' . $item . ', USER: ' . $this->auth->get_user_id(), __METHOD__);
            redirect(config_item('site_url'));
        }
        
        $photos = $this->media->get_by_point($item);

        if (count($photos) >= config_item('max_photo_upload')) {
            return $this->output->set_output(json_encode(array(
                'code' => 'error',
                'text' => 'Загружено максимальное количество фотографий для этого обращения'
            )));
        }

        if ($point->item_author != $this->auth->get_user_id()) {
            log_write(LOG_ERR, 'User is not the author of the point, ID: ' . $item . ', USER: ' . $this->auth->get_user_id(), __METHOD__);
            return $this->output->set_output(json_encode(array(
                'code'  => 'error'
            )));
        }

        $directory = FCPATH . 'uploads/' . $item;

        if ( ! is_dir($directory)) {
            mkdir($directory, 0777, TRUE);
        }

        $config['upload_path']   = $directory;
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size']      = 8000;
        $config['max_width']     = 6000;
        $config['max_height']    = 6000;
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file')) {

            debug($this->upload->display_errors());

        } else {
            
            $upload_data = $this->upload->data();
            
            $resize['image_library']  = 'gd2';
            $resize['create_thumb']   = TRUE;
            $resize['maintain_ratio'] = TRUE;
            $resize['quality']        = '60%';
            $resize['width']          = 280;
            $resize['height']         = 280;
            $resize['source_image']   = $upload_data['full_path'];
            
            $this->load->library('image_lib', $resize);
            
            if ( ! $this->image_lib->resize()) {
                debug($this->image_lib->display_errors());
            }

            $image = array(
                'item_title'     => $point->item_name,
                'item_mime'      => $upload_data['file_type'],
                'item_size'      => filesize($upload_data['full_path']),
                'item_point'     => $item,
                'item_ext'       => str_replace('.', '', $upload_data['file_ext']),
                'item_filename'  => $upload_data['file_name'],
                'item_latitude'  => $point->item_latitude,
                'item_longitude' => $point->item_longitude,
            );

            $image_id = $this->media->create($image);

            log_write(LOG_INFO, 'Image save, ID: ' . $image_id . ', USER: ' . $this->auth->get_user_id(), __METHOD__);

            $photo = explode('.', $upload_data['file_name']);

            return $this->output->set_output(json_encode(array(
                'code'  => 'luck',
                'image' => '/uploads/' . $item . '/' . $photo[0] . '_thumb.' . $photo[1],
                'id'    => $item
            )));
        }

        log_write(LOG_ERR, 'Image not loaded, PointID: ' . $item . ', USER: ' . $this->auth->get_user_id(), __METHOD__);
        
        return $this->output->set_output(json_encode(array(
            'code'  => 'error'
        )));
    } // function upload()
    
    
    /**
     * Methdo send yandex geocode request
     * @return JSON
     */
    function geocode() {
        if ( ! $this->input->is_ajax_request() || ! $this->auth->is_login()) {
            return redirect(config_item('site_url'));
        }
        
        $latitude  = filter($this->input->get('lat'), 'float', 20);
        $longitude = filter($this->input->get('lon'), 'float', 20);

        if (empty($latitude) || empty($longitude)) {
            return $this->output->set_output(json_encode(array(
                'code'  => 'error'
            )));
        }

        $this->load->library('Location');
        
        $geocode = $this->location->get_address($latitude, $longitude);

        if ( ! empty($geocode) && is_array($geocode)) {
            return $this->output->set_output(json_encode(array(
                'code'    => 'luck',
                'address' => $geocode['address']
            )));
        }

        log_write(LOG_WARNING, 'Yandex geocode error, USER: ' . $this->auth->get_user_id(), __METHOD__);

        return $this->output->set_output(json_encode(array(
            'code'    => 'error',
            'address' => 'Сервер определения местоположения недоступен. Попробуйте позже.'
        )));
    } // function geocode()


    /**
     * Save point
     * @param string $item
     * @return JSON
     */
    protected function _save($item) {
        $save = array(
            'item_latitude'    => filter($this->input->post('item_latitude', TRUE), 'float'),
            'item_longitude'   => filter($this->input->post('item_longitude', TRUE), 'float'),
            'item_category'    => filter($this->input->post('item_category', TRUE), 'str', 30),
            'item_address'     => filter($this->input->post('item_address', TRUE), 'str', 200),
            'item_message'     => filter($this->input->post('item_message', TRUE), 'text', 5000),
            'item_status'      => STATUS_INWORK,
        );

        $this->point->update($item, $save);
        $this->point->update_status($item, $save['item_status']);

        log_write(LOG_INFO, 'Point save, ID: ' . $item . ', USER: ' . $this->auth->get_user_id(), __METHOD__);

        return $this->_send_backend($item, $save);
    } // protected function _save($item)
    
    
    /**
     * Send data to object
     * @param array $save
     */
    protected function _send_backend($item, $save) {
        $config = array(
            'backend_url'    => config_item('backend_url'),
            'backend_token'  => config_item('backend_token'),
            'backend_urn'    => config_item('backend_urn'),
            'backend_source' => config_item('backend_source'),
        );

        $this->load->library('backend');
        $this->backend->init($config);

        $this->point->update_status($item, STATUS_SENT);
        $this->point->update_status($item, STATUS_INWORK);
/*
        $this->backend->endpoint('send_point', array(
            'person' => array(
                'family'        => $this->TPLVAR['user']->user_lastname,
                'name'          => $this->TPLVAR['user']->user_firstname,
                'patronymic'    => $this->TPLVAR['user_midname']->user_firstname,
                'snils'         => '',
                'personEsiaOid' => '',
            ),
            'contacts' => array(
                'phone' => $this->TPLVAR['user_midname']->user_phone,
                'email' => $this->TPLVAR['user_midname']->user_email,
            ),
            'appeal' => array(
                'id'  => $item,
                'url' => config_item('site_url') . 'points/appeals/' . $item,
                'topic' => ''
            )
        ));
        */
        return $this->output->set_output(json_encode(array(
            'code' => 'luck',
            'item' => $item
        )));
    } // protected function _send_backend($save)
}

/* End of file Form.php */
/* Location: /controllers/Form.php */
