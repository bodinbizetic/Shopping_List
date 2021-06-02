<link href="<?php echo base_url(); ?>/css/list/list.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>/css/common.css" rel="stylesheet">

<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<div class="modal fade" id="createLink" tabindex="-1" role="dialog" aria-labelledby="createLinkTittle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLinkLongTitle">Create Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="modal-form">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <span class="input-group-prepend"><i class="input-group-text fa fa-link"></i></span>
                            <input type="text" class="form-control bg-light" name="link" id="createLink-link" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <span><b>Permissions</b></span>
                            <ul style="list-style-type: none;">
                                <li><input type="radio" name="perm" value="0" checked>Readonly</li>
                                <li><input type="radio" name="perm" value="1">Edit</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" data-dismiss="modal" value="OK" onclick="submitModal();">
                    <input type="reset" class="btn btn-secondary" data-dismiss="modal">
                </div>
            </form>
        </div>
    </div>
</div>

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
                                <div class='collapse <?php if(isset($activeGroup) && ($activeGroup == $groupId)) echo 'show';?>'  id="group-row<?=$groupId?>">
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
<!--                                                        <a href="/lists/renderList/--><?//=$listId?><!--" class="btn btn-outline-primary propagate" role="button" aria-pressed="true">Edit</a>-->
                                                        <button class="btn btn-outline-success link-button" role="button" aria-pressed="true" create-link="<?= base_url().'/guest/guest/'.uniqid($listId); ?>" listid="<?=$listId ?>">Create Link</button>
                                                        <a href="/lists/deleteList/<?=$listId?>" class="btn btn-outline-danger propagate" role="button" aria-pressed="true">Delete</a>
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

    $(document).ready(function () {
        $('.link-button').each(function(index) {
            $(this).get(0).addEventListener('click', function (ev) {
                $('#modal-form').attr('action', '/lists/createLink/' + $(this).attr('listid'));
                $('#createLink-link').attr('value', $(this).attr('create-link'));
                $('#createLink').modal('toggle');
                ev.stopPropagation();
            });
        });

    })

    function submitModal() {
        $.ajax({
            type: "POST",
            url: $('#modal-form').attr('action'),
            data: {
                link: $('#createLink-link').val(),
                perm: $('input[name="perm"]:checked').val(),
            }
        }).done(function() {
            location.reload();
        });
    }
</script>
<script src="<?php echo base_url('assets/jquery/jquery.min.js')?>"></script>
