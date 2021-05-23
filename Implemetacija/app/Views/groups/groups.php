<
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>

<link href="<?php echo base_url(); ?>/css/groups.css" rel="stylesheet">


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Are you sure you want to leave?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                If you click Yes you will be removed and someone from the group will have to call you back in.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                        onclick="window.location.href='<?php echo base_url("group/leaveGroup");?>'">Yes</button>
            </div>
        </div>
    </div>
</div>

  <main id="main">

    <section id="groups">

      <div class="container">

        <div class="section-title">
          <h2>Groups</h2>
        </div>

          <a href="<?php echo base_url('group/renderNewGroup')?>" class="btn btn-success">Create new</a>

        <table class="table" id="my-table">
          <thead>
            <tr>
              <th class="tdImage">Image</th>
              <th class="tdName">Group Name</th>
              <th class="tdActions">Actions</th>
            </tr>
          </thead>
          <tbody>

          <?php for ($i = 0; $i < count($groups); $i++): ?>

              <tr>
                  <td>
                      <?php
                      if(isset($groups[$i]['image']))
                          echo'<img height="50" width="50" src="data:image;base64,'.base64_encode( $groups[$i]['image'] ).'">';
                      ?>
                  </td>
                  <td><?php echo $groups[$i]['name']; ?></td>
                  <td>
                      <div class="btn-group">
                          <button class="btn-outline-info" onclick="window.location.href='<?php echo base_url("group/viewGroup");?>'">Info</button>
                          <button class="btn-outline-success" onclick="window.location.href='<?php echo base_url("homepage/lists");?>'">Lists</button>
                          <button class="btn-outline-primary" onclick="window.location.href='<?php echo base_url("group/editGroup");?>'">Edit</button>
                          <button class="btn-outline-danger" data-toggle='modal' data-target='#exampleModalCenter' >Leave</button>
                      </div>
                  </td>

              </tr>
          <?php endfor; ?>

          </tbody>
        </table>

      </div>
    </section> <!-- End Group section-->
  </main><!-- End #main -->

</body>

<script src="<?php echo base_url('assets/jquery/jquery.min.js')?>"></script>