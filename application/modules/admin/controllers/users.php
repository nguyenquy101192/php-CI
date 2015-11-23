<meta charset="UTF-8"/>
<?php

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");

        $this->load->model("users_model");
        $this->load->library('pagination');
        $this->load->library("session");
        $this->load->model("logins_model");
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url("admin/login/"), 'refresh');
        }
        $this->load->library("form_validation");
    }

    public function index()
    {
        $data['title'] = "<span class='fa fa-folder-open-o'></span>&nbsp;List Users";

        //get page number
        $page_number = $this->uri->segment(4);
        if (!$page_number || $page_number == null) {
            $this->session->unset_userdata("config_users");
            $page_number = 1;
        }

        /*get items per page*/
        if ($this->session->userdata("config_users")) {
            $per_page = $this->session->userdata("config_users");
        } else {
            $per_page = 5;
        }

        //get filed to sort
        $field = $this->uri->segment(5);
        if (!$field) {
            $field = 'user_name';
        }
        //get offset to sort
        $order = $this->uri->segment(6);
        if (!$order) {
            $order = 'ASC';
        }

        if (!is_numeric($page_number) || intval($page_number) <= 0) {
            show_404();
        }


        $config = array();
        $config['base_url'] = base_url() . 'admin/users/index/';
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->users_model->get_total_record();
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['use_page_numbers'] = TRUE;

        $start = ($page_number - 1) * $config['per_page'];

        $data['field'] = $field;
        $data['order'] = $order;
        $data['page_number'] = $page_number;
        $data['listUser'] = $this->users_model->get_users_limit($start, $config['per_page']);
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $data['stt'] = $start + 1;
        $data['total'] = $config['total_rows'];

        $sort_field = array();

        foreach ($data['listUser'] as $key => $value) {
            $sort_field[$key] = $value[$field];
        }

        if (strtolower($order) == 'desc') {
            array_multisort($sort_field, SORT_DESC, $data['listUser']);
        } else {
            array_multisort($sort_field, SORT_ASC, $data['listUser']);
        }

        $data['template'] = "users/users_view";
        $this->load->view("layout", $data);
    }

    //function insert
    public function insert()
    {
        $data['title'] = "<span class='fa fa-sign-in'></span>&nbsp;Insert User";

        if ($this->input->post("insert")) {
            $this->form_validation->set_rules("name", "Tên ", "trim|required|is_unique[tbl_users.user_name]");
            $this->form_validation->set_rules("password", "Mật khẩu ", "trim|required");
            $this->form_validation->set_rules("email", "Email ", "trim|required|valid_email|is_unique[tbl_users.user_email]");
            $this->form_validation->set_rules("address", "Địa chỉ ", "trim|required");
            $this->form_validation->set_rules("phone", "Số điện thoại ", "trim|required|numeric|min_length[10]|max_length[11]");
            $this->form_validation->set_rules("gender", "Giới tính ", "trim|required");
            $this->form_validation->set_rules("level", "Cấp độ user", "trim|required");

            $this->form_validation->set_message("required", "%s không được bỏ trống");
            $this->form_validation->set_message("is_unique", "%s đã tồn tại");
            $this->form_validation->set_message("min_length", "%s không được nhỏ hơn %d kí tự");
            $this->form_validation->set_message("max_length", "%s không được lớn hơn %d kí tự");
            $this->form_validation->set_message("valid_name", "%s không đúng định dạng");
            $this->form_validation->set_message("valid_email", "%s không đúng định dạng");
            $this->form_validation->set_message("numeric", "%s phải là số");
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

            if ($this->form_validation->run()) {
                $dataUser = array(
                    "user_name" => $this->input->post("name"),
                    "user_password" => md5($this->input->post("password")),
                    "user_email" => $this->input->post("email"),
                    "user_address" => $this->input->post("address"),
                    "user_phone" => $this->input->post("phone"),
                    "user_gender" => $this->input->post("gender"),
                    "user_level" => $this->input->post("level")
                );

                $data['userInfo'] = $dataUser;
                $this->users_model->insert($dataUser);
                redirect(base_url("admin/users/"));
            }
        }
        $data['template'] = "users/users_insert";
        $this->load->view("layout", $data);

        //cancel insert
        if ($this->input->post("cancel")) {
            redirect(base_url("admin/users/"));
        }
    }

    //Delete user
    public function delete()
    {
        $id = $this->uri->segment(4);
        $this->users_model->delete_user($id);
        redirect(base_url("admin/users/"));
    }

    public function update()
    {
        $data['title'] = "<span class='fa fa-edit'></span>&nbsp;Update User";

        //code here..
        //lay ra user can sua
        $id = $this->uri->segment(4);
        if ($id == '') $id = -1;
        $data['user'] = $this->users_model->get_one($id);

        //check form
        if ($this->input->post("ok")) {
            $this->form_validation->set_rules("name", "Ten nguoi dung", "trim|required|callback_check_username[" . $id . "]");
            $this->form_validation->set_rules("pass", "Mat khau", "trim|required");
            $this->form_validation->set_rules("email", "Email", "trim|required|valid_email|callback_check_email[" . $id . "]");
            $this->form_validation->set_rules("address", "Dia chi", "trim|required");
            $this->form_validation->set_rules("phone", "So dien thoai", "trim|required|numeric|min_length[9]|max_length[11]");
            $this->form_validation->set_rules("gender", "Gioi tinh", "required");
            $this->form_validation->set_rules("level", "Level", "required");

            $this->form_validation->set_message("required", "%s khong duoc rong");
            $this->form_validation->set_message("valid_email", "%s khong dung dinh dang");
            $this->form_validation->set_message("numeric", "%s phai la so");
            $this->form_validation->set_message("min_length", "%s qua ngan");
            $this->form_validation->set_message("max_length", "%s qua dai");

            //neu ok thi sua vao database
            if ($this->form_validation->run()) {
                $new_pass = $this->input->post("pass");
                if ($new_pass != $data['user']['user_password']) $encryt_pass = md5($new_pass);
                else $encryt_pass = $new_pass;
                $user_update = array("user_name" => $this->input->post("name"),
                    "user_password" => $encryt_pass,
                    "user_email" => $this->input->post("email"),
                    "user_address" => $this->input->post("address"),
                    "user_phone" => $this->input->post("phone"),
                    "user_gender" => $this->input->post("gender"),
                    "user_level" => $this->input->post("level")
                );
                while (!$this->users_model->update($id, $user_update)) ;
                redirect(base_url("admin/users/index"));
            }
        }
        //load view update
        $data['template'] = "users/users_update";
        $this->load->view("layout", $data);

        //cancel update
        if ($this->input->post("cancel")) {
            redirect(base_url("admin/users/"), 'refresh');
        }
    }

    public function check_username($name, $id)
    {
        $this->form_validation->set_message("check_username", "Ten nguoi dung da ton tai!");
        return $this->users_model->check_username($name, $id);
    }

    public function check_email($email, $id)
    {
        $this->form_validation->set_message("check_email", "Email da ton tai!");
        return $this->users_model->check_email($email, $id);
    }
}

?>