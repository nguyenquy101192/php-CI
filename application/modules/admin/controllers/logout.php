<?php
class Logout extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library("session");
		$this->load->model("logins_model");
		$this->load->helper(array('form', 'url'));
	}
	public function index(){
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		$this->load->view('admin/logins/login_view');
	}
}