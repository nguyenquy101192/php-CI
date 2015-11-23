<?php

class Home extends CI_Controller
{
    const ITEMS_PER_PAGE = 6;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model("home_model");
        $this->load->library('pagination');
        $this->load->library("session");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Home page | Watches Store";
        $data['listSlider'] = $this->home_model->get_list_slider();
        $data['slider'] = "templates/slider";
        $data['colleft'] = "templates/colleft";
        $data['colright'] = "templates/colright";
        $data['feature'] = "templates/feature";

        //lay thong tin cart
        $cart = $this->session->userdata('cart');
        if ($cart == false) {
            $data['count'] = 0;
            $data['cost'] = 0;
        } else {
            $count = 0;
            $cost = 0;
            foreach ($cart as $pro) {
                $count += $pro['quantity'];
                $cost += $pro['quantity'] * $pro['price'];
            }
            $data['count'] = $count;
            $data['cost'] = $cost;
        }

        //get page number
        $page_number = $this->uri->segment(4);
        if (!$page_number || $page_number == null) {
            $this->session->unset_userdata("set_cate");
            $this->session->unset_userdata("set_sort_field");
            $this->session->unset_userdata("set_sort_type");
            $this->session->unset_userdata("set_filter_brand");
            $this->session->unset_userdata("set_filter_low_price");
            $this->session->unset_userdata("set_filter_heigh_price");
            $page_number = 1;
        } else if (isset($page_number) && $page_number <= 0) {
            $page_number = 1;
            redirect(base_url("default/home/index/"), 'refresh');
        } else if (!is_numeric($page_number)) {
            $page_number = 1;
            redirect(base_url("default/home/index/"), 'refresh');
        }

        //get field to sort
        if ($this->session->userdata("set_sort_field")) {
            $field = $this->session->userdata("set_sort_field");
        } else {
            $field = "pro_name";
        }

        //get type to sort
        if ($this->session->userdata("set_sort_type")) {
            $order = $this->session->userdata("set_sort_type");
        } else {
            $order = "ASC";
        }

        $config = array();
        $config ['base_url'] = base_url() . 'default/home/index/';
        $config ['per_page'] = self::ITEMS_PER_PAGE;
        $config ['uri_segment'] = 4;
        $config ['total_rows'] = $this->home_model->get_total_record();
        $config ['next_link'] = "<span class='fa fa-angle-double-right'></span>";
        $config ['prev_link'] = "<span class='fa fa-angle-double-left'></span>";
        $config ['use_page_numbers'] = TRUE;

        $start = ($page_number - 1) * $config ['per_page'];
        $limit = $config ['per_page'];

        $data['field'] = $field;
        $data['order'] = $order;
        $data['page_number'] = $page_number;
        $data['listBrand'] = $this->home_model->get_all_brand();
        $data['listCate'] = $this->build_cate();
        $this->pagination->initialize($config);
        $data ['pages'] = $this->pagination->create_links();

        //get post brand
        if ($this->session->userdata("set_filter_brand")) {
            $brand = $this->session->userdata("set_filter_brand");
            $data['listProduct'] = $this->home_model->get_products_by_brand($brand, $start, $limit);
        } else {
            $data['listProduct'] = $this->home_model->get_products_limit($start, $limit);
        }

        $sort_field = array();

        foreach ($data['listProduct'] as $key => $value) {
            $sort_field[$key] = $value[$field];
        }

        if (strtolower($order) == 'desc') {
            array_multisort($sort_field, SORT_DESC, $data['listProduct']);
        } else {
            array_multisort($sort_field, SORT_ASC, $data['listProduct']);
        }
        $data['current_page'] = $page_number;
        $data['template'] = "templates/template";
        $this->load->view("layout", $data);
    }

    public function detail()
    {
        $data['title'] = "Product Info";
        $id = $this->uri->segment(4);
        $msg = $this->uri->segment(5);
        if ($msg != null) {
            $data['msg'] = "Thank for your comment!";
        }
        //check url
        if ($id == null || $id < 0 || !is_numeric($id)) {
            $data['template'] = "404";
        } else {
            $data['proInfo'] = $this->home_model->get_one_record($id);

            //check data
            if (count($data['proInfo']) == 0) {
                $data['template'] = "404";
            } else {
                $data['template'] = "product_detail";
            }
        }

        //lay thong tin cart
        $cart = $this->session->userdata('cart');
        if ($cart == false) {
            $data['count'] = 0;
            $data['cost'] = 0;
        } else {
            $count = 0;
            $cost = 0;
            foreach ($cart as $pro) {
                $count += $pro['quantity'];
                $cost += $pro['quantity'] * $pro['price'];
            }
            $data['count'] = $count;
            $data['cost'] = $cost;
        }

        //get comment
        $data['listComment'] = $this->home_model->get_comments($id);

        //check comment
        if ($this->input->post("feed_submit")) {
            $this->form_validation->set_rules("feed_name", "Your name ", "trim|required");
            $this->form_validation->set_rules("feed_email", "Your email ", "trim|required");
            $this->form_validation->set_rules("feed_title", "Title", "trim|required");
            $this->form_validation->set_rules("feed_content", "Content ", "trim|required");
            $this->form_validation->set_rules("feed_rate", " Rating", "trim|required");

            $this->form_validation->set_message("required", "%s do not null");
            $this->form_validation->set_message("valid_email", "%s không đúng định dạng");
            $this->form_validation->set_error_delimiters("<span>", "</span>");
            if ($this->form_validation->run()) {
                $data['display'] = 0;
                $feed_back = array(
                    "feed_name" => $this->input->post("feed_name"),
                    "feed_email" => $this->input->post("feed_email"),
                    "feed_title" => $this->input->post("feed_title"),
                    "feed_content" => htmlspecialchars($this->input->post("feed_content")),
                    "feed_rate" => $this->input->post("feed_rate"),
                    "pro_id" => $this->input->post("pro_id")
                );
                $feed_id = $this->home_model->insert_feedback($feed_back);
                redirect(base_url("default/home/detail/" . $id . "/1"));
            } else {
                $data['display'] = 1;
            }

        }
        $data['rating_avg'] = $this->home_model->get_rating_avg($id);
        $this->load->view("layout", $data);
    }

    public function about_us()
    {
        $data['title'] = "About us";

        //lay thong tin cart
        $cart = $this->session->userdata('cart');
        if ($cart == false) {
            $data['count'] = 0;
            $data['cost'] = 0;
        } else {
            $count = 0;
            $cost = 0;
            foreach ($cart as $pro) {
                $count += $pro['quantity'];
                $cost += $pro['quantity'] * $pro['price'];
            }
            $data['count'] = $count;
            $data['cost'] = $cost;
        }

        $data['template'] = "about_us";
        $this->load->view("layout", $data);
    }

    public function contact_us()
    {
        $data['title'] = "Contact us";

        //lay thong tin cart
        $cart = $this->session->userdata('cart');
        if ($cart == false) {
            $data['count'] = 0;
            $data['cost'] = 0;
        } else {
            $count = 0;
            $cost = 0;
            foreach ($cart as $pro) {
                $count += $pro['quantity'];
                $cost += $pro['quantity'] * $pro['price'];
            }
            $data['count'] = $count;
            $data['cost'] = $cost;
        }

        if ($this->input->post("btok")) {
            $name = $this->input->post("txtname");
            $email = $this->input->post("txtemail");
            $phone = $this->input->post("txtphone");
            $opinion = $this->input->post("txtopinion");
            if ($name != null && $email != null && $phone != null && $opinion != null) {
                ?>
                <script>
                    alert("Thanks your opinion !");
                </script>
                <?php
                redirect(base_url("default/home"), "refresh");
            }
        }
        $data['template'] = "contact_us";
        $this->load->view("layout", $data);
    }

    public function build_cate()
    {
        $list = $this->home_model->get_list_cate(); //echo "<pre>"; print_r($list);die();
        $html = '';
        foreach ($list as $key => $cate) {
            $html .= "<li class='li-cate' id='" . $cate['cate_id'] . "' cate_name='" . $cate['cate_name'] . "'><a>" . $cate['cate_name'] . "<span id='count-items-cate'>[" . $cate['count'] . "]</span></a>";
            $next = isset($list[$key + 1]) ? $list[$key + 1] : '';
            if ($next == '') {
                if ($cate['level'] > 0) for ($i = $cate['level']; $i > 0; $i--) {
                    $html .= "</ul></li>";
                }
                else $html .= "</li>";
                break;
            }
            if ($next['level'] == $cate['level']) $html .= "</li>";
            elseif ($next['level'] < $cate['level']) {
                for ($i = $cate['level']; $i > $next['level']; $i--) {
                    $html .= "</ul></li>";
                }
            } else $html .= "<ul>";
        }

        return $html;
    }

    public function sort_filter_cate()
    {
        //get id category
        $cate_id = array();
        if ($this->input->post("cate_id")) {
            $cate_id[] = $this->input->post('cate_id');
            $this->session->set_userdata("set_cate", $cate_id);
        } else if ($this->session->userdata("set_cate")) {
            $cate_id = $this->session->userdata("set_cate");
        } else {
            $listCateID = array();
            $listCateID = $this->home_model->get_all_cate_by_id();
            foreach ($listCateID as $key_cate => $value_cate) {
                $cate_id[] = $value_cate['cate_id'];
            }
        }
        //echo "<pre>";
//        print_r($cate_id);
//        die();

        //get page current number    
        $page_number = $this->input->post('page');
        if ($page_number == null) {
            $page_number = 1;
        } else if (isset($page_number) && $page_number <= 0) {
            $page_number = 1;
            redirect(base_url("default/home/index/"), 'refresh');
        } else if (!is_numeric($page_number)) {
            $page_number = 1;
            redirect(base_url("default/home/index/"), 'refresh');
        }


        //get post to sort
        if ($this->input->post("field")) {
            $field = $this->input->post('field');
            $this->session->set_userdata("set_sort_field", $field);
        } else
            $field = "pro_name";

        if ($this->input->post('type')) {
            $type = $this->input->post('type');
            $this->session->set_userdata("set_sort_type", $type);
        } else
            $type = "ASC";


        //get list brand to filter
        $brand = array();
        if ($this->input->post('brand')) {
            $brand = $this->input->post('brand');
            $this->session->set_userdata("set_sort_brand", $brand);
        } else {
            if ($this->input->post('click')) {
                $this->session->unset_userdata("set_sort_brand");
                $listBrandID = array();
                $listBrandID = $this->home_model->get_all_brand_by_id();
                foreach ($listBrandID as $key_brand => $value_brand) {
                    $brand[] = $value_brand['brand_id'];
                }
            } else {
                if ($this->session->userdata('set_sort_brand')) {
                    $brand = $this->session->userdata("set_sort_brand");
                } else {
                    $listBrandID = array();
                    $listBrandID = $this->home_model->get_all_brand_by_id();
                    foreach ($listBrandID as $key_brand => $value_brand) {
                        $brand[] = $value_brand['brand_id'];
                    }
                }
            }
        }
        //echo "<pre>";
//        print_r($brand);
//        die();

        //get price to filter
        if ($this->input->post("low")) {
            $low_price = $this->input->post("low");
            $this->session->set_userdata("set_filter_low_price", $low_price);
        } else if ($this->session->userdata("set_filter_low_price")) {
            $low_price = $this->session->userdata("set_filter_low_price");
        } else
            $low_price = 0;

        if ($this->input->post("heigh")) {
            $heigh_price = $this->input->post("heigh");
            $this->session->set_userdata("set_filter_heigh_price", $heigh_price);
        } else if ($this->session->userdata("set_filter_heigh_price")) {
            $heigh_price = $this->session->userdata("set_filter_heigh_price");
        } else
            $heigh_price = 30000;
        //echo "<pre>";
//        print_r($heigh_price);
//        die();

        $config = array();
        $config ['base_url'] = base_url() . 'default/home/index/';
        $config ['per_page'] = self::ITEMS_PER_PAGE;
        $config ['uri_segment'] = 4;
        $config ['next_link'] = "<span class='fa fa-angle-double-right'></span>";
        $config ['prev_link'] = "<span class='fa fa-angle-double-left'></span>";
        $config ['use_page_numbers'] = TRUE;

        $start = ($page_number - 1) * $config ['per_page'];
        $limit = $config ['per_page'];

        $data['field'] = $field;
        $data['order'] = $type;
        $data['page_number'] = $page_number;
        if (count($cate_id) == 1) {
            $listCate = $this->home_model->get_cate_child($cate_id[0]);
        } else
            $listCate = $cate_id;

        $listProducts = $this->home_model->get_all_products($listCate, $brand, $low_price, $heigh_price, $start, $limit);
        $this->pagination->initialize($config);
        $pages = $this->pagination->create_links();

        //echo "<pre>";
//        print_r($cate_id);
//        print_r($brand);
//        print_r($low_price);
//        print_r($heigh_price);
//        die();

        //sort array before print
        $sort_field = array();

        foreach ($listProducts as $key => $value) {
            $sort_field[$key] = $value[$field];
        }

        if (strtolower($type) == 'desc') {
            array_multisort($sort_field, SORT_DESC, $listProducts);
        } else {
            array_multisort($sort_field, SORT_ASC, $listProducts);
        }
        //print list products
        echo "<ul>";
        if ($listProducts == null) {
            echo "<span class='no-items'>No items !</span>";
            echo "</ul>";
        }
        if ($listProducts != '') foreach ($listProducts as $key => $value) {
            echo "<li>
			    	<div class='product'>
				    	<div class='pro-info'>
					    	<div class='pro-image'>
					    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'><img src='" . base_url() . "public/images/products/" . $value['pro_images'] . "' /></a>
					    	</div>
					    	<div class='pro-name'>
					    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'>" . strtoupper($value['pro_name']) . "</a>
					    	</div>
					    	<div class='pro-price'>";
            if ($value['pro_sale_price'] < $value['pro_list_price']) {
                echo "<s>" . number_format($value["pro_list_price"], "0", "", ",") . "&nbsp;$</s>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo "<img src='" . base_url() . "public/images/icon/sale.png" . "' id='product-sale'/>";
            }
            echo "<span style='color: #ff3333;'>" . number_format($value["pro_sale_price"], "0", "", ",") . "&nbsp;$</span>";
            echo "</div>
				    	</div>
				    	<div class='cart-detail'>
					    	<div class='cart'>
					    		<a href='#'><span class='fa fa-shopping-cart'></span>&nbsp;Add to cart</a>
					    	</div>
					    	<div class='detail'>
					    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'>Detail</a>
					    	</div>
				    	</div>
			    	</div>
		    	</li>";
        }
        else echo "<span class='no-items'>No items !</span>";
        echo "</ul>
    	       <div class='pagination'>";
        if ($pages != null) echo $pages;
        echo "</div>";
    }


    //public function filter(){
//	   //get page + check url
//    	$page_number = $this->input->post('page');
//    	if($page_number == null) {
//    		$page_number = 1;
//    	}
//    	else if(isset($page_number) && $page_number <= 0){
//    		$page_number = 1;
//    		redirect(base_url("default/home/index/"), 'refresh');
//    	}
//    	else if(!is_numeric($page_number)){
//    		$page_number = 1;
//    		redirect(base_url("default/home/index/"), 'refresh');
//    	}
//        
//		if($this->input->post("low")){
//			$low_price = $this->input->post("low"); 
//		}
//		else
//			$low_price = 0;
//		
//		if($this->input->post("heigh")){
//			$heigh_price = $this->input->post("heigh");
//		}
//		else
//			$height_price = 30000;
//		
//		$config = array ();
//    	$config ['base_url']         = base_url () . 'default/home/index/';
//    	$config ['per_page']         = self::ITEMS_PER_PAGE;
//    	$config ['uri_segment']      = 4;
//    	$config ['total_rows']       = $this->home_model->get_total_record();
//    	$config ['next_link']        = "<span class='fa fa-angle-double-right'></span>";
//    	$config ['prev_link']        = "<span class='fa fa-angle-double-left'></span>";
//    	$config ['use_page_numbers'] = TRUE;
//    
//    	$start = ($page_number - 1) * $config ['per_page'];
//    	$limit = $config ['per_page'];
//		$listProducts = $this->home_model->get_by_filter($low_price, $heigh_price, $start, $limit);
//        $this->pagination->initialize ( $config );
//    	$pages        = $this->pagination->create_links ();
//		
//		echo "<ul>";
//		if($listProducts == null){
//			echo "<span class='no-items'>No items !</span>";
//			echo "</ul>";
//		}
//		else{
//			foreach ($listProducts as $key=>$value){
//				echo "<li>
//				    	<div class='product'>
//					    	<div class='pro-info'>
//						    	<div class='pro-image'>
//						    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'><img src='" . base_url() . "public/images/products/" . $value['pro_images'] . "' /></a>
//						    	</div>
//						    	<div class='pro-name'>
//						    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'>" . strtoupper($value['pro_name']) . "</a>
//						    	</div>
//						    	<div class='pro-price'>";
//				if($value['pro_sale_price'] < $value['pro_list_price']){
//					echo "<s>" . number_format($value["pro_list_price"], "0", "", ",") . "&nbsp;$</s>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//					echo "<img src='" . base_url() . "public/images/icon/sale.png" . "' id='product-sale'/>";
//				}
//				echo "<span style='color: #ff3333;'>" . number_format($value["pro_sale_price"], "0", "", ",") . "&nbsp;$</span>";
//				echo "</div>
//					    	</div>
//					    	<div class='cart-detail'>
//						    	<div class='cart'>
//						    		<a href='#'><span class='fa fa-shopping-cart'></span>&nbsp;Add to cart</a>
//						    	</div>
//						    	<div class='detail'>
//						    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'>Detail</a>
//						    	</div>
//					    	</div>
//				    	</div>
//			    	</li>";
//			}
//			echo "</ul>
//            <div class='pagination'>";
//    			if($pages != null) echo $pages;
//    			echo "</div>";
//		}
//	}
//    
//    public function sort(){
//    	//get page + check url
//    	$page_number = $this->input->post('page');
//    	if($page_number == null) {
//    		$page_number = 1;
//    	}
//    	else if(isset($page_number) && $page_number <= 0){
//    		$page_number = 1;
//    		redirect(base_url("default/home/index/"), 'refresh');
//    	}
//    	else if(!is_numeric($page_number)){
//    		$page_number = 1;
//    		redirect(base_url("default/home/index/"), 'refresh');
//    	}
//    
//    	//get post
//    	if($this->input->post("field")){
//    		$field = $this->input->post('field');
//    		$this->session->set_userdata("set_sort_field", $field);
//    		$sess = $this->session->userdata("set_sort_field");
//    	}
//    	else
//    		$field = "pro_name";
//    
//    	if($this->input->post('type')){
//    		$type = $this->input->post('type');
//    		$this->session->set_userdata("set_sort_type", $type);
//    		$sess = $this->session->userdata("set_sort_type");
//    	}
//    	else
//    		$type = "ASC";
//    
//    	$config = array ();
//    	$config ['base_url']         = base_url () . 'default/home/index/';
//    	$config ['per_page']         = self::ITEMS_PER_PAGE;
//    	$config ['uri_segment']      = 4;
//    	$config ['total_rows']       = $this->home_model->get_total_record();
//    	$config ['next_link']        = "<span class='fa fa-angle-double-right'></span>";
//    	$config ['prev_link']        = "<span class='fa fa-angle-double-left'></span>";
//    	$config ['use_page_numbers'] = TRUE;
//    
//    	$start = ($page_number - 1) * $config ['per_page'];
//    	$limit = $config ['per_page'];
//    	$listProduct  = $this->home_model->get_products_limit($start, $limit);
//    	$this->pagination->initialize ( $config );
//    	$pages        = $this->pagination->create_links ();
//    	$sort_field = array();
//    
//    	foreach ($listProduct as $key => $value) {
//    		$sort_field[$key] = $value[$field];
//    	}
//    
//    	if(strtolower($type) == 'desc'){
//    		array_multisort($sort_field, SORT_DESC, $listProduct);
//    	} else {
//    		array_multisort($sort_field, SORT_ASC, $listProduct);
//    	}
//    
//    	echo "<ul>";
//    	foreach ($listProduct as $key=>$value){
//    		echo "<li>
//			    	<div class='product'>
//				    	<div class='pro-info'>
//					    	<div class='pro-image'>
//					    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'><img src='" . base_url() . "public/images/products/" . $value['pro_images'] . "' /></a>
//					    	</div>
//					    	<div class='pro-name'>
//					    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'>" . strtoupper($value['pro_name']) . "</a>
//					    	</div>
//					    	<div class='pro-price'>";
//    			            	if($value['pro_sale_price'] < $value['pro_list_price']){
//	    			                echo "<s>" . number_format($value["pro_list_price"], "0", "", ",") . "&nbsp;$</s>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//	    			                echo "<img src='" . base_url() . "public/images/icon/sale.png" . "' id='product-sale'/>";
//    			                }
//    			                echo "<span style='color: #ff3333;'>" . number_format($value["pro_sale_price"], "0", "", ",") . "&nbsp;$</span>";
//    			            echo "</div>
//				    	</div>
//				    	<div class='cart-detail'>
//					    	<div class='cart'>
//					    		<a href='#'><span class='fa fa-shopping-cart'></span>&nbsp;Add to cart</a>
//					    	</div>
//					    	<div class='detail'>
//					    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'>Detail</a>
//					    	</div>
//				    	</div>
//			    	</div>
//		    	</li>";
//    	}
//    	echo "</ul>
//    	<div class='pagination'>";
//    			if($pages != null) echo $pages;
//    			echo "</div>";
//    }
//    
//    public function filter_price(){
//		//get page + check url
//		$page_number = $this->input->post('page');
//		if($page_number == null) {
//			$page_number = 1;
//		}
//		else if(isset($page_number) && $page_number <= 0){
//			$page_number = 1;
//			redirect(base_url("default/home/index/"), 'refresh');
//		}
//		else if(!is_numeric($page_number)){
//			$page_number = 1;
//			redirect(base_url("default/home/index/"), 'refresh');
//		}
//		
//    	$config = array ();
//    	$config ['base_url']         = base_url () . 'default/home/index/';
//    	$config ['per_page']         = self::ITEMS_PER_PAGE;
//    	$config ['uri_segment']      = 4;
//    	$config ['total_rows']       = $this->home_model->get_total_record();
//    	$config ['next_link']        = "<span class='fa fa-angle-double-right'></span>";
//    	$config ['prev_link']        = "<span class='fa fa-angle-double-left'></span>";
//    	$config ['use_page_numbers'] = TRUE;
//    	
//    	$start = ($page_number - 1) * $config ['per_page'];
//    	$limit = $config ['per_page'];
//    	$this->pagination->initialize ( $config );
//    	$pages        = $this->pagination->create_links ();
//    	
//    	//get post brand
//    	if($this->input->post('brand')){
//    		$brand = $this->input->post('brand');
//    		$this->session->set_userdata("set_filter_brand", $brand);
//    		$sess = $this->session->userdata("set_filter_brand");
//    		if($brand != null){
//    			$listPro = $this->home_model->get_products_by_brand($brand, $start, $limit);
//    		}
//    	}
//    	else{
//			$this->session->unset_userdata("set_filter_brand");
//    		$listPro = $this->home_model->get_products_limit($start, $limit);
//    	}
//    		
//    	echo "<ul>";
//		if ($listPro == null) {
//			echo "<span class='no-items'>No items !</span>";
//			echo "</ul>";
//		} 
//		else {
//			foreach ( $listPro as $key => $value ) {
//				echo "<li>
//			    	<div class='product'>
//				    	<div class='pro-info'>
//					    	<div class='pro-image'>
//					    		<a href='" . base_url () . "default/home/detail/" . $value ['pro_id'] . "'><img src='" . base_url () . "public/images/products/" . $value ['pro_images'] . "' /></a>
//					    	</div>
//					    	<div class='pro-name'>
//					    		<a href='" . base_url () . "default/home/detail/" . $value ['pro_id'] . "'>" . strtoupper ( $value ['pro_name'] ) . "</a>
//					    	</div>
//					    	<div class='pro-price'>";
//    			            	if($value['pro_sale_price'] < $value['pro_list_price']){
//	    			                echo "<s>" . number_format($value["pro_list_price"], "0", "", ",") . "&nbsp;$</s>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//	    			                echo "<img src='" . base_url() . "public/images/icon/sale.png" . "' id='product-sale'/>";
//    			                }
//    			                echo "<span style='color: #ff3333;'>" . number_format($value["pro_sale_price"], "0", "", ",") . "&nbsp;$</span>";
//    			            echo "</div>
//				    	</div>
//				    	<div class='cart-detail'>
//					    	<div class='cart'>
//					    		<a href='#'><span class='fa fa-shopping-cart'></span>&nbsp;Add to cart</a>
//					    	</div>
//					    	<div class='detail'>
//					    		<a href='" . base_url () . "default/home/detail/" . $value ['pro_id'] . "'>Detail</a>
//					    	</div>
//				    	</div>
//			    	</div>
//			    </li>";
//			}
//			echo "</ul>
//			<div class='pagination'>";
//    			if($pages != null) echo $pages;
//    			echo "</div>";
//		}
//	}
//    
//    public function cate(){
//    	//get page + check url
//    	if($this->input->post("cate_id")){
//    		$id = $this->input->post('cate_id');
//    	}
//        elseif($this->uri->segment(3)=='cate'){
//    		$id = $this->uri->segment(4);
//    	}
//    	else
//    		redirect(base_url("default/home/index/"), 'refresh');
//            
//        if($this->input->post("page")){
//    		$page_number = $this->input->post('page');
//        }
//        elseif($this->uri->segment(3)=='cate'){
//    		$page_number = $this->uri->segment(5);
//    	}
//        else
//    		$page_number = 1;
//    	
//    	if($page_number <= 0){
//    		$page_number = 1;
//    	}
//    	else if(!is_numeric($page_number)){
//    		$page_number = 1;
//    	}
//    
//    	$config = array ();
//    	$config ['base_url']         = base_url () . 'default/home/cate/'.$id.'/';
//    	$config ['per_page']         = self::ITEMS_PER_PAGE;
//    	$config ['uri_segment']      = 5;
//    	$config ['total_rows']       = $this->home_model->get_total_record($id);
//    	$config ['next_link']        = "<span class='fa fa-angle-double-right'></span>";
//    	$config ['prev_link']        = "<span class='fa fa-angle-double-left'></span>";
//    	$config ['use_page_numbers'] = TRUE;
//    
//    	$start = ($page_number - 1) * $config ['per_page'];
//    	$limit = $config ['per_page'];
//    	$listProduct  = $this->home_model->get_cate_products($start, $limit, $id);
//    	$this->pagination->initialize ( $config );
//    	$pages        = $this->pagination->create_links ();
//    	   	
//        echo "<ul>";
//    	if($listProduct != '') foreach ($listProduct as $key=>$value){
//    		echo "<li>
//			    	<div class='product'>
//				    	<div class='pro-info'>
//					    	<div class='pro-image'>
//					    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'><img src='" . base_url() . "public/images/products/" . $value['pro_images'] . "' /></a>
//					    	</div>
//					    	<div class='pro-name'>
//					    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'>" . strtoupper($value['pro_name']) . "</a>
//					    	</div>
//					    	<div class='pro-price'>";
//    			            	if($value['pro_sale_price'] < $value['pro_list_price']){
//	    			                echo "<s>" . number_format($value["pro_list_price"], "0", "", ",") . "&nbsp;$</s>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//	    			                echo "<img src='" . base_url() . "public/images/icon/sale.png" . "' id='product-sale'/>";
//    			                }
//    			                echo "<span style='color: #ff3333;'>" . number_format($value["pro_sale_price"], "0", "", ",") . "&nbsp;$</span>";
//    			            echo "</div>
//				    	</div>
//				    	<div class='cart-detail'>
//					    	<div class='cart'>
//					    		<a href='#'><span class='fa fa-shopping-cart'></span>&nbsp;Add to cart</a>
//					    	</div>
//					    	<div class='detail'>
//					    		<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'>Detail</a>
//					    	</div>
//				    	</div>
//			    	</div>
//		    	</li>";
//    	}
//        else echo "<span class='no-items'>No items !</span>";
//    	echo "</ul>
//    	       <div class='pagination'>";
//    			if($pages != null) echo $pages;
//    			echo "</div>";
//    }
}

?>
