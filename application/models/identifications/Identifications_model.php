<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Identifications_model {

    private $ci;
    private $fields = array(
        'get' => array(
            'usid_id' => 'id', 
            'usid_name' => 'name',
            'usid_abb' => 'abbrev',
            'status' => 'status'),
        'post' => array(
            'name'=>'usid_name',
            'abbrev' => 'usid_abb',
        ),
        'put' => array(
            'id' => 'usid_id',
            'name'=>'usid_name',
            'abbrev' => 'usid_abb',
            'status' => 'status'
        ),
        'delete' => array('usid_id')
    );
    private $result = array('status' => true, 'message' => '', 'data' => null);

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('identifications/Identifications_db', 'pr_db');
    }

    public function get_identifications()
    {
        return $this->ci->pr_db->get_identifications( select_columns($this->fields['get']) );
    }

    public function set_identification($data)
    {
        // Campos que se insertan
        $data_insert = fields_relation($this->fields['post'], $data);
        if(! empty($data_insert)) {
            $id = $this->ci->pr_db->set_identification($data_insert);
            if($id) {
                $this->result['data'] = $id;
                $this->result['message'] = 'Insertado Correctamente';
            } else {
                $this->result['status'] = false;
                $this->result['message'] = 'No se pudo registrar. Por intente nuevamente.';
            }
        } else {
            $this->result['status'] = false;
            $this->result['message'] = 'No hay datos para registrar. Por favor revise e intente nuevamente.';
        }
        return $this->result;
    }

    public function update_identification($data)
    {
        // campos a actualizar
        $data_update = fields_relation($this->fields['put'], $data);
        $id = array_shift($data_update);
        $where = array_fill_keys($this->fields['delete'], $id);
        if(! empty($data_update) && ! empty($where)) {
            if($this->ci->pr_db->update_identification($data_update, $where)) {
                $this->result['message'] = 'Registro actualizado correctamente';
            } else {
                $this->result['status'] = false;
                $this->result['message'] = 'No se ha actualizado ningún registro';
            }
        } else {
            $this->result['status'] = false;
            $this->result['message'] = 'Datos incompletos, por favor revisar.';
        }
        $this->result['data'] = $id;
        return $this->result;
    }

    public function delete_identification($id)
    {
        $where = array_fill_keys($this->fields['delete'], $id);
        if($this->ci->pr_db->delete_identification($where)) {
            $this->result['message'] = 'Registro borrado correctamente';
        } else {
            $this->result['status'] = false;
            $this->result['message'] = 'No se ha borrado ningún registro con ese parámetro';
        }
        $this->result['data'] = $id;
        return $this->result;
    }

}

/* End of file ModelName.php */
