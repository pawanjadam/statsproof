<?php
session_start();
include('inc/connect.php');

function split_name($name){
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
    return array($first_name, $last_name);
}

function remove_protocol($url) {
   $disallowed = array('https://www.', 'http://www.', 'https://', 'http://', 'www.');
   foreach($disallowed as $d){
      if(strpos($url, $d) === 0) {
         return str_replace($d, '', $url);
      }
   }
   return $url;
}

if(isset($_POST['action']) && $_POST['action']=='changePassword'){
	$useremail = $_SESSION['user']['email'];
	$select = mysqli_query($connect, "SELECT * FROM users where email='$useremail'");
	if(mysqli_num_rows($select)==0){
		//Something went wrong
		echo 3;
		exit;
	}
	$row = mysqli_fetch_assoc($select);
	if($row['password'] == $_POST['oldPassword']){
		$newPassword = mysqli_real_escape_string($connect, $_POST['newPassword']);
		mysqli_query($connect, "UPDATE users set password='$newPassword' where email='$useremail'");
		echo 1;
		exit;
	}else{
		//Old Password do not match
		echo 2;
		exit;
	}
}

if(isset($_POST['action']) && $_POST['action']=='getcities'){
	?>
	<option value="">Select city</option>
	<?php
	$countrycode = $_POST['countrycode'];
	$select = mysqli_query($connect, "SELECT city FROM world where countrycode='$countrycode' order by city asc");
	if(mysqli_num_rows($select)>0){
		while($row = mysqli_fetch_assoc($select)){
			?>
			<option value="<?=$row['city'];?>"><?=ucfirst($row['city']);?></option>
			<?php
		}
	}
}

if(isset($_POST['action']) && $_POST['action']=='savefirstmodal'){
	$useremail = $_SESSION['user']['email'];
	$name = $_POST['name'];
	$contactemail = $_POST['contactemail'];
	$country = $_POST['country'];
	$city = $_POST['city'];
	$names = split_name($name);
	$firstName = $names[0];
	$lastName = $names[1];
	$update = mysqli_query($connect, "UPDATE users set first_name='$firstName', last_name='$lastName', contactemail='$contactemail', city='$city', country='$country', basicInfo=1 where email='$useremail'");	
	if($update){
		$select = mysqli_query($connect, "SELECT * FROM users where email='$useremail'");
		$row = mysqli_fetch_assoc($select);
		$_SESSION['user'] = $row;
		echo 1;
	}else{
		echo 0;
	}
}

if(isset($_POST['action']) && $_POST['action']=='savesecondmodal'){
	$useremail = $_SESSION['user']['email'];
	$productName = $_POST['productName'];
	$website = remove_protocol($_POST['website']);
	$category = $_POST['category'];
	$niche = implode(", ", $_POST['niche']);
	$update = mysqli_query($connect, "UPDATE users set brand='$productName', website='$website', category='$category', prefCategories='$niche', basicInfo=2 where email='$useremail'");	
	if($update){
		$select = mysqli_query($connect, "SELECT * FROM users where email='$useremail'");
		$row = mysqli_fetch_assoc($select);
		$_SESSION['user'] = $row;
		echo 1;
	}else{
		echo 0;
	}
}


if(isset($_POST['action']) && $_POST['action']=='saveAccountSettings'){
	$useremail = $_SESSION['user']['email'];
	$name = $_POST['name'];
	$contactemail = $_POST['contactemail'];
	$country = $_POST['country'];
	$city = $_POST['city'];
	$names = split_name($name);
	$firstName = $names[0];
	$lastName = $names[1];
	$productName = $_POST['productName'];
	$website = remove_protocol($_POST['website']);
	$category = $_POST['category'];
	$niche = implode(", ", $_POST['niche']);
	$update = mysqli_query($connect, "UPDATE users set first_name='$firstName', last_name='$lastName', contactemail='$contactemail', city='$city', country='$country', brand='$productName', website='$website', category='$category', prefCategories='$niche', basicInfo=2 where email='$useremail'");	
	if($update){
		$select = mysqli_query($connect, "SELECT * FROM users where email='$useremail'");
		$row = mysqli_fetch_assoc($select);
		$_SESSION['user'] = $row;
		echo 1;
	}else{
		echo 0;
	}
}
?>