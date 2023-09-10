<?php
include('config.php');
$select = mysqli_query($connect, "SELECT id, categoryId from youtube.categorycount where updatedAt<date_sub(NOW(), INTERVAL 1 DAY)");
if(mysqli_num_rows($select)){
	while($row = mysqli_fetch_assoc($select)){
		$id = $row['id'];
		$categoryId = $row['categoryId'];
		$selectcount = mysqli_query($connect, "SELECT count(id) as num from youtube.channelsearch where category like '%".$categoryId."%'");
		$rowcount = mysqli_fetch_assoc($selectcount);
		$count = $rowcount['num'];
		mysqli_query($connect, "UPDATE youtube.categorycount set dataCount='$count', updatedAt=NOW() where id='$id'");
	}
}
?>