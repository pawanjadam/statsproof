<?php
session_start();
include('inc/connect.php');

if(isset($_POST['action']) && $_POST['action']=='login'){
	$email = $_POST['email'];
	$password = $_POST['password'];
	$select = mysqli_query($connect, "SELECT * FROM users where email='$email'");
	if(mysqli_num_rows($select)==0){
		//Email not registered
		echo 2;
		exit;
	}
	$row = mysqli_fetch_assoc($select);
	if($password!=$row['password']){
		//Incorrect password
		echo 3;
		exit;
	}

	$_SESSION['user'] = $row;
	$_SESSION['isLoggedIn'] = true;
	echo 1;
}
?>