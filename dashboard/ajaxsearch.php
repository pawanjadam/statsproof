<?php
session_start();
if(!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] == false){
  header('Location: ../login.php');
}
include('inc/connect.php');
include('../dataarray.php');

$userId = $_SESSION['user']['id'];

function shortNumber($number){
    if($number>999999){
        return round($number/1000000, 2)."M";
    }else if($number<1000){
        return $number;
    }else{
        return round($number/1000, 2)."K";
    }
}

if(isset($_POST['action']) && $_POST['action']=='deletelist'){
	$listId = $_POST['listId'];
	$delete = mysqli_query($connect, "DELETE FROM lists where id='$listId' and userId='$userId'");
	if($delete){
		mysqli_query($connect, "DELETE FROM listitems where listId='$listId'");
		echo 1;
	}else{
		echo 0;
	}
}


if(isset($_POST['action']) && $_POST['action']=='createlist'){
	$listName = $_POST['listName'];
	$listDescription = mysqli_real_escape_string($connect, $_POST['listDescription']);
	$add = mysqli_query($connect, "INSERT INTO lists(userId, listName, listDescription, createdAt) VALUES('$userId', '$listName', '$listDescription', NOW())");
	if($add){
		echo 1;
	}else{
		echo 0;
	}
}


if(isset($_POST['action']) && $_POST['action']=='addtolist'){
	$listId=$_POST['listId'];
	$channelId=$_POST['channelId'];
	$add = mysqli_query($connect, "INSERT INTO listitems(listId, userId, channelId) VALUES('$listId', '$userId', '$channelId')");
	if($add){
		mysqli_query($connect, "UPDATE lists set listCount=listCount+1 where id='$listId'");
		echo 1;
	}else{
		echo 0;
	}
}

if(isset($_POST['action']) && $_POST['action']=='removefromlist'){
	$listId=$_POST['listId'];
	$channelId=$_POST['channelId'];
	$delete = mysqli_query($connect, "DELETE from listitems where listId='$listId' and channelId='$channelId'");
	if($delete){
		mysqli_query($connect, "UPDATE lists set listCount=listCount-1 where id='$listId'");
		echo 1;
	}else{
		echo 0;
	}
}


if(isset($_POST['action']) && $_POST['action']=='search'){
	$page=$_POST['page'];
	$count = ($page-1)*20;
	$keyword = $_POST['keyword'];
	$criteria = "";

	if(isset($_POST['country']) && $_POST['country']!=''){
		$country = $_POST['country'];
		$criteria .= " and country = '$country'";
	}

	if(isset($_POST['language']) && $_POST['language']!=''){
		$language = $_POST['language'];
		$criteria .= " and language = '$language'";
	}

	if(isset($_POST['lastupdated']) && $_POST['lastupdated']!=''){
		$lastPublished = $_POST['lastupdated'];
		$criteria .= " and lastPublished > '$lastPublished'";
	}

	if(isset($_POST['category']) && $_POST['category']!=''){
		$category = $_POST['category'];
		$criteria .= " and category like '%$category%'";
	}

	if(isset($_POST['sortby']) && $_POST['sortby']!=''){
		$sortby = $_POST['sortby'];
		$criteria .= " order by $sortby desc";
	}

	$lists = array();
	$selectlists = mysqli_query($connect, "SELECT * FROM lists where userId='$userId'");
	while($row = mysqli_fetch_assoc($selectlists)){
	  $lists[$row['id']] = $row;
	}
	$listitems = array();
	$selectlistitems = mysqli_query($connect, "SELECT * FROM listitems where userId='$userId'");
	while($row = mysqli_fetch_assoc($selectlistitems)){
	  $listitems[$row['listId']][] = $row['channelId'];
	}

	$querycount = mysqli_query($connect, "SELECT count(id) as num from channelsearch where title like '%".$keyword."%' ".$criteria);
	$row = mysqli_fetch_assoc($querycount);
	$total = $row['num'];
	?>
	<!-- Hoverable Table rows -->
              <div class="card">
                <h5 class="card-header">Showing <?php echo $count+1;?> - <?php echo $count+20>$total?$total:$count+20;?> of <?php echo $total;?></h5>
                <div class="table-responsive text-nowrap">
                	<input type="hidden" id="search" value="<?php echo $page;?>">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Subscribers<br>Videos</th>
                        <th>Country<br>Language</th>
                        <th>Email</th>
                        <th>Profile</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
	<?php
	$query = "SELECT * from channelsearch where id>1 and title like '%".$keyword."%' ".$criteria." limit $count, 20";
	$select = mysqli_query($connect, $query);

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
			$categories = explode(", ", $row['category']);
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
	                  title="Lilian Fuller"
	                >
	                  <img src="<?php echo $thumbnail;?>" alt="Avatar" class="rounded-circle" />
	                </li>
	              </ul>
	            </td>
	            <td><strong>
	              <a title="<?php echo $title;?>" target="_blank" href="https://youtube.com/channel/<?php echo $channel;?>">
	              	<?php echo strip_tags(strlen($title)>17? substr($title,0,14)."...":$title);?>
	              	</a>
	              <?php
	              if($customUrl!=''){
	              	?>
	              	<br>
	              	<a title="<?php echo '@'.$customUrl;?>" target="_blank" style="color:#CD201F" href="https://youtube.com/@<?php echo $customUrl;?>">
	              		@<?php echo strip_tags(strlen($customUrl)>17? substr($customUrl,0,14)."...":$customUrl);?>
	              		</a>
	              	<?php
	              }else{
	              	echo "<br>";
	              }
	              ?>
	              </strong>
	              <?php
	              if($lastPublished!=''){
	            		?>
	            		<br><span title="Latest video published date"><i style="color:#CD201F" class="bx bx-calendar"></i><?php echo date('d-m-Y', strtotime($lastPublished));?></span>
	            		<?php
	            	}
	            	?>
	            </td>
	            <td>

	            	<?php
	            	$totalCategories = count($categories);
	            	if($totalCategories>0){
		            	$showing = 0;
		            	$categoriesToShow = 2;
		            	if($totalCategories<$categoriesToShow){
										$categoriesToShow = $totalCategories;
									}
		            	foreach($categories as $category){
		            		if($category!=''){
		            			$showing++;
			            		?>
			            		<span class="badge bg-label-primary me-1"><?php echo $topics[$category];?></span><br>
			            		<?php
			            		//echo $topics[$category]."<br>";
			            		if($showing>=$categoriesToShow){
			            			break;
			            		}	
		            		}
		            	}
		            	if($totalCategories>$categoriesToShow){
		            		?>
		            		<span class="badge bg-label-warning me-1"><?php echo $totalCategories-$categoriesToShow.' more';?></span>
		            		<?php
		            	}
	            	}
	            	?>

	            	<!-- <span class="badge bg-label-success me-1"><?php echo 'Cat1';?></span> -->
	            </td>
	            <td>
	            	<span title="Subscribers"><?php echo shortNumber($subscribers);?></span>
	            	<br><br><span title="Videos"><?php echo shortNumber($videos);?></span>
	            </td>
	            <td>
	            	<?php
	            if($country!=''){
	             echo '<span title="Country"><i style="color:#CD201F" class="bx bx-map"></i>'.$countries[$country].'</span>';
	            }
	            ?>
	            <?php 
		            if($language!=''){
			            echo '<br><br><span title="Language"><i style="color:#CD201F" class="bx bx-speaker"></i>'.$languages[$language].'</span>';
			          }
		          ?>
		          </td>
	            <td>
	            	<?php
	            	if($email!=''){
	            		?>
	            		<a title="Send email to this influencer" href="mailto:<?php echo $email;?>"><i style="color:#c4302b; font-size: 35px;" class="bx bx-envelope"></i></a>
	            		<?php
	            	}
	            	?>
	            </td>
	            <td>
	            	<a title="Click to view Public Profile" target="_blank" href="../profile.php?channel=<?php echo $channel;?>">
	            		<i style="color:#CD201F; font-size: 35px;" class="bx bx-chalkboard"></i>
	            		</a>
	            </td>
	            <td>
                          <div class="dropdown">
                            <button title="Add to list" type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i style="color:#CD201F" class="bx bx-plus"></i>
                            </button>
                            <div class="dropdown-menu">
                              <?php
                              $listCount=0;
                              foreach($lists as $key => $list){
                                if(isset($listitems[$key]) && in_array($channelId, $listitems[$key])){
                                  $listCount++;
                                   ?>
                                    <a onclick="removefromlist('<?php echo $key;?>','<?php echo $channelId;?>')" style="color:#CD201F" title="Added to this list, click to remove" class="dropdown-item" href="javascript:void(0);">
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
                        <!-- <td style="color:<?php echo $listCount>0?'green':'';?>">
                          <?php echo $listCount;?> List<?php echo $listCount>1?'s':'';?>
                        </td> -->
	          </tr>
	          <?php
	      }
$pages=ceil($total/20);
if($pages>1){
  $start=1;
  $end=5;
  if($page>$pages){
    $page=$pages;
  }else if($page<1){
    $page=1;
  }
  $previous=$page-1;
  if($previous<1){
    $previous=1;
  }
  $previous5 = $page-5;
  if($previous5<1){
    $previous5=1;
  }
  $next = $page+1;
  if($next>$pages){
    $next = $pages;
  }
  $next5 = $page+5;
  if($next5>$pages){
    $next5 = $pages;
  }
  if($page>3){
  $start = $page-3;
  }
  if($page+3<$pages){
    $end=$page+3;
  }else{
    $end=$pages;
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
                      <btn title="Skip 5 pages" onclick="search(<?php echo $previous5; ?>)" class="page-link">
                        <i class="tf-icon bx bx-chevrons-left"></i>
                      </btn>
                    </li>
                    <li class="page-item prev">
                      <btn title="Previous Page" onclick="search(<?php echo $previous; ?>)" class="page-link">
                        <i class="tf-icon bx bx-chevron-left"></i>
                      </btn>
                    </li>

                    <?php for($i=$start;$i<=$end; $i++){
				      ?>
				      
				        <li class="page-item">
                      <btn class="page-link <?php if($page==$i){echo "btn-primary";}?>" onclick="search(<?php echo $i; ?>)"><?php echo $i;?></btn>
                    </li>

				      <?php
				    }
				    ?>

					<li class="page-item next">
                      <btn title="Next page" class="page-link" onclick="search(<?php echo $next; ?>)">
                        <i class="tf-icon bx bx-chevron-right"></i>
                      </btn>
                    </li>

                    <li class="page-item next">
                      <btn title="Skip 5 pages" class="page-link" onclick="search(<?php echo $next5; ?>)">
                        <i class="tf-icon bx bx-chevrons-right"></i>
                      </btn>
                    </li>				    

                  </ul>
                </nav>
              </div>
              <!--/ Pagination -->

			<?php
			}
		}
	}
?>