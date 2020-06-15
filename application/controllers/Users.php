<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
require APPPATH.'libraries\RestController.php';
require APPPATH.'libraries\Format.php';

class Users extends RestController {

    
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
		$this->load->model('users/Users_model', 'model');
    }
    

    public function user_get()
    {
        $this->response($this->model->get_users());
    }

    public function user_post()
    {
        // validación de los campos
        $validate = $this->_validate_fields('post', $this->post());
        if($validate['status']) {
            $this->response( $this->model->set_user($this->post()) );
        } else {
            $this->response($validate);
        }
    }

    public function user_put()
    {
        // validación de los campos
        $validate = $this->_validate_fields('put', $this->put());
        if($validate['status']) {
            $this->response( $this->model->update_user($this->put()) );
        } else {
            $this->response($validate);
        }
    }

    public function user_delete($id)
    {
        // validación del id
        $validate = $this->_validate_num($id);
        if($validate['status']) {
            $this->response($this->model->delete_user($id));
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
        //profile
        if( ! isset($data['profile']) ) {
            $result['message'] = 'Falta el campo: profile';
            return $result;
        }
        //profile value
        if( ! is_numeric($data['profile']) ) {
            $result['message'] = 'El campo profile no es válido';
            return $result;
        }
        //profile value
        if( is_numeric($data['profile']) && $data['profile'] <= 0 ) {
            $result['message'] = 'El valor de profile no es válido';
            return $result;
        }
        //gender
        if( ! isset($data['gender']) ) {
            $result['message'] = 'Falta el campo: gender';
            return $result;
        }
        //gender value
        if( ! is_numeric($data['gender']) ) {
            $result['message'] = 'El campo gender no es válido';
            return $result;
        }
        //gender value
        if( is_numeric($data['gender']) && $data['gender'] < 0 ) {
            $result['message'] = 'El valor de gender no es válido';
            return $result;
        }
        //idType
        if( ! isset($data['idType']) ) {
            $result['message'] = 'Falta el campo: idType';
            return $result;
        }
        //idType value
        if( ! is_numeric($data['idType']) ) {
            $result['message'] = 'El campo idType no es válido';
            return $result;
        }
        //idType value
        if( is_numeric($data['idType']) && $data['idType'] <= 0 ) {
            $result['message'] = 'El valor de idType no es válido';
            return $result;
        }
        //identification
        if( ! isset($data['identification']) ) {
            $result['message'] = 'Falta el campo: identification';
            return $result;
        }
        //identification value
        $data['identification'] = trim($data['identification']);
        if( strlen($data['identification']) <= 0 ) {
            $result['message'] = 'El campo identification está vacio';
            return $result;
        }
        //password
        if( ! isset($data['password']) ) {
            $result['message'] = 'Falta el campo: password';
            return $result;
        }
        //password value
        if( strlen($data['password']) ) {
            $data['password'] = trim($data['password']);
            if( strlen($data['password']) <= 0 ) {
                $result['message'] = 'El campo password está vacio';
                return $result;
            }
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
        //lastname
        if( ! isset($data['lastname']) ) {
            $result['message'] = 'Falta el campo: lastname';
            return $result;
        }
        //lastname value
        if( strlen($data['lastname']) ) {
            $data['lastname'] = trim($data['lastname']);
            if( strlen($data['lastname']) <= 0 ) {
                $result['message'] = 'El campo lastname está vacio';
                return $result;
            }
        }
        //girthdate
        if( ! isset($data['girthdate']) ) {
            $result['message'] = 'Falta el campo: girthdate';
            return $result;
        }
        //girthdate value
        if( strlen($data['girthdate']) ) {
            $data['girthdate'] = trim($data['girthdate']);
            if( strlen($data['girthdate']) <= 0 ) {
                $result['message'] = 'El campo girthdate está vacio';
                return $result;
            }
        }
        //email
        if( ! isset($data['email']) ) {
            $result['message'] = 'Falta el campo: email';
            return $result;
        }
        //email value
        $data['email'] = trim($data['email']);
        if( strlen($data['email']) <= 0 ) {
            $result['message'] = 'El campo email está vacio';
            return $result;
        }
        //phone
        if( ! isset($data['phone']) ) {
            $result['message'] = 'Falta el campo: phone';
            return $result;
        }
        //phone value
        if( strlen($data['phone']) ) {
            $data['phone'] = trim($data['phone']);
            if( strlen($data['phone']) <= 0 ) {
                $result['message'] = 'El campo phone está vacio';
                return $result;
            }
        }
        //address
        if( ! isset($data['address']) ) {
            $result['message'] = 'Falta el campo: address';
            return $result;
        }
        //address value
        if( strlen($data['address']) ) {
            $data['address'] = trim($data['address']);
            if( strlen($data['address']) <= 0 ) {
                $result['message'] = 'El campo address está vacio';
                return $result;
            }
        }

        if($method == 'put') {
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
