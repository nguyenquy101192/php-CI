<?php

class Config extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model("users_model");
        $this->load->model("brands_model");
        $this->load->model("products_model");
        $this->load->library('pagination');
        $this->load->library("session");
        $this->load->model("logins_model");
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url("admin/login/"), 'refresh');
        }
        $this->load->library("form_validation");
    }

    public function config_users()
    {
        //get page number
        $page_number = $this->uri->segment(4);
        if (!$page_number) {
            $page_number = 1;
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

        /*set items per page*/
        if ($this->input->post('per_page')) {
            $per_page = $this->input->post('per_page');
            $this->session->set_userdata("config_users", $per_page);
            $sess = $this->session->userdata("config_users");
        } else
            $per_page = 5;

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
        $listUser = $this->users_model->get_users_limit($start, $config['per_page']);
        $this->pagination->initialize($config);
        $pages = $this->pagination->create_links();
        $stt = $start + 1;
        $total = $config['total_rows'];

        $sort_field = array();

        foreach ($listUser as $key => $value) {
            $sort_field[$key] = $value[$field];
        }

        if (strtolower($order) == 'desc') {
            array_multisort($sort_field, SORT_DESC, $listUser);
        } else {
            array_multisort($sort_field, SORT_ASC, $listUser);
        }

        $next_order = ($order == 'ASC') ? 'DESC' : 'ASC';
        $current_url = base_url() . 'admin/config/config_users';

        echo "<table class='result-table' border='1'>
		<tr class='title-table'>
		<td>No</td>
		<td>Username&nbsp;<a href='" . $current_url . $page_number . "/user_name/" . $next_order . " class='fa fa-sort'></a></td>
		<td>Email&nbsp;<a href='" . $current_url . $page_number . "/user_email/" . $next_order . " class='fa fa-sort'></a></td>
		<td>Address&nbsp;<a href='" . $current_url . $page_number . "/user_address/" . $next_order . " class='fa fa-sort'></a></td>
		<td>Phone</td>
		<td>Gender&nbsp;<a href='" . $current_url . $page_number . "/user_gender/" . $next_order . " class='fa fa-sort'></a></td>
		<td>Level&nbsp;<a href='" . $current_url . $page_number . "/user_level/" . $next_order . " class='fa fa-sort'></a></td>
		<td colspan='2'>Action</td>
		</tr>";

        foreach ($listUser as $key => $value) {
            echo "<tr>";
            echo "<td class='align'>" . $stt . "</td>";
            echo "<td>" . $value['user_name'] . "</td>";
            echo "<td>" . $value['user_email'] . "</td>";
            echo "<td>" . $value['user_address'] . "</td>";
            echo "<td>" . $value['user_phone'] . "</td>";
            echo "<td>";
            if ($value['user_gender'] == 1)
                echo "Male";
            else echo "Female";
            echo "</td>";
            echo "<td>";
            if ($value['user_level'] == 1)
                echo "Admin";
            else echo "Member";
            echo "</td>";
            echo "<td class='align'><a href='" . base_url("admin/users/update") . "/" . $value['user_id'] . "' class='fa fa-pencil'></a></td>";
            echo "<td class='align'><a href='" . base_url() . "admin/users/delete/" . $value['user_id'] . "' onclick='if(checkDelete() == false) return false' class='fa fa-trash-o' ></a></td>";
            echo "</tr>";
            $stt++;
        }

        echo "</table>
		<div class='pagination'>"
            . $pages .
            "</div>";
    }

    public function config_brands()
    {
        //get page number
        $page_number = $this->uri->segment(4);
        if (!$page_number) {
            $page_number = 1;
        }
        //get filed to sort
        $field = $this->uri->segment(5);
        if (!$field) {
            $field = 'brand_name';
        }
        //get offset to sort
        $order = $this->uri->segment(6);
        if (!$order) {
            $order = 'ASC';
        }

        if (!is_numeric($page_number) || intval($page_number) <= 0) {
            show_404();
        }

        /*set items per page*/
        if ($this->input->post('per_page')) {
            $per_page = $this->input->post('per_page');
            $this->session->set_userdata("config_brands", $per_page);
            $sess = $this->session->userdata("config_brands");
        } else
            $per_page = 5;

        $config = array();
        $config['base_url'] = base_url() . 'admin/brands/index/';
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->brands_model->get_total_record();
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['use_page_numbers'] = TRUE;

        $start = ($page_number - 1) * $config['per_page'];

        $data['field'] = $field;
        $data['order'] = $order;
        $data['page_number'] = $page_number;
        $listBrands = $this->brands_model->get_brands_limit($start, $config['per_page']);
        $this->pagination->initialize($config);
        $pages = $this->pagination->create_links();
        $stt = $start + 1;
        $total = $config['total_rows'];

        $sort_field = array();

        foreach ($listBrands as $key => $value) {
            $sort_field[$key] = $value[$field];
        }

        if (strtolower($order) == 'desc') {
            array_multisort($sort_field, SORT_DESC, $listBrands);
        } else {
            array_multisort($sort_field, SORT_ASC, $listBrands);
        }

        $next_order = ($order == 'ASC') ? 'DESC' : 'ASC';
        $current_url = base_url() . 'admin/config/config_brands';

        echo "<table class='result-table' border='1'>
		<tr class='title-table'>
		<td>No</td>
		<td>Brand name&nbsp;<a href='" . $current_url . $page_number . "/brand_name/" . $next_order . " class='fa fa-sort'></a></td>
		<td colspan='2'>Action</td>
		</tr>";

        foreach ($listBrands as $key => $value) {
            echo "<tr>";
            echo "<td class='align'>" . $stt . "</td>";
            echo "<td>" . $value['brand_name'] . "</td>";
            echo "<td class='align'><a href='" . base_url("admin/brands/update") . "/" . $value['brand_id'] . "' class='fa fa-pencil'></a></td>";
            echo "<td class='align'><a href='" . base_url() . "admin/brands/delete/" . $value['brand_id'] . "' onclick='if(checkDelete() == false) return false' class='fa fa-trash-o' ></a></td>";
            echo "</tr>";
            $stt++;
        }

        echo "</table>
		<div class='pagination'>"
            . $pages .
            "</div>";
    }

    public function config_products()
    {
        //get page number
        $page_number = $this->uri->segment(4);
        if (!$page_number) {
            $page_number = 1;
        }
        //get filed to sort
        $field = $this->uri->segment(5);
        if (!$field) {
            $field = 'pro_id';
        }
        //get offset to sort
        $order = $this->uri->segment(6);
        if (!$order) {
            $order = 'ASC';
        }

        if (!is_numeric($page_number) || intval($page_number) <= 0) {
            show_404();
        }

        /*set items per page*/
        if ($this->input->post('per_page')) {
            $per_page = $this->input->post('per_page');
            $this->session->set_userdata("config_products", $per_page);
            $sess = $this->session->userdata("config_products");
        } else
            $per_page = 5;

        $config = array();
        $config['base_url'] = base_url() . 'admin/products/index/';
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->products_model->get_total_record();
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['use_page_numbers'] = TRUE;

        $start = ($page_number - 1) * $config['per_page'];

        $data['field'] = $field;
        $data['order'] = $order;
        $data['page_number'] = $page_number;
        $listProducts = $this->products_model->get_products_limit($start, $config['per_page']);
        $this->pagination->initialize($config);
        $pages = $this->pagination->create_links();
        $stt = $start + 1;
        $total = $config['total_rows'];

        $sort_field = array();

        foreach ($listProducts as $key => $value) {
            $sort_field[$key] = $value[$field];
        }

        if (strtolower($order) == 'desc') {
            array_multisort($sort_field, SORT_DESC, $listProducts);
        } else {
            array_multisort($sort_field, SORT_ASC, $listProducts);
        }

        $next_order = ($order == 'ASC') ? 'DESC' : 'ASC';
        $current_url = base_url() . 'admin/config/config_brands';

        echo "<table class='result-table' border='1'>
		<td>No</td>
        <td>Slider</td>
		<td>Product image</td>
		<td>Product name&nbsp;<a href='" . $current_url . $page_number . '/pro_name/' . $next_order . "' class='fa fa-sort'></a></td>
		<td>List price&nbsp;<a href='" . $current_url . $page_number . '/pro_list_price/' . $next_order . "' class='fa fa-sort'></a></td>
		<td>Sale price&nbsp;<a href='" . $current_url . $page_number . '/pro_sale_price/' . $next_order . "' class='fa fa-sort'></a></td>
		<td>Description</td>
		<td>Brand&nbsp;<a href='" . $current_url . $page_number . '/brand_id/' . $next_order . "' class='fa fa-sort'></a></td>
		<td>Origin&nbsp;<a href='" . $current_url . $page_number . '/pro_origin/' . $next_order . "' class='fa fa-sort'></a></td>
		<td colspan='2'>Action</td>";

        foreach ($listProducts as $key => $value) {
            echo "<tr>
                <td class='align'>" . $stt . "</td>
                <td class='align'><input type=checkbox";
            foreach ($listSlider as $key => $slider) {
                if ($value['pro_id'] == $slider['pro_id']) {
                    echo "checked";
                }
            };
            echo "onclick='window.location='" . base_url() . "'admin/sliders/add_delete_slider?product_id=" . $value['pro_id'] . "'; return true;'></td>
        		<td class='align'>
        			<img alt='IMAGE' src='" . base_url() . "public/images/products/" . $value["pro_images"] . "' width='50' height='50'/>
        		</td>
        		<td style='font-weight: bold;'>"
                . $value["pro_name"] .
                "</td>
                <td class='align' style='color: #ff3333;'>";
            number_format($value["pro_list_price"], "0", "", ".") . "&nbsp;<span class='fa fa-dollar'></span>";
            echo "</td>
        		<td class'align' style='color: #ff3333;'>";
            number_format($value["pro_sale_price"], "0", "", ".") . "&nbsp;<span class='fa fa-dollar'></span>";
            echo "</td>
        		<td>
        			 " . $value["pro_desc"] . "
        		</td>
        		<td>
        			" . $value["brand_name"] . "
        		</td>
        		<td>
        			" . $value["pro_country"] . "
        		</td>
        		<td class='align' style='width: 50px;'><a href='" . base_url() . "admin/products/update/" . $value['pro_id'] . "' class='fa fa-pencil'></a></td>
        		<td class='align' style='width: 50px;'><a href='" . base_url() . "admin/products/datele/" . $value['pro_id'] . "' class='fa fa-trash-o' onclick='if(check_delete()==false) return false'></a></td>        	</tr>";
            $stt++;
        }

        echo "</table>
		<div class='pagination'>"
            . $pages .
            "</div>";
    }
}

?>