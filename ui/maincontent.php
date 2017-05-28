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
		$_SESSION['connection'] = $connection;

		$user = $connection->get("account/verify_credentials");

		$_SESSION['user'] = $user;

		$tweets = $connection->get('statuses/home_timeline',["count" =>10]);

		$ajaxfollowers = $connection->get('followers/list',["screen_name" =>$user->screen_name]);

		$followers = $connection->get('followers/list',["screen_name" =>$user->screen_name, "count"=>10]);

		$a= array();
		$dt = $connection->get('statuses/home_timeline',["count" =>10]); 
			foreach($dt as $c){
				$temp = $c->user->name;
			   	$a[$temp] = $c->text;							
		}
		$_SESSION['a']=$a;

		$followerd = $connection->get('followers/list',["screen_name" =>$user->screen_name]);
		$fdata= array();

		$_SESSION['test'] = "hello";
		
		foreach ($followerd->users as $result) {
			$utweets = $connection->get('search/tweets',["q" =>$result->screen_name]);
			$i=0;
			foreach ($utweets->statuses as $res) {
				$fdata[$result->screen_name][$i]=$res;
				$i++;
				}
		}

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
		<script src="assets/js/download.js?v3.1"></script>
		<style>
			.slider-wrap {max-width:1080px; margin:0 auto; padding-top:50px}
			.bxslider {margin-top:0}
			.bxslider li {left:0}
		</style>
	</head>
	<body style="background-color: black; color:#fff;">
		<center>
			<div class="container" style="padding-top:1%; padding-bottom: 8%;">
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-11"><h1>Welcome To See Tweets and Followers of Your Account</h1></div>

				</div>
				
				<div class="row" style="padding-top:1%;">
					<div class="col-lg-1"></div>
					<div class="col-lg-9">
						<input type="text" id="txt1" />

						<input type="text" id="txtAutoComplete1" class="form-control" placeholder="Autocomplete Followers search box" list="languageList1"/>

						<datalist id="languageList1">
							<?php foreach($ajaxfollowers->users as $b){?>
								<option value="<?php echo $b->screen_name;?>" />
							<?php }?>
						
						</datalist>

					</div>	
					<div class="col-lg-2">
					<!--<input type="button" id="click2" value="see follower" class="btn btn-success"/> -->
					</div>
					<div class="col-lg-2">
						<input type="button" id="click" value="Download Tweets" class="btn btn-success"/>
						<input type="button" id="showtweets" value="show Tweets" class="btn btn-success"/>
						<input type="button" id="test" value="Test" class="btn btn-success"/>
					</div>
				</div>
				
				
				<div class="row" style=" padding-top: 1%;">
					<div class="col-lg-1"></div>
					<div class="col-lg-5 col-md-12 col-sm-12">
						<div class="jq-tweets">
							<ul class="bxslider " style="color:black;">
								<?php foreach ($tweets as $result) {?>
								<li><p> <?php echo "<h2>".$result->user->name . ": " . $result->text . "</h2>";?> </p></li>
								<?php } ?>
							</ul>
						</div>
						<script>

							$(document).ready(function(){
								$(document).on("click", "#click", function(){
								        var s = <?php echo json_encode($a); ?>;
									console.log(s);
									alert("Wait Few seconds file will be downloaded!!!!!");
									$.ajax({
									  type: "POST",
									  url: "ahtml.php",
									  data: { d: JSON.stringify(s)},
									}).done(function( msg ) {
										alert(msg);
										var x=new XMLHttpRequest();
										x.open("GET", "https://rtwittertest.herokuapp.com/ui/Tweets.json", true);
										x.responseType = 'json';
										x.onload=function(e){download(JSON.stringify(x.response), "tweets.json", "application/json" ); }
										x.send();
									    
									  });
								 });
									$(document).on("click", "#click2", function(){
										var f=<?php echo json_encode($fdata); ?>;
										var sa = document.getElementById('txtAutoComplete1').value;
										console.log(f);
										console.log(sa);
									});
								
								$('.bxslider').bxSlider({
									mode: 'fade',
									controls: false,
									adaptiveHeight: true
								});
								

								
									
							});
							$('#test').click(function() {
										var username = $("input[id=txt1]").val();
										alert("test"+username);
									});

								$('#showtweets').click(function() {
									var username = $("input[id=txtAutoComplete1]").val();
										alert("username"+username);


									if(username=='' || username==null){
										alert("Please select a follower");
									}

									else{
										$.ajax({
										  type: "POST",
										  url: "followers.php",
										  data: { user: username},
										}).done(function( msg ) {
											
											console.log(msg); 				
											tweets = JSON.parse(msg);		
											str='<ul class="bxslider " style="color:black;">';	
											$.each( tweets, function( key, value ) 
											{
											console.log(value); 
											str+="<li><p>";
											str+=value;
											str+="</p></li>";
											console.log(str);
											  
											});
											str+="</ul>";
											$('.jq-tweets').html(str);
											
										    $('.bxslider').bxSlider({
												mode: 'fade',
												controls: false,
												adaptiveHeight: true
											});
										  });
									}
										
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
				<div class="row">
					<div class="col-lg-1">
					</div>
					<div class="col-lg-6">
						<div id="fdata" style="color:white;">
						</div>
					</div>
				</div>
			</div>
		</center>
	</body>
</html>
