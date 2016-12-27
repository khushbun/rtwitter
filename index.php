<?php
session_start();
require 'autoload.php';
use TwitterOAuth\TwitterOAuth;
 
define('CONSUMER_KEY', 'htjBgpI7OieRzufwsWwUA4lYU'); 
define('CONSUMER_SECRET', 'bsZ3rejBiBexaZC004TNBSDw7XHWXWZnuFeIeV7Ckvgza2niIb'); 
define('OAUTH_CALLBACK', 'https://rtwittertest.herokuapp.com/callback.php'); 

if (!isset($_SESSION['access_token'])) {
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
// echo $url;
header('Location: '.$url);
} 

else {
	$access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$user = $connection->get("account/verify_credentials");

	echo "Tweets :<br/>";
	$usertweets = $connection->get('search/tweets',["q" =>$user->screen_name]);
	foreach ($usertweets->statuses as $result) {
  		echo $result->user->screen_name . ": " . $result->text . "<br/>";
	}
	
	echo "TimelineTweets :<br/>";
	$tweets = $connection->get('statuses/home_timeline',["count" =>10]);
	foreach ($tweets as $result) {
  		echo $result->user->name . ": " . $result->text . "<br/>";
	}

	echo "Followers : <br/>";	
	$followers = $connection->get('followers/list',["screen_name" =>$user->screen_name]);
	
	foreach ($followers->users as $result) {
  		echo $result->id . ": " . $result->screen_name . "<br/>";
	}
	
	echo "Followers data full: <br/>";	
	$followers = $connection->get('followers/list',["screen_name" =>$user->screen_name]);
	
	foreach ($followers->users as $result) {
  		echo $result->screen_name  . ": " .$result->statuses_count . "<br/>";
		foreach($$result->statuses as $res){
			echo $res . "<br/>";
		}
		echo "-------------------------------------------";
	}


	echo "done";
}
