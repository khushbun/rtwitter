<?php

if(isset($_POST["d"]))
{
  $data = json_encode($_POST['d']);
  $filename = "Tweets.json";
  file_put_contents($filename, $data);

  if (file_exists($filename)) {
    
      header('Content-Type: application/json');
      header('Content-Disposition: attachment; filename='.$filename);
      readfile($filename);
      exit;
  }
}


?>
