<?php
	session_start();
	echo "hii".$_SESSION['test'].$_SESSION['access_token'];

	$conn = $_SESSION['connection'];
	$utweets = $connection->get('search/tweets',["q" =>'17_harshil']);
			
	foreach ($utweets->statuses as $res) {
		echo $res;
		
	}
?>