<?php 
session_start();
require 'vendor/autoload.php';
// 946809333321-k3v94qcjogi8upu5un8sg5534o4cst17.apps.googleusercontent.com === clientid


// HXrV31w86cO2LGDjI-LeDfvt == clientsecret
// echo "hii";
$fileMetadata = new Google_Service_Drive_DriveFile(array(
  'name' => 'My Report',
  'mimeType' => 'application/vnd.google-apps.spreadsheet'));
$content = file_get_contents('files/test.csv');
$file = $driveService->files->create($fileMetadata, array(
  'data' => $content,
  'mimeType' => 'text/csv',
  'uploadType' => 'multipart',
  'fields' => 'id'));
// printf("File ID: %s\n", $file->id);

?>

