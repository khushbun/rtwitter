<?php session_start();
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
	header('Location: '.$url);} 
	else {
		$access_token = $_SESSION['access_token'];
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$user = $connection->get("account/verify_credentials");
		$tweets = $connection->get('statuses/home_timeline',["count" =>10]);		
		$ajaxfollowers = $connection->get('followers/list',["screen_name" =>$user->screen_name]);
		$followers = $connection->get('followers/list',["screen_name" =>$user->screen_name, "count"=>10]);
		$a= array();
		$dt = $connection->get('statuses/home_timeline',["count" =>10]); 
			foreach($dt as $c){
				$temp = $c->user->name;
				$d = array();
				if($a[$temp] != "")
				{
			           $d[sizeof($d)] =  $c->text;
			           $a[$temp] = $d;							
				}
				else
				{
				    $t = $a[$temp];
				    $t[sizeof($t)] = $c->text;
					$a[$temp] = $t;
					
				}
		}
		$_SESSION['a']=$a;
		$ex = "hello";
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
		<script src="assets/js/jquery.fileDownload.js"></script>
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
					<div class="col-lg-3">
						
					</div>
					<div class="col-lg-6"><h1>Tweets and Followers</h1></div>

				</div>
				
				<div class="row" style="padding-top:5%;">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<input type="text" id="txtAutoComplete1" class="form-control" list="languageList1"/><!--your input textbox-->
						<datalist id="languageList1">
							<?php foreach($ajaxfollowers->users as $b){?>
						<option value="<?php echo $b->screen_name;?>" /><?php }?>
						
						</datalist>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-4"><h4>10 recent Tweets</h4></div>
					<div class="col-lg-4"><h4>10 Followers</h4></div>
					
				</div>
				<div class="row" >
					<div class="col-lg-1"><input type="button" id="click" /></div>
					<div class="col-lg-5 col-md-12 col-sm-12">
						<div class="slider-wrap">
							<ul class="bxslider" style="color:black;">
								<?php foreach ($tweets as $result) {?>
								<li><p> <?php echo "<h2>".$result->user->name . ": " . $result->text . "</h2>";?> </p></li>
								<?php } ?>
							</ul>
						</div>
						<script>

							$(document).ready(function(){
								$(document).on("click", "#click", function(){
								        var s = <?php echo $a; ?>;
									console.log(s);
									//alert(JSON.stringify(s));
									$.ajax({
									  method: "POST",
									  url: "ahtml.php",
									  data: { d: s }
									})
									  .done(function( msg ) {
										/*$.fileDownload("Tweets.json").done(function(){
											alert("downloaded");
										}).fail(function(){
											alert("error");
										});*/
										//window.location = "Tweets.json";
									    
									  });
								 });
								
								$('.bxslider').bxSlider({
									mode: 'fade',
									controls: false,
									adaptiveHeight: true
							});
							});

						</script>
					</div>
					<div class="col-lg-1"></div>
					<div class="col-lg-5 col-md-12 col-sm-12">
						<ul class="list-group" style="color:black;">
							<?php foreach ($followers->users as $result){?>
							<li class="list-group-item">								
								<?php echo $result->screen_name;} }?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</center>
	</body>
</html>
