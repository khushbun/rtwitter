<?php 
require('assets/lib/fpdf.php');
$a=$_GET['a'];
echo "hello".$a;
$a="Hello World!";
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,$a);
$pdf->Output();
?>
