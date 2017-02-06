<html>
<body>
<?php 
include 'db.php';
session_start();
//$id=$_GET['iid'];
$filename = "id.txt";
$myfile = fopen($filename,"r");


	$id=fread($myfile,filesize($filename));
	fclose($myfile);
	$query=mysql_query("select * from  `order` where bill_id='".$id."' ");
	$result=mysql_fetch_array($query);
	
	$buyer=mysql_query("select * from ".USER_REGISTER ." where user_id='".$result['user_id']."'");
	$buyername=mysql_fetch_array($buyer);
	
	$seller=mysql_query("select * from ".PRODUCT1 ." where serverProductId='".$result['serverProductId']."' ");
	$Sellerid=mysql_fetch_array($seller);
	
	$sellername=mysql_query("select * from ".SELLER ." where serveruserid='".$Sellerid['serverUserId']."' ");
	$sellerName=mysql_fetch_array($sellername);

	$invoiceno = $result['bill_id'];
	$invoicedate = $result['created_at'];
	
	if($result['payment_method']=='completed')
	{
		$paid="PAID";
	}else{
		$paid="UNPAID";
	} 
	
	?>
	<table ><tr><td style="margin-left:50px;" width="15%"><img src="http://www.sellxg.com/sellxg/images/logo.png" alt="Trendz" style="margin-top:-15px;" width="70px" ></td>
<td align="left" style="padding:15px;" width="60%"><br>
									<p><b>SELLXG <br>Office No.418,4th Floor, 
									Belgium Squre,Near Japan Market,
									Delhi Gate,Ring Road,
									Surat(Gujarat)-395007
									<?php
									echo $_SESSION['bid'];
									?></b></p><br>
									<br>
								</td>
								<td><table padding-top:5px;><tr ><td width="80%" height="20px"  align="center" style="padding:1px;border:1px solid black;"><?php echo$paid; ?></td></tr></table></td>
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
								<td width="78%"><h3><?php echo $buyername[user_name]; ?></h3></td>
								<td width="22%" align="right"><h1><!--180/DDN--></h1></td>
							</tr>
							<tr>
								<td><font size="7"><?php echo $buyername[user_address]; ?><br>
										<b>CITY </b><?php echo $buyername[city]; ?><b> / </b> <b>STATE </b><?php echo$buyername[state]; ?><br>
										<b>PIN </b> <?php echo $buyername[pincode]; ?><br>
										<b>MOBILE NO </b><?php echo $buyername[user_contactno]; ?>
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
										<?php
										$i=1;
										$query=mysql_query("select * from  `order` where bill_id='".$id."' ");
										while($result=mysql_fetch_array($query))
										{
										$seller=mysql_query("select * from ".PRODUCT1 ." where serverProductId='".$result['serverProductId']."' ");
										$Sellerid=mysql_fetch_array($seller);
										if(!isset($_SESSION[currency]))
										{
										$price="<i >Rs."." "."<b>".$result[price]."</b></i>"; 
										}
										else   
										{
										$price="$ ". round($result[price] / $_SESSION[currency],2);
										}
										if(!isset($_SESSION[currency]))
										{
										$total="<i >Rs."." "."<b>".$result[total]."</b></i>";
										}
										else   
										{
										$total= "$ ". round($result[total] / $_SESSION[currency],2);
										}
										?>
										<tr valign="middle">
											<td valign="middle" style="border-right:1px solid #333;"><?php echo $i; ?><br></td>
											<td valign="middle" style="border-right:1px solid #333;"><?php echo $Sellerid[productName]; ?><br></td>
											<td style="border-right:1px solid #333;"><?php echo $result[quantity]; ?></td>
											<td style="border-right:1px solid #333;">
											<?php echo $price; ?></td>
											<td><b><font size="9"><?php echo $total; ?></font></b></td>
										</tr>
										<?php 
											$sum=$sum + $result[total];
											if(!isset($_SESSION[currency]))
											{
											$sum1="<i >Rs."." "."<b>".$sum."</b></i>";
											}
											else   
											{
											$sum1= "$ ". round($sum / $_SESSION[currency],2);
											}
											$i++;
										} ?>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table align="center" style="border-bottom:1px solid #333;">
									<tr>
										<td width="75%"><font size="9">TOTAL</font></td>
										<td width="25%"><font size="9"><?php echo $sum1; ?></font></td>
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
								<td colspan="2" align="center" style="font-weight:bold;size:9px;"><?php echo $invoiceno; ?></td>
							</tr>
							<tr>
								<td colspan="2" align="center" style="font-weight:bold;"><?php echo $orderid; ?></td>
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
									<font size="7"><b>INVOICE NUMBER : </b><?php echo $invoiceno; ?></font>
								<br>
									<font size="7"><b>INVOICE DATE : </b><?php echo $invoicedate; ?></font>
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
									<font size="9"><b><?php echo $sellerName[sellerName]; ?></b></font><br>
									<!--<font size="7">$SAddress<br>
										<b>CITY </b>$SCity<b> / </b> <b>STATE </b>$Sstate<br>
										<b>PIN </b> $SPincode<br>
										<b>COMPANY'S VAT TIN: </b>12345678901<br>
										<b>COMPANY'S CST NO: </b>12345678901
									</font>-->
								</td>
								<td>
									<font size="10"><b>BUYER</b></font><br>
									<font size="9"><b><?php echo $buyername[user_name]; ?></b></font><br>
									<font size="7"><?php echo $buyername[user_address]; ?><br>
										<b>CITY </b><?php echo $buyername[city]; ?><b> / </b> <b>STATE </b><?php echo $buyername[state]; ?><br>
										<b>PIN </b><?php  $buyername[pincode]; ?><br>
										<b>MOBILE NO </b><?php $buyername[user_address]; ?>
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
							
							
							<?php
										$i=1;
										$query=mysql_query("select * from  `order` where bill_id='".$id."' ");
										while($result=mysql_fetch_array($query))
										{
										$seller=mysql_query("select * from ".PRODUCT1 ." where serverProductId='".$result['serverProductId']."' ");
										$Sellerid=mysql_fetch_array($seller);
										if(!isset($_SESSION[currency]))
										{
										$price="<i >Rs."." "."<b>".$result[price]."</b></i>"; 
										}
										else   
										{
										$price="$ ". round($result[price] / $_SESSION[currency],2);
										}
										if(!isset($_SESSION[currency]))
										{
										$total="<i >Rs."." "."<b>".$result[total]."</b></i>";
										}
										else   
										{
										$total= "$ ". round($result[total] / $_SESSION[currency],2);
										}
										?>
								<tr>
								<td><?php echo $i; ?></td>
								<td align="left" style="border-left:1px solid #333;text-transform:capitalize;"> 

								<?php echo $Sellerid[productName]; ?><BR><BR> <!--SUBORDER NO.: 123456789--></td>
								<td style="border-left:1px solid #333;"><?php echo $result[quantity]; ?></td>
								<td style="border-left:1px solid #333;"><?php echo $price; ?></td>
								<td style="border-left:1px solid #333;"><?php echo $total; ?></td>
							</tr>
							<?php 
											$sum3=$sum3 + $result[total];
											if(!isset($_SESSION[currency]))
											{
											$sum2="<i >Rs."." "."<b>".$sum3."</b></i>";
											}
											else   
											{
											$sum2= "$ ". round($sum3 / $_SESSION[currency],2);
											}
											$i++;
										} ?>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table align="center" style="border-bottom:1px solid #333;">
							<tr>
								<td width="75%"><font size="9">TOTAL</font></td>
								<td width="25%"><font size="9"><?php echo  $sum2; ?></font></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td></td>
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
</table>
</body>
</html>