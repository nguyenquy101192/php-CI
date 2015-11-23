<?php
$this->load->view("templates/top_view");
$this->load->view("templates/main_view");
if (isset($template)) {
    $this->load->view($template);
}
$this->load->view("templates/footer_view");
?>