
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

    <div class="statistic">
        <table class="table spending">
            <caption>Spending</caption>
            <tr>
                <th></th>
                <th>Today</th>
                <th>This month</th>
                <th>This year</th>
            </tr>
            <tr>
                <td>Money spent</td>
                <td><?= $prices[0] ?></td>
                <td><?= $prices[1] ?></td>
                <td><?= $prices[2] ?></td>
            </tr>
            <tr>
                <td>No of lists</td>
                <td><?= $noLists[0] ?></td>
                <td><?= $noLists[1] ?></td>
                <td><?= $noLists[2] ?></td>
            </tr>
        </table>
        <div class="statistic-freq">
            <table class="table freq-month">
                <caption>Most frequently requested Last Month</caption>
                <tr>
                    <th>Name</th>
                    <th>Count</th>
                </tr>
                <?php foreach($items['month'] as $name => $cnt) : ?>
                    <tr>
                        <td><?= $name ?></td>
                        <td><?= $cnt ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <table class="table freq-year">
                <caption>Most frequently requested Last Year</caption>
                <tr>
                    <th>Name</th>
                    <th>Count</th>
                </tr>
                <?php foreach($items['month'] as $name => $cnt) : ?>
                    <tr>
                        <td><?= $name ?></td>
                        <td><?= $cnt ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
