<?php
ob_start();
session_start();
require_once('../../../connection.php');
include('php-barcode-generator-master/src/BarcodeGenerator.php');
include('php-barcode-generator-master/src/BarcodeGeneratorPNG.php');
include('php-barcode-generator-master/src/BarcodeGeneratorSVG.php');
include('php-barcode-generator-master/src/BarcodeGeneratorHTML.php');
$generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();

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
$pdf->SetTitle('Cashtag Invoice');
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
			mysql_query("update order_detail set Order_status='Pack', modifydate = '".date("Y-m-d")."' where Ord_dt_id='".$printinv[$c]."'");
			
			
		
		//header("Location: tcpdf-master/tcpdf-master/examples/example_061.php?id='".$printinv[0]."'");
//echo "Number of Items in the cart = ".sizeof($_SESSION['invoice'])." <a href=cart-remove-all.php>Remove all</a><br>";
//while (list ($key, $val) = each ($_SESSION['invoice'])) { 
 
	//echo "$key ->  <br>"; 
$id = $printinv[$c];//$_GET['id'];
$id1 = explode("'",$id);
*/
$id=$_REQUEST['invoiceid'];
// add a page
$filename = "id.txt";
$myfile = fopen($filename, "w");
$txt = $_REQUEST['invoiceid'];
fwrite($myfile, $txt);
fclose($myfile);

$pdf->AddPage();
$html = file_get_contents('http://cashtag.co.in/mainadmin/tcpdf-master/tcpdf-master/examples/file1.php');

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
/*$html = <<<EOF

<!-- EXAMPLE OF CSS STYLE -->

<table ><tr><td style="margin-left:50px;" width="15%"><img src="http://www.sellxg.com/sellxg/images/logo.png" alt="Trendz" style="margin-top:-15px;" width="70px" ></td>
<td align="left" style="padding:15px;" width="60%"><br>
									<p><b>SELLXG <br>Office No.418,4th Floor, 
									Belgium Squre,Near Japan Market,
									Delhi Gate,Ring Road,
									Surat(Gujarat)-395007</b></p><br>
									<br>
								</td>
								<td><table padding-top:5px;><tr ><td width="80%" height="20px"  align="center" style="padding:1px;border:1px solid black;">$paid</td></tr></table></td>
</tr></table> 
<br>
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
								<td width="78%"><h3>$buyername[user_name]</h3></td>
								<td width="22%" align="right"><h1><!--180/DDN--></h1></td>
							</tr>
							<tr>
								<td><font size="7">$buyername[user_address]<br>
										<b>CITY </b>$buyername[city]<b> / </b> <b>STATE </b>$buyername[state]<br>
										<b>PIN </b> $buyername[pincode]<br>
										<b>MOBILE NO </b>$buyername[user_contactno]
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
							<!--<tr>
								<td><h3 align="center">Delhivery</h3></td>
								<td><h3>$type1</h3></td>
							</tr>
							<tr>
								<td colspan="2" align="center">$Trackbarcode</td>
							</tr>
							<tr>
								<td colspan="2" align="center" style="letter-spacing:3px;font-weight:bold;">$trackno</td>
							</tr>--> 
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
											<th width="10%"><b>ID</b></th>
											<th width="35%"><b>ITEM NAME</b></th>
											<th width="10%"><b>QTY</b></th>
											<th width="25%"><b>VALUE PER QTY</b></th>
											<th width="20%"><b><font size="6">AMOUNT</font></b></th>
										</tr>
										<br/>
										<tr valign="middle">
											<td valign="middle" style="border-right:1px solid #333;">1<br></td>
											<td valign="middle" style="border-right:1px solid #333;">$Sellerid[productName]<br></td>
											<td style="border-right:1px solid #333;">$result[quantity]</td>
											<td style="border-right:1px solid #333;">
											$price</td>
											<td><b><font size="9">$total</font></b></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table align="center" style="border-bottom:1px solid #333;">
									<tr>
										<td width="75%"><font size="9">TOTAL</font></td>
										<td width="25%"><font size="9">$total</font></td>
									</tr>
									</table>
								</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="border-bottom:2px solid #333;">
							<tr>
								<td><h3 align="center">// SellXG REFERENCE NO. //</h3></td>
							</tr>
							<tr>
								<td colspan="2" align="center" style="font-weight:bold;size:9px;">$invoiceno</td>
							</tr>
							<tr>
								<td colspan="2" align="center" style="font-weight:bold;">$orderid</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="font-size:10px;padding-right:100px;" >
							<tr>
								<td>
									<b>//SHIPPER ADDRESS//</b>
								</td>
								<td align="left" style="padding-top:15px;"><br>
									<b>SELLXG <br>Office No.418,4th Floor, 
									Belgium Squre,Near Japan Market,
									Delhi Gate,Ring Road,
									Surat(Gujarat)-395007</b>
									</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="font-size:10px;padding-right:100px;" >
							<tr>
								<td>
									<b>//ACCOUNT DETAILS//</b>
								</td>
								<td align="left" style="padding-top:15px;"><br>
									<b>Account Name:SellXg<br>
									Account No: 6439884307<br>
									Account Type: Current<br>
									Bank: Indian Bank<br>
									IFSC Code: IDIB000B089
									</b>
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
									<font size="9">ordered via <b>SellXG.com</b></font>
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
									<font size="7"><b>INVOICE NUMBER : </b>$invoiceno</font>
								<br>
									<font size="7"><b>INVOICE DATE : </b>$result[created_at]</font>
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
									<font size="9"><b>$sellerName[sellerName]</b></font><br>
									<!--<font size="7">$SAddress<br>
										<b>CITY </b>$SCity<b> / </b> <b>STATE </b>$Sstate<br>
										<b>PIN </b> $SPincode<br>
										<b>COMPANY'S VAT TIN: </b>12345678901<br>
										<b>COMPANY'S CST NO: </b>12345678901
									</font>-->
								</td>
								<td>
									<font size="10"><b>BUYER</b></font><br>
									<font size="9"><b>$buyername[user_name]</b></font><br>
									<font size="7">$buyername[user_address]<br>
										<b>CITY </b>$buyername[city]<b> / </b> <b>STATE </b>$buyername[state]<br>
										<b>PIN </b> $buyername[pincode]<br>
										<b>MOBILE NO </b>$buyername[user_address]
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
									<!--<font size="7"><b>DISPATCHED VIA : </b>GO JAVAS</font>-->
								<br>
									<!--<font size="7"><b>DISPATCHED DOC. NO.(AWB) : </b>WIKIPEDIA39</font>-->
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="border-top:1px solid #333; border-bottom:1px solid #333;">
						<table align="center">
						
							<tr>
								<th width="10%"><b>ID</b></th>
								<th width="50%" style="border-left:1px solid #333;"><b>ITEM DESCRIPTION</b></th>
								<th width="10%" style="border-left:1px solid #333;"><b>QTY</b></th>
								<th width="15%" style="border-left:1px solid #333;"><b>RATE</b></th>
								<th width="15%" style="border-left:1px solid #333;"><b>AMOUNT</b></th>
							</tr>
							
							<tr>
								<td>1</td>
								<td align="left" style="border-left:1px solid #333;text-transform:capitalize;"> 

								$Sellerid[productName]<BR><BR>
								ORDER NO.: $result[id] <BR> <!--SUBORDER NO.: 123456789--></td>
								<td style="border-left:1px solid #333;">$result[quantity]</td>
								<td style="border-left:1px solid #333;">$price</td>
								<td style="border-left:1px solid #333;">$total</td>
							</tr>
							
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table align="center" style="border-bottom:1px solid #333;">
							<tr>
								<td width="75%"><font size="9">TOTAL</font></td>
								<td width="25%"><font size="9">$total</font></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td><!--<font size="6"><b>AMOUNT IN WORDS: ONE THOUSAND FIVE HUNDRED NINETY NINE ONLY</b></font>--></td>
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
									I $Dcusname hereby confirm that the above side product/s are being purchased for my internal/personal consumption and not for re-sale.
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
</table><?php 
EOF;
*/
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
		//$c++;
		//}
//	}
//}
//}
//ob_end_flush();
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($invoiceno.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>