<?php
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
/*if(isset($_REQUEST['printnew']) && $_REQUEST['printnew']='Print')
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
*/
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

<table width="640" cellpadding="0" style="font-size: 8px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #555; box-sizing: border-box;">
	<tr>
		<td>
			<table cellpadding="5" cellspacing="5">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td><h4>//DELIVERY ADDRESS//</h4></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td width="78%"><h3>JAYESH PATEL</h3></td>
								<td width="22%" align="right"><h1>180/DDN</h1></td>
							</tr>
							<tr>
								<td><font size="7">42, RAM NAGAR SOC2, A K ROAD, VARACHHA, SURAT<br>
										<b>CITY </b>SURAT<b> / </b> <b>STATE </b>GUJARAT<br>
										<b>PIN </b> 395006<br>
										<b>MOBILE NO </b>1234567890
									</font>
								</td>
								<td>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="border-top:2px solid #333; border-bottom:2px solid #333;">
							<tr>
								<td><h3 align="center">GO JAVAS</h3></td>
								<td><h3>CASH ON DELIVERY</h3></td>
							</tr>
							<tr>
								<td colspan="2"><img src="http://www.sopingkart.com/inc/image/barcode.png"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="border-bottom:2px solid #333;">
							<tr>
								<td>
									<table align="center" valign="middle">
										<tr>
											<th width="45%"><b>ITEM NAME AND SKU</b></th>
											<th width="10%"><b>QTY</b></th>
											<th width="25%"><b>VALUE PER QTY</b></th>
											<th width="20%"><b><font size="9">COLLECT</font></b></th>
										</tr>
										<br/>
										<tr valign="middle">
											<td valign="middle" style="border-right:1px solid #333;">Gruhini Mart Yellow Faux Georgette Lehenga(Size: Free-Size)<br>yellowcholi</td>
											<td style="border-right:1px solid #333;">1</td>
											<td style="border-right:1px solid #333;">1599</td>
											<td><b><font size="9">Rs.1599.0</font></b></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<font size="6">Seller TIN No. - 12345678901<b> | </b>Shipping Charges Rs. 0<b> | </b>COD Charges Rs. 0</font>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="border-bottom:2px solid #333;">
							<tr>
								<td><h3 align="center">// SNAPDEAL REFERENCE NO. //</h3></td>
							</tr>
							<tr>
								<td colspan="2"><img src="http://www.sopingkart.com/inc/image/barcode.png"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="font-size:10px;">
							<tr>
								<td>
									<b>//SHIPPER ADDRESS//</b>
								</td>
								<td align="right">
									<b>GRUHINI MART</b><br>
									18, rupali soc3, a k road,varachha<br>
									Surat, Gujarat - 395006
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="border-top:1px solid #333;">
							<tr>
								<td align="right">
									<font size="9">ordered via <b>snapdeal.com</b></font>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td border="1">
									<font align="center" size="11"><b>LOGISTICS FORMS NEEDED FOR TRANSIT</b></font>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
			
		<td>
			<table cellpadding="1" cellspacing="5">
				<tr>
					<td style="border-top:1px solid #333; border-bottom:1px solid #333;">
						<table cellpadding="5">
							<tr>
								<td>
									<h4 align="center">RETAIL INVOICE</h4>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<font size="7"><b>INVOICE NUMBER : </b>G5M712/12-15/257</font>
								<br>
									<font size="7"><b>INVOICE DATE : </b>22-MAR-2016</font>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #333; border-bottom:1px solid #333;">
						<table cellpadding="5" cellspacing="0">
							<tr>
								<td style="border-right:1px solid #333;">
									<font size="10"><b>SELLER</b></font><br>
									<font size="9"><b>GRUHINI MART</b></font><br>
									<font size="7">18,RUPALI SOC3,A K ROAD,VARACHHA<br>
										<b>CITY </b>SURAT<b> / </b> <b>STATE </b>GUJARAT<br>
										<b>PIN </b> 395006<br>
										<b>COMPANY'S VAT TIN: </b>12345678901<br>
										<b>COMPANY'S CST NO: </b>12345678901
									</font>
								</td>
								<td>
									<font size="10"><b>BUYER</b></font><br>
									<font size="9"><b>JAYESH PATEL</b></font><br>
									<font size="7">42, RAM NAGAR SOC2, A K ROAD, VARACHHA, SURAT<br>
										<b>CITY </b>SURAT<b> / </b> <b>STATE </b>GUJARAT<br>
										<b>PIN </b> 395006<br>
										<b>MOBILE NO </b>1234567890
									</font>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<font size="7"><b>DISPATCHED VIA : </b>GO JAVAS</font>
								<br>
									<font size="7"><b>DISPATCHED DOC. NO.(AWB) : </b>WIKIPEDIA39</font>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #333; border-bottom:1px solid #333;">
						<table align="center">
						
							<tr>
								<th width="10%"><b>S.NO.</b></th>
								<th width="50%" style="border-left:1px solid #333;"><b>ITEM DESCRIPTION</b></th>
								<th width="10%" style="border-left:1px solid #333;"><b>QTY</b></th>
								<th width="15%" style="border-left:1px solid #333;"><b>RATE</b></th>
								<th width="15%" style="border-left:1px solid #333;"><b>AMOUNT</b></th>
							</tr>
							
							<tr>
								<td>1</td>
								<td align="left" style="border-left:1px solid #333;">GRUHINI MART YELLOW FAUX GEORGETTE LEHENGA ATTRIBUTE SIZE: FREE-SIZE<BR>ORDER NO.: 123456789<BR> SUBORDER NO.: 123456789</td>
								<td style="border-left:1px solid #333;">1</td>
								<td style="border-left:1px solid #333;">1599.0</td>
								<td style="border-left:1px solid #333;">1599.0</td>
							</tr>
							
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table align="center" style="border-bottom:1px solid #333;">
							<tr>
								<td width="85%"><font size="9">TOTAL</font></td>
								<td width="15%"><font size="9">RS.1599</font></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td><font size="6"><b>AMOUNT IN WORDS: ONE THOUSAND FIVE HUNDRED NINETY NINE ONLY</b></font></td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0">
							<tr style="padding:0; margin:0;">
								<td>
									<h3 style="margin-bottom:-1px;">DECLARATION</h3>
									We declare that this invoice shows actual price of goods described inclusive of taxes and that all particulars are true and correct.
									<h3>CUSTOMER ACKNOWLEDGEMENT</h3>
									I JAYESH PATEL hereby confirm that the above side product/s are being purchased for my internal/personal consumption and not for re-sale.
									<br>
										<h4 style="font-size:7px; border-top:1px solid #333; border-bottom:1px solid #333;"><b>THIS IS THE COMPUTER GENERATED INVOICE AND DOES NOT REQUIRE SIGNATURE</b></h4>
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
	/*	$c++;
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

?>