<?php
require_once('vendor/autoload.php');
$client = new Google_Client();
$client->setAuthConfig('client.json');
$client->setScopes([
	'https://www.googleapis.com/auth/userinfo.email',
	'https://www.googleapis.com/auth/userinfo.profile'
]);
?>