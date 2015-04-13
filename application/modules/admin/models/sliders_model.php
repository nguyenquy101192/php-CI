<?php
	class Sliders_model extends CI_Model{
		protected $_table = "tbl_sliders";
		public function __construct(){
			parent::__construct();
			$this->load->database();
		}
		public function get_slider(){
			$query = $this->db->get("tbl_sliders");
			return $query->result_array();
		}
		public function insert_slider($pro_id,$slider_link){
			$this->db->select_max('img_order');
			$query = $this->db->get($this->_table);
			$max = $query->result_array()[0]['img_order']+1;
			$data=array(	"pro_id"=>$pro_id,
							"img_link"=>$slider_link,
							"img_order"=>$max);
			$query = $this->db->insert($this->_table,$data);
		}
		public function delete_slider($pro_id){
			$this->db->where('pro_id', $pro_id);
			$this->db->delete($this->_table); 
		}
		public function get_slider_by_pro_id($id){
			$this->db->select('*');
			$this->db->from($this->_table);
			$this->db->where("pro_id", $id);
			$query = $this->db->get();
			return $query->result_array();
		}
		public function get_slider_order(){
			$this->db->select("tbl_sliders.pro_id,tbl_products.pro_name,tbl_sliders.img_link,tbl_sliders.img_order");
			$this->db->join("tbl_products","tbl_products.pro_id = tbl_sliders.pro_id");
			$this->db->order_by("img_order asc");
			return $this->db->get($this->_table)->result_array();
		}
		public function update_slider($data){
			$this->db->empty_table($this->_table);
			$this->db->insert_batch($this->_table,$data);
		}
	}