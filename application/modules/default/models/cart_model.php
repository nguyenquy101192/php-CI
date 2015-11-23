<?php

class cart_model extends CI_Model
{
    protected $_order = "tbl_orders";
    protected $_orderdetail = "tbl_orderDetails";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper("url");
    }

    public function check_out($data)
    {
        //insert in to tbl_order
        $this->db->insert($this->_order, $data['orderInfo']);
        $order_id = $this->db->insert_id();

        //insert into tbl_orderdetail
        foreach ($data['cart'] as $pro_id => $pro) {
            $arr = array(
                "orderDetail_price" => $pro['price'],
                "orderDetail_quantity" => $pro['quantity'],
                "pro_name" => $data['listProduct'][$pro_id]['pro_name'],
                "order_id" => $order_id,
                "pro_id" => $pro_id
            );
            $this->db->insert($this->_orderdetail, $arr);
        }

    }
} 