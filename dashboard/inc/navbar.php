          <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <?php
                  if(isset($element) and $element=='search'){
                ?>
                <div class="nav-item d-flex align-items-center">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Search Youtube..."
                    aria-label="Search Youtube..."
                    id="searchbox"
                  />
                </div>
                <div class="m-1">
                  <select class="form-select" id="category" onchange="search(1)">
                    <option value="">Category</option>
                    <option value="/m/04rlf">Music (parent topic)</option>
                    <option value="/m/02mscn">Christian music</option>
                    <option value="/m/0ggq0m">Classical music</option>
                    <option value="/m/01lyv">Country</option>
                    <option value="/m/02lkt">Electronic music</option>
                    <option value="/m/0glt670">Hip hop music</option>
                    <option value="/m/05rwpb">Independent music</option>
                  </select>
                </div>
                <div class="m-1">
                  <select class="form-select" id="country" onchange="search(1)">
                    <option value="">Country</option>
                    <option value="DE">Germany</option>
                    <option value="IN">India</option>
                    <option value="JP">Japan</option>
                    <option value="TH">Thailand</option>
                    <option value="UK">United Kingdom</option>
                    <option value="US">United States</option>
                  </select>
                </div>
                <div class="m-1">
                  <select class="form-select" id="language" onchange="search(1)">
                    <option value="">Language</option>
                    <option value="en">English</option>
                    <option value="en-US">English US</option>
                    <option value="ja">Japanese</option>
                    <option value="tr">Turkish</option>
                    <option value="zxx">Without Language</option>
                  </select>
                </div>
                <div class="m-1">
                  <select class="form-select" id="lastupdated" onchange="search(1)">
                    <option value="">Last Updated</option>
                    <option value="<?php echo date('Y-m-d', strtotime(date('Y-m-d')."-1 week"));?>">In 1 Week</option>
                    <option value="<?php echo date('Y-m-d', strtotime(date('Y-m-d')."-1 month"));?>">In 1 Month</option>
                    <option value="<?php echo date('Y-m-d', strtotime(date('Y-m-d')."-3 month"));?>">In 3 Months</option>
                    <option value="<?php echo date('Y-m-d', strtotime(date('Y-m-d')."-6 month"));?>">In 6 Months</option>
                    <option value="<?php echo date('Y-m-d', strtotime(date('Y-m-d')."-1 year"));?>">In 1 Year</option>
                  </select>
                </div>
                <div class="m-1">
                  <select class="form-select" id="sortby" onchange="search(1)">
                    <option value="">Sort By</option>
                    <option value="subscribers">Subscribers</option>
                    <option value="videos">Videos</option>
                    <option value="lastPublished">Last Updated</option>
                  </select>
                </div>
                <div class="nav-item d-flex align-items-center">
                  <button type="button" onclick="search(1)" class="btn btn-primary">
                  Search</button>
                </div>
                <?php
                  }
                ?>
              </div>

              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <?php
                      if(!empty($_SESSION['user']['picture'])){
                        ?>
                        <img src="<?php echo $_SESSION['user']['picture'];?>" alt class="w-px-40 h-auto rounded-circle" />
                        <?php
                      }else if(empty($_SESSION['user']['picture']) && $_SESSION['user']['gender']=='male'){
                        ?>
                        <img src="../assets/img/avatars/man.jpg" alt class="w-px-40 h-auto rounded-circle" />
                        <?php
                      }else if(empty($_SESSION['user']['picture']) && $_SESSION['user']['gender']=='female'){
                        ?>
                        <img src="../assets/img/avatars/woman.jpg" alt class="w-px-40 h-auto rounded-circle" />
                        <?php
                      }else{
                        ?>
                        <img src="../assets/img/avatars/default.png" alt class="w-px-40 h-auto rounded-circle" />
                        <?php
                      }
                      ?>                      
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                      <?php
                      if(!empty($_SESSION['user']['picture'])){
                        ?>
                        <img src="<?php echo $_SESSION['user']['picture'];?>" alt class="w-px-40 h-auto rounded-circle" />
                        <?php
                      }else if(empty($_SESSION['user']['picture']) && $_SESSION['user']['gender']=='male'){
                        ?>
                        <img src="../assets/img/avatars/man.jpg" alt class="w-px-40 h-auto rounded-circle" />
                        <?php
                      }else if(empty($_SESSION['user']['picture']) && $_SESSION['user']['gender']=='female'){
                        ?>
                        <img src="../assets/img/avatars/woman.jpg" alt class="w-px-40 h-auto rounded-circle" />
                        <?php
                      }else{
                        ?>
                        <img src="../assets/img/avatars/default.png" alt class="w-px-40 h-auto rounded-circle" />
                        <?php
                      }
                      ?>                      
                    </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?php echo $_SESSION['user']['first_name'];?></span>
                            <small class="text-muted">User</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <!-- <li>
                      <a class="dropdown-item" href="account-settings.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li> -->
                    <li>
                      <a class="dropdown-item" href="account-settings.php">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>
          