<?php

 function download() {
$filename = "toy_csv.csv";
$fp = fopen('php://output', 'w');

// $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='phppot_examples' AND TABLE_NAME='toy'";
$result = array
(
"Peter,Griffin,Oslo,Norway",
"Glenn,Quagmire,Oslo,Norway",
);
// while ($row = mysql_fetch_row($result)) {
// 	$header[] = $row[0];
// }	

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);

$result = array
(
"Peter,Griffin,Oslo,Norway",
"Glenn,Quagmire,Oslo,Norway",
);
}?>