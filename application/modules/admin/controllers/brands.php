<meta charset="UTF-8"/>
<?php

class Brands extends CI_Controller
{
    const USERS_PER_PAGE = 5;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("brands_model");
        $this->load->helper("url");
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library("session");
        $this->load->model("logins_model");
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url("admin/login/"), 'refresh');
        }
    }

    public function index()
    {
        $data ['title'] = "<span class='fa fa-folder-open-o'></span>&nbsp;List Brands";

        //get page number
        $page_number = $this->uri->segment(4);
        if (!$page_number || $page_number == null) {
            $this->session->unset_userdata("config_brands");
            $page_number = 1;
        } else if (isset($page_number) && $page_number <= 0) {
            $page_number = 1;
            redirect(base_url("admin/brands/index/"), 'refresh');
        } else if (!is_numeric($page_number)) {
            $page_number = 1;
            redirect(base_url("admin/brands/index/"), 'refresh');
        }
        //get field to sort
        $field = $this->uri->segment(5);
        if (!$field) {
            $field = 'brand_name';
        }
        //get offset to sort
        $order = $this->uri->segment(6);
        if (!$order) {
            $order = 'ASC';
        }

        /*get items per page*/
        if ($this->session->userdata("config_brands")) {
            $per_page = $this->session->userdata("config_brands");
        } else {
            $per_page = 5;
        }

        $config = array();
        $config ['base_url'] = base_url() . 'admin/brands/index/';
        $config ['per_page'] = $per_page;
        $config ['uri_segment'] = 4;
        $config ['total_rows'] = $this->brands_model->get_total_record();
        $config ['next_link'] = 'Next';
        $config ['prev_link'] = 'Prev';
        $config ['use_page_numbers'] = TRUE;

        $start = ($page_number - 1) * $config ['per_page'];

        $data['field'] = $field;
        $data['order'] = $order;
        $data['page_number'] = $page_number;
        $data ['listBrand'] = $this->brands_model->get_brands_limit($start, $config ['per_page'], $field, $order);
        $this->pagination->initialize($config);
        $data ['pages'] = $this->pagination->create_links();
        $data ['stt'] = $start + 1;
        $data ['total'] = $config ['total_rows'];

        $sort_field = array();

        foreach ($data['listBrand'] as $key => $value) {
            $sort_field[$key] = $value[$field];
        }

        if (strtolower($order) == 'desc') {
            array_multisort($sort_field, SORT_DESC, $data['listBrand']);
        } else {
            array_multisort($sort_field, SORT_ASC, $data['listBrand']);
        }

        $data ['template'] = "brands/brands_view";
        $this->load->view("layout", $data);
    }

    //function insert
    public function insert()
    {
        $data['title'] = "<span class='fa fa-sign-in'></span>&nbsp;Insert Brand";
        if ($this->input->post("insert")) {
            $this->form_validation->set_rules("brand_name", "Tên Brand ", "trim|required|is_unique[tbl_brands.brand_name]");

            $this->form_validation->set_message("required", "%s không được bỏ trống");
            $this->form_validation->set_message("is_unique", "%s đã tồn tại");
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

            if ($this->form_validation->run()) {
                $dataBrand = array(
                    "brand_name" => $this->input->post("brand_name")
                );
                $this->brands_model->insert($dataBrand);
                redirect(base_url("admin/brands/"), 'refresh');
            }
        }
        $data['template'] = "brands/brands_insert";
        $this->load->view("layout", $data);

        // cancel insert
        if ($this->input->post("cancel")) {
            redirect(base_url("admin/brands/"), 'refresh');
        }
    }

    //function update
    public function update()
    {
        $data ['title'] = "<span class='fa fa-edit'></span>&nbsp;Update Brand";
        $id = $this->uri->segment(4);

        // check url
        if (!is_numeric($id) || intval($id) <= 0) {
            show_404();
        }

        $all_brands = $this->brands_model->get_all_brands();
        $all_id = array();
        if (!empty ($all_brands)) {
            foreach ($all_brands as $brand) {
                $all_id [] = $brand ['brand_id'];
            }
        }

        if (!in_array($id, $all_id)) {
            show_404();
        }
        // End check url

        $data ['brandInfor'] = $this->brands_model->detail($id);

        if ($this->input->post('update')) {
            $this->form_validation->set_rules("brand_name", "Tên Brand ", "trim|required");

            $this->form_validation->set_message("required", "%s không được bỏ trống");
            $this->form_validation->set_message("is_unique", "%s đã tồn tại");
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
            $ten = $this->input->post("brand_name");
            if ($this->form_validation->run()) {
                $dataBrand = array(
                    "brand_name" => $this->input->post("brand_name")
                );
                $this->brands_model->update($dataBrand, $id);
                redirect(base_url("admin/brands/"), 'refresh');
            }
            $data['brandInfor'] = $this->brands_model->detail($id);
        }
        $data ['template'] = "brands/brands_update";
        $this->load->view("layout", $data);

        // cancel update
        if ($this->input->post("cancel")) {
            redirect(base_url("admin/brands/"), 'refresh');
        }
    }

    //function delete
    public function delete()
    {
        $id = $this->uri->segment(4);
        if ($id != '') $this->brands_model->delete($id);
        redirect(base_url("admin/brands"), 'refresh');
    }


    //function seach
    public function search()
    {
        if (isset($_POST['search'])) {
            $keywords = $this->input->post('search');
        } else {
            $keywords = $this->session->userdata('search');
        }
        $this->session->set_userdata("search", $keywords);
        // die ($keywords);
        $data ['title'] = "<span class='fa fa-search'></span>&nbsp;Search Brand";
        $data ['template'] = "brands/brands_view";
        $data ['keywords'] = $keywords;

        //get page number
        $page_number = $this->uri->segment(4);
        if (!$page_number) {
            $page_number = 1;
        } else if (isset($page_number) && $page_number <= 0) {
            $page_number = 1;
            redirect(base_url("admin/brands/search/"), 'refresh');
        } else if (!is_numeric($page_number)) {
            $page_number = 1;
            redirect(base_url("admin/brands/search/"), 'refresh');
        }

        $config = array();
        $config ['base_url'] = base_url() . 'admin/brands/search/';
        $config ['per_page'] = self::USERS_PER_PAGE;
        $config ['uri_segment'] = 4;
        $config ['total_rows'] = $this->brands_model->search_brands_rows($keywords);
        $config ['next_link'] = 'Next';
        $config ['prev_link'] = 'Prev';
        $config ['use_page_numbers'] = TRUE;

        $start = ($page_number - 1) * $config ['per_page'];

        $data['page_number'] = $page_number;
        $data['order'] = "ASC";
        $data ['listBrand'] = $this->brands_model->search_brands_limit($keywords, $start, $config ['per_page']);
        $this->pagination->initialize($config);
        $data ['pages'] = $this->pagination->create_links();
        $data ['stt'] = $start + 1;
        $this->load->view("layout", $data);
    }
}

?>