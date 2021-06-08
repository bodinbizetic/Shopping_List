<!-- Autor - Bodin Bizetic 0058/2018, Andrej Gobeljic 0019/2018 -->
<!-- Stranica za doradjivanje spiska i kupovinu -->

<div class="modal fade" id="finishList" tabindex="-1" role="dialog" aria-labelledby="finishListTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finishListLongTitle">Are you finished shopping?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                If you click Delete the list would be removed permanently. You can chose to Move to new list with non bought items.
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" data-dismiss="modal" onclick="window.location = '/lists/finish/<?=$listId?>/yes'">Move</button>
                <button class="btn btn-primary" data-dismiss="modal" onclick="window.location = '/lists/finish/<?=$listId?>/no'">Delete</button>
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Are you sure you want to remove item?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                If you click Yes item would be removed permanently
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="delItem()">Yes</button>
            </div>
        </div>
    </div>
</div>

<section>
   <div class="container">
       <div class="section-title">
           <h2><?=$listName?></h2>
           <h3><?= $shop?></h3>
       </div>
       <?php if ($writable) { ?>
       <div class="row">
           <div class="col col-md-8">
               <div class="form-group">
                   <div class="input-group">
                       <span class="input-group-prepend"><i class="input-group-text">Select a shop</i></span>
                       <select type="text" name="Shops" id="shops" width="10" class="form-control" placeholder="Shop">
                           <option class="form-control" value="" selected disabled>New shop</option>
                           <?php foreach($shops as $shopSelect){?>
                               <option class="form-control" value="<?= $shopSelect['idShopChain']?>"><?php echo($shopSelect['name'])?></option>
                           <?php }?>
                       </select>
                   </div>
               </div>
           </div>
           <div class="col col-md-2">
               <a href="/lists/addItemRender/<?=$id?>" type="button" class="btn btn-primary shop-btn">Add New Item</a>
           </div>
       </div>
       <?php } ?>
       <table class="table">
           <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity/Measure</th>
                    <th>Estimated price</th>
                    <th>Actions</th>
                </tr>
           </thead>
           <tbody>
                <?php foreach ($items as $item) { ?>
                    <tr <?php if ($item[2]) echo 'class="strikeout item-row"'; else echo 'class="item-row"' ?> <?= 'contains="'.$item[3].'"'?> disabled="">
                        <td class="padding-td-center">
                            <input type="checkbox" <?php if ($item[2]) echo 'checked'?> <?php if(!$writable) echo 'disabled'?>>
                            <?= $item[0] ?>
                        </td>
                        <td class="padding-td-center"><?= $item[1] ?></td>
                        <td class="padding-td-center"><?= $item[4]?></td>
                        <td class="actions">
                            <div class='btn-group btn-group' role='group' id="button-group">
                                <a href='/lists/editItem/<?=$item[3]?>/<?=$id?>' class='btn btn-outline-primary' role='button' aria-pressed='true'>Edit</a>
                                <a href='#' class='btn btn-outline-danger' onclick='toModal(this, "/lists/deleteItem/<?=$item[3]?>/<?=$listId?>")' content="/lists/deleteItem/<?=$item[3]?>/<?=$listId?>" data-toggle='modal' data-target='#exampleModalCenter'>Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
           </tbody>
       </table>
       <div class="w-100 text-center">
           <a href="" type="button" class="btn btn-outline-danger <?php if(!$writable) echo 'disabled'?>" data-toggle="modal" data-target="#finishList" >Finish</a>
       </div>
   </div>
</section>

<style>
    tr.item-row:hover {
        background-color: #defce9;
        color: #000000;
    }

    tr.strikeout td:before {
        content: " ";
        position: absolute;
        top: 50%;
        left: 0;
        border-bottom: 2px solid #111;
        width: 100%;
    }

    td { position: relative; }

    .padding-td-center {
        padding-top: 18px !important;
    }
</style>

<script>
    var writable = <?= $writable ?>;

    function strikeoutUpdate()
    {
        let idContains = $(this).attr('contains');
        var xhttp = new XMLHttpRequest();
        let checkbox = $('input[type="checkbox"]', $(this));
        if ($(this).hasClass('strikeout'))
        {
            xhttp.open("GET", '/lists/bought/' + idContains + '/null')
            $(this).removeClass('strikeout');
            checkbox.prop('checked', false);
        }
        else
        {
            xhttp.open("GET", '/lists/bought/' + idContains + '/notnull')
            $(this).addClass('strikeout');
            checkbox.prop('checked', true);
        }

        xhttp.send();

    }

    function onCheckboxClick()
    {
        let row = $(this).parent('tr');
        let idContains = row.attr('contains');
        var xhttp = new XMLHttpRequest();
        if ($(this).hasClass('strikeout'))
        {
            xhttp.open("GET", '/lists/bought/' + idContains + '/null')
            row.removeClass('strikeout');
            $(this).prop('checked', false);
        }
        else
        {
            xhttp.open("GET", '/lists/bought/' + idContains + '/notnull')
            row.addClass('strikeout');
            $(this).prop('checked', true);
        }

        xhttp.send();
    }

    function toModal(val, id)
    {
        //setRowIndex(val);
        link = id;
        $('#exampleModalCenter').modal('toggle');
    }

    function delItem()
    {
        window.location = link;
    }

    $(document).ready(function()
    {
        if (writable == 1) {
            $(".item-row").click(strikeoutUpdate);
            $(".actions").click(function (event) {event.stopPropagation();});
            $("input[type='checkbox']").click(strikeoutUpdate);
            document.getElementById("shops").onchange = function() {
                console.log("changed");
                window.location = "/lists/changeShop/<?= $id ?>/" + this.value;
            }
        }
    });
</script>