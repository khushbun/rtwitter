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
		$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

		function search(array $query){
  
		  return $twitter->get('search/tweets', $query);
		}
 
		$query = array(
		  "q" => "digital marketing",
		  "count" => 30,
		  "result_type" => "recent",
		);
		  
		$results = search($query);
	
		
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Twitter API SEARCH</title>
</head>
<body>
	<?php 
		foreach ($results->statuses as $result) {
	  		echo $result->user->screen_name . ": " . $result->text . "<br/>";
		}
	?>
  

</body>
</html>






