<?php
session_start();
error_reporting(0);
include('../../../db_hrtracker.php');
if($_SESSION['email']==''){
	echo "<script>window.location='../../../login.php';</script>";
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
$pdf->SetAuthor('?Drivehere HR-Tracker');
$pdf->SetTitle('Employee Work History');
$pdf->SetSubject('Employee Work History');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE , PDF_HEADER_STRING);

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
$result=mysql_fetch_array(mysql_query("select * from user where id='".$_REQUEST['id']."' "));
$user_id=$_REQUEST['id'];
$name=$result['name'];
$email=$result['email'];
$phone=$result['phone_number'];
$whour=$result['hours_by_type'];
$wsalary=$result['hourly_salary'];
$ot_hour=$result['hours_of_ot'];
$ot_salary=$result['ot_salary'];
$company=$result['company_code'];
$start_date=$_REQUEST['sdate'];
$end_date=$_REQUEST['edate'];
$wh=mysql_query("select * from work_hour where date>='".$start_date."' AND date<='".$end_date."' and user_id='".$user_id."'");

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
<h2>Employee Details:</h2>
<table border="1" cellpadding="4" style="width:60%;">
	<tr>
		<th><strong>Parameter</strong></th>		
		<th><strong>Details</strong></th>
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

<h2>Work History:</h2>

	<div style="background-color:#337ab7; border: 1px solid #000; color: #fff;  line-height:35px;text-align:center;border-radius:5px 5px 0 0;"><strong>Work Report : </strong>$start_date to  $end_date			
	</div>

EOF;
$tableh = <<<EOF
<table cellpadding="5" style="border: 1px solid black; width=100%" >
EOF;
$header= <<<EOF
	<tr>
			<th style="border: 1px solid black; border-collapse: collapse; text-align: center;"><strong>Day</strong></th>
			<th style="border: 1px solid black; border-collapse: collapse; text-align: center;"><strong>Date</strong></th>
			<th style="border: 1px solid black; border-collapse: collapse; text-align: center;"><strong>Time In</strong></th>
			<th style="border: 1px solid black; border-collapse: collapse; text-align: center;"><strong>Time Out</strong></th>			
			<th style="border: 1px solid black; border-collapse: collapse; text-align: center;"><strong>Working Hours</strong></th>			
		</tr>
EOF;

		$totalwh=0;
		$totalwhpw=0;
		$t=0;

		while($whrow=mysql_fetch_array($wh))
		{
				
			$day = date('l', strtotime($whrow['date']));
			$date=$whrow['date'];
			$in_time =$whrow['checkin_time'];
			$out_time = $whrow['checkout_time'];
			$total_time = gmdate("H:i:s", $whrow['working_hour']);
			
		
$row =$row.<<<EOF
			<tr>
				<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">$day </td>
				<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">$date </td>
				<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">$in_time </td>
				<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">$out_time </td>
				<td style="border: 1px solid black; border-collapse: collapse; text-align: center;">$total_time </td>			
			</tr>	
EOF;
		$totalwh=$totalwh+$whrow['working_hour'];
		$t++;
		}
$tablef= <<<EOF
</table>
</br>
EOF;
$total_weekly=0;
	    $total_OT=0;	
		
		$end_date = strtotime($end_date);
		
		for($i = strtotime('Monday this week', strtotime($start_date)); $i <= $end_date; $i = strtotime('+1 week', $i))
		{			
			$work_hour=$result['hours_by_type'];
			$work_hour = (int)($work_hour * 3600);
			$weekly_work=0;	
			$ot_hour=0;		
			
			$sd1=date('Y-m-d', $i);
			$ed1=date("Y-m-d", strtotime('sunday this week', strtotime($sd1)));   
			$wh1=mysql_query("select * from work_hour where date BETWEEN '".$sd1."' AND '".$ed1."' and user_id = '".$user_id."'");
			//echo "<br>select * from work_hour where date BETWEEN '".$sd1."' AND '".$ed1."' and user_id = '".$user_id."'"; 
			
			
			while($whrow1=mysql_fetch_array($wh1))
			{
				//echo "<br>".$work_hour=$whrow1['working_hour'];
				$weekly_work=$weekly_work+$whrow1['working_hour'];
			
			}
			$weekly_work;
						
			if($weekly_work > $work_hour)
			{	
				//If total work > allowed work
				//Calculate OT hours
				$ot_hour= $weekly_work-$work_hour;
				$h2 = (int)($ot_hour / 3600);
				$m2 = (int)(($ot_hour - $h2*3600) / 60);
				//echo "<br>".$h2."h:".$m2."m";	
				
				//Calculate Total work hours
				$weekly_work = $result['hours_by_type'];
				$weekly_work = (int)($weekly_work * 3600);
				$h1 = (int)($work_hour / 3600);
				$m1 = (int)(($work_hour - $h1*3600) / 60);
				//echo "<br>".$h1."h:".$m1."m";
			}
			else
			{
				//Calculate OT hours
				$h2 = 0;
			    $m2 = 0;
			   // echo "<br>".$h2."h:".$m2."m";
			   
			    //Calculate Total work hours
				$h1 = (int)($weekly_work / 3600);
				$m1 = (int)(($weekly_work - $h1*3600) / 60);
				//echo "<br>".$h1."h:".$m1."m";
			}		
			
			//Total worked hour and OT hour between start date and end date	
			$total_weekly=$total_weekly+$weekly_work;
			$total_OT=$total_OT+$ot_hour;
			
			//Total hour (work+OT)	
			$total = $total_weekly + $total_OT;
			
		}
//calculate total worked hour
$h3 = (int)($total_weekly / 3600);
$m3 = (int)(($total_weekly - $h3*3600) / 60);

//calculate total OT hour
$h4 = (int)($total_OT / 3600);
$m4 = (int)(($total_OT - $h4*3600) / 60);

//calculate total hours
$h5 = (int)($total / 3600);
$m5 = (int)(($total - $h5*3600) / 60);

//calculate salary
$work_totals = (int)($h3*$result['hourly_salary']+ceil(($m3*$result['hourly_salary'])/60));
$OT_totals = (int)($h4*$result['ot_salary']+ceil(($m4*$result['ot_salary'])/60));
$total_salary=$work_totals+$OT_totals;
	
$Content=<<<EOF
<br><br>
<table border="1" cellpadding="5" style="text-align:center;">
				<tr valign="center">
					<th bgcolor="#337ab7" style="width:70px;"><center>Working Hours</center></th>					
					<th bgcolor="#337ab7" style="width:70px;">OT Hours</th>
					<th bgcolor="#337ab7" style="width:70px;">Total Hours</th>
					<th bgcolor="#337ab7" style="width:150px;">Working Hours Earning</th>
					<th bgcolor="#337ab7" style="width:150px;">OT Hours Earning</th>
					<th bgcolor="#337ab7" style="width:150px;">Total Earning <br> (Work+ +OT)</th>
				</tr>				
				<tr>
					<td style="width:70px;"><center>$h3 h: $m3 m</center></td>
					<td style="width:70px;">$h4 h: $m4 m</td>
					<td style="width:70px;">$h5 h: $m5 m</td>
					<td style="width:150px;">$h3*$$wsalary+($m3 *$ $wsalary)/60<br>=$$work_totals</td>
					<td style="width:150px;">$h4*$$ot_salary+($m4*$$ot_salary)/60<br>=$$OT_totals</td>
					<td style="width:150px;">$$work_totals+$$OT_totals<br>=$$total_salary</td>
				</tr>				
</table>
</div>
 	<div style="margin-top:100px;">   
		<div style="width:50%; float:left;">
		Employee signature : ______________________<br>Date:
		</div>
		<br> 
		<div style="width:50%; float:right;">
		Manager signature : _______________________<br>Date:
		</div>
	</div>
EOF;
$html=$html." ".$tableh." ".$header." ".$row." ".$tablef." ".$Content;

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
$pdf->Output('Employee Work History.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>