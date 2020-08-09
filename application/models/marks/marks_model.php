<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Marks_model {

    private $ci;
    private $fields = array(
        'get' => array(
            'prma_id' => 'id', 
            'prma_name' => 'name', 
            'status' => 'status'),
        'post' => array(
            'name'=>'prma_name'
        ),
        'put' => array(
            'id' => 'prma_id',
            'name'=>'prma_name',
            'status' => 'status'
        ),
        'delete' => array('prma_id')
    );
    private $result = array('status' => true, 'message' => '', 'data' => null);

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('marks/Marks_db', 'pr_db');
    }

    public function get_marks()
    {
        return $this->ci->pr_db->get_marks( select_columns($this->fields['get']) );
    }

    public function set_mark($data)
    {
        // Campos que se insertan
        $data_insert = fields_relation($this->fields['post'], $data);
        if(! empty($data_insert)) {
            $id = $this->ci->pr_db->set_mark($data_insert);
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

    public function update_mark($data)
    {
        // campos a actualizar
        $data_update = fields_relation($this->fields['put'], $data);
        $id = array_shift($data_update);
        $where = array_fill_keys($this->fields['delete'], $id);
        if(! empty($data_update) && ! empty($where)) {
            if($this->ci->pr_db->update_mark($data_update, $where)) {
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

    public function delete_mark($id)
    {
        $where = array_fill_keys($this->fields['delete'], $id);
        if($this->ci->pr_db->delete_mark($where)) {
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
