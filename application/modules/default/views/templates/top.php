<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8"/>
    <meta name="group03" content="mock project"/>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.font-end.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>public/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/jquery.fancybox.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/jslider.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/jslider.plastic.css"/>

    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-1.11.1.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/lightbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/backtop.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.dependClass-0.1.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/product_detail.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/slideshow.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/ajax.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/cart.js"></script>

    <!-- price slider -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/jquery-ui.css"/>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-ui.js"></script>
    <!-- Rating -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/rateit.css"/>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.rateit.js"></script>

    <title><?php if (isset($title)) echo $title; ?></title>
    <link rel="SHORTCUT ICON" href="<?php echo base_url(); ?>public/images/icon/favicon.ico"/>
</head>
<body>
<a id="lightbox"></a>

<div id="wrapper">
    <!--Header-->
    <div id="header">
        <div id="header-left">
            <a href='<?php echo base_url(); ?>default/home'><img
                    src="<?php echo base_url(); ?>public/images/icon/logo-header.png"/></a>
        </div>

        <div id='header-center'>
            <ul>
                <li><a href='<?php echo base_url(); ?>default/home'><span class='fa fa-home'></span>&nbsp;Home</a></li>
                <li><a href='<?php echo base_url(); ?>default/home/about_us'>About us</a></li>
                <li><a href='<?php echo base_url(); ?>default/home/contact_us'>Contact us</a></li>
            </ul>
        </div>

        <div id="header-right">
            <div id='header-cart'>
                <a href="<?php echo base_url(); ?>default/cart" id="tooltip-cart" title="This is your cart"><span
                        class="fa fa-shopping-cart"></span>&nbsp;My
                    cart: <?php if (isset($count)) echo $count; else echo "0"; ?>&nbsp;items
                    - <?php if (isset($cost)) echo number_format($cost, "0", "", ","); else echo "0"; ?> $</a>
            </div>
        </div>
    </div>
    <!--End header-->