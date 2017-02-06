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
    $negative    = 'negative ';
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
*{margin:0;padding:0;}
*, ::after, ::before{box-sizing:border-box;}
html{width:100%;height:100%;}
body{width:100%;height:100%;background:#fff;}
/*.invoice table.main_table{width:100%;border:1px solid #000;}
.invoice table.main_table .add_row td{width:50%;padding:10px;}
.invoice table.main_table .add_row td:first-child{border-right:1px solid #000;}
.invoice table.main_table .add_row td h4{margin-bottom:5px;font-size:18px;}
.invoice table.main_table .add_row td p{line-height:21px;font-size:15px;}
.invoice table.main_table .add_row td table tr td:first-child{border:none;width:30%}
.invoice table.main_table .add_row td table tr td{width:2%;padding:3px;}
.invoice table.main_table .add_row td table tr td:last-child{width:68%}
.header_row{width:100%;border-bottom:1px solid #000; display:flex}
.header_row .add_div, .header_row .detail_div{float:left;width:50%;padding:10px;}
.header_row .add_div{border-right:1px solid #000;}
.header_row .add_div h4{font-size:18px;}
.header_row .add_div p{line-height:21px;}
.header_row .detail_div .detail{line-height:23px}
.header_row .detail_div .detail span:first-child{width:30%;}
.header_row .detail_div .detail span{width:2%;}
.header_row .detail_div .detail span:last-child{width:68%;}
.bill_div{width:100%;}
.bill_div .row{width:100%;border-bottom:1px solid #000;display:flex;}
.bill_div .row:last-child{border-bottom:none;}
.bill_div .head{font-weight:bold;text-align:center;}
.bill_div .head .col{padding:7px;height:auto !important}
.bill_div .row .col{float:left;border-right:1px solid #000;height:25px;line-height:25px;text-align:center;}
.bill_div .row .col:last-child{border-right:none;}
.bill_div .row .col-1, .bill_div .row .col-2, .bill_div .row .col-3, .bill_div .row .col-4, .bill_div .row .col-5, .bill_div .row .col-6, .bill_div .row .col-7, .bill_div .row .col-8{width:12.5%;}
.bill_div .row .center-2col{width:25%; padding:0;}
.bill_div .row .center-2col .bill_haed{width:100%;}
.bill_div .row .center-2col .bill_haed:first-child{border-bottom:1px solid #000;padding:7px;}
.bill_div .row .center-2col .bill_haed .col_part1{width:50%;font-weight:normal;font-size:15px;}
.bill_div .row .total_div{width:37.5%}
.bill_div .row .col-mr-2{width:25%;}
.bill_div .row .col-mr-5{width:70%}
.bill_div .row .col-mr-7{width:87.5%;}*/
.bottom_detail{margin-top:40px;}
.bottom_detail p{line-height:25px;font-size:16px !important;display:inline-block}
.bottom_detail p span:first-child{width:150px;display:inline-block}
.bottom_detail p span{font-size:16px !important;display:inline-block}
.bottom_tag_line{margin-top:40px;font-weight:bold;font-size:19px;margin-bottom:50px;}
.footer{border-top:1px solid rgba(0,0,0,0.3);padding-top:25px; text-align:center;}
.footer .head{font-size:20px;color:#c92223;font-weight:bold;text-transform:uppercase}
.footer p{line-height:23px;display:inline-block}
.footer p span{color:#c92223; font-weight:bold;}
@media (max-width=768px){
	.header_row .add_div, .header_row .detail_div{width:100%;}
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
	
<section class="invoice">
	<div class="container">
    	<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 logodiv">
			<img src="../../../image/red-logo.png" width="95">
		</div>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="text-align:center;">
			<b style="font-size:18px;">INVOICE</b>
		</div>
        <br /><br /><br /><br />

        	<!--<div class="header_row">
            	<div class="add_div">
					<?php
						/*$seloutlet=mysql_query("select * from ct_outlets where id=$fetinid[outlet_id]");
						$fetoutlet=mysql_fetch_array($seloutlet);
						$selloc=mysql_query("select * from ct_location where id=$fetoutlet[location_id]");
						$fetloc=mysql_fetch_array($selloc);
						$selmerchant=mysql_query("select * from merchant where outlet_id=$fetoutlet[id]");
						$fetmerchant=mysql_fetch_array($selmerchant);
					?>
                	<h4><i>Merchant Name & Address</i></h4>
                    <p>
                    	<?php echo $fetoutlet['company_name']; ?><br />
                        <?php echo $fetoutlet['address']; ?><br />
                        <?php echo $fetloc['name']; ?><br />
                        kolkata - 700005<br />
                        PAN - <?php echo $fetoutlet['pan']; ?>
                    </p>
                </div>
                <div class="detail_div">
                	<div class="detail"><span>Merchant Id</span> <span>:</span> <span><?php echo $fetmerchant['merchantid']; ?></span></div>
                    <div class="detail"><span>Invoice No</span> <span>:</span> <span><?php echo $fetinid['id']; ?></span></div>
                    <div class="detail"><span>Invoice Date</span> <span>:</span> <span><?php echo date('d-m-Y',$fetinid['created_date']/1000); ?></span></div>
                    <div class="detail"><span>Billing Period</span> <span>:</span> <span><?php echo $fetinid[2] . " to " . $fetinid[3]; ?></span></div>
                    <div class="detail"><span>Payment Terms</span> <span>:</span> <span>Billing Date + <?php echo $fetconfig[1];*/ ?> Days</span></div>
                </div>
            </div>-->
            
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
            
            
            <table style="width:100%;" border="1">
            	<thead>
                	<tr height="100" width="600" bordercolor="#666666">
                        <th width="70px">Date</th>
                        <th width="70px">Txn Id</th>
                        <th width="70px">Bill Number</th>
                        <!--<th colspan="2">Bill Amount (Rs.)</th>-->
                        <!--<th width="12.5%">Tags (%)</th>
                        <th width="12.5%">Tags Redeemed</th>
                        <th width="12.5%">Tags Approved</th>-->
                	<tr>
                    <!--<tr>
                    	<th>Approval</th>
                        <th>Redemption</th>
                    </tr>-->
                </thead>
                <tbody>
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
                    
                    <tr>
                        <td><?php echo date("d-m-Y",$fet['approval_date']/1000); ?></td>
                        <td><?php echo $fet['transaction_id']; ?></td>
                        <td><?php echo $fet['bill_no']; ?></td>
                       <!-- <td><?php /*if($fet['type']=="approval"){echo $fet['bill_amount'];$totapproval=$totapproval+$fet['bill_amount'];}*/ ?></td>-->
                        <!--<td><?php /*if($fet['type']=="redemption")echo $fet['bill_amount'];*/ ?></td>-->
                        <!--<td><?php /*if($fet['type']=='approval')echo $fetoutlet['cashtag_percentage']; ?></td>
                        <td><?php if($fet['type']=='redemption'){ echo $fet['redemption_tag'];$red=$red+$fet['redemption_tag']; } ?></td>
                        <td><?php if($fet['type']=='approval'){echo $fet['approval_tags'];$app=$app+$fet['approval_tags']; }*/ ?></td>-->
                    </tr>
                    
                    <?php
                            }
                        }
                    ?>
                    
                    <div class="row" style="border:1px solid #000;">
                        <div class="col total_div">Total</div>
                        
                        <div class="col col-6"><?php echo $totapproval; ?></div>
                        <div class="col col-mr-2"></div>
                        <div class="col col-7"><?php echo $red; ?></div>
                        <div class="col col-8"><?php echo $app; ?></div>
                    </div>
                    <div class="row" style="border-top:1px solid #000;">
                        <div class="col col-mr-7"><?php echo $fetoutlet['approval_comm']; ?>% commission on bills approval</div>
                        <div class="col col-8"><?php 
                        $appcomm=$app * $fetoutlet['approval_comm'] / 100;
                        echo $fetinid['approval_comm']; 
                    ?></div>
                        <!--<div class="col col-7"></div>-->
                    </div>
                    <?php
                        if($fetoutlet['redemption_comm']!="" && $fetoutlet['redemption_comm']!=0)
                        {
                    ?>
                    <div class="row">
                        <div class="col col-mr-7"><?php echo $fetoutlet['redemption_comm']; ?>% commission on tags redeemed</div>
                        <div class="col col-8" style="border-bottom:1px solid #000;"><?php 
                        $redcomm=$red * $fetoutlet['redemption_comm'] / 100;
                        echo $fetinid['redemption_comm']; 
                    ?></div>
                        <!--<div class="col col-7"></div>-->
                    </div>
                    <?php
                        }
                    ?>
                    
                    <div class="row">
                        <div class="col col-mr-7">Amount to be received</div>
                        <div class="col col-8"><?php  
                    $totapp=$app + $fetinid['approval_comm'] + $fetinid['redemption_comm'];
                    echo round($totapp,2); 
                ?></div>
                        <!--<div class="col col-7"></div>-->
                    </div>
                    <div class="row">
                        <div class="col col-mr-7">Less : Tags Redeemed</div>
                        <div class="col col-8"><?php  echo round($red,2); ?></div>
                        <!--<div class="col col-7"></div>-->
                    </div>
                    <div class="row">
                        <div class="col col-mr-7"><b>Net Amount</b></div>
                        <div class="col col-8"><b><?php 
                    echo $fetinid['netpay']; 
                ?></b></div>
                        <!--<div class="col col-7"></div>-->
                    </div>
                    
                    <div class="row" style="border:1px solid #000;padding-left:10px;">
                        <div class="col" style="text-transform:capitalize;">Amount in Words : Rupees <?php $word=convert_number_to_words(round($fetinid['netpay']));
                        echo $word; ?> only</div>
                    </div>
                
            	</tbody>
            </table>
        
        <div class="bottom_detail">
        	<div><p>Payment to be made by crossed Cheque / Bank Draft in favour of <?php echo $fetconfig[2]; ?></p></div>
            <div><p>Wire Transfer remit in favour of Cashtag Technologies Pvt Ltd</p></div>
            <div><p><span>Bank Name</span> <span><?php echo $fetconfig[3]; ?></span></p></div>
            <div><p><span>Account Number</span> <span><?php echo $fetconfig[4]; ?></span></p></div>
            <div><p><span>IFSC Code</span> <span><?php echo $fetconfig[5]; ?></span></p></div>
            <div><p><span>PAN</span> <span><?php echo $fetconfig[6]; ?></span></p></div>
        </div>
        
        <div class="bottom_tag_line">This is a system generated invoice and does not require any signature</div>
		
    </div>
    <div class="footer">
    	<div class="head">cashtag technologies private limited</div>
        <div><p>Registered Office : 40/34 D.H. Road Kolkata - 700038</p></div>
        <div><p>CIN : U72300WB2015PTC208082</p></div>
        <div><P>Website : www.cashtag.co.in<span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span>Email Id : info@cashtag.co.in</P></div>
    </div>
</section>
</body>

</html>
