<?php
	session_start();

	require 'autoload.php';
	use TwitterOAuth\TwitterOAuth;
	include("ahtml.php");

	define('CONSUMER_KEY', 'htjBgpI7OieRzufwsWwUA4lYU'); 
	define('CONSUMER_SECRET', 'bsZ3rejBiBexaZC004TNBSDw7XHWXWZnuFeIeV7Ckvgza2niIb'); 
	define('OAUTH_CALLBACK', 'https://rtwittertest.herokuapp.com/ui/callback.php'); 

	$user = $_SESSION['user'];	

	$access_token = $_SESSION['access_token'];
	$conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		

	$utweets = $conn->get('statuses/user_timeline',["screen_name" =>'17_harshil','count' => '10']);
		
	$temp = [];
	foreach ($utweets as $res) {
		
		$temp[]=$res->text;
		
	}
	echo json_encode($temp);

?>