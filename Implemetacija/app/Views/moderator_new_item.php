<!-- Autor - Andrej Gobeljic 0019/2018 -->
<!-- Stranica za pravljenje novog Item-a -->

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>

<style>
    #my-table td {
        padding: 20px;
    }
    #my-table td:last-child {
        padding: 10px;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    function changePrice(id) {
        newPrice = $("#" + id).val();
        console.log(id + " " + newPrice);
        window.location.href = "/moderator/changePrice/" + id + "/" + newPrice;
    }
    function showImage() {
        file_input = document.querySelector("input[type='file']");
        if (file_input.files && file_input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#group-img')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(file_input.files[0]);
        }
    }

</script>


<main id="main">
    <!-- ======= New Item Section ======= -->


    <section id="new-group">
        <div class="container">
            <div class="section-title">
                <h2>New item</h2>
            </div>
            <form class="form-vertical" method="post" action="/moderator/addItem" enctype="multipart/form-data">
                <div class="row">
                    <div class="col col-md-4">
                        <div class="form-group" style="text-align: center">
                            <label for="image">
                                <input type="file" name="image" id="image" style="display:none;" onchange="showImage()"/>
                                <img id="group-img" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle" style="border-radius: 50%; width: 80%;" >
                                <p>Browse image</p>
                            </label>
                        </div>
                    </div>
                    <div class="col col-md-8">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group ">
                                    <div class="input-group">
                                        <input type="text" id="itemName" name="item_name" class="form-control" placeholder="Item Name" value="" required="required">
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <select name="Shops" id="shops" style="margin-bottom: 15px" class="form-control" size='1'>
                                            <option class="form-control" selected disabled value="-1">Select a shop</option>
                                            <?php foreach ($shops as $shop): ?>
                                                <option class="form-control" value="<?php echo $shop['idShopChain']; ?>"><?php echo $shop['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="input-group">
                                        <input type="text" name="qty" id="quantity"  class="form-control" placeholder="Quantity" >
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <select style="margin-bottom: 15px" class="form-control" id="quant" size='1' name="measure">
                                            <option selected>kom</option>
                                            <option>g</option>
                                            <option>kg</option>
                                            <option>ml</option>
                                            <option>l</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <select style="margin-bottom: 15px" class="form-control" id="category" size="1" name="category">
                                            <?php foreach($allCategories as $category){ ?>
                                                <option value="<?= $category['idCategory'] ?>"><?php echo $category['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="Create Item" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>

        </div>

    </section><!-- End New Item Section -->

</main><!-- End #main -->

<script>
    function funkc()
    {
        var e = document.getElementById("quant");
        var strMeasure = e.options[e.selectedIndex].text;
        e = document.getElementById("shops");
        var strShop = e.options[e.selectedIndex].value;
        e = document.getElementById("category");
        var category = e.options[e.selectedIndex].value;
        var image_name = document.querySelector("input[type='file']");
        console.log(image_name);
        window.location = "addItem/" +
            document.getElementById("itemName").value + "/" +
            strMeasure + "/" +
            document.getElementById("quantity").value + "/" +
            category + "/" +
            strShop;
    }
</script>
