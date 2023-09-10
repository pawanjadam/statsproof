              <!-- Hoverable Table rows -->
              <div class="card">
                <h5 class="card-header">Showing 1 - 20 of 86297</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Subscribers</th>
                        <th>Videos</th>
                        <th>Country</th>
                        <th>Language</th>
                        <th>Email</th>
                        <th>Lists</th>
                        <th>Added To</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php
                      $count=0;
                      $select = mysqli_query($connect, "SELECT * FROM youtube.channelsearch where country!='' and language!='' and category!='' and title!='' and email!='' limit 20");
                      if(mysqli_num_rows($select)>0){
                        while($row = mysqli_fetch_assoc($select)){
                          $count++;
                          $channelId = $row['id'];
                          $title = $row['title'];
                          $channel = $row['channel'];
                          $thumbnail = $row['thumbnail'];
                          $customUrl = $row['customUrl'];
                          $subscribers = $row['subscribers'];
                          $videos = $row['videos'];
                          $views = $row['views'];
                          $publishedAt = $row['publishedAt'];
                          $lastPublished = $row['lastPublished'];
                          $category = $row['category'];
                          $country = $row['country'];
                          $language = $row['language'];
                          $email = $row['email'];
                          ?>
                          <tr>
                        <td><?php echo $count;?></td>
                        <td>
                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li
                              data-bs-toggle="tooltip"
                              data-popup="tooltip-custom"
                              data-bs-placement="top"
                              class="avatar avatar-xl pull-up"
                              title="<?php echo $title;?>"
                            >
                              <img src="<?php echo $thumbnail;?>" alt="Avatar" class="rounded-circle" />
                            </li>
                          </ul>
                        </td>
                        <td><strong>
                          <a target="_blank" href="https://youtube.com/channel/<?php echo $channel;?>"><?php echo $title;?><i class="bx bx-arrow-up"></i></a><br>
                          <a target="_blank" style="color:red" href="https://youtube.com/@<?php echo $customUrl;?>">@<?php echo $customUrl;?></a></strong></td>
                        <td><span class="badge bg-label-success me-1"><?php echo 'Cat1';?></span></td>
                        <td><?php echo $subscribers;?></td>
                        <td><?php echo $videos;?></td>
                        <!-- <td><?php echo $views;?></td> -->
                        <td><?php echo $country;?></td>
                        <td><?php echo $language;?></td>
                        <td><a title="Send email to this influencer" href="mailto:<?php echo $email;?>" style="color:red"><i class="bx bx-envelope"></i></a></td>
                        <td>
                          <div class="dropdown">
                            <button title="Add to list" type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-plus"></i>
                            </button>
                            <div class="dropdown-menu">
                              <?php
                              $count=0;
                              foreach($lists as $key => $list){
                                if(isset($listitems[$key]) && in_array($channelId, $listitems[$key])){
                                  $count++;
                                   ?>
                                    <a onclick="removefromlist('<?php echo $key;?>','<?php echo $channelId;?>')" style="color:green" title="Added to this list, click to remove" class="dropdown-item" href="javascript:void(0);">
                                      <i class="bx bx-collection me-1"></i><?php echo $list['listName'];?>
                                      <i class="bx bx-check-circle me-1"></i>
                                    </a>
                                    <?php
                                  }else{
                                    ?>
                                    <a onclick="addtolist('<?php echo $key;?>','<?php echo $channelId;?>')" title="Click to add to this list" class="dropdown-item" href="javascript:void(0);">
                                      <i class="bx bx-collection me-1"></i><?php echo $list['listName'];?>
                                    </a>
                                    <?php
                                  }
                              }
                              ?>
                            </div>
                          </div>
                        </td>
                        <td style="color:<?php echo $count>0?'green':'';?>">
                          <?php echo $count;?> List<?php echo $count>1?'s':'';?>
                        </td>
                      </tr>
                          <?php
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Hoverable Table rows -->

              <!-- Pagination -->
              <div class="demo-inline-spacing">
                <nav aria-label="Page navigation">
                  <ul class="pagination justify-content-center">
                    <li class="page-item prev">
                      <btn onclick="search(1)" class="page-link">
                        <i class="tf-icon bx bx-chevrons-left"></i>
                      </btn>
                    </li>

                    <?php for($i=1;$i<=5;$i++){
                    ?>
                    <li class="page-item">
                      <btn class="page-link <?php if($i==1){echo "btn-primary";}?>" onclick="search(<?php echo $i; ?>)"><?php echo $i;?></btn>
                    </li>
                    <?php
                    }
                    ?>

                    <li class="page-item next">
                      <btn class="page-link" onclick="search(6)">
                        <i class="tf-icon bx bx-chevrons-right"></i>
                      </btn>
                    </li>
                  </ul>
                </nav>
              </div>
              <!--/ Pagination -->