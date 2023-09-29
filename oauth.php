<?php
session_start();
include('googleConfig.php');
include('config.php');
$loginButton = '';
$dashboardPageURL='dashboard/home.php';
if(isset($_GET['code'])){
	$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
	if(!isset($token['error'])){
		$client->setAccessToken($token['access_token']);
		$_SESSION['access_token'] = $token['access_token'];
		$service = new Google_Service_Oauth2($client);
		$user = $service->userinfo->get();
		if(!empty($user['email'])){
			$_SESSION['user']['email'] = $user['email'];
		}
		
		$id= !empty($user['id'])? $user['id']:'';
	   	$firstName= !empty($user['given_name'])? $user['given_name']:''; 
	   	$lastName= !empty($user['family_name'])? $user['family_name']:''; 
	   	$email= !empty($user['email'])?$user['email']:''; 
	   	$gender= !empty($user['gender'])? $user['gender']:''; 
	   	$picture= !empty($user['picture'])? $user['picture']:''; 
	   	$oauth_provider = 'google';
	    $data = [
	    	'oauth_uid'  => $id,
	     	'first_name' => $firstName,
	     	'last_name'  => $lastName,
	     	'email'      => $email,
	     	'gender'     => $gender,
	     	'picture'    => $picture,
	     	'oauth_provider'=>$oauth_provider
	  	];

	  	$select = mysqli_query($connect, "SELECT * from users where oauth_uid='$id'");
	  	if(mysqli_num_rows($select)>0){
	  		//$update = mysqli_query($connect, "UPDATE users set first_name='$firstName', last_name='$lastName', email='$email', gender='$gender', picture='$picture', oauth_provider='google' where oauth_uid='$id'");
	  		//if($update){
	  			$select = mysqli_query($connect, "SELECT * from users where oauth_uid='$id'");
	  			$row = mysqli_fetch_assoc($select);
	  			$_SESSION['user'] = $row;
	  			$_SESSION['isLoggedIn'] = true;
	  		//}
	  	}else{
	  		$insert = mysqli_query($connect, "INSERT INTO users(oauth_provider, oauth_uid, first_name, last_name, email, gender, picture, oauth_provider, created) VALUES('google', '$id', '$firstName', '$lastName', '$email', '$gender', '$picture', '$oauth_provider', NOW())");
	  		if($insert){
	  			$userId = mysqli_insert_id($connect);
	  			mysqli_query($connect, "INSERT INTO lists(userId, listName, listDescription, isDefault, createdAt) VALUES('$userId', 'Favourites', 'Default Favourite List', '1', NOW()), ('$userId', 'Hidden', 'Default Hidden List', '1', NOW())");
	  			$select = mysqli_query($connect, "SELECT * from users where oauth_uid='$id'");
	  			$row = mysqli_fetch_assoc($select);
	  			$_SESSION['user'] = $row;
	  			$_SESSION['isLoggedIn'] = true;
	  		}
	  	}
	  	header('Location: ' . filter_var($dashboardPageURL, FILTER_SANITIZE_URL));
	}
}
if(!isset($_SESSION['access_token'])){
	$loginButton = $client->createAuthUrl();
}else{
	header('Location: ' . filter_var($dashboardPageURL, FILTER_SANITIZE_URL));
}
?>