<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->

    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/icofont/icofont.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/boxicons/css/boxicons.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/animate.css/animate.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/owl.carousel/assets/owl.carousel.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/venobox/venobox.css')?>" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('css/common.css')?>" rel="stylesheet">

</head>

<body>

<!-- ======= Top Bar ======= -->
<div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
    <div class="container d-flex">
        <div class="contact-info mr-auto">
            <i class="icofont-envelope"></i> <a href="mailto:contact@example.com">contact@example.com</a>
            <i class="icofont-phone"></i> +1 5589 55488 55
        </div>
        <div class="social-links">
            <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
            <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
            <a href="#" class="linkedin"><i class="icofont-linkedin"></i></i></a>
        </div>
    </div>
</div>


<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
        <h1 class="logo mr-auto"><a href="<?php echo base_url('homePage/index')?>">Jel ti usput?</a></h1>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="active"><a href="<?php echo base_url('homePage/index')?>">Home</a></li>
                <li><a href="<?php echo base_url('homePage/lists')?>">Shopping list</a></li>
                <li><a href="<?php echo base_url('group/index')?>">Groups</a></li>
                <li><a href="<?php echo base_url('notification/index')?>">Notifications</a></li>
                <li><a href="<?php echo base_url('profile/index')?>">Profile</a></li>
            </ul>
        </nav>
        <a href="<?php echo base_url('login/logout')?>" class="get-started-btn scrollto">Logout</a>
    </div>
</header>
<!-- End Header -->