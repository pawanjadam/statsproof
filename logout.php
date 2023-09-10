<?php
session_start();
include('googleConfig.php');
$client->revokeToken();
session_destroy();
header('location:login.php');
?>