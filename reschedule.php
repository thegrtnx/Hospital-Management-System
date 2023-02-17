<?php
include("components/head.php");

if(isset($_GET['ref'])) {

$ref = clean(escape($_GET['ref']));

user_details();

$doctor = "Dr ".$t_users['fullname'];
$dctel = $GLOBALS['t_users']['tel'];

} else {

    redirect("./appointment");

   
}

?>

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


                   
                        <!-- Basic Layout -->
                        <div class="row">
                          <div class="col-xl-12">
                              
                            <div class="card mb-4">
                              <div class="card-header d-flex justify-content-between align-items-center">
                              <h5 class="card-header">Reschedule Appointment</h5>

                              </div>
                              <div class="card-body">
                                <form>

                            
                                
                                  <div class="mb-3" id="bckdtt">
                                    <label class="form-label" for="basic-default-phone">Pick new appointment date</label>
                                    <input
                                      type="date"
                                      id="aptdte"
                                      class="form-control"
                                    />
                                  </div>

                                  <input type="text" value="<?php echo $ref ?>" id="reff" hidden>
                                  <input type="text" value="<?php echo $doctor ?>" id="docname" hidden>
                                  <input type="text" value="<?php echo $dctel ?>" id="dctel" hidden>
                                  
                                  
                                  <button type="button" id="newbck" class="btn btn-primary">Submit</button>
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