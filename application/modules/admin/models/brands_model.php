<?php
	class Brands_model extends CI_Model{
		protected $_table = "tbl_brands";
        
		public function __construct(){
			parent::__construct();
			
			$this->load->database();
		}
        
        public function get_all_brands(){
            $this->db->select("*");
            $query = $this->db->get($this->_table);
            
            return $query->result_array();
        }
        
        public function get_brands_limit($start, $limit){
            $this->db->select("*");
            $this->db->limit($limit, $start);
            $query = $this->db->get($this->_table);
            
            return $query->result_array();
        }
        
        public function get_limit_brands_orderby($start, $limit, $field, $order){
    		$this->db->limit($limit, $start);
            $this->db->order_by($field, $order);
            $query = $this->db->get($this->_table);
    		return $query->result_array();
        }
        
        //Insert Brand
		public function insert($data){
			$this->db->insert($this->_table, $data);
		}
        
        //Update Brand
		public function update($data,$id){
			$this->db->where("brand_id",$id);
			$this->db->update($this->_table,$data);
		}
		
		public function detail($id){
			$this->db->where("brand_id = $id");
			return $this->db->get($this->_table)->row_array();
		}
		
        public function get_total_record(){
            $this->db->select("*");
            $query = $this->db->get($this->_table);
            return $query->num_rows();
        }
        
        public function delete($id=''){
            if($id=='') return false;
            $this->db->where("brand_id", $id);
            $this->db->delete($this->_table);
        }
        public function  search_brands_rows($keywords){
        	$this->db->like("brand_name", "$keywords");
        	$query = $this->db->get($this->_table);
        	return $query->num_rows();
        }
        public function search_brands_limit($keywords,$start, $limit){
        	$this->db->like("brand_name","$keywords");
        	$this->db->limit($limit, $start);
        	$query = $this->db->get($this->_table);
        	return $query->result_array();
        }
		public function get_total($name,$id){
			$this->db->select("*");
            $this->db->where('brand_name',$name);
			$this->db->where('brand_id !=',$id);
			$query = $this->db->get($this->_table);
            return $query->num_rows();
        }	
    }
?>