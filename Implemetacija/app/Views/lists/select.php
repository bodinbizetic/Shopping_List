<link href="<?php echo base_url(); ?>/css/list/list.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>/css/common.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>/css/list/select.css" rel="stylesheet">
<main id="main">
    <!-- ======= New Item Section ======= -->
    <section id="new-group">

        <div class="container">
            <div class="section-title">
                <h2><?php echo $categoryName; ?></h2>
            </div>

            <ul class="product-list">
                <?php foreach ($cenotekaItems as $cenotekaItem){ ?>
                <li class="item">
                    <div class="component">
                        <div class="product-layout">
                            <div class="product-img">
                                <div>
                                    <img src="<?= base_url().'/uploads/items/'.$cenotekaItem[1]['image'] ?>">
                                </div>
                            </div>
                            <div class="content-layout">
                                <div class="title">
                                    <header class="header">
                                        <div class="description2">
                                            <p class="p2"><?= $cenotekaItem[1]['name'] ?></p>
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
                                                <span class="super-bold"><?php echo $cenotekaItem[2]; ?> RSD</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add">
                                        <div class="my-btn">
                                            <a class="btn btn-primary btn-block" href="<?php if($idListContains == null) echo '/lists/addCenotekaItem/'.$listId.'/'.$cenotekaItem[1]['idItem'];
                                                else echo '/lists/changeCenotekaItem/'.$listId.'/'.$cenotekaItem[1]['idItem'].'/'.$idListContains; ?>
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

                <!--<li class="item">
                    <div class="component">
                        <div class="product-layout">
                            <div class="product-img">
                                <div>
                                    <img src="imgs/coca-cola0.5l.jpg">
                                </div>
                            </div>
                            <div class="content-layout">
                                <div class="title">
                                    <header class="header">
                                        <div class="description1">
                                            <p class="p1">Coca cola</p>
                                        </div>
                                        <div class="description2">
                                            <p class="p2">Coca cola 1l PET</p>
                                        </div>
                                    </header>
                                </div>
                                <div class="add-price">
                                    <div class="price">
                                        <div class="quant">
                                            <div class="property">
                                                <input type="number" min = 0 name="register_fullname" class="form-control" placeholder="Quantity" >
                                            </div>
                                            <div class="property">
                                                <span class="super-bold">75,00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add">
                                        <div class="my-btn">
                                            <button class="btn btn-primary btn-block">Add Item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="item">
                    <div class="component">
                        <div class="product-layout">
                            <div class="product-img">
                                <div>
                                    <img src="imgs/fruvita1l.jpg">
                                </div>
                            </div>
                            <div class="content-layout">
                                <div class="title">
                                    <header class="header">
                                        <div class="description1">
                                            <p class="p1">Fruvita</p>
                                        </div>
                                        <div class="description2">
                                            <p class="p2">Sok narandza Premium Fruvita 0.75l</p>
                                        </div>
                                    </header>
                                </div>
                                <div class="add-price">
                                    <div class="price">
                                        <div class="quant">
                                            <div class="property">
                                                <input type="number" min = 0 name="register_fullname" class="form-control" placeholder="Quantity" >
                                            </div>
                                            <div class="property">
                                                <span class="super-bold">144,99</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add">
                                        <div class="my-btn">
                                            <button class="btn btn-primary btn-block">Add Item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>


                <li class="item">
                    <div class="component">
                        <div class="product-layout">
                            <div class="product-img">
                                <div>
                                    <img src="imgs/nectarlifejabuka.jpg">
                                </div>
                            </div>
                            <div class="content-layout">
                                <div class="title">
                                    <header class="header">
                                        <div class="description1">
                                            <p class="p1">Nectar Life</p>
                                        </div>
                                        <div class="description2">
                                            <p class="p2">Sok jabuka 100% Nectar Life 1l</p>
                                        </div>
                                    </header>
                                </div>
                                <div class="add-price">
                                    <div class="price">
                                        <div class="quant">
                                            <div class="property">
                                                <input type="number" min = 0 name="register_fullname" class="form-control" placeholder="Quantity" >
                                            </div>
                                            <div class="property">
                                                <span class="super-bold">99,99</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add">
                                        <div class="my-btn">
                                            <button class="btn btn-primary btn-block">Add Item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                -->
            </ul>
        </div>
    </section>
</main>
<script src="<?php echo base_url('assets/jquery/jquery.min.js')?>"></script>