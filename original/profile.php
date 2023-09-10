<?php
if(isset($_GET['channel']) && $_GET['channel']!=''){
	$channel = $_GET['channel'];
}else{
  echo "Please include channel id also like : ?channel=UCttspZesZIDEwwpVIgoZtWQ";
  exit;
}

include('config.php');
include('functions.php');
$dateToday = date_create(date('Y-m-d'));

$url = "https://www.googleapis.com/youtube/v3/channels?key=".$apikey."&id=".$channel."&part=brandingSettings,contentDetails,contentOwnerDetails,id,localizations,snippet,statistics,status,topicDetails";
$html = json_decode(gethtml($url), true);

// echo "<pre>";
// print_r($html);
// echo "</pre>";
// die();
if(isset($html['error']['errors'][0]['domain']) && $html['error']['errors'][0]['domain']=='youtube.quota'){
	echo "Daily Limit Exceeded";
	exit;
}else if(isset($html['pageInfo']['totalResults']) && $html['pageInfo']['totalResults']=='0'){
	echo "No results found";
	exit;
}else{
	if(isset($html['items'][0]['id'])){
		$id = $html['items'][0]['id'];
	}
	if(isset($html['items'][0]['snippet'])){
		$snippet = $html['items'][0]['snippet'];
	}
	if(isset($html['items'][0]['statistics'])){
		$statistics = $html['items'][0]['statistics'];
	}
	if(isset($html['items'][0]['topicDetails'])){
		$topicDetails = $html['items'][0]['topicDetails']['topicCategories'];
	}
	if(isset($html['items'][0]['brandingSettings'])){
		$brandingSettings = $html['items'][0]['brandingSettings'];
	}
}

$titleVideo = getVideoDetails($brandingSettings['channel']['unsubscribedTrailer']);
$mostwatched = getMostWatchedVideoDetails($channel);

// echo "<pre>";
// print_r($brandingSettings);
// die();


$playlistId="UU".substr($channel, 2);
$html = json_decode(gethtml("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&order=date&maxResults=30&playlistId=".$playlistId."&key=".$apikey), true);

foreach($html['items'] as $item){
  $videoids[] = $item['contentDetails']['videoId'];
  $videoId = $item['contentDetails']['videoId'];
  $videos[$videoId]['snippet'] = $item['snippet'];
}


$videoStats = getVideoStats($videoids);

// echo "<pre>";
// print_r($videoStats);
// die();
// echo "<pre>";
// print_r($videoStats);
// echo "</pre>";

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
  data-assets-path="assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Profile | StatsProof</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-content-navbar">
      <div>

        <!-- Layout container -->
        <div class="">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->



              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                
                <li class="nav-item lh-1 me-3">
                 <a target="_blank" href="https://youtube.com/channel/<?php echo $id;?>"><?php echo $snippet['customUrl'];?></a>
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="<?php echo $snippet['thumbnails']['default']['url'];?>" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <?php
                  if(@$isUserLoggedIn==1){
                  	?>
                  	<ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?php echo $snippet['thumbnails']['default']['url'];?>" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">John Doe</span>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="auth-login-basic.html">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                  <?php
                    }
                  ?>
                </li>
                <!--/ User -->

                <li  class="nav-item lh-1 me-3">
                  <div>
                    <a href="#" class="btn btn-danger btn-buy-now" data-bs-toggle="modal"
                          data-bs-target="#basicModal">
                      Collaborate
                    </a>
                  </div>
                </li>
                
              </ul>
                  	                
            </div>
          </nav>
<!-- Modal -->
                        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameBasic" class="form-label">Name</label>
                                    <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name" />
                                  </div>
                                </div>
                                <div class="row g-2">
                                  <div class="col mb-0">
                                    <label for="emailBasic" class="form-label">Email</label>
                                    <input type="text" id="emailBasic" class="form-control" placeholder="xxxx@xxx.xx" />
                                  </div>
                                  <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">DOB</label>
                                    <input type="text" id="dobBasic" class="form-control" placeholder="DD / MM / YY" />
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Close
                                </button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                              </div>
                            </div>
                          </div>
                        </div>
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">

              	<div class="col-lg-2 mb-4 col-md-2">
                  
                      <div class="card">
                        <div class="card-body-profile-picture">
                          <div class="align-items-center justify-content-between">
                          	<center>
                            <div class="flex-shrink-0">
                              <img
                                src="<?php echo $snippet['thumbnails']['medium']['url'];?>"
                                alt="chart success"
                                class="rounded" style="width:92%"
                              />
                            </div>
                        </center>
                          </div>
                        </div>
                      </div>
                

                      <div class="card" style="margin-top:20px">
                        <div class="card-body">
                          
                          <span class="fw-semibold d-block mb-1">Subscribers</span>
                          <h3 class="card-title mb-2"><?php echo shortNumber($statistics['subscriberCount']);?></h3>
                          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +2.80%</small>
                        </div>
                      </div>
                    </div>

                <div class="col-lg-8 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary"><a target="_blank" href="https://youtube.com/channel/<?php echo $id;?>"><?php echo $snippet['title'];?></a></h5>
                          <p><b>Description: </b></p>
                          <p class="mb-4">
                            <?php echo strip_tags(strlen($snippet['description'])>100? substr($snippet['description'],0,180)."... <a hreh='#'>Read more</a>":$snippet['description']);?>
                          </p>
                              <li class="d-flex mb-4 pb-1" title="Category">
                                <div class="avatar flex-shrink-0 me-3">
                                  <span class="avatar-initial rounded bg-label-success"
                                    ><i class="bx bx-category"></i
                                  ></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                  <div class="me-2">
                                    <h6 class="mb-0">
                                      <?php
                                        foreach($topicDetails as $topic){
                                          $topicName = explode("/", $topic);
                                          ?>
                                          <a href="<?php echo $topic;?>"><?php echo ucfirst(end($topicName));?></a>&nbsp&nbsp
                                          <?php
                                        }
                                      ?>
                                      <a href="#"><?php echo ucfirst(getCategoryName($videoStats['category']));?>
                                      </a>
                                      </h6>
                                  </div>
                                </div>
                              </li>

                          <div class="row">
                            <div class="col-6">
                              <li class="d-flex mb-4 pb-1" title="Country">
                                <div class="avatar flex-shrink-0 me-3">
                                  <span class="avatar-initial rounded bg-label-danger"
                                    ><i class="bx bx-map"></i
                                  ></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                  <div class="me-2">
                                    <h6 class="mb-0"><?php echo getCountryName($snippet['country']);?></h6>
                                  </div>
                                </div>
                              </li>
                            </div>
                            <div class="col-6">
                              <li class="d-flex mb-4 pb-1"  title="Language">
                                <div class="avatar flex-shrink-0 me-3">
                                  <span class="avatar-initial rounded bg-label-primary"
                                    ><i class="bx bx-speaker"></i
                                  ></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                  <div class="me-2">
                                    <h6 class="mb-0"><?php echo getLanguageName($videoStats['language']);?></h6>
                                  </div>
                                </div>
                              </li>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="<?php echo $brandingSettings['image']['bannerExternalUrl'];?>"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                          />
                          <p><b>Keywords: </b></p>
                          <p title="Channel keywords">
                            <a href="#"><?php echo $brandingSettings['channel']['keywords'];?></p>
                            </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-2 col-md-2 mb-4 order-1">
                  
                      <div class="card">
                        <div class="card-body-profile-picture">
                          <div class="align-items-center justify-content-between">
                          
                            <div class="flex-shrink-0" id="getsocial">
                              Social Profiles Here
                            </div>
                        
                          </div>
                        </div>
                      </div>
                    
                </div>
                <!-- Total Revenue -->
            </div>

            <div class="row">
                <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                  <div class="card">
                    <div class="row row-bordered g-0">

                      <div class="col-md-6">
                        <h5 class="card-header m-0 me-2 pb-3">Video Performance</h5>
                          <div class="card-body">
                      <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">Latest 5</small>
                              <h6 class="mb-0">Average Views</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0"><?php echo shortNumber($videoStats['avgviews']);?></h6>
                              
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="assets/img/icons/unicons/wallet.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">Latest 10</small>
                              <h6 class="mb-0">Average Views</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0"><?php echo shortNumber($videoStats['avgviews']);?></h6>
                              
                            </div>
                          </div>
                        </li>
                        
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="assets/img/icons/unicons/cc-success.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">All Time</small>
                              <h6 class="mb-0">Average Views</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0"><?php echo shortNumber($statistics['viewCount']/$statistics['videoCount']);?></h6>
                              
                            </div>
                          </div>
                        </li>
                        
                        
                      </ul>
                    </div>
                        <!-- <div id="totalRevenueChart" class="px-2"></div> -->
                      </div>

                      <div class="col-md-6">
                        <h5 class="card-header m-0 me-2 pb-3">Video Statistics</h5>
                          <div class="card-body">
                      <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">Latest 5</small>
                              <h6 class="mb-0">Average Likes</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0"><?php echo shortNumber($videoStats['avglikes']);?></h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="assets/img/icons/unicons/wallet.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">Latest 5</small>
                              <h6 class="mb-0">Average Comments</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0"><?php echo shortNumber($videoStats['avgcomments']);?></h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="assets/img/icons/unicons/chart.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">Latest 5</small>
                              <h6 class="mb-0">Average Favourite</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0"><?php echo shortNumber($videoStats['avgfavorites']);?></h6>
                            </div>
                          </div>
                        </li>

                      </ul>
                    </div>
                        <!-- <div id="totalRevenueChart" class="px-2"></div> -->
                      </div>

                      
                    </div>
                  </div>
                </div>
                <!--/ Total Revenue -->
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                      <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Channel Statistics</h5>
                        <small class=""><?php echo shortNumber($statistics['viewCount']);?> Total Views</small>
                      </div>
                      
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                          <h2 class="mb-2"><?php echo shortNumber($statistics['subscriberCount']);?></h2>
                          <span>Total Subscribers</span>
                        </div>
                        <div id="orderStatisticsChart"></div>
                      </div>
                      <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"
                              ><i class="bx bx-mobile-alt"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Videos</h6>
                              <small class="text-muted">Videos on channel</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold"><?php echo shortNumber($statistics['videoCount']);?></small>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Published At</h6>
                              <small class="text-muted"><?php
                              $publishedAt = date_create(date('Y-m-d', strtotime($snippet['publishedAt'])));
                              $interval = date_diff($dateToday, $publishedAt);
                              echo $interval->format('%y Years %m Months');
                               ?></small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold"><?php echo date('d-m-Y', strtotime($snippet['publishedAt']));?></small>
                            </div>
                          </div>
                        </li>
                        <!-- <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Decor</h6>
                              <small class="text-muted">Fine Art, Dining</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">849k</small>
                            </div>
                          </div>
                        </li> -->
                        <!-- <li class="d-flex">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-secondary"
                              ><i class="bx bx-football"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Sports</h6>
                              <small class="text-muted">Football, Cricket Kit</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">99</small>
                            </div>
                          </div>
                        </li> -->
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Videos /</span> Title & Most Watched</h4>
              <div class="row">
                
                <div class="col-md-6 col-lg-4 mb-3">
                  
                  <div class="card h-100">
                    <div class="card-body">
                      <h5 class="card-title" title="<?php echo strip_tags($titleVideo['snippet']['title']);?>"><?php echo strip_tags(strlen($titleVideo['snippet']['title'])>30? substr($titleVideo['snippet']['title'],0,30)."...":$titleVideo['snippet']['title']);?></h5>
                      <h6 class="card-subtitle text-muted">Title Video: <a hreh="#"><?php echo date('d-m-Y', strtotime($titleVideo['snippet']['publishedAt']));?></a></h6>
                    </div>
                    <!-- <iframe id="player" type="text/html" width="100%" height="150%"
                      src="http://www.youtube.com/embed/<?php echo $brandingSettings['channel']['unsubscribedTrailer'];?>"
                      frameborder="0"></iframe> -->
                    
                    <a href="https://youtube.com/watch?v=<?php echo $brandingSettings['channel']['unsubscribedTrailer'];?>" target="_blank">
                        <img class="img-fluid" src="<?php echo $titleVideo['snippet']['thumbnails']['high']['url']; ?>" alt="<?php echo strip_tags($titleVideo['snippet']['title']);?>"/>
                      </a>
                    <div class="card-body">
                      <p class="card-text" title="<?php echo strip_tags($titleVideo['snippet']['description']);?>"><?php 
                      echo strip_tags(strlen($titleVideo['snippet']['description'])>30? substr($titleVideo['snippet']['description'],0,30)."...":$titleVideo['snippet']['description']);?></p>
                      <a href="javascript:void(0);" class="card-link">Views: <?php echo shortNumber($titleVideo['statistics']['viewCount']);?></a>
                      <a href="javascript:void(0);" class="card-link">Likes: <?php echo shortNumber($titleVideo['statistics']['likeCount']);?></a>
                      <a href="javascript:void(0);" class="card-link">Comments: <?php echo shortNumber($titleVideo['statistics']['commentCount']);?></a>
                      <p title="Video tags">
                        Keywords:<br>
                      <?php 
                      foreach($titleVideo['snippet']['tags'] as $tag){
                        echo "<a href='#'>#".$tag."</a>&nbsp&nbsp";
                      }
                      ?>
                    </p>
                    </div>
                  </div>
                </div>
              
                <!-- <div class="col-md-6 col-lg-4 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h5 class="card-title" title="">From Youtuber</h5>
                      <h6 class="card-subtitle text-muted">From Youtuber Here</h6>
                    </div>
                    <div class="card-body">
                      <p class="card-text" >Text here</p>
                      <a href="javascript:void(0);" class="card-link">Card link</a>
                      <a href="javascript:void(0);" class="card-link">Another link</a>
                    </div>
                  </div>
                </div> -->

                <div class="col-md-6 col-lg-4 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h5 class="card-title" title="<?php echo strip_tags($mostwatched['snippet']['title']);?>"><?php echo strip_tags(strlen($mostwatched['snippet']['title'])>30? substr($mostwatched['snippet']['title'],0,30)."...":$mostwatched['snippet']['title']);?></h5>
                      <h6 class="card-subtitle text-muted">Most Popular: <a hreh="#"><?php echo date('d-m-Y', strtotime($mostwatched['snippet']['publishedAt']));?></a></h6>
                    </div>
                    <!-- <iframe id="player" type="text/html" width="100%" height="150%"
                      src="http://www.youtube.com/embed/<?php echo $mostwatched['videoId'];?>"
                      frameborder="0"></iframe> -->  
                      <a href="https://youtube.com/watch?v=<?php echo $mostwatched['videoId'];?>" target="_blank">
                        <img class="img-fluid" src="<?php echo $mostwatched['snippet']['thumbnails']['high']['url']; ?>" alt="<?php echo strip_tags($mostwatched['snippet']['title']);?>"/>
                      </a>
                    <div class="card-body">
                      <p class="card-text" title="<?php echo strip_tags($mostwatched['snippet']['description']);?>"><?php 
                      echo strip_tags(strlen($mostwatched['snippet']['description'])>30? substr($mostwatched['snippet']['description'],0,30)."...":$mostwatched['snippet']['description']);?></p>
                      <a href="javascript:void(0);" class="card-link">Views: <?php echo shortNumber($mostwatched['statistics']['viewCount']);?></a>
                      <a href="javascript:void(0);" class="card-link">Likes: <?php echo shortNumber($mostwatched['statistics']['likeCount']);?></a>
                      <a href="javascript:void(0);" class="card-link">Comments: <?php echo shortNumber($mostwatched['statistics']['commentCount']);?></a>
                      <p title="Video tags">
                        Keywords:<br>
                      <?php 
                      foreach($mostwatched['snippet']['tags'] as $tag){
                        echo "<a href='#'>#".$tag."</a>&nbsp&nbsp";
                      }
                      ?>
                    </p>
                    </div>
                  </div>
                </div>
              </div>

              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Videos /</span> Latest Five</h4>
              <div class="row">

                <?php
                $count = 0;
                foreach($videos as $videoId => $video){

                  $count++;
                  ?>
                  <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">
                      <div class="card-body">
                        <h5 class="card-title" title="<?php echo strip_tags($video['snippet']['title']);?>"><?php echo strip_tags(strlen($video['snippet']['title'])>30? substr($video['snippet']['title'],0,30)."...":$video['snippet']['title']);?></h5>
                        <h6 class="card-subtitle text-muted">Published At: <a hreh="#"><?php echo date('d-m-Y', strtotime($video['snippet']['publishedAt']));?></a></h6>
                      </div>
                      <!-- <iframe id="player" type="text/html" width="100%" height="150%"
                      src="http://www.youtube.com/embed/<?php echo $videoId;?>"
                      frameborder="0"></iframe> -->
                      <a href="https://youtube.com/watch?v=<?php echo $videoId;?>" target="_blank">
                        <img class="img-fluid" src="<?php echo $video['snippet']['thumbnails']['high']['url']; ?>" alt="<?php echo strip_tags($mostwatched['snippet']['title']);?>"/>
                      </a>
                      <div class="card-body">
                        <p class="card-text" title="<?php echo strip_tags($video['snippet']['description']);?>"><?php 
                      echo strip_tags(strlen($video['snippet']['description'])>30? substr($video['snippet']['description'],0,30)."...":$video['snippet']['description']);?></p>

                      <a href="javascript:void(0);" class="card-link">Views: <?php echo shortNumber($videoStats[$videoId]->viewCount);?></a>
                      <a href="javascript:void(0);" class="card-link">Likes: <?php echo shortNumber($videoStats[$videoId]->likeCount);?></a>
                      <a href="javascript:void(0);" class="card-link">Comments: <?php echo shortNumber($videoStats[$videoId]->commentCount);?></a>
                      <?php
                      if(isset($video['snippet']['tags']) && !empty($video['snippet']['tags'])){
                        echo "<p title='Video tags'>Keywords:<br>";
                        foreach($video['snippet']['tags'] as $tag){
                          echo "<a href='#'>#".$tag."</a>&nbsp&nbsp";
                        }
                        echo "</p>";
                      }
                      ?>
                      </div>
                    </div>
                  </div>
                  <?php
                    if($count>=5){
                      break;
                    }
                  }
                ?>
              </div>

              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Average /</span> Views Likes Comments Favourites</h4>

              <div class="row">
                <!-- Expense Overview -->
                <div class="col-md-12 col-lg-12 mb-4">
                  <div class="card h-100">
                    <div class="card-header">
                      <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                          <button
                            type="button"
                            class="nav-link active"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-tabs-line-card-income"
                            aria-controls="navs-tabs-line-card-income"
                            aria-selected="true"
                          >
                            Income
                          </button>
                        </li>
                        <li class="nav-item">
                          <button type="button" class="nav-link" role="tab">Expenses</button>
                        </li>
                        <li class="nav-item">
                          <button type="button" class="nav-link" role="tab">Profit</button>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body px-0">
                      <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                          <div class="d-flex p-4 pt-3">
                            <div class="avatar flex-shrink-0 me-3">
                              <img src="assets/img/icons/unicons/wallet.png" alt="User" />
                            </div>
                            <div>
                              <small class="text-muted d-block">Total Balance</small>
                              <div class="d-flex align-items-center">
                                <h6 class="mb-0 me-1">$459.10</h6>
                                <small class="text-success fw-semibold">
                                  <i class="bx bx-chevron-up"></i>
                                  42.9%
                                </small>
                              </div>
                            </div>
                          </div>
                          <div id="incomeChart"></div>
                          <div class="d-flex justify-content-center pt-4 gap-2">
                            <div class="flex-shrink-0">
                              <div id="expensesOfWeek"></div>
                            </div>
                            <div>
                              <p class="mb-n1 mt-1">Expenses This Week</p>
                              <small class="text-muted">$39 less than last week</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Expense Overview -->
              </div>


            </div>
            <!-- / Content -->



            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://statsproof.com" target="_blank" class="footer-link fw-bolder">StatsProof</a>
                </div>
                <div>
                  <a href="https://statsproof.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://statsproof.com/" target="_blank" class="footer-link me-4">Privacy Policy</a>

                  <a
                    href="https://statsproof.com/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://statsproof.com/"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
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

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script language="javascript">
    $(document).ready(function(){
        // $.post("profileajax.php", {action:"getsocial", channel:'<?php echo $channel; ?>'}).done(function(data){
        //   console.log(data);
        //   $("#getsocial").html(data);
        // });
    });
    </script>

  </body>
</html>
