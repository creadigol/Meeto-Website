<?php
//ob_start();
//session_start();
include('connect.php');

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
if(isset($_REQUEST['printnew']) && $_REQUEST['printnew']='Print')
{
	if(isset($_REQUEST['print']))
	{
		//$print = $_REQUEST['print'];
		//mysql_query("update order_detail set Order_status='Pack' where Ord_dt_id='".$print."'");
		//header("Location: tcpdf-master/tcpdf-master/examples/example_061.php?id='".$print."' ");
		$count=0;
		foreach($_REQUEST['print'] as $print)
		{
			$printinv[]=$print;
			$count++;
		}
		$c=0; 
		while($c<$count)
		{
			mysql_query("update order_detail set Order_status='Pack' where Ord_dt_id='".$printinv[$c]."'");
			
			
		
		//header("Location: tcpdf-master/tcpdf-master/examples/example_061.php?id='".$printinv[0]."'");
//echo "Number of Items in the cart = ".sizeof($_SESSION['invoice'])." <a href=cart-remove-all.php>Remove all</a><br>";
//while (list ($key, $val) = each ($_SESSION['invoice'])) { 
 
	//echo "$key ->  <br>"; 
$id = $printinv[$c];//$_GET['id'];
$id1 = explode("'",$id);

$qry = mysql_query("select * from order_detail where Ord_dt_id = '".$id1[0]."' ");
$qryrw = mysql_fetch_array($qry);
$Qtity = $qryrw['Qtity'];
$Unit_price = $qryrw['Unit_price'];
$total=$Unit_price*$Qtity; 

$qry2 = mysql_query("select * from corder where Order_id = '".$qryrw['Order_id']."'");
$qryrw2 = mysql_fetch_array($qry2);
$date = strtotime($qryrw2['Date']);
$dt1 = date('d-M-Y', $date );
$type = $qryrw2['Payment_type'];
$cbillid = $qryrw2['cbillid'];
$Payment_type = $qryrw2['Payment_type'];
$Shipping_charge = $Qtity*100; //$qryrw2['Shipping_charge'];
$Payment_amount = $total+$Shipping_charge;//$qryrw2['Payment_amount'];

$qry3 = mysql_query("select * from seller where Seller_id = '".$qryrw['Seller_id']."'");
$qryrw3 = mysql_fetch_array($qry3);
$SAddress = $qryrw3['Address'];

$qry4 = mysql_query("select * from product where Prd_id = '".$qryrw['Prd_id']."'");
$qryrw4 = mysql_fetch_array($qry4);
$PName = $qryrw4['Name'];

$qry5 = mysql_query("select * from customer_bill where billid = '".$cbillid."'");
$qryrw5 = mysql_fetch_array($qry5);
$Bfname = $qryrw5['fname'];
$Blname = $qryrw5['lname'];
$pincode = $qryrw5['pincode'];
$BAddress1 = $qryrw5['address1'];
$BAddress2 = $qryrw5['address2'];

$qry9 = mysql_query("select * from country where Cnt_id = '".$qryrw5['country']."'");
$qryrw9 = mysql_fetch_array($qry9);
$CBname = $qryrw9['Country'];

$qry10 = mysql_query("select * from state where Stid = '".$qryrw5['state']."'");
$qryrw10 = mysql_fetch_array($qry10);
$SBname = $qryrw10['State'];

$qry6 = mysql_query("select * from seller_company where seller_id = '".$qryrw3['Seller_id']."'");
$qryrw6 = mysql_fetch_array($qry6);
$cdname = $qryrw6['cdisplay_name'];

$qry7 = mysql_query("select * from country where Cnt_id = '".$qryrw3['Country']."'");
$qryrw7 = mysql_fetch_array($qry7);
$Cname = $qryrw7['Country'];

$qry8 = mysql_query("select * from state where Stid = '".$qryrw3['State']."'");
$qryrw8 = mysql_fetch_array($qry8);
$Sname = $qryrw8['State'];

// add a page
$pdf->AddPage();

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

<table width="640" cellpadding="20" style="border:1px solid #eee; box-shadow:0 0 10px rgba(0,0,0,0.15); font-size: 15px; line-height: 24px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #555; box-sizing: border-box;">
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table cellpadding="10" cellspacing="10">
							<tr>
								<td>
									<table cellspacing="0">
										<tr>
											<td>
												<img src="http://sopingkart.com/inc/image/payment-logo.png" style="width:250px;">
											</td>
											<td align="right">
												Invoice No. :  $id1[1] <br> 
												Order Date : $dt1 <br>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<table cellpadding="10" cellapacing="10">
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0">
										<tr>
											<td>
												$cdname <br>
												$SAddress <br>
												$Sname, <br>
												$Cname.
											</td>
											
											<td align="right">
												$Bfname $Blname,<br>
												$BAddress1<br>
												$BAddress2, $pincode.<br>
												$SBname, $CBname.<br>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<table cellpadding="" cellspacing="10">
							<tr>
								<td>
									<table>
										<tr>
											<td>
												<table cellpadding="6">
													<tr>
														<td bgcolor="#eee" height="" valign="center" style="border-bottom: 1px solid #ddd; font-weight: bold;">
															Payment Method
														</td>
														<td bgcolor="#eee" style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #ddd; font-weight: bold;">
															$Payment_type
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<table cellspacing="7">
										<tr>
											<td>
												<table cellpadding="6">
													<tr>
														<td>
															
														</td>
														
														<td valign="top" align="right">
															
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<table cellpadding="" cellspacing="10">
							<tr>
								<td>
									<table>
										<tr>
											<td>
												<table cellpadding="6">
													<tr>
														<td bgcolor="#eee" height="" valign="center" style="border-bottom: 1px solid #ddd; font-weight: bold;">
															Item
														</td>
														<td bgcolor="#eee" style="padding: 5px; vertical-align: top; text-align: center; border-bottom: 1px solid #ddd; font-weight: bold;">
															Quantity
														</td>
														<td bgcolor="#eee" style="padding: 5px; vertical-align: top; text-align: center; border-bottom: 1px solid #ddd; font-weight: bold;">
															Price
														</td>
														<td bgcolor="#eee" style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #ddd; font-weight: bold;">
															Total Amount
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<table cellspacing="7">
										<tr>
											<td>
												<table cellpadding="6">
													<tr>
														<td style="border-bottom: 1px solid #ddd;">
															$PName
														</td>
														<td align="center" style="border-bottom: 1px solid #ddd;">
															$Qtity
														</td>
														<td align="center" style="border-bottom: 1px solid #ddd;">
															$Unit_price
														</td>
														<td align="right" style="border-bottom: 1px solid #ddd;">
															$total 
														</td>
													</tr>
													<tr>
														<td style="border-bottom: 1px solid #ddd;">
															Shipping Charge
														</td>
														<td align="center" style="border-bottom: 1px solid #ddd;"></td>
														<td align="center" style="border-bottom: 1px solid #ddd;"></td>
														<td align="right" style="border-bottom: 1px solid #ddd;">
															$Shipping_charge
														</td>
													</tr>
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td align="right" style="font-weight:bold;">
															Total: $Payment_amount
															
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
		$c++;
		//}
	}
}

}
//ob_end_flush();
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_061.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>