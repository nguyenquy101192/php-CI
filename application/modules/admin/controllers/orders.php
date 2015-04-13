<meta charset="UTF-8" />
<?php
class Orders extends CI_Controller{
    const USERS_PER_PAGE = 5;
    
    public function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->model("orders_model");
		$this->load->library ( 'pagination' );
    }
    
    public function index(){
        $data['title']      = "<span class='fa fa-file-text-o'></span>&nbsp;List Orders";  
        //get page number
        $page_number = $this->uri->segment(4);	
		if(!$page_number) {
			$page_number = 1;
		}
        else if(isset($page_number) && $page_number <= 0){
            $page_number = 1;
            redirect(base_url("admin/orders/index/"), 'refresh');
        }
        else if(!is_numeric($page_number)){
            $page_number = 1;
            redirect(base_url("admin/orders/index/"), 'refresh');
        }
        //get field to sort
        $field = $this->uri->segment(5);
		if(!$field){
			$field = 'order_status';
		}
        //get offset to sort
        $order = $this->uri->segment(6);
		if (!$order) {
			$order = 'ASC';
		}
        
        $config = array ();
		$config ['base_url']         = base_url () . 'admin/orders/index/';
		$config ['per_page']         = self::USERS_PER_PAGE;
		$config ['uri_segment']      = 4;
		$config ['total_rows']       = $this->orders_model->get_total_record();
		$config ['next_link']        = 'Next';
		$config ['prev_link']        = 'Prev';
		$config ['use_page_numbers'] = TRUE;
		
		$start = ($page_number - 1) * $config ['per_page'];
        
        $data['field']       = $field;
		$data['order']       = $order;
        $data['page_number'] = $page_number;
		$data ['listOrders']  = $this->orders_model->get_limit_orders_orderby($start, $config ['per_page']);
		$this->pagination->initialize ( $config );
		$data ['pages']      = $this->pagination->create_links ();
		$data ['stt']        = $start + 1;
        $data ['total']      = $config ['total_rows'];
        
        $sort_field = array();

		foreach ($data['listOrders'] as $key => $value) {
			$sort_field[$key] = $value[$field];
		}
		if(strtolower($order) == 'desc'){
			array_multisort($sort_field, SORT_DESC, $data['listOrders']);			
		} else {
			array_multisort($sort_field, SORT_ASC, $data['listOrders']);
		}
        $data['template']   = "orders/orders_view";
        $this->load->view("layout", $data);
    }
    
    public function details(){
        $data['title'] = "Order Details";
        $id = $this->uri->segment(4);
        $data['userInfo'] = $this->orders_model->get_order($id);
        $data['orderDetails'] = $this->orders_model->get_details($id);
        if($this->input->post("pay")){
            $array = array("order_status"=>1);
            $this->orders_model->update_status($array, $id);
            redirect(base_url("admin/orders"), 'refresh');
        }
        $data['template'] = "orders/orderDetails_view";
        $this->load->view("layout", $data);
    }
    
    public function delete(){
        $id = $this->uri->segment(4);
        if($id != '') $this->orders_model->delete($id);
        redirect(base_url("admin/orders"), 'refresh');
    }
}
?>