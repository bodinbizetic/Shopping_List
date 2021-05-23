<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>

<main id="main">
    <section>
        <div class="container">
            <div class="section-title">
                <h2>New Group</h2>
            </div>


            <form class="form-vertical" method="post" action="/group/newgroup">
               <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                        <label for="image">
                          <input type="file" name="image" id="image" style="display:none;"/ value="<?php echo set_value('image');?>">
                          <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" style="border-radius: 50%;"/>
                          <p style="text-align: center;">Browse image</p>
                        </label>
                      </div>
                  </div>

                  <div class="col-8">
                      <div class="row form-group">
                          <div class="col-12 input-group">
                              <div class="input-group-addon"><i class="fa fa-user"></i></div>
                              <input type="text" name="name" class="form-control" placeholder="Group Name" value="<?php echo set_value('name');?>">
                          </div>
                      </div>

                      <div class="row form-group">
                          <div class="col-12 input-group">
                              <div class="input-group-addon"><i class="fa fa-male"></i></div>
                              <input type="text" name="description" class="form-control" placeholder="Description" value="<?php echo set_value('description');?>">
                          </div>
                      </div>

                      <div class="row form-group">
                          <div class="col-11 input-group">
                            <input type="text" class="form-control" placeholder="Invite members" aria-label="Recipient's username"
                                 name="invite_member" value="<?php echo set_value('invite_members');?>">
                          </div>
                          <div class="col-1 input-group">
                              <button class="btn btn-success" type="button">Add</button>
                          </div>
                      </div>

                      <div class="row">
                          <table>
                              <tbody>

                              </tbody>
                          </table>
                      </div>

                      <div class="row form-group">
                          <div class="col-12 input-group">
                            <input type="submit" value="Create Group" class="btn btn-success btn-block">
                          </div>
                      </div>

                  </div>
               </div>
            </form>
        </div>
    </section>
</main>


