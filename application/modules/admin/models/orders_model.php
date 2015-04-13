<?php
	class Orders_model extends CI_Model{
		protected $_table = "tbl_orders";
        protected $_detail = "tbl_orderDetails";
        
		public function __construct(){
			parent::__construct();
			$this->load->database();
		}
        
        public function get_all_orders(){
            $this->db->select("*");
            $query = $this->db->get($this->_table);
            return $query->result_array();
        }
        
        public function get_total_record(){
            $this->db->select("*");
            $query = $this->db->get($this->_table);
            return $query->num_rows();
        }
        
        public function get_limit_orders_orderby($start, $limit){
            $this->db->order_by("order_status ", "ASC");
    		$this->db->limit($limit, $start);
            $query = $this->db->get($this->_table);
    		return $query->result_array();
        }
        
        public function get_details($id){
            $sql = "SELECT * FROM $this->_table as O 
                    JOIN $this->_detail as D
                    ON O.order_id = D.order_id
                    WHERE O.order_id=$id";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
        
        public function get_order($id){
            $this->db->select("*");
            $this->db->where("order_id", $id);
            $query = $this->db->get($this->_table);
            return $query->result_array();
        }
        
        public function update_status($data, $id){
            $this->db->where("order_id", $id);
            $this->db->update($this->_table, $data);
        }
        
        public function delete($id=''){
            if($id=='') return false;
            $this->db->where("order_id", $id);
            $this->db->delete($this->_table);
        }
    }
?>