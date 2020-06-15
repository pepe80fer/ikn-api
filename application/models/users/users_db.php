<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_db extends CI_Model {

    private $table = 'us_users';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function get_users($select)
    {
        if(strlen($select))
            $this->db->select($select);

        $query = $this->db->order_by('user_name')->get($this->table);
        return $query->result();
    }

    public function set_user($data)
    {
        try {
            $result = $this->db->insert($this->table, $data);
            if( ! $result) throw new Exception($this->db->error()['message']);
            return $this->db->insert_id();
        } catch (Exception $e) {
            log_message("error", "{$e->getFile()} | {$e->getMessage()} | Line: {$e->getLine()}");
        }
    }
    
    public function delete_user($where)
    {
        $this->db->delete($this->table, $where);
        return $this->db->affected_rows();
    }

    public function update_user($data, $where)
    {
        $this->db->where($where)->update($this->table, $data);
        return $this->db->affected_rows();   
    }

}

/* End of file ModelName.php */
