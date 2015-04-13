<?php
	class Categories_model extends CI_Model{
		protected $_table = "tbl_categories";
        
		public function __construct(){
			parent::__construct();
			$this->load->database();
		}
        public function get_all_categories(){
			$this->db->select("*");
			$query = $this->db->get($this->_table);
			
			return $query->result_array();
		}
		
        public function get_cate_orderby(){
            $this->db->select("*");
            $this->db->order_by("cate_orderby");
            $query = $this->db->get($this->_table);
            return $query->result_array();
        }
        
        public function get_cate_start_orderby($start){
            $this->db->select("*");
            $this->db->where("cate_orderby >", $start);
            $query = $this->db->get($this->_table);
            return $query->result_array();
        }
        
        public function update_orderby($id, $data){
            $this->db->where("cate_id", $id);
            $this->db->update($this->_table, $data);
        }
        
        public function insert($data) {
            $this->db->insert($this->_table, $data);
        }
        public function update_move($data){
        	$i=1;
        	foreach ($data as $key=>$value){
        		$cate_id = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
        		$cate = array("parent_id"=>$value, "cate_orderby"=>$i);
        
        		$this->db->where("cate_id", $cate_id);
        		$this->db->update($this->_table, $cate);
        		$i++;
        	}
        }
        
        public function delete($id, $option = '') {
            if($id=='') return false;
            //lay ra cate co id la $id
            $this->db->where("cate_id",$id);
            $cate = $this->db->get($this->_table)->row_array();
            $parent = $cate['parent_id'];
            $order = $cate['cate_orderby'];
                
            //mac dinh delete thi cac con cua no duoc chuyen thanh con cua cha no
            if($option=='')
            {               
                //chuyen cac con cua no len lam con cua cha no                
                $this->db->set('parent_id',$parent);
                $this->db->where("parent_id",$id);
                $this->db->update($this->_table);
                
                //chuyen cac product con vao cate cha
                $this->db->set('cate_id',$parent);
                $this->db->where("cate_id = $id");
                $this->db->update("tbl_procate");   
                
                //delete cate
                $this->db->where("cate_id = $id");
                $this->db->delete($this->_table); 
                
                //sua lai care_orderby cua nhung cate dung sau no
                $cate_arr = $this->get_cate_start_orderby($order);
                foreach($cate_arr as $key=>$value)
                {
                    $order = $value['cate_orderby'];
                    $id = $value['cate_id'];
                    $this->db->set('cate_orderby',$order-1);
                    $this->db->where("cate_id",$id);
                    $this->db->update($this->_table);
                }
            }
            
            //neu muon delete ca cac con no, chon option deleteAllSub
            if($option=='deleteAllSub')
            {
                $count = 0;//dem so cate bi xoa
                
                //lay ra danh sach cate va add level cho chung 
                $cate_arr = $this->get_cate_orderby();
                $list = array();
                foreach($cate_arr as $key=>$value)
                {
                    $list[$value['cate_id']] = $value;
                }
                foreach($list as $key=>$value)
                {
                    if($value['parent_id']==0)
                    {
                        $list[$key]['level'] = 0;
                    }
                    else
                    {
                        $list[$key]['level'] = $list[$value['parent_id']]['level'] + 1;
                    }
                }
                //xoa cac con cua no
                $level = $list[$id]['level'];
                foreach($list as $key=>$value)
                {
                    if($value['cate_orderby']>$order)
                    {
                        //kiem tra co phai con cua no khong
                        if($value['level']>$level)
                        {
                            //xoa cate cua cac product thuoc no
                            $this->db->where("cate_id = $key");
                            $this->db->delete("tbl_procate");
                            //xoa cate
                            $this->db->where("cate_id = $key");              
                            $this->db->delete($this->_table);                            
                            //cong count
                            $count++;
                        }
                        else break;
                    }                    
                }                
                
                //xoa cate cua cac product con
                $this->db->where("cate_id = $id");
                $this->db->delete("tbl_procate");  
                
                //delete cate    
                $this->db->where("cate_id = $id");            
                $this->db->delete($this->_table);
                $count++;
                
                //sua lai care_orderby cua nhung cate dung sau cac cate bi xoa
                $cate_arr = $this->get_cate_start_orderby($cate['cate_orderby']);
                foreach($cate_arr as $key=>$value)
                {
                    $order = $value['cate_orderby'];
                    $id = $value['cate_id'];
                    $this->db->set('cate_orderby',$order-$count);
                    $this->db->where("cate_id",$id);
                    $this->db->update($this->_table);
                }
            }
        }
    }
?>