<!-- Autor - Olga Maslarevic 0007/2018 -->
<!-- Forma za registraciju -->

<?= $this->extend('login/login_common') ?>

<?= $this->section('content') ?>
<script>
    $(document).ready(function() {
        value= "<?php echo set_value('register_phone'); ?>";
        if(value == "") {
            value = "Phone";
        }
        $("input[name='register_phone']").val(value);
    });


    function showImage() {
        file_input = document.querySelector("input[type='file']");
        if (file_input.files && file_input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#group-img')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(file_input.files[0]);
        }
    }
</script>
<form class="form-horizontal row" method="post" action="/login/register" enctype="multipart/form-data">
    <div class="col col-md-9">
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                <input type="text" name="register_username" class="form-control" placeholder="Username" required="required" value="<?php echo set_value('register_username'); ?>">
                <div class="input-group-addon">Required</div>
            </div>
        </div>
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-male"></i></div>
                <input type="text" name="register_fullname" class="form-control" placeholder="Full name" required="required" value="<?php echo set_value('register_fullname'); ?>">
                <div class="input-group-addon">Required</div>
            </div>
        </div>
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                <input type="email" name="register_email" class="form-control" placeholder="Email" required="required" value="<?php echo set_value('register_email'); ?>">
                <div class="input-group-addon">Required</div>
            </div>
        </div>
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                <input type="tel" name="register_phone" class="form-control" placeholder="Phone" value="<?php echo set_value('register_phone'); ?>">
            </div>
        </div>
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                <input type="password" name="register_password" class="form-control" placeholder="Password" required="required">
                <div class="input-group-addon">Required</div>
            </div>
        </div>
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                <input type="password" name="register_cpassword" class="form-control" placeholder="Confirm Password" required="required">
                <div class="input-group-addon">Required</div>
            </div>
        </div>
        <input type="submit" value="Register" class="btn btn-success btn-block">
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
    </div>
    <div class="col col-md-3">
        <div class="form-group">
            <label for="image">
                <input type="file" name="image" id="image" onchange="showImage()" style="display:none;"/>
                <img id="group-img" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle"/>
                <p>Browse image</p>
            </label>
        </div>
    </div>
</form>

<?= $this->endSection() ?>