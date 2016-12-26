<?php

if(isset($_POST["d"]))
{
  $data = $_POST['d'];
  $filename = "Tweets.json";
  file_put_contents($filename, $data);
/*
  if (file_exists($filename)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="'.basename($filename).'"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($filename));
      readfile($filename);
      exit;
  }*/
}


?>
