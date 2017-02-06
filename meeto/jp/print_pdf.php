<?php
error_reporting(0);
ini_set('error_reporting', 0);
ini_set('display_errors', 0);
session_start();

date_default_timezone_set('Asia/Kolkata');

define('DB_HOST', 'jobmatch1.db.12566969.hostedresource.com');
define('DB_USERNAME', 'jobmatch1');
define('DB_PASSWORD', 'Job@1234');
define('DB_NAME', 'jobmatch1');
define('APPROVED', 'approved');
define('PENDING', 'pending');
$con = mysql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD);
mysql_select_db(DB_NAME,$con) or die(mysql_error());
require('../mypdf/fpdf.php');
class PDF extends FPDF
{
	// Simple table
function BasicTable($header,$data)
{
	foreach($header as $col)
        $this->Cell(190,12,$col,1);
    $this->Ln();
	$this->Ln();
    foreach($data as $row)
    {
        foreach($row as $col)
		{
            $this->Cell(60,10,$col,0);
			
		}
        $this->Ln();
    }
	$this->Ln();
	for($i=0;$i<=58;$i++)
{
	$hd.="\t";
}
$hd.='Thank You';
	$this->Cell(190,12,$hd,1);
}

}

if($_GET['tp']=='download') {
$pdf = new PDF();

$bookedtiket=mysql_fetch_array(mysql_query("select * from seminar_booking where id=$_REQUEST[bkid]"));

 $bookedseminar=mysql_fetch_array(mysql_query("select * from seminar where id=$_REQUEST[sem_id]"));
$nam=$_SESSION['fname'].$_SESSION['lname'];
for($i=0;$i<=60;$i++)
{
	$hd.="\t";
}
$hd.='Meeto';
$header = array($hd);
$pdfdata = array(array('User Name :',$nam),
				array('Seminar Title :',$bookedseminar['title']),
				array('Seminar From Date :',$bookedtiket['from_date']),
				array('To Date :',$bookedtiket['to_date']),
				array('Total Book Seat :',$bookedtiket['book_seat']),
				array('Booking No. :',$bookedtiket['booking_no']),
			);
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->BasicTable($header,$pdfdata);
$pdf->Output();
}
?>
