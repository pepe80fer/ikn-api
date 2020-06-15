<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Profiles_db extends CI_Model {

    private $table = 'us_profiles';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_profiles($select)
    {
        if(strlen($select))
            $this->db->select($select);

        $query = $this->db->order_by('uspr_name')->get($this->table);
        return $query->result();
    }

    public function set_profile($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function delete_profile($where)
    {
        $this->db->delete($this->table, $where);
        return $this->db->affected_rows();
    }

    public function update_profile($data, $where)
    {
        $this->db->where($where)->update($this->table, $data);
        return $this->db->affected_rows();   
    }

}

/* End of file ModelName.php */
