<!-- Autor - Olga Maslarevic 0007/2018 -->
<!-- Prikaz header-a i navigacije za moderatora sajta -->

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

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url('css/common.css')?>" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $("#refresh").bind('click', function() {
                $("#passModal").css({'display': "block"});
            });
            $("#close").bind('click', function() {
                $("#passModal").css({'display': "none"});
            });
            $("#save").bind('click', function() {
                pass = $("input[type='password']").val();
                if(pass == "")
                    alert("Password can not be empty!");
                else
                    window.location.href = "/moderator/refreshPassword/" + pass;
            });
            $("#passModal").css({'display': "none"});
        });
    </script>
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

<div id="passModal" class="modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                        <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                        <div class="input-group-addon">Required</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="get-started-btn scrollto" id="close">Close</a>
                <a href="#" class="get-started-btn scrollto" id="save">Save</a>
            </div>
        </div>
    </div>
</div>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
        <h1 class="logo mr-auto"><a href="<?php echo base_url('moderator/index')?>">Jel ti usput?</a></h1>
        <a href="#" id="refresh" class="get-started-btn scrollto">Refresh password</a>
        <a href="<?php echo base_url('login/logout')?>" class="get-started-btn scrollto">Logout</a>
    </div>
</header>
<!-- End Header -->