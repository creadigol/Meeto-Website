<?php
error_reporting(0);
ini_set('error_reporting', 0);
ini_set('display_errors', 0);
session_start();

date_default_timezone_set('Asia/Tokyo');

define('DB_HOST', 'jobmatch1.db.12566969.hostedresource.com');
define('DB_USERNAME', 'jobmatch1');
define('DB_PASSWORD', 'Job@1234');
define('DB_NAME', 'jobmatch1');
define('APPROVED', 'approved');
define('PENDING', 'pending');
$con = mysql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD);
mysql_select_db(DB_NAME,$con) or die(mysql_error());
if($_SESSION['jpmeetou']['email']==''){
	echo "<script>window.location='../../index.php';</script>";
}


//ob_start();
//session_start();
//include('connect.php');
//ob_start();
//session_start();
//include('connect.php');

//============================================================+
// File name   : example_061.php
// Begin       : 2010-05-24
// Last Update : 2014-01-25
//
// Description : Example 061 for TCPDF class
//               XHTML + CSS
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: XHTML + CSS
 * @author Nicola Asuni
 * @since 2010-05-25
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Meeto');
$pdf->SetTitle('Meeto Ticket');
$pdf->SetSubject('Ticket Booking Details');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 049', PDF_HEADER_STRING);
$pdf->SetHeaderData("header_logo.png", "20", "Meeto", "Meeto a seminar booking platform.");

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();
$bookedtiket=mysql_fetch_array(mysql_query("select * from seminar_booking where id=$_REQUEST[bkid]"));
$bookedseminar=mysql_fetch_array(mysql_query("select * from seminar where id=$_REQUEST[sem_id]"));
$title=$bookedseminar['title'];
$name=$_SESSION['jpmeetou']['fname'].$_SESSION['jpmeetou']['lname'];
$ffdate=date("d-m-Y",$bookedtiket['from_date']/1000);
$ttdate=date("d-m-Y",$bookedtiket['to_date']/1000);
$total_book_seat=$bookedtiket['book_seat'];
$booking_no=$bookedtiket['booking_no'];
/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */
// define some HTML content with style
$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<h2>Tickets Details:</h2>
<table border="1" cellpadding="4" style="width:60%;">
	<tr>
		<th><strong>Details</strong></th>		
		<th><strong>Details</strong></th>
	</tr>
	<tr>
		<td>Name</td>
		<td>$name</td>	
	</tr>
	<tr>
		<td>Seminar Title</td>
		<td>$title</td>	
	</tr>
	<tr>
		<td>Seminar From Date</td>
		<td>$ffdate</td>	
	</tr>
	<tr>
		<td>To Date</td>
		<td>$ttdate</td>	
	</tr>
	<tr>
		<td>Total Book Seat</td>
		<td>$total_book_seat</td>	
	</tr>
	<tr>
		<td>Booking No.</td>
		<td>$booking_no</td>	
	</tr>
	
</table>
</br>



	<div style="background-color:#337ab7; border: 1px solid #000; color: #fff;  line-height:35px;text-align:center;border-radius:5px 5px 0 0;"><strong>Thank You</strong>	
	</div>

EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
		/*$c++;
		//}
	}
}

}*/
//ob_end_flush();
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('print_pdf.pdf	', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>