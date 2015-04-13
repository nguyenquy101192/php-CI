<?php
	class Users_model extends CI_Model{
		protected $_table = "tbl_users";
        
		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

        
        public function get_all_users(){
            $this->db->select("*");
            $query = $this->db->get($this->_table);
            
            return $query->result_array();
        }
        
		
        public function get_users_limit($start, $limit){
            $this->db->select("*");
            $this->db->limit($limit, $start);
            $query = $this->db->get($this->_table);
            
            return $query->result_array();
        }
        
        public function get_limit_users_orderby($start, $limit, $field, $order){
    		$this->db->order_by($field, $order);
    		$this->db->limit($limit, $start);
            $query = $this->db->get($this->_table); 
    		return $query->result_array();
        }
        
        public function get_total_record(){
            $this->db->select("*");
            $query = $this->db->get($this->_table);
            return $query->num_rows();
        }
        
        //insert user
        public function insert($data) {
            $this->db->insert($this->_table, $data);
        }
        
		//Delete user
		public function delete_user($id)
		{
			$this->db->where("user_id", $id);
			$this->db->delete($this->_table);
		}
        
        public function get_one($id='')
        {
            if($id=='') return false;
            $this->db->where("user_id", $id);
            $user = $this->db->get($this->_table)->row_array();
            if($user != '') return $user;
            else return false;
        }
        
        public function update($id='', $data='')
        {
            if($id=='' || $data=='') return false;
            $this->db->where("user_id", $id);
            if($this->db->update($this->_table,$data)) return true;
            else return false;
        }
        
        public function check_username($name='',$id='')
        {
            if($name=='' || $id=='') return false;
            $this->db->where("user_name", $name);
            $this->db->where("user_id !=", $id);
            $row = $this->db->get($this->_table)->num_rows();
            if($row>0) return false;
            else return true;
        }
        
        public function check_email($email='',$id='')
        {
            if($email=='' || $id=='') return false;
            $this->db->where("user_email", $email);
            $this->db->where("user_id !=", $id);
            $row = $this->db->get($this->_table)->num_rows();
            if($row>0) return false;
            else return true;
        }
    }
?>