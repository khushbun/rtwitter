<?php
	session_start();
	echo "hii".$_SESSION['test'];

	$conn = $_SESSION['connection'];
	$user = $_SESSION['user'];
	print_r($conn);
	print_r($user);


	echo "done";
	$utweets = $conn->get('search/tweets',["q" =>'17_harshil']);
	// $followers = $conn->get('followers/list',["screen_name" =>$user->screen_name, "count"=>10]);

	// print_r($followers);	
	print_r($utweets);	
	foreach ($utweets->statuses as $res) {
		echo $res;
		
	}
?>