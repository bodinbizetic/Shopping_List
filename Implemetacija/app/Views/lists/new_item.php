<!-- Autor - Andrej Gobeljic 0019/2018 -->
<!-- Stranica za dodavanje novog Item-a u spisak -->

<link href="<?php echo base_url(); ?>/css/list/list.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>/css/common.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>/css/list/editItem.css" rel="stylesheet">

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Invite sent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                You sent someone invite to join your group. They will recive an email with link to join the group. You will get notification only if they accept.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<main id="main">
    <!-- ======= New Item Section ======= -->
    <section id="new-group">
        <div class="container">
            <div class="section-title">
                <h2>New Item</h2>
            </div>
            <table id="itemTable" class="table">

                <tbody>

                <!-- Row0 -->
                <tr>
                    <td>
                        <div class="form-group" >
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-male"></i></div>
                                <input id="namevar" type="text" id="itemInput" name="register_fullname" class="form-control" placeholder="Custom item" value="">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="searchQuant" class="form-group" >
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-male"></i></div>
                                <input id="quantityvar" type="number" min = 0 name="register_fullname" class="form-control" placeholder="Quantity/Measurement" value="">
                                <select class="form-control" id="quant" size='1'>
                                    <option selected>kom</option>
                                    <option>g</option>
                                    <option>kg</option>
                                    <option>ml</option>
                                    <option>l</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type ="button" class="btn btn-success btn-block" onclick="edit()" value="New Item" class="btn btn-success btn-block">

                    </td>
                </tr>
                </tbody>
            </table>

            <!-- My -->
            <div class="Menu">

                <div class="row header-category">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-6 title"><h3>Categories</h3></div>
                    <div class="col col-md-3"></div>
                </div>

                <div class="items">
                    <?php foreach($categories as $category){?>
                        <div class="item" style="text-align: center">
                            <a class="item-link" href="/lists/renderCategory/<?= $idList ?>/<?= $category['idCategory'] ?>">
                                <div class="item-img">
                                    <img src="<?php echo $category['image'] ?>">
                                </div>
                                <div class="item-title">
                                    <?php echo $category['name'] ?>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                    <!--<div class="item">
                        <a class="item-link" href="../online/pice.html">
                            <div class="item-img">
                                <img src="imgs/pice.jpg">
                            </div>
                            <div class="item-title">
                                Pice, kafa i caj
                            </div>
                        </a>
                    </div>

                    <div class="item">
                        <a class="item-link" href="#">
                            <div class="item-img">
                                <img src="imgs/mlecni_proizvodi.jpg">
                            </div>
                            <div class="item-title">
                                Mlecni proizvodi i jaja
                            </div>
                        </a>
                    </div>

                    <div class="item">
                        <a class="item-link" href="#">
                            <div class="item-img">
                                <img src="imgs/voce_povrce.jpg">
                            </div>
                            <div class="item-title">
                                Voce i porvce
                            </div>
                        </a>
                    </div>

                    <div class="item">
                        <a class="item-link" href="#">
                            <div class="item-img">
                                <img src="imgs/meso.jpg">
                            </div>
                            <div class="item-title">
                                Meso, mesne i riblje preradjevine
                            </div>
                        </a>
                    </div>

                    <div class="item">
                        <a class="item-link" href="#">
                            <div class="item-img">
                                <img src="imgs/pekara.jpg">
                            </div>
                            <div class="item-title">
                                Pekara
                            </div>
                        </a>
                    </div>

                    <div class="item">
                        <a class="item-link" href="#">
                            <div class="item-img">
                                <img src="imgs/za_kucu.jpg">
                            </div>
                            <div class="item-title">
                                Sve za kucu
                            </div>
                        </a>
                    </div>

                    <div class="item">
                        <a class="item-link" href="#">
                            <div class="item-img">
                                <img src="imgs/kozmetika.jpg">
                            </div>
                            <div class="item-title">
                                Licna higijena i kozmetika
                            </div>
                        </a>
                    </div>-->

                </div>




            </div>

        </div>
    </section><!-- End New Item Section -->

</main><!-- End #main -->

<script src="<?php echo base_url('assets/jquery/jquery.min.js')?>"></script>
<script>
    function edit(){
        var ename = document.getElementById("namevar");
        var strName = ename.value;
        var equantity = document.getElementById("quantityvar");
        var strQuantity = equantity.value;
        var e = document.getElementById("quant");
        var strMeasure = e.options[e.selectedIndex].text;
        if(e.value == 0)
            strMeasure = ""
        if((strName != "") && (strQuantity!=""))
            window.location = "/lists/addItem/"+strName+"/"+strQuantity+"/"+strMeasure+"/<?=$idList?>";
        else
            alert("Missing information");
    }
</script>