<?php 
function download_file($a){
require('assets/lib/fpdf.php');
$a = unserialize($_POST['input_name']);
echo $a;
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,$a);
$pdf->Output();}
?>
