<?php

class Checkout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library("session");
    }

    public function index()
    {
        $data['title'] = "Check out";

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
        $data['template'] = "checkout_view";
        $this->load->view("layout", $data);
    }
}