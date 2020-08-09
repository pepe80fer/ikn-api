<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
require APPPATH.'libraries\RestController.php';
require APPPATH.'libraries\Format.php';

class Colors extends RestController {

    
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
		$this->load->model('colors/Colors_model', 'model');
    }
    

    public function color_get()
    {
        $this->response($this->model->get_colors());
    }

    public function color_post()
    {
        // validación de los campos
        $validate = $this->_validate_fields('post', $this->post());
        if($validate['status']) {
            $this->response( $this->model->set_color($this->post()) );
        } else {
            $this->response($validate);
        }
    }

    public function color_put()
    {
        // validación de los campos
        $validate = $this->_validate_fields('put', $this->put());
        if($validate['status']) {
            $this->response( $this->model->update_color($this->put()) );
        } else {
            $this->response($validate);
        }
    }

    public function color_delete()
    {
        // validación del id
        $id = $this->delete('id');
        $validate = $this->_validate_num($id);
        if($validate['status']) {
            $this->response($this->model->delete_color($id));
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
        // colorCode
        if( ! isset($data['colorCode']) ) {
            $result['message'] = 'El campo colorCode está vacio';
            return $result;
        }
        // colorCode value
        $data['colorCode'] = trim($data['colorCode']);
        if( strlen($data['colorCode']) <= 0 ) {
            $result['message'] = 'Por favor seleccione el código del color';
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
