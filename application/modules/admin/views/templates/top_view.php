<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" charset="UTF-8" />
	<meta name="author" content="Group03" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/style.admin.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/stype.move.slider.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/style.move.cate.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/style.update.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/font-awesome/css/font-awesome.min.css" />
    
    <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>public/js/jquery.fancybox.js"></script>
	<script src="<?php echo base_url();?>public/js/jquery.nestable.js"></script>
	<script src="<?php echo base_url();?>public/js/js.js"></script>
	<script src="<?php echo base_url();?>public/js/js.nouse.js"></script>
	<script src="<?php echo base_url();?>public/js/jquery.cslider.js"></script>
	<script src="<?php echo base_url();?>public/js/jquery-ui.js"></script>
	<title>Home page | Admin</title>
    <link rel="SHORTCUT ICON" href="<?php echo base_url();?>public/images/icon/favicon.ico" />
</head>

<body>
    <!--Wrapper-->
    <div id="wrapper">
    <!--Header-->
    <div id="header-banner">
        <!--Header top-->
        <div class="header">
        <div id="header-left">
            <a href="<?php echo base_url();?>admin/users">
                <span class="fa fa-clock-o"></span>&nbsp;Admin Management
            </a>
        </div>
        
        <div id="header-right">
            Logged in <a href="<?php echo base_url();?>admin/users/update/1">admin</a> |
            <?php
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $timezone = date_default_timezone_get();
                $date = date('l, d - m - Y');
                echo $date;
            ?>
            | &nbsp;&nbsp;
            <a href="<?php echo base_url();?>admin/logout" id="logout" class="fa fa-power-off"></a>
        </div>
        </div>
        <!--End header top-->
    
        <!--Menu top-->
        <div class="menu-top">
            <ul>
                <li><a href="<?php echo base_url();?>admin/users">&nbsp;Users management&nbsp;</a></li>
                <li><a href="<?php echo base_url();?>admin/brands">&nbsp;Brands management&nbsp;</a></li>
                <li><a href="<?php echo base_url();?>admin/products">&nbsp;Products management&nbsp;</a></li>
                <li><a href="<?php echo base_url();?>admin/categories">&nbsp;Categories management&nbsp;</a></li>
                <li><a href="<?php echo base_url();?>admin/orders">&nbsp;Orders management&nbsp;</a></li>
                <li><a href="<?php echo base_url();?>admin/sliders">&nbsp;Sliders management&nbsp;</a></li>
                <li><a href="<?php echo base_url();?>admin/comments">&nbsp;Comment management&nbsp;</a></li>
                <li><a href="<?php echo base_url();?>admin/reports">&nbsp;Reports management&nbsp;</a></li>
            </ul>
        </div>
        <!--End Menu top-->
    </div>
    <!--End header-->