<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Identifications_db extends CI_Model {

    private $table = 'us_identifications';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_identifications($select)
    {
        if(strlen($select))
            $this->db->select($select);

        $query = $this->db->order_by('usid_name')->get($this->table);
        return $query->result();
    }

    public function set_identification($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function delete_identification($where)
    {
        $this->db->delete($this->table, $where);
        return $this->db->affected_rows();
    }

    public function update_identification($data, $where)
    {
        $this->db->where($where)->update($this->table, $data);
        return $this->db->affected_rows();
    }

}

/* End of file ModelName.php */
