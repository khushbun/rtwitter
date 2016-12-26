<?php session_start();
echo $_SESSION['a'];
die();
$filename = "tweets.csv";
$fp = fopen('php://output', 'w');
$result =$a;
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);
$result = $a;
} ?>
