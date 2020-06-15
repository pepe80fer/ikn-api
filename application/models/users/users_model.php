<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model {

    private $ci;
    private $fields = array(
        'get' => array(
            'user_id' => 'id',
            'uspr_id' => 'profile',
            'usge_id' => 'gender',
            'usid_id' => 'idType',
            'user_ident' => 'identification',
            'user_pass' => 'password',
            'user_name' => 'name',
            'user_lastname' => 'lastname',
            'user_girthdate' => 'girthdate',
            'user_email' => 'email',
            'user_phone' => 'phone',
            'user_address' => 'address',
            'status' => 'status'
        ),
        'post' => array(
            'profile' => 'uspr_id',
            'gender' => 'usge_id',
            'idType' => 'usid_id',
            'identification' => 'user_ident',
            'password' => 'user_pass',
            'name' => 'user_name',
            'lastname' => 'user_lastname',
            'girthdate' => 'user_girthdate',
            'email' => 'user_email',
            'phone' => 'user_phone',
            'address' => 'user_address'
        ),
        'put' => array(
            'id' => 'user_id',
            'profile' => 'uspr_id',
            'gender' => 'usge_id',
            'idType' => 'usid_id',
            'identification' => 'user_ident',
            'password' => 'user_pass',
            'name' => 'user_name',
            'lastname' => 'user_lastname',
            'girthdate' => 'user_girthdate',
            'email' => 'user_email',
            'phone' => 'user_phone',
            'address' => 'user_address',
            'status' => 'status'
        ),
        'delete' => array('user_id')
    );
    private $result = array('status' => true, 'message' => '', 'data' => null);

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('users/Users_db', 'pr_db');
    }

    public function get_users()
    {
        return $this->ci->pr_db->get_users( select_columns($this->fields['get']) );
    }

    public function set_user($data)
    {
        // Campos que se insertan
        $data_insert = fields_relation($this->fields['post'], $data);
        // validar si existe un usuario por el email o el número de identificación

        if(! empty($data_insert)) {
            $id = $this->ci->pr_db->set_user($data_insert);
            if($id) {
                $this->result['data'] = $id;
                $this->result['message'] = 'Insertado correctamente';
            } else {
                $this->result['status'] = false;
                $this->result['message'] = 'No se pudo insertar. Por intente nuevamente.';
            }
        } else {
            $this->result['status'] = false;
            $this->result['message'] = 'No hay datos para insertar. Por favor revise e intente nuevamente.';
        }
        return $this->result;
    }

    public function update_user($data)
    {
        // campos a actualizar
        $data_update = fields_relation($this->fields['put'], $data);
        $id = array_shift($data_update);
        $where = array_fill_keys($this->fields['delete'], $id);
        if(! empty($data_update) && ! empty($where)) {
            if($this->ci->pr_db->update_user($data_update, $where)) {
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

    public function delete_user($id)
    {
        $where = array_fill_keys($this->fields['delete'], $id);
        if($this->ci->pr_db->delete_user($where)) {
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
