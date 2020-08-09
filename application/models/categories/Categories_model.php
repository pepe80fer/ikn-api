<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model {

    private $ci;
    private $fields = array(
        'get' => array(
            'prca_id' => 'id', 
            'prca_name' => 'name',
            'prca_visible' => 'visible',
            'prca_order' => 'order',
            'prca_sub' => 'is_subcategorie',
            'status' => 'status'),
        'post' => array(
            'name'=>'prca_name',
            'visible' => 'prca_visible',
            'order' => 'prca_order',
            'is_subcategorie' => 'prca_sub'
        ),
        'put' => array(
            'id' => 'prca_id',
            'name'=>'prca_name',
            'visible' => 'prca_visible',
            'order' => 'prca_order',
            'is_subcategorie' => 'prca_sub',
            'status' => 'status'
        ),
        'delete' => array('prca_id'),
        'relation' => array(
            'parent'=>'prca_id',
            'child'=>'prca_sub_id'
        )
    );
    private $result = array('status' => true, 'message' => '', 'data' => null);

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('categories/Categories_db', 'pr_db');
    }

    public function get_categories()
    {
        return $this->ci->pr_db->get_categories( select_columns($this->fields['get']) );
    }

    public function set_categorie($data)
    {
        // Campos que se insertan
        $data_insert = fields_relation($this->fields['post'], $data);
        if(! empty($data_insert)) {
            $id = $this->ci->pr_db->set_categorie($data_insert);
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

    public function update_categorie($data)
    {
        // campos a actualizar
        $data_update = fields_relation($this->fields['put'], $data);
        $id = array_shift($data_update);
        $where = array_fill_keys($this->fields['delete'], $id);
        if(! empty($data_update) && ! empty($where)) {
            if($this->ci->pr_db->update_categorie($data_update, $where)) {
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

    public function delete_categorie($id)
    {
        $where = array_fill_keys($this->fields['delete'], $id);
        if($this->ci->pr_db->delete_categorie($where)) {
            $this->result['message'] = 'Registro borrado correctamente';
        } else {
            $this->result['status'] = false;
            $this->result['message'] = 'No se ha borrado ningún registro con ese parámetro';
        }
        $this->result['data'] = $id;
        return $this->result;
    }

    public function get_relation($id=null, $id_sub=null, $status=1)
    {
        $where = ['status' => $status];
        if( ! is_null($id) && is_numeric($id) && $id > 0)
            $where['id'] = $id;
        if( ! is_null($id_sub) && is_numeric($id_sub) && $id_sub > 0)
            $where['id_sub'] = $id_sub;
        return $this->ci->pr_db->get_relation($where);
    }

    public function set_relation($data)
    {
        $id = $data['parent'];
        $id_sub = (isset($data['child'])) ? $data['child'] : null;
        // Validar si la relación ya existe
        $relation = current($this->get_relation($id, $id_sub));
        // Validar que no existe la relación
        if(empty($relation) OR ($relation->id == $id && $relation->id_sub != $id_sub )) {
            // Campos que se insertan
            $data_insert = fields_relation($this->fields['relation'], $data);
            if(! empty($data_insert)) {
                $id_rel = $this->ci->pr_db->set_relation($data_insert);
                if($id_rel) {
                    $this->result['data'] = $id_rel;
                    $this->result['message'] = 'Relación insertada correctamente';
                } else {
                    $this->result['status'] = false;
                    $this->result['message'] = 'No se pudo registrar la relación. Por intente nuevamente.';
                }
            } else {
                $this->result['status'] = false;
                $this->result['message'] = 'No hay datos para registrar. Por favor revise e intente nuevamente.';
            }
        } else {
            $this->result['status'] = false;
            $this->result['message'] = 'Ya existe la relación de la categoría.';
        }
        return $this->result;
    }

    public function delete_relation($id)
    {
        $where = ['prsuca_id' => $id];
        if($this->ci->pr_db->delete_relation($where)) {
            $this->result['message'] = 'Relación borrada correctamente';
        } else {
            $this->result['status'] = false;
            $this->result['message'] = 'No se ha borrado la relación';
        }
        $this->result['data'] = $id;
        return $this->result;
    }

}

/* End of file ModelName.php */
