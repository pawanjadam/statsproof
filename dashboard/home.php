<?php
session_start();
if(!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] == false){
  header('Location: ../login.php');
}
include('inc/connect.php');
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
date_default_timezone_set("Asia/Calcutta");
$date = date('Y-m-d H:i:s');
$userip = get_client_ip();
mysqli_query($connect, "INSERT INTO statsproof.sitevisits(page, userip, visittime) VALUES(4, '$userip', '$date')");
$element='home';
function shortNumber($number){
    if($number>999999){
        return round($number/1000000, 2)."M";
    }else if($number<1000){
        return $number;
    }else{
        return round($number/1000, 2)."K";
    }
}
?>
<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Dashboard | StatsProof - Your Youtube Data Research Partner</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assetslp/images/favicon.png" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <?php include('inc/aside.php');?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <?php include('inc/navbar.php');?>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary">WelCome! 🎉</h5>
                          <p class="mb-4">
                            We have added <span class="fw-bold">6,258</span> new channels today.
                            <br>Search now.
                          </p>

                          <a href="search.php" class="btn btn-sm btn-outline-primary">Explore</a>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="../assets/img/illustrations/man-with-laptop-light.png"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                $select = mysqli_query($connect, "SELECT listName, listCount from lists where listName in ('Hidden','Favourites')");
                if(mysqli_num_rows($select)>0){
                  while($row = mysqli_fetch_assoc($select)){
                    $lists[$row['listName']] = $row['listCount'];
                  }
                }
                ?>
                <div class="col-lg-4 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-star"></i>
                              </span>
                            </div>
                            
                          </div>
                          <span class="fw-semibold d-block mb-1">Favourites</span>
                          <h3 class="card-title mb-2">
                            <?php if(isset($lists['Favourites']) && $lists['Favourites']>0){ echo $lists['Favourites'];}else{echo 0;}?>
                            </h3>
                          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Channels</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <div class="avatar flex-shrink-0">
                              <span class="avatar-initial rounded bg-label-danger">
                                <i class="bx bx-hide"></i>
                              </span>
                            </div>
                            </div>
                            
                          </div>
                          <span>Hidden</span>
                          <h3 class="card-title text-nowrap mb-1">
                            <?php if(isset($lists['Hidden']) && $lists['Hidden']>0){ echo $lists['Hidden'];}else{echo 0;}?>
                          </h3>
                          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Channels</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Total Revenue -->
                <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                  <div class="card">
                    <div class="row row-bordered g-0">
                      <h5 class="card-header m-0 me-2 pb-3">Top Categories</h5>
                      <div class="col-md-6">
                        <div class="card-body">
                          <ul class="p-0 m-0">
                      <?php
                      $count=0;
                      $select = mysqli_query($connect, "SELECT * FROM categorycount");
                      while($row = mysqli_fetch_assoc($select)){
                        $count++;
                        $category = $row['category'];
                        $dataCount = $row['dataCount'];
                        $dataClass = $row['class'];
                        $dataBxicon = $row['bxicon'];
                        ?>
                            <li class="d-flex mb-4 pb-1">
                              <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-<?php echo $dataClass;?>">
                                  <i class="bx bx-<?php echo $dataBxicon;?>"></i>
                                </span>
                              </div>
                              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                  <h6 class="mb-0"><?php echo $category;?></h6>
                                  <small class="text-muted d-block mb-1">Category</small>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                  <h6 class="mb-0"><?php echo shortNumber($dataCount);?><br>
                                  <small class="text-muted">Channels</small></h6>
                                </div>
                              </div>
                            </li>
                          
                      
                        <?php
                        if($count%4==0){
                          ?>
                          </ul>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="card-body">
                          <ul class="p-0 m-0">
                          <?php
                        }
                      }
                      ?>
                            <li class="d-flex mb-4 pb-1">
                              <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                  <i class="bx bx-category"></i></span>
                              </div>
                              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                  <h6 class="mb-0">55 more</h6>
                                  <small class="text-muted d-block mb-1">Categories</small>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                  <h6 class="mb-0"><a href="search.php">Search here</a></h6>
                                </div>
                              </div>
                            </li>

                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                  <div class="row">
                    
                    <!-- Order Statistics -->
              
                <div class="col-12">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                      <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Statistics</h5>
                        <?php
                        $select = mysqli_query($connect, "SELECT count(id) as num from channelsearch");
                        $row = mysqli_fetch_assoc($select);
                        ?>
                        <small class="text-muted"><?php echo shortNumber($row['num']);?> Total Channels</small>
                      </div>
                      
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                          <h2 class="mb-2">6,258</h2>
                          <span>Added today</span>
                        </div>
                        <div id="orderStatisticsChart"></div>
                      </div>
                      <!-- <div class="card-body"> -->
                          <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                              <div class="card-title">
                                <h5 class="text-nowrap mb-2">Total Channels</h5>
                                <span class="badge bg-label-warning rounded-pill">Year 2023</span>
                              </div>
                              <div class="mt-sm-auto">
                                <small class="text-success text-nowrap fw-semibold"
                                  ><i class="bx bx-chevron-up"></i> <?php echo round((6258/$row['num'])*100, 2);?>
                                    %</small
                                >
                                <h3 class="mb-0"><?php echo shortNumber($row['num']);?></h3>
                                <span>Channels</span>
                              </div>
                            </div>
                            <div id="profileReportChart"></div>
                          </div>
                        <!-- </div> -->
                    </div>
                  </div>
                </div>
              
                <!--/ Order Statistics -->
                    
                    <div class="col-12 mb-4">
                      <div class="card">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <?php include('inc/footer.php');?>
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
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
