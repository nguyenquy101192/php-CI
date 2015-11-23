<meta charset="UTF-8"/>
<?php

class Comments extends CI_Controller
{
    const USERS_PER_PAGE = 5;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("comments_model");
        $this->load->helper("url");
        $this->load->library("session");
        $this->load->library('pagination');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url("admin/login/"), 'refresh');
        }
    }

    public function index()
    {
        $data['title'] = "<span class='fa fa-wrench'></span>&nbsp;Comment management";
        $page_number = $this->uri->segment(4);
        if (!$page_number) {
            $page_number = 1;
        } else if (isset($page_number) && $page_number <= 0) {
            $page_number = 1;
            redirect(base_url("admin/brands/index/"), 'refresh');
        } else if (!is_numeric($page_number)) {
            $page_number = 1;
            redirect(base_url("admin/brands/index/"), 'refresh');
        }

        $config = array();
        $config ['base_url'] = base_url() . 'admin/comments/index/';
        $config ['per_page'] = self::USERS_PER_PAGE;
        $config ['uri_segment'] = 4;
        $config ['total_rows'] = count($this->comments_model->get_comments());
        $config ['next_link'] = 'Next';
        $config ['prev_link'] = 'Prev';
        $config ['use_page_numbers'] = TRUE;

        $start = ($page_number - 1) * $config ['per_page'];

        $data['page_number'] = $page_number;
        $data ['listComment'] = $this->comments_model->get_comments($start, $config ['per_page']);
        $this->pagination->initialize($config);
        $data ['pages'] = $this->pagination->create_links();
        $data ['stt'] = $start + 1;
        $data ['total'] = $config ['total_rows'];
        $data['per_page'] = self::USERS_PER_PAGE;

        $data['template'] = "comments/comments_view";
        $this->load->view("layout", $data);
    }

    public function approve()
    {
        $feed_id = $this->uri->segment(4);
        $feed_status = $this->uri->segment(5);
        $this->comments_model->approve($feed_id);
        redirect(base_url("admin/comments"), 'refresh');
    }

    public function delete()
    {
        $comment_id = $this->uri->segment(4);
        $this->comments_model->delete($comment_id);
        redirect(base_url("admin/comments"), 'refresh');
    }
}

?>