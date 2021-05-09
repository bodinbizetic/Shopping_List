<?= $this->extend('login_common') ?>

<?= $this->section('content') ?>

<form class="form-horizontal" method="post" action="/login/login">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-user"></i></div>
            <input type="text" name="login_username" class="form-control" placeholder="Username" required="required" value="<?php echo set_value('login_username'); ?>">
            <div class="input-group-addon">Required</div>
        </div>
    </div>
    <div class="form-group ">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-key"></i></div>
            <input type="password" name="login_password" class="form-control" placeholder="Password" required="required">
            <div class="input-group-addon">Required</div>
        </div>
    </div>
    <input type="submit" value="Login" class="btn btn-success btn-block">
    <br>
    <?php if(isset($errors)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php
            foreach($errors as $error) {
                echo $error. "<br>";
            }
            ?>
        </div>
    <?php } ?>
</form>

<?= $this->endSection() ?>
