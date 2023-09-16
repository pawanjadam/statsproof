<?php
session_start();
if(!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] == false){
  header('Location: ../login.php');
}
include('inc/connect.php');
$element='list';
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

    <title>Lists | StatsProof - Your Youtube Data Research Partner</title>

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


              <!-- Small Modal -->
                      <div class="modal fade" id="createListModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel2">Create List</h5>
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
                                  <label for="listName" class="form-label">Name</label>
                                  <input type="text" id="listName" class="form-control" placeholder="Enter List Name" />
                                </div>
                              </div>
                              <div class="row g-2">
                                <div class="col mb-0">
                                  <label class="form-label" for="listDescription">Description</label>
                                  <textarea class="form-control" id="listDescription"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                              </button>
                              <button type="button" class="btn btn-sm btn-primary" onclick="createList()">Save</button>
                            </div>
                          </div>
                        </div>
                      </div>
              <!-- Hoverable Table rows -->
              <div class="card">


          <nav class="layout-navbar container-xxl navbar navbar-expand-xl align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <button type="button"
                          class="btn btn-primary"
                          data-bs-toggle="modal"
                          data-bs-target="#createListModal">Create</button>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>




                <h5 class="card-header">Lists</h5>

                <div class="table-responsive text-nowrap">

                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>List</th>
                        <th>Description</th>
                        <th>Channels</th>
                        <th>Default</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php
                      $userId = $_SESSION['user']['id'];
                      $count = 0;
                      $select = mysqli_query($connect, "SELECT * from lists where userId='$userId'");
                      while($row = mysqli_fetch_assoc($select)){
                        $count++;
                        $listId = $row['id'];
                        $listName = $row['listName'];
                        $listDescription = $row['listDescription'];
                        $listCount = $row['listCount'];
                        $isdefault = $row['isdefault'];
                        ?>
                        <tr>
                        <td><?php echo $count;?></td>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $listName;?></strong></td>
                        <td title="<?php echo $listDescription;?>"><?php echo strip_tags(strlen($listDescription)>30? substr($listDescription,0,30)."...":$listDescription);?></td>
                        <td><?php echo $listCount;?></td>
                        <td><span class="badge bg-label-<?php echo $isdefault==1?'success':'primary';?> me-1"><?php echo $isdefault==1?'Default':'User Made';?></span></td>

                        <td>
                              <a href="javascript:void(0);">
                                <i class="bx bx-edit-alt me-1"></i>View
                              </a>
                              <a style="margin-left: 25px;" onclick="listDownload('<?php echo $listId;?>')" href="javascript:void(0);">
                                <i class="bx bx-download me-1"></i>Download
                              </a>
                              <?php
                              if($isdefault==0){
                                ?>
                                <a style="margin-left: 25px; color: red;" onclick="deleteList('<?php echo $listId;?>')" href="javascript:void(0);">
                                <i class="bx bx-trash me-1"></i>Delete
                              </a>
                              <?php
                              }
                            ?>
                              
                        </td>
                        
                      </tr>

                        <?php
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Hoverable Table rows -->
            </div>
            <!-- / Content -->
            <script type="text/javascript">
              function createList(){
                var listName = $('#listName').val();
                if(listName=='' || typeof(listName)=='undefined'){
                  alert('Enter List Name');
                  return false;
                }
                var listDescription = $('#listDescription').val();
                if(listDescription=='' || typeof(listDescription)=='undefined'){
                  alert('Enter List Description');
                  return false;
                }
                $.post("ajaxsearch.php", {action:"createlist", listName:listName, listDescription:listDescription}).done(function(data){
                  if(data == 1){
                    location.reload();
                  }else{
                    alert('Something went wrong!');
                  }
                });
              }

              function deleteList(listId){
                if(confirm("Do you really want to delete this list?")){
                  $.post("ajaxsearch.php", {action:"deletelist", listId:listId}).done(function(data){
                    if(data == 1){
                      location.reload();
                    }else{
                      alert('Something went wrong!');
                    }
                  });
                }
              }

              function listDownload(listId){
                if(listId>0){
                  window.location = 'listdownload.php?listId='+listId;
                }
              }
            </script>

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
