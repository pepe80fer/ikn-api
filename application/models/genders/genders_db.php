<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Genders_db extends CI_Model {

    private $table = 'us_genders';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_genders($select)
    {
        if(strlen($select))
            $this->db->select($select);

        $query = $this->db->order_by('usge_name')->get($this->table);
        return $query->result();
    }

    public function set_gender($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function delete_gender($where)
    {
        $this->db->delete($this->table, $where);
        return $this->db->affected_rows();
    }

    public function update_gender($data, $where)
    {
        $this->db->where($where)->update($this->table, $data);
        return $this->db->affected_rows();   
    }

}

/* End of file ModelName.php */
