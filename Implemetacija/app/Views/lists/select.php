<link href="<?php echo base_url(); ?>/css/list/list.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>/css/common.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>/css/list/select.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>
<script>
    function search() {
        val = $("input[type='text']").val();
        href = window.location.href.split("?")[0];
        window.location.href = href + "?search=" + val + "&sorted=" + $('#sorted').val();
    }
</script>

<main id="main">
    <!-- ======= New Item Section ======= -->
    <section id="new-group">

        <div class="container">
            <div class="section-title">
                <h2><?php echo $categoryName ?></h2>
            </div>
            <div class="row">
                <div class="col col-sm-6 offset-3">
                    <div class="form-group form-row">
                        <div class="input-group col-6">
                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                            <input type="text" name="search" class="form-control" placeholder="Search..." onchange="search()">
                            <div class="input-group-addon"></div>
                        </div>
                        <div class="input-group offset-2 col-4">
                            <div class="input-group-addon">Sorted</div>
                            <select name="sorted" id="sorted"  style="margin-bottom: 0px !important; " class="form-control h-100" onchange="search()">
                                <option class="form-control" value="0" selected>None</option>
                                <option class="form-control" value="1">Ascending</option>
                                <option class="form-control" value="2">Descending</option>
                            </select>
                            <div class="input-group-addon"></div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <ul class="product-list">
                <?php foreach ($cenotekaItems as $cenotekaItem){ ?>
                <li class="item">
                    <div class="component">
                        <div class="product-layout">
                            <div class="product-img">
                                <div>
                                    <img src="<?= base_url().'/uploads/items/'.$cenotekaItem['image'] ?>">
                                </div>
                            </div>
                            <div class="content-layout">
                                <div class="title">
                                    <header class="header">
                                        <div class="description2">
                                            <p class="p2"><?= $cenotekaItem['name'] ?></p>
                                        </div>
                                    </header>
                                </div>
                                <div class="add-price">
                                    <div class="price">
                                        <div class="quant">
                                            <!--<div class="property">
                                                <input type="number" min = 0 name="register_fullname" class="form-control" placeholder="Quantity" >
                                            </div>-->
                                            <div class="property" style="text-align: center">
                                                <span class="super-bold"><?php if($cenotekaItem['price'] == 0){echo "N/A";}else{echo $cenotekaItem['price']." RSD";} ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add">
                                        <div class="my-btn">
                                            <a class="btn btn-success btn-block" href="<?php if($idListContains == null) echo '/lists/addCenotekaItem/'.$listId.'/'.$cenotekaItem['idItem'];
                                                else echo '/lists/changeCenotekaItem/'.$listId.'/'.$cenotekaItem['idItem'].'/'.$idListContains; ?>
                                                ">
                                                <?php
                                                if($idListContains == null)
                                                        echo "Add Item";
                                                    else
                                                        echo "Change Item";
                                                ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>

            <?php if(isset($pager)): ?>
                <?= $pager->links('items', 'my_pager') ?>
            <?php endif; ?>
        </div>
    </section>
</main>
<script src="<?php echo base_url('assets/jquery/jquery.min.js')?>"></script>