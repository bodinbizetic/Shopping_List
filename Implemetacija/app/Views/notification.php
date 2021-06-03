<!-- Autor - Olga Maslarevic 0007/2018 -->
<!-- Prikaz notifikacija  -->

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>

<link href="<?php echo base_url(); ?>/public/css/notification.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>/public/js/notification.js" type="text/javascript"></script>


<main id="main">
    <section>
        <div class="container">
            <div class="section-title">
                <h2>Notifications</h2>
            </div>


            <table class="table" id="my-table">
                <thead>
                <tr>
                    <th style="text-align: center">Image</th>
                    <th style="text-align: center">Group</th>
                    <th style="text-align: center">Message</th>
                    <th style="text-align: center">Type</th>
                    <th style="text-align: center">Action</th>
                </tr>
                </thead>
                <tbody>

                    <?php for ($i = 0; $i < count($notifications); $i++): ?>

                        <tr class="<?php if($notifications[$i]['isRead'] == 1) echo 'bg-white'; else echo 'bg-warning'; ?>">
                            <td style="text-align: center">
                                <?php if(isset($notifications[$i]['image'])): ?>
                                     <img height="50" width="50" src="<?php echo base_url(). '/groupUploads/'. $notifications[$i]['image']; ?>">
                                <?php endif; ?>
                            </td>
                            <td style="padding: 20px; text-align: center"><?php echo $notifications[$i]['name']; ?></td>
                            <td style="padding: 20px; text-align: center""><?php echo $notifications[$i]['text']; ?></td>
                            <td style="padding: 20px; text-align: center"">
                                <span class="<?php echo $typesClass[$notifications[$i]['type']]; ?>">
                                    <?php echo $typesText[$notifications[$i]['type']];?>
                                </span>
                            </td>
                            <td style="padding: 20px;">
                                <?php if($notifications[$i]['isRead'] == false): ?>
                                    <?php if($notifications[$i]['type'] == 0): ?>
                                        <div class="btn-group">
                                            <button class="btn btn-success"
                                                    onclick="window.location.href='<?php $id = $notifications[$i]['idNotification'];
                                                    echo base_url("notification/approve/$id");?>'">Approve</button>
                                            <button class="btn btn-danger"
                                                    onclick="window.location.href='<?php $id = $notifications[$i]['idNotification'];
                                                    echo base_url("notification/decline/$id");?>'">Decline</button>
                                        </div>
                                    <?php else: ?>
                                        <button class="btn btn-info"
                                                onclick="window.location.href='<?php $id = $notifications[$i]['idNotification'];
                                                echo base_url("notification/markDone/$id");?>'"><i class="fa fa-check"></i></button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
            <?= $pager->links('notif-group', 'my_pager') ?>
        </div>
    </section>
</main>

<script src="<?php echo base_url('assets/jquery/jquery.min.js')?>"></script>
