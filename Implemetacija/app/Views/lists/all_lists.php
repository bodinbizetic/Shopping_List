<link href="<?php echo base_url(); ?>/css/list/list.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>/css/common.css" rel="stylesheet">
<main id="main">
    <section>
        <div class="container">
            <div class="section-title">
                <h2>Shopping Lists</h2>
            </div>
        </div>
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="3" class="group-header">Groups:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userGroups as $groupId => $lists) { ?>
                        <tr data-toggle="collapse" data-target="#group-row<?=$groupId?>" class="group-info">
                            <td>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16" style="margin-right: 10px;">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                            </td>
                            <td class="group-name"><?= $groupNames[$groupId]?></td>
                            <td><a href="/lists/renderCreate/<?=$groupId?>" type="button" class="btn btn-success newButton">Create new</a></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="collapse" id="group-row<?=$groupId?>">
                                    <table class="table">
                                        <tbody class="hoverable-row" id="">
                                            <?php foreach ($lists as $listId => $listName) { ?>
                                            <tr class="row-clickable" data-href="/lists/shopping/<?=$listId?>">

                                                <td>
                                                    <img src="<?= base_url() ?>/images/lists/shopping-list.png" style="border-radius: 50%;" class="avatar img-circle">
                                                </td>
                                                <td><?= $listName ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="/lists/renderList/<?=$listId?>" class="btn btn-outline-primary" role="button" aria-pressed="true">Edit</a>
                                                        <a href="/lists/createLink/<?=$listId?>" class="btn btn-outline-success" role="button" aria-pressed="true">Create Link</a>
                                                        <a href="/lists/deleteList/<?=$listId?>" class="btn btn-outline-danger" role="button" aria-pressed="true">Delete</a>
                                                    <!-- TODO: implementiraj -->
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </section>
</main>


<script>
    $('.row-clickable').click(function ()
    {
        window.location = $(this).data('href');
    });
</script>
<script src="<?php echo base_url('assets/jquery/jquery.min.js')?>"></script>
