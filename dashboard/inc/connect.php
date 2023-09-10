<?php
$hostname = "localhost";
$username = "root";
$password = "";
$databasename = "statsproof";
$connect = new mysqli($hostname, $username, $password,$databasename);
if ($connect->connect_error) {
	die("Unable to Connect database: " . $connect->connect_error);
}
?>