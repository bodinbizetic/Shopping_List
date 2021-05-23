<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Edit Group</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/icofont/icofont.min.css" rel="stylesheet">
  <link href="../assets/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="../assets/venobox/venobox.css" rel="stylesheet">

  <link href="../common.css" rel="stylesheet">
  <link href="editGroup.css" rel="stylesheet">

</head>

<body onload="onLoad()">

    <!-- ======= Top Bar ======= -->
    <div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
        <div class="container d-flex">
          <div class="contact-info mr-auto">
            <i class="icofont-envelope"></i> <a href="mailto:contact@example.com">contact@example.com</a>
            <i class="icofont-phone"></i> +1 5589 55488 55
          </div>
          <div class="social-links">
            <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
            <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
            <a href="#" class="linkedin"><i class="icofont-linkedin"></i></i></a>
          </div>
        </div>
      </div>
    
      <!-- ======= Header ======= -->
      <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">
    
          <h1 class="logo mr-auto"><a href="#">Jel ti usput?</a></h1>
          <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
    
          <nav class="nav-menu d-none d-lg-block">
            <ul>
              <li><a href="../home/home.html">Home</a></li>
              <li><a href="../lists/list.html">Shopping list</a></li>
              <li class="active"><a href="groups.php">Groups</a></li>
              <li><a href="../notifications/notification.html">Notifications</a></li>
              <li><a href="../profile/profile.html">Profile</a></li>
            </ul>
          </nav><!-- .nav-menu -->
          <a href="../login/login.html" class="get-started-btn scrollto">Logout</a>
        </div>
      </header><!-- End Header -->

  <section>
    <div>
    </div>
  </section><!-- End Hero -->

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
    <!-- ======= Edit Group Section ======= -->
    <section>
      <div class="container">

        <div class="row">
          <div class="col col-md">
                <div class="form-group">
                    <label for="image">
                        <input type="file" name="image" id="image" style="display:none;"/>
                        <img src="imgs/friendsLarge.jpg" style="border-radius: 50%;"/>
                        <p style="text-align: center;">Browse image</p>
                    </label>
                </div>
          </div>
          <div class="col col-md-9">
              <div class="form-group ">
                  <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-user"></i></div>
                      <input type="text" name="register_username" class="form-control" placeholder="Group Name", value="Porodica">
                  </div>
              </div>
              <div class="form-group ">
                  <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-male"></i></div>
                      <input type="text" name="register_fullname" class="form-control" placeholder="Description", value="Spisak za kucu">
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
                  
                </tbody>
              </table>
              <div>
                <p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Invite members" aria-label="Invite user" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-outline-success" type="button" data-toggle='modal' data-target='#membersModal'>Invite</button>
                    </div>
                </div>
              </p>
              </div>
              <input type="submit" value="Save changes" class="btn btn-success btn-block"> 
          </div>
</div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <h3>Jel ti usput?</h3>
      <div class="social-links">
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/jquery/jquery.min.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/venobox/venobox.min.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

    <!-- Script for table actions -->
    <script src="./editGroup.js" type="text/javascript"></script>

</body>

</html>