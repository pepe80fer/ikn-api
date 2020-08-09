<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Marks_db extends CI_Model {

    private $table = 'pr_marks';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_marks($select)
    {
        if(strlen($select))
            $this->db->select($select);

        $query = $this->db->order_by('prma_name')->get($this->table);
        return $query->result();
    }

    public function set_mark($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function delete_mark($where)
    {
        $this->db->delete($this->table, $where);
        return $this->db->affected_rows();
    }

    public function update_mark($data, $where)
    {
        $this->db->where($where)->update($this->table, $data);
        return $this->db->affected_rows();   
    }

}

/* End of file ModelName.php */
