<?php 
require_once('db.php');  
require_once('condition.php'); 
$uidd=$_SESSION['jpmeetou']['id'];
if(isset($_REQUEST['subbtn'])){		
$upuser=mysql_query("update user set email_verify=1 where id=$uidd");
}	 
$row = mysql_fetch_array(mysql_query("select * from user where id = '".$uidd."'")); 
$rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = '".$uidd."'")); 
$rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = '".$uidd."'")); 

?>
<!DOCTYPE html>
<html lang="ja">  
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<?php	
	require_once('head1.php'); 
	?>
	
<style>

a.booking_menu, a.booking_menu:hover{
	background-color:#f9f9f9 !important;
	color:#7323DC !important;
	border-bottom:none !important;
	font-weight:bold !important;
	border-top:5px solid #7323dc !important;
	padding-top:7px !important;
}
</style>	
	
	<!-- NAVBAR================================================== -->
	<body onload="openCity(event,'Verified')" style="overflow:auto !important">  
	<?php	require_once('header1.php');   ?>
	<?php	require_once('usermenu.php');   ?>
	<!-- pop up start -->
	<div class="container-flude container-margin background-container">	
	  <div class="container">		
	    <div class="row">
	        <div class="col-md-3">				
	           <div class="top-margin-20"> </div>					
				<ul class="nav edit listing">	
					<li><a href="#" class="tablinks active" onclick="openCity(event,'Verified')">
ご予約</a></li>
					<li><a href="#" class="tablinks" onclick="openCity(event,'Reservations')">前の予約</a></li>			
				</ul>					
				<div class="top-margin-30"> </div>
			</div>
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-md-8">	
				<div class="top-margin-20"> </div>	
				<div class="row hedding-row tabcontent" id="Verified">				
						<div class="col-md-12 Required-head Verification-head menu-border booking-head">
							<h5>ご予約</h5>
						</div>
							<div class="clearfix"></div>
							<!--<div class="col-md-8 reservation">
								<form>
									<input type="text" value="" name=" " placeholder="Where are you going?" class="booking-input">
									
									<input class="blue-button booking-search" type="submit" value="Search">
								</form>
							</div>-->
							<div class="col-md-12 reservation tabel-scroll">
								<table width="100%">
									<thead>
										<tr height="40px" class="table-padding table-head">
											<td style="width:100px;"><strong><strong>
で予約</strong></strong></td>
											<td style="width:100px"><strong>
セミナー名</strong></td>
											<td style="width:100px"><strong>
ホスト</strong></td>
											<td style="width:140px"><strong>
日付と場所</strong></td>
											
											<td style="width:50px"><strong>
ホストの承認</strong></td>
											
										</tr>
									</thead>		
									<?php			
										$bkd=$_SESSION['jpmeetou']['id'];
									$selbooking=mysql_query("select * from seminar_booking where uid=$bkd order by created_date DESC");
									while($fetbooking=mysql_fetch_array($selbooking))		
										{							
									$selseminar=mysql_query("select * from seminar where id=$fetbooking[seminar_id] and status=1");	
									$row=mysql_num_rows($selseminar);
									$fetseminar=mysql_fetch_array($selseminar);
										if($row>=1)
										{
								
									$selsemiphoto=mysql_query("select * from seminar_photos where seminar_id=$fetbooking[seminar_id] limit 0,1");
									$fetsemiphoto=mysql_fetch_array($selsemiphoto);			
									?>									
									<tbody>									
									<tr class="table-padding">										
									<td><?php echo $date=date('d-m-Y',$fetbooking['created_date']/1000); ?></td>					<td><img src="../img/<?php echo $fetsemiphoto['image']; ?>" width="100" style="transform:rotate(<?php echo $fetsemiphoto['rotateval']; ?>deg)" height="100" alt="Big Office - Electra City Tower"class="table-img"><a href="infomation.php?id=<?php echo $fetseminar['id']; ?>"><br><?php $marutra = explode('"',translate(str_replace(" ","+",$fetseminar['title']))); echo $marutra[1];  ?></a></td>							
									<td><?php $marutra = explode('"',translate(str_replace(" ","+",$fetseminar['hostperson_name']))); echo $marutra[1]; ?></td>											
									<td class="text-left"><br> <b>日から :</b> <br>
									<?php echo date("d-m-Y",$fetbooking['from_date']/1000); ?> <br>
									<b>
現在まで:</b> <br><?php echo date("d-m-Y",$fetbooking['to_date']/1000); ?> <br>
									<b>
住所: </b><br><?php $marutra = explode('"',translate(str_replace(" ","+",$fetseminar['address']))); echo $marutra[1];  ?><br><label style="font-weight:bold;">
予約なし :</label><?php $marutra = explode('"',translate(str_replace(" ","+",$fetbooking['booking_no']))); echo $marutra[1];  ?>
									</td>																
									<td><p style=" color: #000; font-weight: bold; "><?php $marutra = explode('"',translate(str_replace(" ","+",$fetbooking['approval_status']))); echo $marutra[1];  ?> </p>
									<?php if($fetbooking['approval_status']=='accepted')
									{
									 
									?>
									<div class="text-uppercase dawonlod-ticket" data-toggle="modal" data-target="#myModal" onclick="booked('<?php echo $fetbooking['id'];?>');" >ダウンロードチケット
									</div>
									<?php
									}										
									?>
									</td>														
									</tr>						
									</tbody>				
									<?php					
									}		
										}									
									?>
								</table>
								
						<div class="modal fade" id="myModal" role="dialog">

							<div class="modal-dialog">

							   Modal content

							  <div class="modal-content modal-c">

							  

								<div class="modal-header model-head">

								  <button type="button" class="close" data-dismiss="modal">&times;</button>

								  <h4 class="modal-title semibold-o">
ダウンロードチケット</h4>

								</div>

								<div class="modal-body" id="bookedtiket1">

									

									
								

								</div>

								

															
							  </div>
							  
							</div>
					    </div>		
					</div>
							
						<div class="clearfix"></div>
				</div>
					
					
					<div class="row hedding-row tabcontent" id="Reservations">				
						<div class="col-md-12 Required-head Verification-head menu-border booking-head">
							<h5>
あなたの前の予約</h5>
						</div>
							<div class="clearfix"></div>
							<!---<div class="col-md-8 reservation">
								<form>
									<input type="text" value="" name=" " placeholder="Where are you going?" class="booking-input">
									
									<input class="blue-button booking-search" type="submit" value="Search">
								</form>
							</div>--->
							<div class="col-md-12 reservation tabel-scroll">
								<table width="100%">
									<thead>
										<tr height="40px" class="table-padding table-head">
											<td style="width:100px;"><strong><strong>で予約</strong></strong></td>
											<td style="width:100px"><strong>
プロパティ名</strong></td>
											<td style="width:100px"><strong>
ホスト
</strong></td>
											<td style="width:140px"><strong>
日付と場所</strong></td>
											
											<td style="width:50px"><strong>ホストの承認</strong></td>
											
										</tr>
									</thead>								
									<?php	
									$selbooking=mysql_query("select * from seminar_booking where uid=$_SESSION[id]");									
									while($fetbooking=mysql_fetch_array($selbooking))
									{										
										$selseminar=mysql_query("select * from seminar where id=$fetbooking[seminar_id] and status=1");
										$fetseminar=mysql_fetch_array($selseminar);			
										$selsemiphoto=mysql_query("select * from seminar_photos where seminar_id=$fetbooking[seminar_id] limit 0,1");	
										$fetsemiphoto=mysql_fetch_array($selsemiphoto);		
										?>								
										<tbody>					
										<tr class="table-padding">	
										<td><?php echo date('d-m-Y',$fetbooking['created_date']/1000); ?></td>	
										<td><img src="../img/<?php echo $fetsemiphoto['image']; ?>" width="100" height="100" alt="Big Office - Electra City Tower"class="table-img"><a href="infomation.php?id=<?php echo $fetseminar['id']; ?>"><br><?php $marutra = explode('"',translate(str_replace(" ","+",$fetseminar['title']))); echo $marutra[1];  ?></a></td>		
										<td><?php $marutra = explode('"',translate(str_replace(" ","+",$fetseminar['hostperson_name']))); echo $marutra[1];  ?></td>					
										<td class="text-left"><br> <b>
日から :</b> <br><?php echo $fetbooking['from_date']; ?> <br><b>
現在まで :</b> <br><?php echo $fetbooking['to_date']; ?> <br><b>
住所: </b><br><?php $marutra = explode('"',translate(str_replace(" ","+",$fetseminar['address']))); echo $marutra[1]; ?><br><label style="font-weight:bold;">
予約なし :</label><?php echo $fetbooking['booking_no']; ?></td>			
										<td><p style=" color: #000; font-weight: bold; "><?php $marutra = explode('"',translate(str_replace(" ","+",$fetbooking['approval_status']))); echo $marutra[1];  ?>  </p></td>	
										</tr>
										
										</tbody>				
									<?php				
									}					
									?>
								</table>
							</div>
						<div class="clearfix"></div>
					</div>
				</div>
			
			</form>				
		</div>
	</div>
	<div class="top-margin-10">&nbsp;</div>
</div>



<?php
require_once('footer1.php');
?>
<!-- footer END-->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>

