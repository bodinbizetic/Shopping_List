<section>
   <div class="container">
       <div class="section-title">
           <h2><?=$listName?></h2>
       </div>

       <table class="table">
           <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity/Measure</th>
                    <th>Estimated price</th>
                </tr>
           </thead>
           <tbody>
                <?php foreach ($items as $item) { ?>
                    <tr <?php if ($item[2]) echo 'class="strikeout item-row"'; else echo 'class="item-row"' ?> <?= 'contains="'.$item[3].'"'?>>
                        <td>
                            <input type="checkbox" <?php if ($item[2]) echo 'checked'?>>
                            <?= $item[0] ?>
                        </td>
                        <td><?= $item[1] ?></td>
                        <td>0</td>
                    </tr>
                <?php } ?>
           </tbody>
       </table>
       <div class="w-100 text-center">
           <a href="" type="button" class="btn btn-outline-danger">Finish</a>
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
</style>

<script>
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

    $(document).ready(function()
    {
        $(".item-row").click(strikeoutUpdate)
        $("input[type='checkbox']").click(strikeoutUpdate)
    });
</script>