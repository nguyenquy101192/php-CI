<meta charset="UTF-8"/>
<?php

class Sliders extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model("products_model");
        $this->load->model("sliders_model");
    }

    public function index()
    {
        $data ['title'] = 'Choose slider';
        $data ['template'] = 'sliders/sliders_select_view';
        $data['order'] = $this->sliders_model->get_slider_order();
        $this->load->view("layout", $data);
    }

    public function add_delete_slider()
    {
        $product_id = $_GET['product_id'];
        if (count($this->sliders_model->get_slider_by_pro_id($product_id)) > 0) {
            $this->sliders_model->delete_slider($product_id);
        } else {
            $product = $this->products_model->get_product_by_id($product_id);
            $slider_link = $product[0]['pro_images'];
            $this->sliders_model->insert_slider($product_id, $slider_link);
        }
        redirect(base_url("admin/products/"), 'refresh');
    }

    public function setOrder()
    {

        $update = $_POST['data'];
        $this->sliders_model->update_slider($update);
    }
}

?>