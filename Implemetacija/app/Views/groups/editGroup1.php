
  <link href="../common.css" rel="stylesheet">
  <link href="editGroup.css" rel="stylesheet">

   <!-- Modal -->
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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="leaveGroup()">Yes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal#2 -->
<div class="modal fade" id="membersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Invite sent</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        You sent someone invite to join your group. They will recive notification to join the group. You will get notification only if they accept.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">OK</button>
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

  <form class="form-vertical" method="post" action="/group/editGroup/<?php echo $groupId;?>">
      <div class="row">
          <div class="col-4">
              <div class="form-group">
                  <div class="form-group">
                      <label for="image">
                          <input type="file" name="image" id="image" style="display:none;"/>
                          <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle" style="border-radius: 50%"/>
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
                          if($myId==$member['idUser']) echo '(You)';?></td>
                        <td>
                            <input type="checkbox" name="<?php $id = $member['idUser']; echo 'admin_'.$id ?>"
                                   id="<?php $id = $member['idUser']; echo 'admin_'.$id ?>"
                                   <?php if($inGroup[$i++]['type']=='1') echo 'checked'; ?>
                                   onchange="window.location.href='<?php $id = $member['idUser'];
                                   if(isset($_POST['admin_'.$id])) $flag='false'; else $flag='true';
                                   echo base_url("/group/changeAdmin/$groupId/$id/$flag"); ?>'">
                        </td>
                        <td>
                            <button class="btn btn-outline-danger"
                                    onclick="window.location.href='<?php  $id = $member['idUser'];
                                    echo base_url("group/removeFromGroup/$groupId/$id");?>'">
                                <?php if($myId != $member['idUser']) echo 'Remove'; else echo 'Leave'; ?></button>
                        </td>

                    </tr>

                  <?php endforeach; ?>

                </tbody>
              </table>
              <div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Invite members" aria-label="Invite user" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-outline-success" type="button" data-toggle='modal' data-target='#membersModal'>Invite</button>
                    </div>
                </div>
              </div>
              <input type="submit" value="Save changes" class="btn btn-success btn-block"> 
          </div>
      </div>
  </form>
          </div>
      </section>
  </main>


