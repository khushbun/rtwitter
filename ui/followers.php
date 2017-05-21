<?php
	session_start();
	echo "hii".$_SESSION['test'];

	$conn = $_SESSION['connection'];
	$utweets = $connection->get('search/tweets',["q" =>'17_harshil']);
	print_r($utweets);	
	foreach ($utweets->statuses as $res) {
		echo $res;
		
	}
?>