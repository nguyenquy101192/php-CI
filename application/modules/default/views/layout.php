<?php
$this->load->view("templates/top");
if (isset($slider)) {
    $this->load->view($slider);
}
$this->load->view("templates/main-content");
if (isset($colleft)) {
    $this->load->view($colleft);
}
if (isset($colright)) {
    $this->load->view($colright);
}
if (isset($feature)) {
    $this->load->view($feature);
}
if (isset($template)) {
    $this->load->view($template);
}
$this->load->view("templates/footer");
?>