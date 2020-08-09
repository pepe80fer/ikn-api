<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_db extends CI_Model {

    private $table = 'pr_categories';
    private $table_subcategories = 'pr_subcategories';
    private $view = 'v_categories';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_categories($select)
    {
        if(strlen($select))
            $this->db->select($select);

        $query = $this->db->order_by('prca_name')->get($this->table);
        return $query->result();
    }

    public function set_categorie($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function delete_categorie($where)
    {
        $this->db->delete($this->table, $where);
        return $this->db->affected_rows();
    }

    public function update_categorie($data, $where)
    {
        $this->db->where($where)->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function get_relation($where=array())
    {
        if(is_array($where) && ! empty($where))
            $this->db->where($where);
            
        $query = $this->db->get($this->view);
        return $query->result();
    }

    public function set_relation($data)
    {
        $this->db->insert($this->table_subcategories, $data);
        return $this->db->insert_id();
    }

    public function delete_relation($where)
    {
        $this->db->delete($this->table_subcategories, $where);
        return $this->db->affected_rows();
    }

}

/* End of file ModelName.php */
