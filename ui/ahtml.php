<?php 
$a=$_GET['a'];
echo "hello".$a;
$filename = "tweets.txt";
$fp = fopen('php://output', 'w');
$result =$a;
header('Content-type: application/txt');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);
$result = $a;

?>
