<!--<link href="--><?php //echo base_url(); ?><!--/css/list/list.css" rel="stylesheet">-->
<!--<link href="--><?php //echo base_url(); ?><!--/css/common.css" rel="stylesheet">-->
<!--<!-- Modal 1-->-->
<!--<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">-->
<!--    <div class="modal-dialog modal-dialog-centered" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title" id="exampleModalLongTitle">Are you sure you want to remove item?</h5>-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                    <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                If you click Yes item would be removed permanently-->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>-->
<!--                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="delItem()">Yes</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<!-- Modal 2-->-->
<!--<div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">-->
<!--    <div class="modal-dialog modal-dialog-centered" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title" id="exampleModalLongTitle">Do you want to make new list?</h5>-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                    <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                You have unbought items. If you click Yes new list will be made, and this items will be automatically added.-->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>-->
<!--                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location = '/lists/shopping/--><?//=$listId?>//'" >Yes</button>
//            </div>
//        </div>
//    </div>
//</div>
//
//
//<main id="main">
//    <!-- ======= Group Section ======= -->
//
//
//    <section id="groups">
//        <div class="container">
//
//            <div class="section-title">
//                <h2>Edit list</h2>
//                <h3><?//= $shop?><!--</h3>-->
<!--            </div>-->
<!---->
<!--            <div class="row">-->
<!--                <div class="col col-md-8">-->
<!--                    <div class="form-group">-->
<!--                        <div class="input-group">-->
<!--                            <span class="input-group-prepend"><i class="input-group-text">Select a shop</i></span>-->
<!--                            <select type="text" name="Shops" id="shops" width="10" class="form-control" placeholder="Shop">-->
<!--                                <option class="form-control" value="" selected disabled>New shop</option>-->
<!--                                --><?php //foreach($shops as $shopSelect){?>
<!--                                <option class="form-control" value="--><?//= $shopSelect['idShopChain']?><!--">--><?php //echo($shopSelect['name'])?><!--</option>-->
<!--                                --><?php //}?>
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col col-md-2">-->
<!--                    <a href="/lists/addItemRender/--><?//=$listId?><!--" type="button" class="btn btn-primary shop-btn">Add New Item</a>-->
<!--                </div>-->
<!--                <div class="col col-md-2">-->
<!--                    <input type="button" class="btn btn-success shop-btn" data-toggle='modal' data-target='#finishModal' value="Finish"></input>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <table class="table" id="my-table">-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th class="tdImage">Name</th>-->
<!--                    <th class="tdName">Quantity/Measure</th>-->
<!--                    <th class="tdActions">Actions</th>-->
<!--                    <th class="tdName">Price</th>-->
<!--                    <!--<th class="tdImage">Check</th>-->-->
<!--                </tr>-->
<!--                --><?php //foreach ($items as $item){?>
<!--                <tr>-->
<!--                    <td>-->
<!--                        --><?//= $item[0] ?>
<!--                    </td>-->
<!--                    <td>-->
<!--                        --><?//= $item[1] ?>
<!--                    </td>-->
<!--                    <td>-->
<!--                        <div class='btn-group btn-group' role='group'>-->
<!--                            <a href='/lists/editItem/--><?//=$item[5]?><!--/--><?//=$id?><!--' class='btn btn-outline-primary' role='button' aria-pressed='true'>Edit</a>-->
<!--                            <a href='#' class='btn btn-outline-danger' onclick='toModal(this, "/lists/deleteItem/--><?//=$item[5]?>///<?//=$listId?>//")' role='button' aria-pressed='true' data-toggle='modal' data-target='#exampleModalCenter'>Delete</a>
//                        </div>
//                    </td>
//                    <td>
//                        <?//= $item[4] ?>
<!--                    </td>-->
<!--                    <!--<td>-->
<!--                        <div><input type=checkbox></input></div>-->
<!--                    </td>-->-->
<!--                </tr>-->
<!--                --><?php //}?>
<!--                </thead>-->
<!--                <tbody>-->
<!--                </tbody>-->
<!--            </table>-->
<!---->
<!---->
<!---->
<!--        </div>-->
<!--    </section> <!-- End Group section-->-->
<!--</main><!-- End #main -->-->
<!---->
<!---->
<!--<script>-->
<!--    var link;-->
<!--    $('.row-clickable').click(function ()-->
<!--    {-->
<!--        window.location = $(this).data('href');-->
<!--    });-->
<!---->
<!--    function toModal(val, id)-->
<!--    {-->
<!--        //setRowIndex(val);-->
<!--        link = id;-->
<!--    }-->
<!---->
<!--    function delItem()-->
<!--    {-->
<!--        window.location = link;-->
<!--    }-->
<!---->
<!--    document.getElementById("shops").onchange = function(){-->
<!--        window.location = "/lists/changeShop/--><?//=$id?>///" + this.value;
//    }
//</script>
//<script src="<?php //echo base_url('assets/jquery/jquery.min.js')?><!--"></script>-->
