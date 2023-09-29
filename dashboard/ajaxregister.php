<?php
session_start();
include('inc/connect.php');

if(isset($_POST['action']) && $_POST['action']=='register'){
	$email = $_POST['email'];
	$password = $_POST['password'];
	$check = mysqli_query($connect, "SELECT * FROM users where email='$email'");
	if(mysqli_num_rows($check)>0){
		echo 2;
		exit;
	}

	$create = mysqli_query($connect, "INSERT INTO users(email, password, created) VALUES('$email', '$password', NOW())");
	if($create){
		$user = mysqli_query($connect, "SELECT * FROM users where email='$email'");
		$row = mysqli_fetch_assoc($user);
		$_SESSION['user'] = $row;
		$_SESSION['isLoggedIn'] = true;
		echo 1;
	}else{
		echo 0;
	}
}
?>