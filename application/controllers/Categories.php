<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
require APPPATH.'libraries\RestController.php';
require APPPATH.'libraries\Format.php';

class Categories extends RestController {

    
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
		$this->load->model('categories/Categories_model', 'model');
    }
    

    public function categorie_get()
    {
        $this->response($this->model->get_categories());
    }

    public function categorie_post()
    {
        // validación de los campos
        $validate = $this->_validate_fields('post', $this->post());
        if($validate['status']) {
            $this->response( $this->model->set_categorie($this->post()) );
        } else {
            $this->response($validate);
        }
    }

    public function categorie_put()
    {
        // validación de los campos
        $validate = $this->_validate_fields('put', $this->put());
        if($validate['status']) {
            $this->response( $this->model->update_categorie($this->put()) );
        } else {
            $this->response($validate);
        }
    }

    public function categorie_delete()
    {
        // validación del id
        $id = $this->delete('id');
        $validate = $this->_validate_num($id);
        if($validate['status']) {
            $this->response($this->model->delete_categorie($id));
        } else {
            $this->response($validate);
        }
    }

    public function relation_post()
    {
        // validación de los campos
        $validate = $this->_ids_relation($this->post());
        if($validate['status']) {
            $this->response( $this->model->set_relation($this->post()) );
        } else {
            $this->response($validate);
        }
    }

    public function relation_delete()
    {
        // validación del id
        $id = $this->delete('id');
        $validate = $this->_validate_num($id);
        if($validate['status']) {
            $this->response($this->model->delete_relation($id));
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
        //visible
        if( ! isset($data['visible']) ) {
            $result['message'] = 'Falta el campo: visible';
            return $result;
        }
        //visible numeric
        if( ! is_numeric($data['visible'])) {
            $result['message'] = 'El campo visible no es válido';
            return $result;
        }
        //order
        if( ! isset($data['order']) ) {
            $result['message'] = 'Falta el campo: order';
            return $result;
        }
        //order numeric
        if( ! is_numeric($data['order'])) {
            $result['message'] = 'El campo order no es válido';
            return $result;
        }
        //is_subcategorie
        if( ! isset($data['is_subcategorie']) ) {
            $result['message'] = 'Falta el campo: is_subcategorie';
            return $result;
        }
        //is_subcategorie numeric
        if( ! is_numeric($data['is_subcategorie'])) {
            $result['message'] = 'El campo is_subcategorie no es válido';
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

    private function _ids_relation($data=array())
    {
        $result = array('status' => false, 'message' => '');
        //data
        if( empty($data) ) {
            $result['message'] = 'No ha enviado datos';
            return $result;
        }
        //parent
        if( ! isset($data['parent']) ) {
            $result['message'] = 'No ha enviado una categoría';
            return $result;
        }
        //parent numeric
        if( ! is_numeric($data['parent'])) {
            $result['message'] = 'La categoría no es válida';
            return $result;
        }
        //child
        if( isset($data['child']) && ! is_numeric($data['child'])) {
            $result['message'] = 'La subcategoría no es válida';
            return $result;
        }
        $result['status'] = true;
        return $result;
    }

}

/* End of file Controllername.php */
