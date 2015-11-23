<meta charset="UTF-8"/>
<?php

class Reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library('session');
        $this->load->model('reports_model');
    }

    public function index()
    {
        $data['title'] = "<span class='fa fa-files-o'></span>&nbsp;Reports";

        //code here..
        $data['products'] = $this->report('product');
        $data['template'] = "reports/reports_products_view";
        $this->load->view("layout", $data);
    }

    public function category()
    {
        $data['title'] = "<span class='fa fa-files-o'></span>&nbsp;Reports";

        //code here..
        $data['cates'] = $this->report('category');
        $data['template'] = "reports/reports_categories_view.php";
        $this->load->view("layout", $data);
    }

    public function report_product()
    {
        $data['title'] = "<span class='fa fa-files-o'></span>&nbsp;Reports";
        //code here..
        $data['products'] = $this->report('product');
        $data['from_date'] = $this->session->userdata('from_date');
        $data['to_date'] = $this->session->userdata('to_date');
        $data['template'] = "reports/reports_products_view.php";
        $this->load->view("layout", $data);
    }

    public function report_category()
    {
        $data['title'] = "<span class='fa fa-files-o'></span>&nbsp;Reports";
        //code here..
        $data['from_date'] = $this->session->userdata('from_date');
        $data['to_date'] = $this->session->userdata('to_date');
        $data['cates'] = $this->report('category');
        $data['template'] = "reports/reports_categories_view.php";
        $this->load->view("layout", $data);
    }

    private function report($type = "product")
    {

        if ($this->input->post("btnReport")) {

            $from_date = $this->input->post("from_date");
            $to_date = $this->input->post("to_date");

            if (!isset($from_date) || !isset($to_date) || empty($from_date) || empty($to_date)) {
                $this->session->unset_userdata('from_date');
                $this->session->unset_userdata('to_date');
            } else {
                $this->session->set_userdata('from_date', $from_date);
                $this->session->set_userdata('to_date', $to_date);
            }
        } else {
            $from_date = $to_date = date("Y/m/d");
            $this->session->set_userdata('from_date', $from_date);
            $this->session->set_userdata('to_date', $to_date);
        }

        if ($this->session->userdata('from_date') && $this->session->userdata('to_date')) {

            $from_date = $this->session->userdata('from_date') . " 00:00:00";
            $to_date = $this->session->userdata('to_date') . " 23:59:59";

            $items = $this->reports_model->$type($from_date, $to_date);

            $order = 0;
            foreach ($items as &$item) {

                $item['order'] = ++$order;
            }

            return $items;
        }

        return array();

    }
}

?>