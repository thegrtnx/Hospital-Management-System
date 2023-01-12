<?php include("components/head.php") ?>
  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <?php include("components/aside.php") ?>

        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <?php include("components/nav.php") ?>


          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">


            <?php 
            if(patientbookings()) {
            
            ?>

             <!-- Basic Bootstrap Table -->
             <div class="card mb-5">
                <h5 class="card-header">Your Appointment</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table mb-3">
                    <thead>
                      <tr>
                        <th>Appointment ID</th>
                        <th>Date Booked</th>
                        <th>Reason for <br/> appointment</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Doctor Assigned</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        
                        $email = $_SESSION['login'];

                        $sql = "SELECT * FROM book WHERE `email` = '$email' ORDER BY `id` Desc";
                        $res = query($sql);

                        while($row = mysqli_fetch_array($res)) {
                        ?>
                    
                      <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $row['bkid'] ?></strong></td>
                        <td><?php echo date('l, F d, Y', strtotime($row['date'])); ?></td>
                        <td><?php echo $row['msg'] ?></td>
                        <td><span class="badge bg-label-primary me-1"><?php echo $row['status'] ?></span></td>
                        <td><?php echo $row['category'] ?></td>
                        <td><?php echo $row['doctor_assigned'] ?></td>
                      </tr>

                      <?php
                        }
                      ?>
                     
                    </tbody>
                  </table>
                </div>
             </div>
              <!--/ Basic Bootstrap Table -->

              <?php 
              
                    } else {

                    }
                ?>
             
              <!-- Basic Layout -->
              <div class="row">
                <div class="col-xl-12">
                    
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-header">Book an Appointment with a Doctor</h5>

                    </div>
                    <div class="card-body">
                      <form>
 
                        <div class="mb-3">
                          <label class="form-label" for="basic-default-phone">Pick an appointment date</label>
                          <input
                            type="date"
                            id="aptdte"
                            class="form-control"
                          />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-default-message">What's your appointment for?</label>
                          <textarea
                            id="bkmsg"
                            class="form-control"
                            placeholder="Hi, Do you have a moment to talk Joe?"
                          ></textarea>
                        </div>
                        <button type="button" id="bkdoc" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <?php include("components/footer.php") ?>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="js/toastr.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>
    <script src="ajax.js"></script>
    <!-- Page JS -->
    <script>
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
  </script>
  </body>
</html>
