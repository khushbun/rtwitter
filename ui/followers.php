<?php
	session_start();

	require 'autoload.php';
	use TwitterOAuth\TwitterOAuth;
	include("ahtml.php");

	define('CONSUMER_KEY', 'htjBgpI7OieRzufwsWwUA4lYU'); 
	define('CONSUMER_SECRET', 'bsZ3rejBiBexaZC004TNBSDw7XHWXWZnuFeIeV7Ckvgza2niIb'); 
	define('OAUTH_CALLBACK', 'https://rtwittertest.herokuapp.com/ui/callback.php'); 



	echo "hii".$_SESSION['test'];

	//$conn = $_SESSION['connection'];
	$user = $_SESSION['user'];
	print_r($_SESSION['access_token']);
	print_r($user->screen_name);


	echo "done";

	$access_token = $_SESSION['access_token'];
	$conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		

	$utweets = $conn->get('search/tweets',["q" =>'dkhanani96']);

	 $followers = $conn->get('followers/list',["screen_name" =>$user->screen_name, "count"=>10]);

	 //print_r($followers);
echo "tweets of followers";
	print_r($utweets);	
	foreach ($utweets->statuses as $res) {
		echo $res;
		echo "<br> here<br>";
		
	}
?>