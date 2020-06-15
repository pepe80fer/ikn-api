<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Profiles_model {

    private $ci;
    private $fields = array(
        'get' => array(
            'uspr_id' => 'id', 
            'uspr_name' => 'name', 
            'status' => 'status'),
        'post' => array(
            'name'=>'uspr_name'
        ),
        'put' => array(
            'id' => 'uspr_id',
            'name'=>'uspr_name',
            'status' => 'status'
        ),
        'delete' => array('uspr_id')
    );
    private $result = array('status' => true, 'message' => '', 'data' => null);

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('profiles/Profiles_db', 'pr_db');
    }

    public function get_profiles()
    {
        return $this->ci->pr_db->get_profiles( select_columns($this->fields['get']) );
    }

    public function set_profile($data)
    {
        // Campos que se insertan
        $data_insert = fields_relation($this->fields['post'], $data);
        if(! empty($data_insert)) {
            $id = $this->ci->pr_db->set_profile($data_insert);
            if($id) {
                $this->result['data'] = $id;
                $this->result['message'] = 'Perfil insertado correctamente';
            } else {
                $this->result['status'] = false;
                $this->result['message'] = 'No se pudo insertar el perfil. Por intente nuevamente.';
            }
        } else {
            $this->result['status'] = false;
            $this->result['message'] = 'No hay datos para insertar. Por favor revise e intente nuevamente.';
        }
        return $this->result;
    }

    public function update_profile($data)
    {
        // campos a actualizar
        $data_update = fields_relation($this->fields['put'], $data);
        $id = array_shift($data_update);
        $where = array_fill_keys($this->fields['delete'], $id);
        if(! empty($data_update) && ! empty($where)) {
            if($this->ci->pr_db->update_profile($data_update, $where)) {
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

    public function delete_profile($id)
    {
        $where = array_fill_keys($this->fields['delete'], $id);
        if($this->ci->pr_db->delete_profile($where)) {
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
