<!-- Autor - Olga Maslarevic 0007/2018 -->
<!-- Logo sa animacijom -->

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <link href="<?php echo base_url('/css/login.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('/css/common.css')?>" rel="stylesheet" type="text/css">
</head>
<body>

<div class="row" id="body">
    <div class="col-md-3 logo">
        <img src="<?php echo base_url('images/logo.png'); ?>" />
        <h3>Jel ti usput?</h3>
    </div>
    <div class="col-md-9 content">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a href="<?php echo base_url('login/renderLogin')?>" class="get-started-btn scrollto">Login</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url('login/renderRegistration')?>" class="get-started-btn scrollto">Registration</a>
            </li>
        </ul>
        <?= $this->renderSection('content') ?>
    </div>
</div>

</body>
</html>