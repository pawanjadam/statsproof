<?php
session_start();
if(!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] == false){
  header('Location: ../login.php');
}
include('inc/connect.php');
if(isset($_GET['listId']) && $_GET['listId']>0){
	$userId = $_SESSION['user']['id'];
	$listId = $_GET['listId'];
	$selectList = mysqli_query($connect, "SELECT * FROM lists where id='$listId' and userId='$userId'");
	if(mysqli_num_rows($selectList)>0){
		$rowList = mysqli_fetch_assoc($selectList);
		$listName = $rowList['listName'];
	}
	if(!empty($listName)){
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='.ucfirst($listName).'.csv');
		$output = fopen("php://output", "w");
		fputcsv($output, array("Channel", "Title", "CustomURL", "Email", "Subscribers", "Language", "Country", "LastPublished", "PublishedAt"));
		$query= mysqli_query($connect, "SELECT channel, title, customUrl, email, subscribers, language, country, lastPublished, publishedAt from channelsearch where id in (SELECT channelId from listitems where listId='$listId' and userId='$userId')");
		while($row = mysqli_fetch_assoc($query)){
			fputcsv($output, $row);
		}
		fclose($output);
		echo $output;
	}
}

?>