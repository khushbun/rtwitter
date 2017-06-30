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
} else {
	$access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
	// getting basic user info
	$user = $connection->get("account/verify_credentials");
	
	// printing username on screen
	echo "Welcome " . $user->screen_name . '<br>';
	// getting recent tweeets by user 'snowden' on twitter
	$tweets = $connection->get('search/tweets', ["q" => "digital marketing", "count" => 30]);
	$totalTweets[] = $tweets;
	$page = 0;
	for ($count = 30; $count < 180; $count += 30) { 
		$max = count($totalTweets[$page]) - 1;
		$tweets = $connection->get('search/tweets', ["q" => "digital marketing", "count" => 30, 'max_id' => $totalTweets[$page][$max]->id_str]);
		$totalTweets[] = $tweets;
		$page += 1;
	}
	// printing recent tweets on screen
	$start = 1;
	foreach ($totalTweets as $page) {
		foreach ($page as $key) {
			echo $start . ':' . $key->text . '<br>';
			$start++;
		}
	}
}