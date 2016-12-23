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
	$statuses = $connection->get("search/tweets", ["q" => "sweet_khushbu_n"]);
	echo $user->screen_name;
	echo "status".$statuses;
	
	
	$url = 'https://api.twitter.com/1.1/followers/ids.json';
$getfield = '?screen_name='.$user->screen_name;
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
echo $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
}
