<!-- Tamara Avramovic 2018/0293 -->

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

<link href="<?php echo base_url(); ?>/css/editGroup.css" rel="stylesheet">
<link href="/public/css/common.css" rel="stylesheet">

   <!-- Modal#1 -->
 <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are you sure you want to remove this member?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        If you click Yes you will remove member from the group.
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="removeFromGroup()">Yes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal#2 -->
<div class="modal fade" id="membersModal" tabindex="-1" role="dialog" aria-labelledby="membersModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="membersModalCenterTitle">Do you want to send invite?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This will send someone invite to join your group. They will recive notification to join the group. You will get notification only if they accept.
          <br>
          This can't be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal" onclick="callNewMember()">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal#3 -->
<div class="modal fade" id="discardModal" tabindex="-1" role="dialog" aria-labelledby="discardModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="discardModalTitle">Do you want to disard changes?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                This will discard changes made on group name, description, image and admins.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal" onclick="back()">Yes</button>
            </div>
        </div>
    </div>
</div>

  <main id="main">
      <section>
          <div class="container">
              <div class="section-title">
                  <h2>Edit Group</h2>
              </div>

  <form class="form-vertical" method="post" action="/group/editGroup/<?=$groupId;?>" enctype="multipart/form-data">
      <div class="row">
          <div class="col col-md-4">
              <div class="form-group">
                  <div class="form-group" style="text-align: center">
                      <label for="image">
                          <input type="file" name="image" id="image" style="display:none;" onchange="showImage()"/>
                          <?php if(isset($image)): ?>
                              <img id="group-img" src="<?php echo base_url(). '/groupUploads/'. $image; ?>" class="avatar img-circle" style="border-radius: 50%">
                          <?php else: ?>
                              <img  id="group-img" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle" style="border-radius: 50%">
                          <?php endif; ?>
                          <p>Browse image</p>
                      </label>
                  </div>
              </div>
          </div>
          <div class="col col-md-8">
              <div class="form-group ">
                  <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-user"></i></div>
                      <input type="text" name="group_name" class="form-control" placeholder="Group Name" value="<?php echo $name;?>" required="required">
                  </div>
              </div>
              <div class="form-group ">
                  <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-male"></i></div>
                      <input type="text" name="description" class="form-control" placeholder="Description" value="<?php echo $description;?>">
                  </div>
              </div>
              <table class="table" id="my-table">
                <thead>
                  <tr>
                    <th class="tdName">Name</th>
                    <th class="tdPermission" >Group Admin</th>
                    <th class="tdActions" >Actions</th>
                  </tr>
                </thead>
                <tbody>
                <?php $i=0; foreach($members as $member): ?>
                    <tr>
                      <td><?php echo $member['username'];
                          if($myId==$member['idUser']) echo '&nbsp(You)';?></td>
                        <td>
                            <input type="checkbox" name="admin[]" value="<?php echo $member['idUser'];?>"
                                    <?php if($inGroup[$i]['type']=='1') {echo 'disabled';}?>
                                   <?php if($inGroup[$i]['type']=='1') {echo 'checked';} $i++?>>
                        </td>
                        <td><a href="#exampleModalCenter" class='btn btn-outline-danger' onclick=toModal(this,<?=$member['idUser']?>) role='button'
                               aria-pressed='true' data-toggle='modal' data-target='#exampleModalCenter'><?php if($myId != $member['idUser']) echo 'Remove'; else echo 'Leave'; ?></a>
                        </td>
                    </tr>

                  <?php endforeach; ?>

                </tbody>
              </table>
              <div>
                <div class="input-group mb-3">
                    <input type="text" id='invite_member' name = "invite_member" class="form-control" placeholder="Invite members" aria-label="Invite user" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <a href="#membersModal" class='btn btn-outline-success' role='button'
                           aria-pressed='true' data-toggle='modal' data-target='#membersModal'>Invite</a>
                    </div>
                </div>
              </div>
              <?php if(isset($errors)) { ?>
                  <div class="alert <?php if($errors[1]==0) echo 'alert-danger'; else echo 'alert-success';?> alert-dismissible" role="alert">
                      <?php
                          echo $errors[0]. "<br>";
                      ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                  </div>
              <?php } ?>
              <br>
              <input type="submit" value="Save changes" class="btn btn-success btn-block">
              <a href="#discardModal" class='btn btn-outline-info' role='button'
                 aria-pressed='true' data-toggle='modal' data-target='#discardModal' style="width: 100%; margin-top: 10px">Back</a>
          </div>
      </div>
  </form>
          </div>
      </section>
  </main>

<script>
    let link;

    function callNewMember(){
        let username = document.getElementById('invite_member').value;
        window.location.href = "/group/addNewMember/" + <?= $groupId ?> + "/" + username;
    }

    function toModal(val, id)
    {
        link = id;
    }

    function removeFromGroup() {
        window.location.href = "/group/removeFromGroup/"+<?= $groupId ?>+"/"+link;
    }

    function back(){
        window.location.href = '/group/index';
    }
</script>
