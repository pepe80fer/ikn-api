<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
require APPPATH.'libraries\RestController.php';
require APPPATH.'libraries\Format.php';

class Genders extends RestController {

    
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
		$this->load->model('genders/Genders_model', 'model');
    }
    

    public function gender_get()
    {
        $this->response($this->model->get_genders());
    }

    public function gender_post()
    {
        // validación de los campos
        $validate = $this->_validate_fields('post', $this->post());
        if($validate['status']) {
            $this->response( $this->model->set_gender($this->post()) );
        } else {
            $this->response($validate);
        }
    }

    public function gender_put()
    {
        // validación de los campos
        $validate = $this->_validate_fields('put', $this->put());
        if($validate['status']) {
            $this->response( $this->model->update_gender($this->put()) );
        } else {
            $this->response($validate);
        }
    }

    public function gender_delete()
    {
        // validación del id
        $id = $this->delete('id');
        $validate = $this->_validate_num($id);
        if($validate['status']) {
            $this->response($this->model->delete_gender($id));
        } else {
            $this->response($validate);
        }
    }

    private function _validate_fields($method, $data=array())
    {
        $result = array('status' => false, 'message' => '');
        //data
        if( empty($data) ) {
            $result['message'] = 'No ha enviado datos';
            return $result;
        }

        //name
        if( ! isset($data['name']) ) {
            $result['message'] = 'Falta el campo: name';
            return $result;
        }
        //name value
        $data['name'] = trim($data['name']);
        if( strlen($data['name']) <= 0 ) {
            $result['message'] = 'El campo name está vacio';
            return $result;
        }

        switch($method) {

            case 'put':
                // id
                if( ! isset($data['id']) ) {
                    $result['message'] = 'Falta el campo: id';
                    return $result;
                }
                // id numeric
                if( ! is_numeric($data['id'])) {
                    $result['message'] = 'El campo id no es válido';
                    return $result;
                }
                // status
                if( ! isset($data['status']) ) {
                    $result['message'] = 'Falta el campo: status';
                    return $result;
                }
                // status numeric
                if( ! is_numeric($data['status'])) {
                    $result['message'] = 'El campo status no es válido';
                    return $result;
                }
            break;
        }
        $result['status'] = true;
        return $result;
    }

    private function _validate_num($num)
    {
        $result = array('status' => false, 'message' => '');
        if( is_null($num)) {
            $result['message'] = 'Debe enviar el identificador';
            return $result;
        }
        if( ! is_numeric($num)) {
            $result['message'] = 'El parámetro enviado no es válido';
            return $result;
        }
        $result['status'] = true;
        return $result;
    }

}

/* End of file Controllername.php */
