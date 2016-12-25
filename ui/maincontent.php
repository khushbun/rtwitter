<html>
	<head>
		<title>twitter signup</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
		<link href="assets/lib/jquery.bxslider.css" rel="stylesheet" />
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.bxslider.min.js"></script>
	</head>
	<body style="background-color: black; color:#fff;">
		<center>
			<div class="container" style="padding-top:5%;">
				<div class="row">
					<div class="col-lg-3"></div>
					<div class="col-lg-6"><h1>Tweets and Followers</h1></div>
				</div>
				<div class="row" style="padding-top:5%;">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<div class="form-group has-feedback">
							<label for="search" class="sr-only">Search followers</label>
							<input type="text" class="form-control" name="search" id="search" placeholder="search">
							<span class="glyphicon glyphicon-search form-control-feedback"></span>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-4"><h4>10 recent Tweets</h4></div>
					<div class="col-lg-4"><h4>10 Followers</h4></div>
					
				</div>
				<div class="row" >
					<div class="col-lg-1"></div>
					<div class="col-lg-5 col-md-12 col-sm-12">
						<ul class="list-group"style="color:black;">
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
								$followers = $connection->get('followers/list',["screen_name" =>$user->screen_name]);

							 foreach ($tweets as $result) {?>
								<li class="list-group-item"><?php echo $result->user->name . ": " . $result->text ; } } ?></li> 
							
					  	</ul>
					</div>
				</div>
			</div>
		</center>
	</body>
</html>
