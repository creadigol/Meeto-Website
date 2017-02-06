<?php
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
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
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 061');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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
/*$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<h1>HTML Example</h1>
Some special characters: &lt; € &euro; &#8364; &amp; è &egrave; &copy; &gt; \\slash \\\\double-slash \\\\\\triple-slash
<h2>List</h2>
List example:
<ol>
	<li><img src="images/logo_example.png" alt="test alt attribute" width="30" height="30" border="0" /> test image</li>
	<li><b>bold text</b></li>
	<li><i>italic text</i></li>
	<li><u>underlined text</u></li>
	<li><b>b<i>bi<u>biu</u>bi</i>b</b></li>
	<li><a href="http://www.tecnick.com" dir="ltr">link to http://www.tecnick.com</a></li>
	<li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.<br />Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</li>
	<li>SUBLIST
		<ol>
			<li>row one
				<ul>
					<li>sublist</li>
				</ul>
			</li>
			<li>row two</li>
		</ol>
	</li>
	<li><b>T</b>E<i>S</i><u>T</u> <del>line through</del></li>
	<li><font size="+3">font + 3</font></li>
	<li><small>small text</small> normal <small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal</li>
</ol>
<dl>
	<dt>Coffee</dt>
	<dd>Black hot drink</dd>
	<dt>Milk</dt>
	<dd>White cold drink</dd>
</dl>
<div style="text-align:center">IMAGES<br />
<img src="images/logo_example.png" alt="test alt attribute" width="100" height="100" border="0" /><img src="images/tcpdf_box.svg" alt="test alt attribute" width="100" height="100" border="0" /><img src="images/logo_example.jpg" alt="test alt attribute" width="100" height="100" border="0" />
</div>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// output some RTL HTML content
$html = '<div style="text-align:center">The words &#8220;<span dir="rtl">&#1502;&#1494;&#1500; [mazel] &#1496;&#1493;&#1489; [tov]</span>&#8221; mean &#8220;Congratulations!&#8221;</div>';
$pdf->writeHTML($html, true, false, true, false, '');

// test some inline CSS
$html = '<p>This is just an example of html code to demonstrate some supported CSS inline styles.
<span style="font-weight: bold;">bold text</span>
<span style="text-decoration: line-through;">line-trough</span>
<span style="text-decoration: underline line-through;">underline and line-trough</span>
<span style="color: rgb(0, 128, 64);">color</span>
<span style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">background color</span>
<span style="font-weight: bold;">bold</span>
<span style="font-size: xx-small;">xx-small</span>
<span style="font-size: x-small;">x-small</span>
<span style="font-size: small;">small</span>
<span style="font-size: medium;">medium</span>
<span style="font-size: large;">large</span>
<span style="font-size: x-large;">x-large</span>
<span style="font-size: xx-large;">xx-large</span>
</p>';

$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();*/

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// add a page
$pdf->AddPage();
include('../../../db_hrtracker.php');
$result=mysql_fetch_array(mysql_query("select * from user where id='".$_REQUEST['id']."' "));
$user_id=$_REQUEST['id'];
$name=$result['name'];
$email=$result['email'];
$phone=$result['phone_number'];
$whour=$result['hours_by_type'];
$wsalary=$result['hourly_salary'];
$ot_hour=$result['hours_of_ot'];
$ot_salary=$result['hourly_salary'];
$company=$result['company_code'];
$start_date=$_REQUEST['sdate'];
$end_date=$_REQUEST['edate'];
$wh=mysql_query("select * from work_hour where date BETWEEN '".$start_date."' AND '".$end_date."' and user_id = '".$user_id."'");

// create some HTML content
//$subtable = '<table border="1" cellspacing="6" cellpadding="4"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>';
//$subtable = '<table border="1" cellspacing="6" cellpadding="4"><tr><td>Start Date</td><td>2016-05-10</td></tr><tr><td>End Date</td><td>2016-05-19</td></tr></table>';

$html = <<<EOF
<h2>Employee Details:</h2>
<table border="1" cellspacing="3" cellpadding="4" style="width:60%;">
	<tr>
		<th>Parameter</th>		
		<th>Details</th>
	</tr>
	<tr>
		<td>Name</td>
		<td>$name</td>	
	</tr>
	<tr>
		<td>Email</td>
		<td>$email</td>	
	</tr>
	<tr>
		<td>Phone</td>
		<td>$phone</td>	
	</tr>
	<tr>
		<td>Work Hour</td>
		<td>$whour hours</td>	
	</tr>
	<tr>
		<td>Hourly Salary</td>
		<td>$wsalary $</td>	
	</tr>
	<tr>
		<td>OT Hour</td>
		<td>$ot_hour hours</td>	
	</tr>
	<tr>
		<td>OT Hourly Salary</td>
		<td>$ot_salary $</td>	
	</tr>
	<tr>
		<td>Company Code</td>
		<td>$company</td>	
	</tr>	
</table>
</br>
EOF;

$header = <<<EOF
<h2>Work History:</h2>
<div style="margin-bottom: 20px; height: 41px; background-color: #fff; width: 100%;  height: 20px; " >
	<div style="background-color:#337ab7; border-color: #337ab7; color: #fff; padding: 10px 15px;"><strong>Work Report : </strong>$start_date to  $end_date			
	</div>
<div>
EOF;

$table_begin = <<< EOF
<table cellpadding="5" style="margin-left:10px; border: 1px solid black;" >
EOF;

$static = <<<EOF
		<tr>
			<th style="border: 1px solid black; border-collapse: collapse; text-align: center;"><strong>Day</strong></th>
			<th style="border: 1px solid black; border-collapse: collapse; text-align: center;"><strong>Date</strong></th>
			<th style="border: 1px solid black; border-collapse: collapse; text-align: center;"><strong>Time In</strong></th>
			<th style="border: 1px solid black; border-collapse: collapse; text-align: center;"><strong>Time Out</strong></th>			
			<th style="border: 1px solid black; border-collapse: collapse; text-align: center;"><strong>Working Hours</strong></th>			
		</tr>
EOF;

$table_end = <<<EOF
		</table>
	</div>	
EOF;	
		
$table_begin2 = <<<EOF  
   <table cellpadding="5" style="margin-left:10px; border: 1px solid black;">
EOF;

$dynamic = <<<EOF
			<tr>
				<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">Monday</td>
				<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">2016-03-01</td>
				<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">14:48:25</td>
				<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">14:48:30</td>
				<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">00:00:05</td>			
			</tr>	
EOF;

$table_end2 = <<<EOF
	</table>
EOF;	

$total = <<<EOF
<table border="1" cellpadding="5">
				<tbody>
				<tr>
					<th bgcolor="#337ab7">Total Working Hours</th>					
					<th bgcolor="#337ab7">Total OT Hours</th>
					<th bgcolor="#337ab7">Total  Hours</th>
					<th bgcolor="#337ab7">Total Working Hours Earning</th>
					<th bgcolor="#337ab7">Total OT Hours Earning</th>
					<th bgcolor="#337ab7">Total Earning (work+ +OT)</th>
				</tr>				
				<tr>
					<td>1h:6m</td>
					<td>0h:0m</td>
					<td>1h:6m</td>
					<td>1*$10+(6*$10)/60 = $11</td>
					<td>0*$+(0*$)/60 = $0</td>
					<td> $10 + $0 = $10</td>
				</tr>				
				</tbody>
</table>
	</div>
   <div style="margin-top:100px;">   
		<div style="width:50%; float:left;">
		Employee signature : ______________________<br>Date:
		</div>
		 
		<div style="width:50%; float:right;">
		<p>Manager signature : _______________________<br>Date:</p>
		</div>
	</div>	

EOF;

$test="hello";
//$html=$html."".$test;
$html=$html.$header;
$html2=$table_begin.$static.$table_end;
$html3=$table_begin2.$dynamic.$table_end2;

$pdf->writeHTML($html2, true, false, true, false, '');
//$pdf->writeHTML($html2, true, false, true, false, '');
//$pdf->writeHTML($html3, true, false, true, false, '');
//$pdf->writeHTML($total, true, false, true, false, '');
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
$pdf->Output('example_061.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
