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
	// echo $url;
		header('Location: '.$url);
	
} 
else {
	$access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
	// getting basic user info
	$user = $connection->get("account/verify_credentials");
	
	  	$m="";
		  	
		$index = 0;

  		foreach (range(1, 1) as $i) {
		  	$query = array(
			    "q" => "digital marketing ",
			    "result_type" => "recent",
			    "max_id" => $m,
			    "count" => 50
		  	);
 
  			$results = $connection->get('search/tweets', $query);

		  	foreach ($results->statuses as $result) {    	
		 		$index++; 
		 		
		 		echo $index." => ".$result->user->screen_name . ": " . $result->text . "<br/>";
		 		// echo "max_id =>".$result->created_at."<br/>";

		 		// echo "max_id =>".$m."<br/><br/>";
		  		
	    		$m = $result->id_str;	
	    		if($index == 30){
	    			break;
	    		}
	    				    	
		  	}

		  	
		}
	  	
	
}