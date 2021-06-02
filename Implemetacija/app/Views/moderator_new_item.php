<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>

<style>
    #my-table td {
        padding: 20px;
    }
    #my-table td:last-child {
        padding: 10px;
    }
    #bute, #itemName, #quantity, #shops, #quant, #category, #additem {
        height: 50px;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    function changePrice(id) {
        newPrice = $("#" + id).val();
        console.log(id + " " + newPrice);
        window.location.href = "/moderator/changePrice/" + id + "/" + newPrice;
    }
</script>


<main id="main">
    <!-- ======= New Item Section ======= -->


    <section id="new-group">
        <div class="container">
            <div class="section-title">
                <h2>New item</h2>
            </div>
            <div>
                <table id="itemTable" class="table">

                    <tbody>

                    <form action="/moderator/" method="post">
                        <tr>
                            <td rowspan="6">
                                <img><!-- OLGAAAAA -->
                            </td>
                            <td>
                                <div class="form-group" >
                                    <input type="text" name="item-name" id="itemName" class="form-control" placeholder="Item name" >
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select type="text" name="Shops" id="shops" width="10" style="padding: 15px" class="form-control" placeholder="Item name">
                                    <?php foreach ($shops as $shop): ?>
                                        <option class="form-control" value="<?php echo $shop['idShopChain']; ?>"><?php echo $shop['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="item-name" id="quantity"  class="form-control" placeholder="Quantity" >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                    <select style="padding: 15px" class="form-control" id="quant" size='1'>
                                        <option selected>kom</option>
                                        <option>g</option>
                                        <option>kg</option>
                                        <option>ml</option>
                                        <option>l</option>
                                    </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select style="padding: 15px" class="form-control" id="category" size="1">
                                    <?php foreach($allCategories as $category){ ?>
                                        <option value="<?= $category['idCategory'] ?>"><?php echo $category['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type ="button" class="btn btn-success btn-block" id="additem" onclick="funkc()" value="Add new item" class="btn btn-success btn-block">
                            </td>
                        </tr>
                    </form>
                    </tbody>
                </table>
            </div>
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
        window.location = "addItem/" +
            document.getElementById("itemName").value + "/" +
            strMeasure + "/" +
            document.getElementById("quantity").value + "/" +
            category + "/" +
            strShop;
    }
</script>
