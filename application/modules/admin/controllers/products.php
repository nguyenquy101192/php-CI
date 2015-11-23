<?php

class Products extends CI_Controller
{
    const USERS_PER_PAGE = 5;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model("products_model");
        $this->load->model("sliders_model");
        $this->load->model("categories_model");
        $this->load->model("brands_model");
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library("upload");
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url("admin/login/"), 'refresh');
        }
    }

    public function index()
    {
        $data['title'] = "<span class='fa fa-folder-open-o'></span>&nbsp;List Products";

        //get page number
        $page_number = $this->uri->segment(4);
        if (!$page_number || $page_number == null) {
            $this->session->unset_userdata("config_products");
            $page_number = 1;
        } else if (isset($page_number) && $page_number <= 0) {
            $page_number = 1;
            redirect(base_url("admin/products/index/"), 'refresh');
        } else if (!is_numeric($page_number)) {
            $page_number = 1;
            redirect(base_url("admin/products/index/"), 'refresh');
        }

        /*get items per page*/
        if ($this->session->userdata("config_products")) {
            $per_page = $this->session->userdata("config_products");
        } else {
            $per_page = 5;
        }

        //get field to sort
        $field = $this->uri->segment(5);
        if (!$field) {
            $field = 'pro_id';
        }
        //get offset to sort
        $order = $this->uri->segment(6);
        if (!$order) {
            $order = 'DESC';
        }

        $config = array();
        $config ['base_url'] = base_url() . 'admin/products/index/';
        $config ['per_page'] = self::USERS_PER_PAGE;
        $config ['uri_segment'] = 4;
        $config ['total_rows'] = $this->products_model->get_total_record();
        $config ['next_link'] = 'Next';
        $config ['prev_link'] = 'Prev';
        $config ['use_page_numbers'] = TRUE;

        $start = ($page_number - 1) * $config ['per_page'];

        $data['field'] = $field;
        $data['order'] = $order;
        $data['page_number'] = $page_number;
        $data ['listProduct'] = $this->products_model->get_products_limit($start, $config ['per_page'], $field, $order);
        $this->pagination->initialize($config);
        $data ['pages'] = $this->pagination->create_links();
        $data ['stt'] = $start + 1;
        $data['total'] = $config ['total_rows'];
        $sort_field = array();

        foreach ($data['listProduct'] as $key => $value) {
            $sort_field[$key] = $value[$field];
        }

        if (strtolower($order) == 'desc') {
            array_multisort($sort_field, SORT_DESC, $data['listProduct']);
        } else {
            array_multisort($sort_field, SORT_ASC, $data['listProduct']);
        }
        $data['listSlider'] = $this->sliders_model->get_slider();
        $data['template'] = "products/products_view";
        $this->load->view("layout", $data);
    }

    public function search()
    {
        $data['title'] = "<span class='fa fa-search'></span>&nbsp;Search Products";

        if (isset($_POST['search']) && isset($_POST['search_type'])) {
            $keywords = $this->input->post('search');
            $search_type = $this->input->post('search_type');
        } else {
            $keywords = $this->session->userdata('search');
            $search_type = $this->session->userdata('search_type');
        }
        $this->session->set_userdata("search", $keywords);
        $this->session->set_userdata("search_type", $search_type);
        $data ['keywords'] = $keywords;
        $data ['search_type'] = $search_type;

        //get page number
        $page_number = $this->uri->segment(4);
        if (!$page_number) {
            $page_number = 1;
        } else if (isset($page_number) && $page_number <= 0) {
            $page_number = 1;
            redirect(base_url("admin/products/search/"), 'refresh');
        } else if (!is_numeric($page_number)) {
            $page_number = 1;
            redirect(base_url("admin/products/search/"), 'refresh');
        }
        //get field to sort
        $field = $this->uri->segment(5);
        if (!$field) {
            $field = 'pro_name';
        }
        //get offset to sort
        $order = $this->uri->segment(6);
        if (!$order) {
            $order = 'ASC';
        }

        $config = array();
        $config ['base_url'] = base_url() . 'admin/products/search/';
        $config ['per_page'] = self::USERS_PER_PAGE;
        $config ['uri_segment'] = 4;
        $config ['total_rows'] = $this->products_model->search_product_rows($keywords, $search_type);
        $config ['next_link'] = 'Next';
        $config ['prev_link'] = 'Prev';
        $config ['use_page_numbers'] = TRUE;

        $start = ($page_number - 1) * $config ['per_page'];

        $data['field'] = $field;
        $data['order'] = $order;
        $data['page_number'] = $page_number;
        $data ['listProduct'] = $this->products_model->search_products_limit($keywords, $search_type, $start, $config ['per_page'], $field, $order);
        $this->pagination->initialize($config);
        $data ['pages'] = $this->pagination->create_links();
        $data ['stt'] = $start + 1;
        $sort_field = array();

        foreach ($data['listProduct'] as $key => $value) {
            $sort_field[$key] = $value[$field];
        }

        if (strtolower($order) == 'desc') {
            array_multisort($sort_field, SORT_DESC, $data['listProduct']);
        } else {
            array_multisort($sort_field, SORT_ASC, $data['listProduct']);
        }
        $data['listSlider'] = $this->sliders_model->get_slider();
        $data['template'] = "products/products_view";
        $this->load->view("layout", $data);
    }

    //function delete
    public function delete()
    {
        $id = $this->uri->segment(4);
        if ($id != null) {
            $this->products_model->delete_product($id);
            redirect(base_url("admin/products/"), 'refresh');
        } else
            ?>
            <script>
                alert("Can not delete this product !");
            </script>
        <?php
        redirect(base_url("admin/products/"), 'refresh');
    }

    public function insert()
    {
        $data['template'] = "products/products_insert";
        $data['title'] = "<span class='fa fa-sign-in'></span>&nbsp;Insert Product";
        $data['brands'] = $this->products_model->get_all_brand();
        $data['category'] = $this->products_model->get_all_category();

        $config['upload_path'] = "public/images/products";
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '9000';
        $config['max_width'] = '1366';
        $config['max_height'] = '768';
        $config['remove_spaces'] = true;

        $this->upload->initialize($config);

        if ($this->input->post("insert")) {
            $this->form_validation->set_rules("pro_name", "Tên sản phẩm ", "trim|required|is_unique[tbl_products.pro_name]");
            $this->form_validation->set_rules("pro_list_price", "Giá sản phẩm ", "trim|required|numeric");
            $this->form_validation->set_rules("pro_sale_price", "Giá sản phẩm ", "trim|required|numeric");
            $this->form_validation->set_rules("pro_desc", "Mô tả sản phẩm ", "trim|required");
            $this->form_validation->set_rules("pro_country", "Xuất sứ ", "trim|required");
            $this->form_validation->set_rules("feature", "Feature", "trim|required");

            $this->form_validation->set_message("required", "%s không được bỏ trống");
            $this->form_validation->set_message("is_unique", "%s đã tồn tại");
            $this->form_validation->set_message("numeric", "%s phải là số");
            $this->form_validation->set_error_delimiters("<span class='error product-error'>", "</span>");

            if (!$this->upload->do_upload('main_img')) {
                $data['error_main_img'] = $this->upload->display_errors();
            } else {
                $temp = $this->upload->data();
                $main_img = $temp['file_name'];
            }
            if (isset($_FILES['thumb_img'])) $files = $_FILES['thumb_img'];
            $count = count($files['name']);
            for ($i = 0; $i < $count; $i++) {
                //gan moi file tro lai $_FILES
                $_FILES['thumb_img']['name'] = $files['name'][$i];
                $_FILES['thumb_img']['type'] = $files['type'][$i];
                $_FILES['thumb_img']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['thumb_img']['error'] = $files['error'][$i];
                $_FILES['thumb_img']['size'] = $files['size'][$i];

                if (!$this->upload->do_upload('thumb_img')) {
                    $temp = $i + 1;
                    $data['error_thumb_img'][] = "File $temp:" . $this->upload->display_errors();
                } else {
                    $temp = $this->upload->data();
                    $thumb_img[] = $temp['file_name'];
                }
            }

            if ($this->form_validation->run() && !isset($data['error_main_img']) && !isset($data['error_thumb_img'])) {
                $productInsert = array(
                    "pro_name" => $this->input->post("pro_name"),
                    "pro_list_price" => $this->input->post("pro_list_price"),
                    "pro_sale_price" => $this->input->post("pro_sale_price"),
                    "pro_images" => $main_img,
                    "pro_desc" => $this->input->post("pro_desc"),
                    "pro_country" => $this->input->post("pro_country"),
                    "brand_id" => $this->input->post("pro_brand"),
                    "feature" => $this->input->post("feature"));

                $cate = $this->input->post("pro_cate");

                //insert product
                $inserted_id = $this->products_model->insert($productInsert);

                //insert image                
                $array = array('img_link' => $main_img, 'img_status' => 1, 'pro_id' => $inserted_id);
                $this->products_model->insert_image($array);

                foreach ($thumb_img as $key => $value) {
                    $array = array('img_link' => $value, 'img_status' => 1, 'pro_id' => $inserted_id);
                    $this->products_model->insert_image($array);
                }

                //insert procate                
                if ($cate != '') foreach ($cate as $key => $value) {
                    $array = array('pro_id' => $inserted_id, 'cate_id' => $value);
                    $this->products_model->insert_procate($array);
                }

                redirect(base_url("admin/products"), 'refresh');
            }
        }
        $this->load->view("layout", $data);

        //Cancel insert
        if ($this->input->post("cancel")) {
            redirect(base_url("admin/products/"), 'refresh');
        }
    }

    //function update
    public function update()
    {
        $data['title'] = "<span class='fa fa-edit'></span>&nbsp;Update Product";
        $id = $this->uri->segment(4);

        //check url
        if (!is_numeric($id) || intval($id) <= 0) {
            show_404();
        }

        $all_products = $this->products_model->get_all_products();
        $all_id = array();
        if (!empty($all_products)) {
            foreach ($all_products as $product) {
                $all_id[] = $product['pro_id'];
            }
        }

        if (!in_array($id, $all_id)) {
            show_404();
        }
        //End check url
        $data['infoProduct'] = $this->products_model->getInforUpdate($id);
        $data['listCatergory'] = $this->categories_model->get_all_categories();
        $data['listBrand'] = $this->brands_model->get_all_brands();

        $test[] = $this->products_model->getCateId($id);
        $test2 = array();
        for ($i = 0; $i < count($test); $i++) {
            foreach ($test[$i] as $value) {
                $test2[] = $value['cate_id'];
            }
        }
        $data['listCateid'] = $test2;

        $data['image'] = $this->products_model->getImages($id);
        $data['listThumb'] = $this->products_model->getImagesThumb($id);

        if ($this->input->post('update')) {
            $this->form_validation->set_rules("pro_name", "Product name", "trim|required");
            $this->form_validation->set_rules("pro_list_price", "Price ", "trim|required|numeric");
            $this->form_validation->set_rules("pro_sale_price", "Price promotion", "trim|numeric");

            $this->form_validation->set_message("required", "%s is not empty!");
            $this->form_validation->set_message("numeric", "%s is the number");
            $this->form_validation->set_error_delimiters("<span class='error' color='red'>", "</span>");

            $dataCategory = $this->input->post('category');
            if ($this->form_validation->run()) {
                if ($this->uploadMainImage()) {
                    $dataUpdate['pro_images'] = $this->uploadMainImage();
                } else {
                    $dataUpdate['pro_images'] = $data['infoProduct']['pro_images'];
                }
                $dataThumb = $this->uploadMultilImages();
                if ($dataThumb[0] != '') {
                    $this->products_model->deleteThumb($id);
                    foreach ($dataThumb as $value) {
                        $this->products_model->updateThumb($value, $id);
                    }
                } else {
                    $dataThumb = $data['listThumb'];
                }

                $dataPro = array(
                    "pro_name" => $this->input->post('pro_name'),
                    "pro_list_price" => $this->input->post('pro_list_price'),
                    "pro_sale_price" => $this->input->post('pro_sale_price'),
                    "pro_images" => $dataUpdate['pro_images'],
                    "pro_desc" => $this->input->post('pro_desc'),
                    "pro_country" => $this->input->post('pro_country'),
                    "brand_id" => $this->input->post('brand_id'),

                );
                $this->products_model->update($dataPro, $id);
                $this->products_model->deleteCate($id);
                if ($dataCategory != null) {
                    foreach ($dataCategory as $value) {
                        $this->products_model->insertCate($value, $id);
                    }
                }

                redirect(base_url("admin/products"), 'refresh');
            }
        }
        $data['template'] = 'products/products_update';
        $this->load->view("layout", $data);

        //Cancel update
        if ($this->input->post("cancel")) {
            redirect(base_url("admin/products/"), 'refresh');
        }
    }

    //Upload main Image
    private function uploadMainImage()
    {
        $fileName = "";
        $fileInfo = $_FILES['images'];
        if ($fileInfo['name'] != null) {
            $fileName = $fileInfo['name'];
            move_uploaded_file($fileInfo['tmp_name'], "public/images/products/" . $fileName);
        }
        return $fileName;
    }

    //Update multi Images
    private function uploadMultilImages()
    {
        $fileInfo = $_FILES['imgs'];
        $fileName = array();
        if (isset($fileInfo['name']) && $fileInfo['name'] != null) {
            for ($i = 0; $i < count($fileInfo['name']); $i++) {
                $nameFile = $fileInfo['name'][$i];
                $fileName[] = $nameFile;
                move_uploaded_file($fileInfo['tmp_name'][$i], "public/images/products/" . $nameFile);
            }
        }
        return $fileName;
    }

    public function deleteThumb()
    {
        $pro_id = $this->uri->segment(4);
        $img_link = $this->uri->segment(5);
        $this->products_model->deleteImage($pro_id, $img_link);
        redirect(base_url("admin/products/update/{$pro_id}"), "refresh");
    }
}

?>