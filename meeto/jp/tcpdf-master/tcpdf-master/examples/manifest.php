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
$Sname = $qryrw8['State'];*/

// add a page
/*if(isset($_REQUEST['printpack']) && $_REQUEST['printpack']='Handover')
{
	if(isset($_REQUEST['print']))
	{
		$count=0;
		foreach($_REQUEST['print'] as $print)
		{
			$printinv[]=$print;
			$count++;
		}
		$c=0;
		while($c<$count)
		{
			mysql_query("update order_detail set Order_status='Handover' where Ord_dt_id='".$printinv[$c]."'");
			$c++;
		}
	}
}*/
$pdf->AddPage();
$createdate=date("l jS \of F Y");
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
			<table align="center">
				<tr>
					<td><font size="9"><b>Vendor Copy</b></font></td>
				</tr>
				<tr>
					<td>
						<table cellpadding="2" valign="middle">
							<tr valign="middle">
								<td width="30%" valign="middle" style="border-top:1px solid #333; border-left:1px solid #333; border-right:1px sold #333;"><h3>Sheet Code:</h3></td>
								<td width="70%" style="border-top:1px solid #333; border-right:1px solid #333;"><!--<img src="http://www.sopingkart.com/inc/image/barcode.png" width="300">--></td>
							</tr>
							<tr>
								<td width="30%" valign="middle" style="border-top:1px solid #333; border-left:1px solid #333; border-right:1px sold #333;"><h3>Sheet Created Date:</h3></td>
								<td width="70%" style="border-top:1px solid #333; border-right:1px solid #333;"><h3>$createdate</h3></td>
							</tr>
							<tr style="border-top:1px solid #333;">
								<td width="30%" valign="middle" style="border-top:1px solid #333; border-left:1px solid #333; border-right:1px sold #333;"><h3>Packets:</h3></td>
								<td width="70%" style="border-top:1px solid #333; border-right:1px solid #333;"><h3></h3></td>
							</tr>
							<tr style="border-top:1px solid #333;border-bottom:1px solid #333">
								<td width="30%" valign="middle" style="border-top:1px solid #333; border-left:1px solid #333; border-right:1px sold #333; border-bottom:1px solid #333;">
									<h3>Vender Address:</h3><br>
									<h2>GRUHINI MART</h2>
									<font size="9">
										18, rupali soc3, a k road, varachha<br>
										near shreyas school,<br>
										Surat, Gujarat, India<br>
										395008
									</font>
								</td>
								<td width="70%" style="border-top:1px solid #333; border-right:1px solid #333; border-bottom:1px solid #333;">
									<!--<h3>Oneship Address:</h3><br>
									<h2>SJ-SUR-ANJANA-VL-CENTER(SJ-SUR-ANJANA-VL)</h2>
									<font size="10"><b>SJ-SUR-ANJANA-VL</b></font><br>
									<font size="9">
										Narayan Industrial State, Block No 8-9, Opp. Peer Abdul Nabi Dargah, Anjana Farm<br>
										Surat, Gujarat, India<br>
										395002
									</font>-->
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<br/>
				<tr>
					<td>
						<table align="center" style="line-height:25px; font-size:10px;">
							<tr bgcolor="#c1995c" style="font-weight:bold;">
								<th width="33%">S.No</th>
								<th width="33%">Suborder</th>
								<th width="33%">Sku</th>
								<!--<th width="15%">Supe</th>
								<th width="25%">AWB</th>
								<th width="30%">Reference Code</th>-->
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table border="1" align="center" style="line-height:25px; font-size:10px;">
							
							<tr border="1" style="border:1px solid #333;">
								<td width="33%" style="border-right:1px solid #333;border-top:1px solid #333;">1</td>
								<td width="33%" style="border-right:1px solid #333;border-top:1px solid #333;">12345678901</td>
								<td width="33%" style="border-right:1px solid #333;border-top:1px solid #333;">yellowcholi</td>
								<!--<td width="15%" style="border-right:1px solid #333;border-top:1px solid #333;">SDL123456789</td>
								<td width="25%" style="border-right:1px solid #333;border-top:1px solid #333;">UNISNPC12345678</td>
								<td width="30%" style="border-top:1px solid #333; line-height:13px"><b>FORMS NEEDED</b><br/>SLP123456789</td>-->
							</tr>
							
							<!--<tr border="1px" bordercolor="#333">
								<td width="7%" style="border-right:1px solid #333;border-top:1px solid #333;">2</td>
								<td width="12%" style="border-right:1px solid #333;border-top:1px solid #333;">12345678901</td>
								<td width="11%" style="border-right:1px solid #333;border-top:1px solid #333;">yellowcholi</td>
								<td width="15%" style="border-right:1px solid #333;border-top:1px solid #333;">SDL123456789</td>
								<td width="25%" style="border-right:1px solid #333;border-top:1px solid #333;">UNISNPC12345678</td>
								<td width="30%" style="border-top:1px solid #333; line-height:13px"><b>FORMS NEEDED</b><br/>SLP123456789</td>
							</tr>-->
						</table>
					</td>
				</tr>
				<br/>
				<tr bgcolor="#f6e8ef">
					<td><font size="12" align="left">cornfirm that I have collected Forms for Shipments marked as "FORMS NEEDED" in this Over Sheet</font>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
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
$pdf->Output('example_061.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>