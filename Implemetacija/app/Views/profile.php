
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>/css/profile.css" rel="stylesheet">

<section id="profile">
    <div class="container">
        <div class="section-title">
            <h2>My Profile</h2>
        </div>
    </div>
</section>

<div class="content">
    <div class="slide">

        <div class="div-img">
            <?php if(isset($user['image']) && $user['image'] != ""): ?>
                <img height="50" width="50" src="data:image;base64,'.base64_encode(<?= $user['image'] ?>).'">
            <?php else: ?>
                <img height="50" width="50" src="<?php echo base_url(); ?>/images/profile/person.jpg">
            <?php endif; ?>
            <h3>
                <?= $user['fullName'] ?>
            </h3>
        </div>

        <div class="my-form">
            <form>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-prepend"><i class="input-group-text fa fa-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="<?= $user['fullName'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-prepend"><i class="input-group-text fa fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="<?= $user['email'] ?>">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group">
                        <span class="input-group-prepend"><i class="input-group-text fa fa-phone"></i></span>
                        <input type="tel" name="phone" class="form-control" placeholder="<?= $user['phone'] ?>">
                    </div>
                </div>
                <input type="button" value="Edit" class="btn btn-success btn-block">
            </form>
        </div>

    </div>

<!--    <div class="statistic">-->
<!--        <table class="table">-->
<!--            <caption>Spending</caption>-->
<!--            <tr>-->
<!--                <th></th>-->
<!--                <th>Today</th>-->
<!--                <th>This month</th>-->
<!--                <th>This year</th>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Money spent</td>-->
<!--                <td>--><?//= $spending['today'] ?><!--</td>-->
<!--                <td>--><?//= $spending['month'] ?><!--</td>-->
<!--                <td>--><?//= $spending['year'] ?><!--</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>No of lists</td>-->
<!--                <td>--><?//= $noLists['today'] ?><!--</td>-->
<!--                <td>--><?//= $noLists['month'] ?><!--</td>-->
<!--                <td>--><?//= $noLists['year'] ?><!--</td>-->
<!--            </tr>-->
<!--        </table>-->
<!--        <table class="table">-->
<!--            <caption>Most frequently requested</caption>-->
<!--            <tr>-->
<!--                <th></th>-->
<!--                <th>Last 10 days</th>-->
<!--                <th>This month</th>-->
<!--                <th>This year</th>-->
<!--            </tr>-->
<!--            --><?php //for ($i = 0; $i < count($items); $i++): ?>
<!--            <tr>-->
<!--                <td>--><?//= $items[$i]['name'] ?><!--</td>-->
<!--                <td>--><?//= $items[$i]['days'] ?><!--</td>-->
<!--                <td>--><?//= $items[$i]['month'] ?><!--</td>-->
<!--                <td>--><?//= $items[$i]['year'] ?><!--</td>-->
<!--            </tr>-->
<!--        </table>-->

    </div>
</div>
