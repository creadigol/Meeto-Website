<?php
session_start();
error_reporting(0);
include('../../db.php');
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
$pdf->SetFont('cid0jp', '', 14);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Meeto');
$pdf->SetTitle('Meeto 予約');
$pdf->SetSubject('Ticket 予約の詳細');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData("../../../img/header_logo.png", "20", "Meeto", " Meeto Seminar Booking Platform.");

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont("dejavusans");
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)

	require_once('lang/jpn.php');
	$pdf->setLanguageArray($l);

// ---------------------------------------------------------
function translate1($text)
{
		if(preg_match('/^[a-zA-Z+0-9-,?\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]*$/',$text))
		{
			return $data = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=ja&dt=t&q=$text");
		}
		else
		{
			return '[[["'.$text;
		}
}
// set font



// add a page
$pdf->AddPage();
$bookedtiket=mysql_fetch_array(mysql_query("select * from seminar_booking where id=$_REQUEST[bkid]"));
$bookedseminar=mysql_fetch_array(mysql_query("select * from seminar where id=$_REQUEST[sem_id]"));
$marutra = explode('"',translate1(str_replace(" ","+",$bookedseminar['title']))); 
$title=$marutra[1];
$marutra = explode('"',translate1(str_replace(" ","+",$_SESSION['jpmeetou']['fname'].$_SESSION['jpmeetou']['lname']))); 
$name=$marutra[1];

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
<h2>切符売場 細部:</h2>
<table border="1" cellpadding="4" style="width:60%;">
	<tr>
		<th><strong>細部 </strong></th>		
		<th><strong>細部 </strong></th>
	</tr>
	<tr>
		<td>名</td>
		<td>$name</td>	
	</tr>
	<tr>
		<td>セミナータイトル </td>
		<td>$title</td>	
	</tr>
	<tr>
		<td>日付からセミナー</td>
		<td>$ffdate</td>	
	</tr>
	<tr>
		<td>日にセミナー</td>
		<td>$ttdate</td>	
	</tr>
	<tr>
		<td>総ブックシート</td>
		<td>$total_book_seat</td>	
	</tr>
	<tr>
		<td>予約なし.</td>
		<td>$booking_no</td>	
	</tr>
	
</table>
</br>



	<div style="background-color:#337ab7; border: 1px solid #000; color: #fff;  line-height:35px;text-align:center;border-radius:5px 5px 0 0;"><strong>ありがとうございました</strong>	
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
$pdf->Output('print_pdf.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>