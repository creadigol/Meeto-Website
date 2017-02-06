<?php
error_reporting(0);
require('lib/fpdf/fpdf.php');

class PDF extends FPDF
{
	// Simple table
function BasicTable($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

}

if($_GET['tp']=='download') {
$pdf = new PDF();
$header = array('ID', 'Product Name', 'Price (Rs)');
$data = array(
	          array('1', 'Item-1', '5000'),
	          array('2', 'Item-2', '1200'),
	          array('3', 'Item-3', '1800'),
	         );
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->Output();
}
?>

<h4>Product Summary</h4>
<table border=1>
<tr><th>ID</th><th>Product Name</th><th>Price (Rs)</th></tr>
<tr><td>1</td><td>Item-1</td><td>5000</td></tr>
<tr><td>2</td><td>Item-2</td><td>1200</td></tr>
<tr><td>3</td><td>Item-3</td><td>1800</td></tr>
</table>
<h3><a href="index.php?tp=download">DOWNLOAD PDF</a></h3>