<?php
session_start();
	require 'autoload.php';
	use TwitterOAuth\TwitterOAuth;
	include("ahtml.php");

	define('CONSUMER_KEY', 'htjBgpI7OieRzufwsWwUA4lYU'); 
	define('CONSUMER_SECRET', 'bsZ3rejBiBexaZC004TNBSDw7XHWXWZnuFeIeV7Ckvgza2niIb'); 
	define('OAUTH_CALLBACK', 'https://rtwittertest.herokuapp.com/ui/callback.php');


if (!isset($_SESSION['access_token'])) {
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
	echo $url;
} 
else {
	$access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
	// getting basic user info
	$user = $connection->get("account/verify_credentials");
	$max_id = "";
foreach (range(1, 1) as $i) { // up to 1 page
  $query = array(
    "q" => "digital marketing",
    "count" => 30,
    "result_type" => "recent",
    "max_id" => $max_id,
  );
 
  $results = $connection->get('search/tweets', $query);
 $ind = 1;
  foreach ($results->statuses as $result) {
    echo $ind." => " ."[" . $result->user->profile_image_url . "]" .
         "[" . $result->user->name . "]" .
         "[" . $result->user->screen_name . "]" .
         "[" . $result->text . "]<br/><br/>";
 
    $max_id = $result->id_str; // Set max_id for the next search page
    $ind++;
  }
}
	
}