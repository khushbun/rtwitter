
<!DOCTYPE HTML>
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
					
					<div class="col-lg-3"></div>
					<div class="col-lg-6 col-md-12 col-sm-12">
					
						<ul class="bxslider">
						  		<li><img src="assets/images/a.jpg"/></li>
						
						</ul>
						<script>
							$(document).ready(function(){
							  $('.bxslider').bxSlider();
							});
						</script>
					</div>
				</div>	
				<div class="row">
					<div class="col-lg-4"></div>
					
					<div class="col-lg-3"><h4>Followers</h4></div>
				</div>
				<div class="row" >
					
					
					<div class="col-lg-3"></div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<ul class="list-group"style="color:black;">
						    <li class="list-group-item">First item</li>
						    <li class="list-group-item">Second item</li>
						    <li class="list-group-item">Third item</li>
					  	</ul>	
		
					</div>
				</div>
				 	</div>
		</center>
	</body>
</html>
