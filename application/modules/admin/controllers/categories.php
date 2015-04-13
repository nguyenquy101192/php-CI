<?php
class Categories extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->model("categories_model");
		$this->load->library ( 'form_validation' );
        $this->load->library("form_validation");
        $this->load->library("session");
        $this->load->model("logins_model");
        if(!$this->session->userdata('logged_in')){
        	redirect(base_url("admin/login/"), 'refresh');
        }
    }
    
    public function index(){
        $data['title']    = "<span class='fa fa-folder-open-o'></span>&nbsp;List Categories"; 
        $listCate = $this->categories_model->get_cate_orderby();
        $List = array();
        foreach($listCate as $key=>$value){
            $List[$value['cate_id']] = $value;
        }
        $List = $this->get_child($List);
        $data['listCate'] = $List;
        $data['template'] = "categories/categories_view";
        $this->load->view("layout", $data);
    }
    
    
    //function move category
    public function move(){
    	$data['title'] = "<span class='fa fa-cab'>&nbsp;Move Categories</span>";
    	$listCate = $this->categories_model->get_cate_orderby();
    	$list = array();
    	foreach($listCate as $key=>$value){
    		$list[$value['cate_id']] = $value;
    	}
    	$listCate = $this->get_child($list);
    	$data['listCate'] = $this->get_string_move($listCate);
    	$data['template'] = "categories/categories_move";
    	$this->load->view("layout", $data);
    }
    
    public function move_action(){
    	$update = $_POST['data'];
    	$this->categories_model->update_move($update);
    
    }
    
    public function get_string_move($listCate){
    	$level = 0;
    	$str = "<ol class='dd-list'>";
    
    	foreach ($listCate as$key=>$value){
    		if($value['level']==$level){
    			$str.="<li class='dd-item' data-id=' ".$value['cate_id']." '><div class = 'dd-handle'>".$value['cate_name']."</div>";
    		}else if($value['level']>$level){
    			$str.="<ol class = 'dd-list'>";
    			$str.="<li class='dd-item' data-id=' ".$value['cate_id']." '><div class = 'dd-handle'>".$value['cate_name']."</div>";
    			 
    			$level++;
    		}
    		else if($value['level']<$level){
    			for($i=$level;$i>$value['level'];$i--){
    				$str.="</ol></li>";
    				$level--;
    			}
    			$str.="<li class='dd-item' data-id=' ".$value['cate_id']." '><div class = 'dd-handle'>".$value['cate_name']."</div>";
    		}
    	}
    	return $str.="</ol>";
    }
    
    
    //function get child
    public function get_child($array){
        foreach($array as $k=>$val){
            $array[$k]['level'] = "";
        }
        foreach($array as $key=>$value){
            if($value['parent_id'] == 0){
                $array[$key]['level'] = 0;
            }
            else{                
                $array[$key]['level'] = $array[$value['parent_id']]['level'] + 1;
            } 
        }
        return $array;
    }
    
    
	//function update
	public function update()
	{
        $data['title'] = "<span class='fa fa-edit'></span>&nbsp;Update Category";	
    	$id = $this->uri->segment(4	);
		$listCate = $this->categories_model->get_cate_orderby();
        $List = array();
        foreach($listCate as $key=>$value){
            $List[$value['cate_id']] = $value;
        }
        $List = $this->get_child($List);
        
        //check url
        if(!is_numeric($id) || intval($id) <= 0){
            show_404();
        }
         $all_categories = $this->categories_model->get_all_categories();
         $all_id = array();
         if(!empty($all_categories)){  
            foreach($all_categories as $category){
                    $all_id[] = $category['cate_id'];
            }
         }
            
         if(!in_array($id, $all_id)){
            show_404();
         }
			
    	$data['cateInfor']= $this->categories_model->detail($id);
    	$data['cateAll']=$this->categories_model->get_all_categories();
		$cate = $this->categories_model->get_all_categories();
    	if($this->input->post('update')){
			$cate_name = $this->input->post('cate_name');
			$parent_id = $this->input->post('sec');
    		$this->form_validation->set_rules("cate_name","Tên category ","trim|required");
    		$this->form_validation->set_message("required","%s không được bỏ trống");
            $this->form_validation->set_message("check_category_name","%s đã tồn tại");
    		$this->form_validation->set_error_delimiters("<span class='error'>","</span>");
			$num = $this->categories_model->get_different_record($cate_name,$id);					
    		if($this->form_validation->run()==true){
				if(isset($List[$_POST['sec']]['cate_orderby'])){
                  	$position = $List[$_POST['sec']]['cate_orderby'];
                }
                else
                    $position = 0; 						
					$dataCate = array(
					"cate_name"=>$this->input->post("cate_name"),
					"parent_id"=>$this->input->post('sec'),
					"cate_orderby"=> $position+1
					);
    			$this->categories_model->update($dataCate,$id);
    			
				$array = $this->categories_model->get_cate_start_orderby($position);
				//TH1:
                foreach($array as $key_arr=>$value_arr)
					{
						$stt=$value_arr['cate_orderby'];
                    	$update_order = array(
                                        "cate_orderby"=>$stt
										);
                    	$this->categories_model->update_orderby($value_arr['cate_id'], $update_order);
						$stt++;
               	 	}
					redirect(base_url("admin/categories"));
    			}
				$start = $this->categories_model->get_cate_current($parent_id)+1;
				$newarray=$this->categories_model->get_cate_start_end_orderby($start,$position);
				//TH2:
				foreach($newarray as $key_arr=>$value_arr1)
				{
					$stt=$value_arr1['cate_orderby'];
					$update_order = array(
                                        "cate_orderby"=>$stt-1
										);
                    	$this->categories_model->update_orderby($value_arr1['cate_id'], $update_order);
						$stt++;
				}
				
				//TH3:di chuyen ca cha va con
				/*
				$level = $List['id']['level'];
				foreach ($List as $key=>$value )
				{
					if($value['cate_orderby']>$orderby)
					{
						if($value['level']>$level)
						{
							
						}
					}
				}
				*/
				redirect(base_url("admin/categories"));
    		}
			$data['listCate'] = $List;
    		$data['template'] = 'categories/categories_update';
            $this->load->view("layout", $data);
            
            //cancel insert
            if($this->input->post("cancel")) {
                redirect(base_url("admin/categories/"),'refresh');
            }
	}
    
    
    //function insert category
    public function insert(){
        $data['title'] = "<span class='fa fa-sign-in'></span>&nbsp;Insert Category";
        
        $listCate = $this->categories_model->get_cate_orderby();
        $List = array();
        foreach($listCate as $key=>$value){
            $List[$value['cate_id']] = $value;
        }
        $List = $this->get_child($List);
        $data['listCate'] = $List;
        
        if($this->input->post("insert")){
            $this->form_validation->set_rules("catename","Tên category ","trim|required|is_unique[tbl_categories.cate_name]");
            
            $this->form_validation->set_message("required","%s không được bỏ trống");
            $this->form_validation->set_message("is_unique","%s đã tồn tại");
            $this->form_validation->set_error_delimiters("<span class='error'>","</span>");
            if($this->form_validation->run()){
                if(isset($List[$_POST['sec']]['cate_orderby'])){
                    $position = $List[$_POST['sec']]['cate_orderby'];
                }
                else
                    $position = 0;            
                $dataCate = array(
                                "cate_name"=>$this->input->post("catename"),
                                "parent_id"=>$_POST['sec'],
                                "cate_orderby"=>$position + 1
                                );
                //update field cate_orderby
                $array = $this->categories_model->get_cate_start_orderby($position);
                foreach($array as $key_arr=>$value_arr){
                    $update_order = array(
                                        "cate_orderby"=>$value_arr['cate_orderby'] + 1
                                        );
                    $this->categories_model->update_orderby($value_arr['cate_id'], $update_order);
                }
				
				
                //insert to tbl_categories
                $this->categories_model->insert($dataCate);
                redirect(base_url("admin/categories"), 'refresh');
            }
        }
        $data['template'] = "categories/categories_insert";
        $this->load->view("layout", $data);
        
        //check cancel
        if($this->input->post("cancel")){
            redirect(base_url("admin/categories"), 'refresh');
        }
    }
    
    
    //function delete category
    public function delete()
    {
        if(isset($_POST['id']) && $_POST['id']!='') $id=$_POST['id'];
        if($id != '') 
        {
            $delmode = '';
            if(isset($_POST['delmode']) && $_POST['delmode']!='') $delmode=$_POST['delmode'];
            $this->categories_model->delete($id,$delmode);   
        }
        redirect(base_url("admin/categories"));
    }
}
?>