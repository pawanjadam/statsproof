<?php
session_start();
if(!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] == false){
  header('Location: ../login.php');
}
include('inc/connect.php');
$element='setting';
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

    <title>Account Settings | StatsProof - Your Youtube Data Research Partner</title>

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

    <!-- Page CSS -->

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

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

        <?php include ('inc/aside.php');?>
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="account-notifications.php"
                        ><i class="bx bx-bell me-1"></i> Notifications</a
                      >
                    </li>
                    <!-- <li class="nav-item">
                      <a class="nav-link" href="account-connections.php"
                        ><i class="bx bx-link-alt me-1"></i> Connections</a
                      >
                    </li> -->
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <!-- <img
                          src="../assets/img/avatars/1.png"
                          alt="user-avatar"
                          class="d-block rounded"
                          height="100"
                          width="100"
                          id="uploadedAvatar"
                        /> -->
                        <?php
                      if(!empty($_SESSION['user']['picture'])){
                        ?>
                        <img
                          src="<?php echo $_SESSION['user']['picture'];?>"
                          alt="user-avatar"
                          class="d-block rounded"
                          height="100"
                          width="100"
                          id="uploadedAvatar"
                        />
                        <?php
                      }else if(empty($_SESSION['user']['picture']) && $_SESSION['user']['gender']=='male'){
                        ?>
                        <img
                          src="../assets/img/avatars/man.jpg"
                          alt="user-avatar"
                          class="d-block rounded"
                          height="100"
                          width="100"
                          id="uploadedAvatar"
                        />
                        <?php
                      }else if(empty($_SESSION['user']['picture']) && $_SESSION['user']['gender']=='female'){
                        ?>
                        <img
                          src="../assets/img/avatars/woman.jpg"
                          alt="user-avatar"
                          class="d-block rounded"
                          height="100"
                          width="100"
                          id="uploadedAvatar"
                        />
                        <?php
                      }else{
                        ?>
                        <img
                          src="../assets/img/avatars/default.png"
                          alt="user-avatar"
                          class="d-block rounded"
                          height="100"
                          width="100"
                          id="uploadedAvatar"
                        />
                        <?php
                      }
                      ?>   
                        <!-- <div class="button-wrapper">
                          <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input
                              type="file"
                              id="upload"
                              class="account-file-input"
                              hidden
                              accept="image/png, image/jpeg"
                            />
                          </label>
                          <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div> -->
                      </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" onsubmit="return false">
                        <div class="row">
                          <div class="col-6">
                          <div class="mb-3">
                            <label for="nameWithTitle" class="form-label">Full Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="nameWithTitle"
                              value="<?=$_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'];?>"
                              placeholder="John Fitzgerald Kennedy"
                            />
                          </div>
                          <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input
                              class="form-control"
                              type="text"
                              id="email"
                              disabled
                              value="<?=$_SESSION['user']['email'];?>"
                            />
                          </div>
                          <div class="mb-3">
                            <label for="contactEmail" class="form-label">Contact E-mail</label>
                            <input
                              class="form-control"
                              type="text"
                              id="contactEmail"
                              value="<?=$_SESSION['user']['contactemail'];?>"
                              placeholder="john@jacob.com"
                            />
                          </div>
                          <!-- <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Organization</label>
                            <input
                              type="text"
                              class="form-control"
                              id="organization"
                              name="organization"
                              value="ThemeSelection"
                            />
                          </div> -->
                          <!-- <div class="mb-3">
                            <label class="form-label" for="phoneNumber">Phone Number</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">US (+1)</span>
                              <input
                                type="text"
                                id="phoneNumber"
                                name="phoneNumber"
                                class="form-control"
                                placeholder="202 555 0111"
                              />
                            </div>
                          </div> -->

                          <div class="mb-3">
                            <label class="form-label" for="country">Country</label>
                            <select id="country" class="form-select" onchange="getcities(this.value)">
                              <option value="">Select country</option>
                              <?php
                              $select = mysqli_query($connect, "SELECT country, countrycode from world group by countrycode order by country");
                              while($row = mysqli_fetch_assoc($select)){
                                ?>
                                <option value="<?=$row['countrycode'];?>" <?=$row['countrycode']==$_SESSION['user']['country']?'selected':'';?>><?=ucfirst($row['country']);?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                          <div class="mb-3">
                            <label for="state" class="form-label">City</label>
                            <select id="city" class="form-select">
                              <option value="">Select your city</option>
                              <?php
                                $select = mysqli_query($connect, "SELECT city FROM world where countrycode='".$_SESSION['user']['country']."' order by city asc");
                                if(mysqli_num_rows($select)>0){
                                  while($row = mysqli_fetch_assoc($select)){
                                    ?>
                                    <option value="<?=$row['city'];?>" <?=$row['city']==$_SESSION['user']['city']?'selected':'';?>><?=ucfirst($row['city']);?></option>
                                    <?php
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>


                        <div class="col-6">
                          <div class="mb-3">
                            <label for="productName" class="form-label">Your Product Name</label>
                            <input
                              type="text"
                              id="productName"
                              class="form-control"
                              placeholder="General Motors"
                              value="<?=ucfirst($_SESSION['user']['brand']);?>"
                            />
                          </div>
                          <div class="mb-3">
                            <label for="website" class="form-label">Product Website</label>
                            <input
                              type="website"
                              id="website"
                              class="form-control"
                              value="www.<?=strtolower($_SESSION['user']['website']);?>"
                              placeholder="www.gm.com"
                            />
                          </div>
                          <div class="mb-3">
                            <label for="category" class="form-label">Product Category</label>
                            <select id="category" class="form-select">
                              <option value="">Select your Product category</option>
                              <?php
                              $select = mysqli_query($connect, "SELECT * FROM topics");
                              while($row = mysqli_fetch_assoc($select)){
                                $categories[] = $row;
                                ?>
                                <option value="<?=$row['topicId'];?>" <?php echo $_SESSION['user']['category']==$row['topicId']?'selected':'';?>><?=$row['topic'];?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                          <div class="mb-3">
                            <label for="niche" class="form-label">Categories of Influencers you want to see (Upto five)</label>
                            <select id="niche" class="form-select" multiple>
                              <option value="">Can select upto five categories</option>
                              <?php
                              foreach($categories as $category){
                                ?>
                                <option
                                  <?php
                                    echo in_array($category['topicId'], explode(", ", $_SESSION['user']['prefCategories']))?'selected':'';
                                  ?>
                                  value="<?=$category['topicId'];?>"><?=$category['topic'];?></option>
                                <?php
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        </div>
                        <div class="mt-2" style="float:right">
                          <div id="accountSettingsError" style="color:red"></div>
                          <button type="submit" onclick="saveAccountSettings()" class="btn btn-primary me-2">Save</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>

                  <div class="card mb-4">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body">
                      <div class="row">
                          <div class="col-6">
                          <div class="mb-3">
                            <label for="oldPassword" class="form-label">Password</label>
                            <input
                              class="form-control"
                              type="password"
                              id="oldPassword"
                              placeholder="Existing password"
                            />
                          </div>
                          <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input
                              class="form-control"
                              type="password"
                              id="newPassword"
                              placeholder="New Password"
                            />
                          </div>
                          <div class="mb-3">
                            <label for="repeatNewPassword" class="form-label">Repeat New Password</label>
                            <input
                              class="form-control"
                              type="password"
                              id="repeatNewPassword"
                              placeholder="Repeat New Password"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="row" style="float:right">
                        <div id="passwordError" style="color:red"></div>
                        <button type="button" onclick="changePassword()" class="btn btn-primary me-2">Change</button>
                      </div>
                    </div>
                  </div>

                  <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                      <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                          <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                          <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                        </div>
                      </div>
                      <form id="formAccountDeactivation" onsubmit="return false">
                        <div class="form-check mb-3">
                          <input disabled
                            class="form-check-input"
                            type="checkbox"
                            name="accountActivation"
                            id="accountActivation"
                          />
                          <label class="form-check-label" for="accountActivation"
                            >I confirm my account deactivation</label
                          >
                        </div>
                        <button type="submit" disabled class="btn btn-danger deactivate-account">Deactivate Account</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <script type="text/javascript">

              function changePassword(){
                $("#passwordError").html('');
                var oldPassword = $("#oldPassword").val();
                if(oldPassword=='' || typeof(oldPassword)=='undefined'){
                  $("#passwordError").html('Old Password can not be empty');
                  $("#oldPassword").focus();
                  return false;
                }
                if(oldPassword.length<6){
                  $("#passwordError").html('Old Password must be atleast six characters');
                  $("#oldPassword").focus();
                  return false;
                }

                var newPassword = $("#newPassword").val();
                if(newPassword=='' || typeof(newPassword)=='undefined'){
                  $("#passwordError").html('New Password can not be empty');
                  $("#newPassword").focus();
                  return false;
                }
                if(newPassword.length<6){
                  $("#passwordError").html('New Password must be atleast six characters');
                  $("#newPassword").focus();
                  return false;
                }

                var repeatNewPassword = $("#repeatNewPassword").val();
                if(repeatNewPassword!=newPassword){
                  $("#passwordError").html('New Password and Repeat New Password do not match');
                  $("#repeatNewPassword").focus();
                  return false;
                }

                if(oldPassword==newPassword){
                  $("#passwordError").html('Old and New Password are same');
                  $("#newPassword").focus();
                  return false;
                }

                $.post("ajaxaccount.php", {action:"changePassword", oldPassword:oldPassword, newPassword:newPassword}).done(function(data){
                  if(data==1){
                    $("#passwordError").html('Password changed');
                    $("#oldPassword").val('');
                    $("#newPassword").val('');
                    $("#repeatNewPassword").val('');
                    return false;
                  }else if(data==2){
                    $("#passwordError").html('Old Password is incorrect');
                    return false;
                  }else{
                    $("#passwordError").html('Something went wrong');
                    return false;
                  }
                });
              }

              $(document).ready(function() {
                var last_valid_selection = null;
                $('#niche').change(function(event) {
                  $("#secondModalError").html('');
                  if ($(this).val().length > 5) {
                    $("#secondModalError").html('You can choose upto five categories only');
                    $(this).val(last_valid_selection);
                  } else {
                    last_valid_selection = $(this).val();
                  }
                });
              });

              function getcities(countrycode){
                $.post("ajaxaccount.php", {action:"getcities", countrycode:countrycode}).done(function(data){
                  $("#city").html(data);
                });
              }

              function saveAccountSettings(){
                document.getElementById("formAccountSettings").addEventListener("submit", function(event){
                  event.preventDefault()
                });
                $("#accountSettingsError").html('');
                var name = $("#nameWithTitle").val();
                if(name=='' || typeof(name)=='undefined' || name.length<3){
                  $("#accountSettingsError").html('Please enter a real name');
                  $("#nameWithTitle").focus();
                  return false;
                }
                var contactemail = $("#contactEmail").val();
                var validRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
                if(contactemail=='' || typeof(contactemail)=='undefined' || !contactemail.match(validRegex)){
                  $("#accountSettingsError").html('Please enter a valid contact email');
                  $("#contactEmail").focus();
                  return false;
                }
                var country = $("#country").val();
                if(country=='' || typeof(country)=='undefined'){
                  $("#accountSettingsError").html('Please select your country');
                  $("#country").focus();
                  return false;
                }
                var city = $("#city").val();
                if(city=='' || typeof(city)=='undefined'){
                  $("#accountSettingsError").html('Please choose your city');
                  $("#city").focus();
                  return false;
                }
                var productName = $("#productName").val();
                if(productName=='' || typeof(productName)=='undefined'){
                  $("#accountSettingsError").html('Please enter Product Name');
                  $("#productName").focus();
                  return false;
                }
                
                var website = $("#website").val();
                var websiteRegex = /^(http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}([0-9A-Za-z-\.@:%_\+~#=]+)+((\.[a-zA-Z]{2,3})+)(\/(.)*)?(\?(.)*)?/g;
                if(website=='' || typeof(website)=='undefined' || !website.match(websiteRegex)){
                  $("#accountSettingsError").html('Please enter a valid product website');
                  $("#website").focus();
                  return false;
                }
                var category = $("#category").val();
                if(category=='' || typeof(category)=='undefined'){
                  $("#accountSettingsError").html('Please select Product category');
                  $("#category").focus();
                  return false;
                }
                var niche = document.getElementById("niche");
                var selectedNiche = [];
                for (var i = 0; i < niche.length; i++) {
                    if (niche.options[i].selected) selectedNiche.push(niche.options[i].value);
                }
                if(selectedNiche.length==0){
                  $("#accountSettingsError").html('Please choose Influencer categories');
                  $("#niche").focus();
                  return false;
                }
                $.post("ajaxaccount.php", {action:"saveAccountSettings", name:name, contactemail:contactemail, country:country, city:city, productName:productName, website:website, category:category, niche:selectedNiche}).done(function(data){
                  if(data==1){
                    $("#accountSettingsError").html('saved');
                    location.reload();
                  }else{
                    $("#accountSettingsError").html('Something went wrong, please try again');
                  }
                });
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

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/pages-account-settings-account.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
