<?php
class Cart extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
        $this->load->model("home_model");
        $this->load->library("form_validation");
        $this->load->model("cart_model");
	}
	
	public function index(){
		$data['title'] = "My cart";
				
		if($this->input->post("clear")){
            $this->clear();
			redirect(base_url("default/cart/"), 'refresh');
		}
        if($this->input->post("checkout")){
            redirect(base_url("default/cart/check_out"), 'refresh');
		}
        
        $cart = $this->session->userdata('cart');
        if($cart == false) { $data['count'] = 0; $data['cost'] = 0; $list = '';}
        else
        {
            $count = 0;
            $cost = 0;
            foreach($cart as $pro)
            {
                $count += $pro['quantity'];
                $cost += $pro['quantity']*$pro['price'];
            }
            $data['count'] = $count;
            $data['cost'] = $cost;
            $pro_id_arr = array_keys($cart);
            $listProduct = $this->home_model->get_products_limit('', '', $pro_id_arr);
            $list = array();
            if($listProduct==''||$listProduct==array()) $list = '';
            else
                foreach($listProduct as $key=>$pro)
                {
                    $list[$pro['pro_id']] = $pro;
                }
        }        
        
		$data['listProduct'] = $list;
        $data['cart'] = $cart;
		$data['template'] = "cart_view";        
		$this->load->view("layout", $data);
	}
    
    public function add()
    {
        $pro_id =  $this->input->post('pro_id');
        $pro_price= $this->input->post('pro_price');
        if($pro_id=='' || $pro_price=='') echo "Error: request add fail! ";
        else
        {
            $cart = $this->session->userdata('cart');
            if($cart == false) { $cart = array($pro_id=>array('quantity'=>1, 'price'=>$pro_price));}
            else
            {
                if(array_key_exists($pro_id,$cart)) $cart[$pro_id]['quantity'] += 1;
                else { $cart[$pro_id]['quantity'] = 1; $cart[$pro_id]['price'] = $pro_price; } 
            }
            $this->session->set_userdata('cart', $cart);
            $count = 0;
            $cost = 0;
            foreach($cart as $pro)
            {
                $count += $pro['quantity'];
                $cost += $pro['quantity']*$pro['price'];
            }
            echo "<span class='fa fa-shopping-cart'></span>";            
            echo " My cart: ".$count." items - ".$cost."$";
        }
    }
    
    public function update()
    {
        if($this->input->post("btnok"))
        {
            $id = $this->input->post("id");
            $quantity = $this->input->post("quantity");            
            $cart = $this->session->userdata('cart');
            if($cart == false) exit("Your cart don't exist!");
            else
            {
                if(array_key_exists($id,$cart)) 
                {
                    if(is_numeric($quantity)&&$quantity>0) $cart[$id]['quantity'] = $quantity;                    
                }
                else exit("Your product don't exist!");
            }
            $this->session->set_userdata('cart', $cart);   
        }        
        redirect(base_url("default/cart"), 'refresh');
    }
    
    public function delete($id)
    {
        $cart = $this->session->userdata('cart');
        if($cart)
        {
            if(isset($cart[$id])) unset($cart[$id]);
            $this->session->set_userdata('cart', $cart);
        }
        redirect(base_url("default/cart"), 'refresh');
    }
    
    private function clear()
    {
        if($this->session->userdata('cart')) $this->session->unset_userdata('cart');
    }
    
    public function check_out()
    {
        $cart = $this->session->userdata('cart');
        if($cart == false) { $data['count'] = 0; $data['cost'] = 0; $list = '';}
        else
        {
            $count = 0;
            $cost = 0;
            foreach($cart as $pro)
            {
                $count += $pro['quantity'];
                $cost += $pro['quantity']*$pro['price'];
            }
            $data['count'] = $count;
            $data['cost'] = $cost;
            $pro_id_arr = array_keys($cart);
            $listProduct = $this->home_model->get_products_limit('', '', $pro_id_arr);
            $list = array();
            if($listProduct==''||$listProduct==array()) $list = '';
            else
                foreach($listProduct as $key=>$pro)
                {
                    $list[$pro['pro_id']] = $pro;
                }
        }        
        
		$data['listProduct'] = $list;
        $data['cart'] = $cart;
        
        $data['success'] = false;
        if($this->input->post("check_out"))
        {
            $this->form_validation->set_rules("name","Your name ","trim|required");
			$this->form_validation->set_rules("email","Your email ","trim|required|valid_email");
			$this->form_validation->set_rules("address","Your address ","trim|required");
			$this->form_validation->set_rules("phone","Your phone ","trim|required|numeric|min_length[10]|max_length[11]");
	
			$this->form_validation->set_message("required","%s is required");
			$this->form_validation->set_message("min_length","%s can't less than %d digit");
            $this->form_validation->set_message("max_length","%s can't more than %d digit");
			$this->form_validation->set_message("valid_email","%s is not valid email");
			$this->form_validation->set_message("numeric","%s must be numeric");
			$this->form_validation->set_error_delimiters("<span class='error'>","</span>");
            
            if($this->form_validation->run()&&$cart){
                $dataOrder = array(
                                "order_name"=>htmlspecialchars($this->input->post("name")),
                                "order_email"=>$this->input->post("email"),
                                "order_address"=>htmlspecialchars($this->input->post("address")),
                                "order_phone"=>$this->input->post("phone")
                                );
                
                $data['orderInfo'] = $dataOrder;
                $this->cart_model->check_out($data);
                $this->session->unset_userdata('cart');
                $data['success'] = true;
            }
            elseif(!$this->form_validation->run()) $data['error'] = "Some of your info is not valid, please check!";
            elseif(!$cart) $data['error'] = "Your cart is empty, can not check out!";          
        }        
        $data['title'] = "Check out";
    	$data['template'] = "checkout_view";       
        $this->load->view("layout", $data);
    }
    
}