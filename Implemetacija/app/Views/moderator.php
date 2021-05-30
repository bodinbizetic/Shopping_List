<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>

<style>
    #my-table td {
        padding: 20px;
    }
    #my-table td:last-child {
        padding: 10px;
    }
    #newShop, #search, #shops {
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
        <form class="container">
            <div class="section-title">
                <h2>Edit items</h2>
            </div>
                <table id="itemTable" class="table">

                    <tbody>

                    <form action="/moderator/" method="post">
                    <tr>
                        <td>
                            <div class="form-group" >
                                <input type="text" name="item-name" id="search"  class="form-control" placeholder="Quick item search" >
                            </div>
                        </td>
                        <td>
                            <select type="text" name="Shops" id="shops" width="10" style="padding: 15px" class="form-control" placeholder="Select shop">
                                <?php foreach ($shops as $shop): ?>
                                    <option class="form-control" value="<?php echo $shop['idShopChain']; ?>"><?php echo $shop['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type ="submit" class="btn btn-success btn-block" id="newShop" value="Submit filters" class="btn btn-success btn-block">
                        </td>
                        <td>
                            <a class="btn btn-danger btn-block" style="height: 50px; padding-top: 12px;" href="/scrapper">Update database</a>
                        </td>
                    </tr>

                    </form>
                    </tbody>
                </table>


            <table class="table" id="my-table">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Shop</th>
                    <th>Price</th>
                    <th>New Price</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($items as $item): ?>

                    <tr>
                        <td><?php echo $item['itemName']; ?></td>
                        <td><?php echo $item['shopName']; ?></td>
                        <td><?php echo $item['price']; ?></td>
                        <td><input type="text" id="<?php echo $item['idItemPrice']; ?>"></td>
                        <td>
                            <a href="javascript:changePrice(<?php echo $item['idItemPrice']; ?>)" class="get-started-btn scrollto">Change price</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php if(isset($pager)): ?>
                <?= $pager->links('moderator', 'my_pager') ?>
            <?php endif; ?>

    </section><!-- End New Item Section -->

</main><!-- End #main -->
