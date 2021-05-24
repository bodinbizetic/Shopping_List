<link href="<?php echo base_url(); ?>/css/common.css" rel="stylesheet">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<section>
    <div class="container">
        <div class="section-title">
            <h2>Create new list</h2>
            <?php if (isset($group_name)) {
                echo '<h3>'.$group_name.'</h3>';
            }
            ?>
        </div>

        <div class="row">
            <div class="offset-2 col-8">
                <form class="form-horizontal" method="post" action="/lists/createNew">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-8">
                                <div class="input-group m-2">
                                    <input type="text" name="list_name" class="form-control" placeholder="List name" required>
                                    <div class="input-group-addon">Required</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <select id="shopid" name="shopid" class="custom-select custom-select-lg m-2">
                                    <?php
                                    foreach ($shops as $shop_id => $shop_name) {
                                        echo '<option value="'.$shop_id.'">'.$shop_name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="group" value="<?php echo $group_id ?>">
                        <input type="submit" value="Create" class="btn btn-success btn-block m-2">
                    </div>
                </form>
                <?php if(isset($errors)) { ?>
                    <div class=""alert alert-danger" role="alert">
                    <?php foreach($errors as $error) {
                        echo $error. "<br>";
                    }
                    ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
