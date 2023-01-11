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
              <div class="row">

                <div class="col-lg-6 mb-4 order-0">
                  <a href="./pharmacy">
                  <div class="card">
                  <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                                                        
                          </div>
                          
                          <h3 class="card-title mb-2">Purchase <br/> Drugs</h3>
                          <small class="text-dark fw-semibold">View and purchase available drugs <i class="bx bx-right-arrow-alt"></i></small>
                        </div>
                  </div>
                  </a>
                 
                </div>
              
                <div class="col-lg-6 mb-4 order-0">
                  <a href="./appointment">
                  <div class="card">
                  <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                                                        
                          </div>
                          
                          <h3 class="card-title mb-2">Book an appointment<br/> with a Doctor  </h3>
                          <small class="text-dark fw-semibold">Schedule a meet with a doctor <i class="bx bx-right-arrow-alt"></i></small>
                        </div>
                  </div>
                  </a>
                  
                </div>

                <div class="col-lg-6 mb-4 order-0">
                  <a href="./profile">
                  <div class="card">
                  <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                                                        
                          </div>
                          
                          <h3 class="card-title mb-2">Edit <br/> Details  </h3>
                          <small class="text-dark fw-semibold">Make changes to your profile details <i class="bx bx-right-arrow-alt"></i></small>
                        </div>
                  </div>
                  </a>
                </div>


                <div class="col-lg-6 mb-4 order-0">
                  <a href="tel: 911">
                  <div class="card">
                  <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                                                        
                          </div>
                          
                          <h3 class="card-title mb-2">Call for <br/> Help/Emergency  </h3>
                          <small class="text-dark fw-semibold">Need prompt help? <i class="bx bx-right-arrow-alt"></i></small>
                        </div>
                  </div>
                  </a>
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

    <script src="assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/dashboards-analytics.js"></script>

    
  </body>
</html>
