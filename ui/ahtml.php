<?php session_start();
	require 'autoload.php';
	use TwitterOAuth\TwitterOAuth;

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
	header('Location: '.$url);} 
	else {
		$access_token = $_SESSION['access_token'];
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$user = $connection->get("account/verify_credentials");

		$tweets = $connection->get('statuses/home_timeline',["count" =>10]);
		
		$ajaxfollowers = $connection->get('followers/list',["screen_name" =>$user->screen_name]);
		$followers = $connection->get('followers/list',["screen_name" =>$user->screen_name, "count"=>10]);
		
?>

<html>
	<head>
		<title>twitter signup</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
		<link href="assets/lib/jquery.bxslider.css" rel="stylesheet" />
		
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.bxslider.min.js"></script>
		
		<style>
			.slider-wrap {max-width:1080px; margin:0 auto; padding-top:50px}
			.bxslider {margin-top:0}
			.bxslider li {left:0}
		</style>
	</head>
	<body style="background-color: black; color:#fff;">
		<center>
			<div class="container" style="padding-top:5%;">
				<div class="row">
					<div class="col-lg-3"></div>
					<div class="col-lg-6"><h1>Tweets and Followers</h1></div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<center>
							<?php  $dt = $connection->get('statuses/home_timeline',["count" =>10]); 
									foreach($dt as $c){
										$a.=$c->user->name . ": " . $c->text."\xA";							
							}
							echo $a;
							} ?>
						
						</center>
					</div>
				</div>
			</div>
		</center>
	</body>
</html>
