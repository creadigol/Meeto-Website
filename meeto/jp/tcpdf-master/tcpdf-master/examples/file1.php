<?php
require_once('../../../connection.php');
require_once('../../../head.php');
$filename = "id.txt";
$myfile = fopen($filename,"r");
$id=fread($myfile,filesize($filename));
fclose($myfile);
$selinid=mysql_query("select * from invoice where id=$id");
$fetinid=mysql_fetch_array($selinid);
$selconfig=mysql_query("select * from invoice_configuration");
$fetconfig=mysql_fetch_array($selconfig);

function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = '';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
.logodiv 
{
	margin-top:-20px !important;
	text-align:left;
	
}
.logodiv img
{
	width:95px;

}
.row{width:100%;}
.col{float:left;}
.maininvoicediv
{
	border:1px solid #000;
	/*padding:-5px;*/
}
.detailtable thead tr th
{
	text-align:center;
}
.bottom_tag_line{margin-top:40px;font-weight:bold;font-size:13x;margin-bottom:50px;}
hr{margin:20px 0 !important;}
.footer{border-top:solid rgba(0,0,0,0.05) !important; text-align:center;opacity:0.4 !important;display:block}
.footer .head{font-size:15px;/*color:#c92223;*/color:rgba(201,34,35,0.35);font-weight:bold;text-transform:uppercase;}
.footer div{line-height:11px;display:inline-block; color:#acacac;}
.footer div span{/*color:#c92223;*/ font-weight:bold; color:rgba(201,34,35,0.35)}
@media (max-width=768px){
	.header_row .add_div, .header_row .detail_div{width:100%;}
}
tr
{
	padding:5px;
}
</style>

<title>Cashtag</title>
</head>

<body>
	<?php
		$seloutlet=mysql_query("select * from ct_outlets where id=$fetinid[outlet_id]");
		$fetoutlet=mysql_fetch_array($seloutlet);
		$selloc=mysql_query("select * from ct_location where id=$fetoutlet[location_id]");
		$fetloc=mysql_fetch_array($selloc);
		$selmerchant=mysql_query("select * from merchant where outlet_id=$fetoutlet[id]");
		$fetmerchant=mysql_fetch_array($selmerchant);
	?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 logodiv">
			<img src="../../../image/red-logo.png">
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="text-align:center;">
			<b style="font-size:18px;">INVOICE</b>
		</div>
      	
        <br /><br /><br /><br />
        <table>
        	<tr>
            	<td>
                	<tr><td><i><b>Merchant Name & Address</b></i></td></tr>
                    <tr><td><?php echo $fetoutlet['company_name']; ?></td></tr>
                    <tr><td><?php echo $fetoutlet['address']; ?></td></tr>
                    <tr><td><?php echo $fetloc['name']; ?></td></tr>
                    <tr><td>kolkata - 700005</td></tr>
                    <tr><td><?php echo $fetoutlet['pan']; ?></td></tr>
                </td>
                <td style="float:right;">
                	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Merchant Id</span> <span>:</span> <span><?php echo $fetmerchant['merchantid']; ?></span></td></tr>
                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Invoice No</span> <span>:</span> <span><?php echo $fetinid['id']; ?></span></td></tr>
                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Invoice Date</span> <span>:</span> <span><?php echo date('d-m-Y',$fetinid['created_date']/1000); ?></span></td></tr>
                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Billing Period</span> <span>:</span> <span><?php echo $fetinid[2] . " to " . $fetinid[3]; ?></span></td></tr>
                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Payment Terms</span> <span>:</span> <span>Billing Date + <?php echo $fetconfig[1]; ?> Days</span></td></tr>
                </td>
            </tr>
        </table>
        
        <table border="1" style="padding:5px 3px;">
            <thead align="center">
                <tr align="center" style="width:100%">
                    <th rowspan="2" style="width:12.5%"><b>Date</b></th>
                    <th rowspan="2" style="width:12.5%"><b>Txn Id</b></th>
                    <th rowspan="2" style="width:12.5%"><b>Bill No</b></th>
                    <th colspan="2" style="width:25%"><b>Bill Amount (Rs.)</b></th>
                    <th rowspan="2" style="width:12.5%"><b>Tags (%)</b></th>
                    <th rowspan="2" style="width:12.5%"><b>Tags Redeemed</b></th>
                    <th rowspan="2" style="width:12.5%"><b>Tags Approved</b></th>
                </tr>
                <tr align="center">
                    <th style="width:12.5%"><b>Approval</b></th>
                    <th style="width:12.5%"><b>Redemption</b></th>
                </tr>
            </thead>
            <tbody style="width:100%">
            <?php
                $arr=explode("-",$fetinid['tranid']);
                $totapproval=0;
                foreach($arr as $data)
                {
                    if($data!="")
                    {
                        $seltran=mysql_query("select * from ct_transaction where id=$data");
                        $fet=mysql_fetch_array($seltran);
            ?>
            <tr align="center" style="width:100%">
                <td style="width:12.5%"><?php echo date("d-m-Y",$fet['approval_date']/1000); ?></td>
                <td style="width:12.5%"><?php echo $fet['transaction_id']; ?></td>
                <td style="width:12.5%"><?php echo $fet['bill_no']; ?></td>
                <td style="width:12.5%"><?php /*if($fet['type']=="approval"){echo $fet['bill_amount'];$totapproval=$totapproval+$fet['bill_amount'];}*/ ?><?php if($fet['type']=="approval"){echo $fet['bill_amount'];$totapproval=$totapproval+$fet['bill_amount'];} ?></td>
                <td style="width:12.5%"><?php if($fet['type']=="redemption")echo $fet['bill_amount']; ?></td>
                <td style="width:12.5%"><?php if($fet['type']=='approval')echo $fetoutlet['cashtag_percentage']; ?></td>
                <td style="width:12.5%"><?php if($fet['type']=='redemption'){ echo $fet['redemption_tag'];$red=$red+$fet['redemption_tag']; }?></td>
                <td style="width:12.5%"><?php if($fet['type']=='approval'){echo $fet['approval_tags'];$app=$app+$fet['approval_tags']; } ?></td>
            </tr>
            <?php
                    }
                }
            ?>
                <tr>
                    <td colspan="3" style="text-align:center;">Total</td>
                    <td style="text-align:center;"><?php echo $totapproval; ?></td>
                    <td colspan="2"></td>
                    <td style="text-align:center;"><?php echo $red; ?></td>
                    <td style="text-align:center;"><?php echo $app; ?></td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align:center;"><?php echo $fetoutlet['approval_comm']; ?>% Commission On Bills Approval</td>
                    <td style="text-align:center;">
                        <?php 
                            $appcomm=$app * $fetoutlet['approval_comm'] / 100;
                            echo $fetinid['approval_comm']; 
                        ?>
                    </td>
                </tr>
                <?php
                    if($fetoutlet['redemption_comm']!="" && $fetoutlet['redemption_comm']!=0)
                    {
                ?>
                <tr>
                    <td colspan="7" style="text-align:center;"><?php echo $fetoutlet['redemption_comm']; ?>% Commission On Tags Redeemed</td>
                    <td style="text-align:center;">
                        <?php 
                            $redcomm=$red * $fetoutlet['redemption_comm'] / 100;
                            echo $fetinid['redemption_comm']; 
                        ?>
                    </td>
                </tr>
                <?php
                    }
                ?>
                <tr>
                    <td colspan="7" style="text-align:center;">Amount To Be Received</td>
                    <td style="text-align:center;">
                        <?php  
                            $totapp=$app + $fetinid['approval_comm'] + $fetinid['redemption_comm'];
                            echo round($totapp,2); 
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align:center;">Less : Tags Redeemed</td>
                    <td style="text-align:center;">
                        <?php  echo round($red,2); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align:center;"><b>Net Amount</b></td>
                    <td style="text-align:center;"><b><?php echo $fetinid['netpay']; ?></b></td>
                </tr>
                <tr style="padding-left:10px;">
                    <td colspan="8"> Amount in Words : Rupees <?php $word=convert_number_to_words(round($fetinid['netpay']));
                echo $word; ?> only</td>
                    
                </tr>
            </tbody>
        </table>
            
		<div class="col-md-6 col-sm-6 col-xs-6 col-lg-6" style="width:50%;line-height:8px;">
			<div><p>Payment to be made by crossed Cheque / Bank Draft in favour of <?php echo $fetconfig[2]; ?></p></div>
            <div><p>Wire Transfer remit in favour of Cashtag Technologies Pvt Ltd</p></div>
            <div><p><span>Bank Name  </span> <span><?php echo $fetconfig[3]; ?></span></p></div>
            <div><p><span>Account Number  </span> <span><?php echo $fetconfig[4]; ?></span></p></div>
            <div><p><span>IFSC Code  </span> <span><?php echo $fetconfig[5]; ?></span></p></div>
            <div><p><span>PAN  </span> <span><?php echo $fetconfig[6]; ?></span></p></div>
		</div>
        <!--<hr />-->
         <div class="bottom_tag_line">This is a system generated invoice and does not require any signature</div>
		<div class="footer">
        <br />
			<div class="head">cashtag technologies private limited</div>
			<div>Registered Office : 40/34 D.H. Road Kolkata - 700038</div>
			<div>CIN : U72300WB2015PTC208082</div>
			<div>Website : www.cashtag.co.in<span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span>Email Id : info@cashtag.co.in</div>
		</div>
	</div>
</body>
</html>
