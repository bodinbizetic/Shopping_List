<script>
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
    <section>
        <div class="container">
            <div class="section-title">
                <h2>New Group</h2>
            </div>


            <form class="form-vertical" method="post" action="/group/newGroup" enctype="multipart/form-data">
                <div class="row">
                    <div class="col col-md-4">
                        <div class="form-group" style="text-align: center">
                            <label for="image">
                                <input type="file" name="image" id="image" style="display:none;" onchange="showImage()"/>
                                <img id="group-img" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle" style="border-radius: 50%" >
                                <p>Browse image</p>
                            </label>
                        </div>
                    </div>
                    <div class="col col-md-8">
                        <div class="row">
                            <div class="col-12">
                        <div class="form-group ">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                <input type="text" name="group_name" class="form-control" placeholder="Group Name" value="<?php echo set_value('group_name'); ?>" required="required">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-male"></i></div>
                                <input type="text" name="description" class="form-control" placeholder="Description" value="<?php echo set_value('description'); ?>">
                            </div>
                        </div>

                        <div>
                            <div class="input-group mb-3">
                                <input type="text" id='member' class="form-control" placeholder="Invite members" aria-label="Invite user" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="button" onclick="addMember()">Add</button>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <table class="table" id="membersToCall" style="width:100%;"></table>
                            </div>
                        </div>
                        <input type="submit" value="Create Group" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>



<script>
    function addMember(){
        let username=document.getElementById('member').value;
        let row = $("<tr></tr>");
        let btn = $('<button class="btn btn-outline-danger dismissMember" name="dismissMember" value="Dismiss">Dismiss</button>');
        let col = $("<td></td>").append($("<input type='text' name='members[]'  value="+username+">"));
        let col2 = $("<td style='text-align: right'></td>").append(btn);
        row.append($(col).attr('name',username));
        row.append(col2);
        $("#membersToCall").append(row);
    }

    $("#membersToCall").on('click', '.dismissMember', function () {
        $(this).closest('tr').remove();
    });

</script>

<style>
    #membersToCall td {
        padding: 10px;
    }

    tr:hover {
        background-color: #defce9;
        color: #000000;
    }
</style>