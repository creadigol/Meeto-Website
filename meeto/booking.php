<?php 
require_once('db.php');  
require_once('condition.php');  
require_once('mypdf/fpdf.php'); 
 if(isset($_REQUEST['subbtn']))
{		
$upuser=mysql_query("update user set email_verify=1 where id=$_SESSION[jpmeetou][id]");
}	 
$row = mysql_fetch_array(mysql_query("select * from user where id = '".$_SESSION['jpmeetou']['id']."'")); 
$rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = '".$_SESSION['jpmeetou']['id']."'")); 
$rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = '".$_SESSION['jpmeetou']['id']."'"));

?>
<!DOCTYPE html>
<html lang="en">  
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
					<li><a href="#" class="tablinks active" onclick="openCity(event,'Verified')">Your Bookings</a></li>
					<li><a href="#" class="tablinks" onclick="openCity(event,'Reservations')">Previous Bookings</a></li>			
				</ul>					
				<div class="top-margin-30"> </div>
			</div>
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-md-8">	
				<div class="top-margin-20"> </div>	
				<div class="row hedding-row tabcontent" id="Verified">				
						<div class="col-md-12 Required-head Verification-head menu-border booking-head">
							<h5>Your Bookings</h5>
						</div>
							<div class="clearfix"></div>
							
							<div class="col-md-12 reservation tabel-scroll">
								<table width="100%">
								   <?php
								    $bkd=$_SESSION['jpmeetou']['id'];
									$selbooking=mysql_query("select * from seminar_booking where uid=$bkd and seminar_id in (select id from seminar where status=1) order by created_date DESC");
									$numrowss=mysql_num_rows($selbooking);
									if($numrowss>=1)
									{
									?>
									<thead>
										<tr height="40px" class="table-padding table-head">
											<td style="width:100px;"><strong>Seminar Image<strong></strong></strong></td>
											<td style="width:100px"><strong>Seminar Name</strong></td>
											<td style="width:80px"><strong>Host</strong></td>
											<td style="width:160px"><strong>Dates and Location</strong></td>
											<td style="width:50px"><strong>Host Approval</strong></td>
											
										</tr>
									</thead>		
									<?php			
									
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
								 <?php											
									if($fetsemiphoto['image']=="" || !file_exists("img/".$fetsemiphoto['image']))	
									{?>	
									<td>
									   <img src="img/no-photo.jpg" class="img-responsive center-block" style="width:100px;height:100px;"/>
									</td> 
									<?
									}						
									else
									{?>
								     <td>
								     <img src="img/<?php echo $fetsemiphoto['image']; ?>"  style="transform:rotate(<?php echo $fetsemiphoto['rotateval']; ?>deg);width:100px;height:100px;" alt="Big Office - Electra City Tower"></td>
									<?
									}?>
									<td><b><a href="infomation.php?id=<?php echo $fetseminar['id']; ?>"><?php echo $fetseminar['title']; ?></a></b></td>	
									
									<td><b><?php echo $fetseminar['hostperson_name']; ?></b></td>											
									<td class="text-left">
									<b>Booked On : </b><?php echo date('d-m-Y',$fetbooking['created_date']/1000); ?><br>
									<b>From Date : </b><?php echo date("d-m-Y",$fetbooking['from_date']/1000); ?><br>
									<b>To Date : </b><?php  echo date("d-m-Y",$fetbooking['to_date']/1000); ?> <br>
									<b>Address : </b><?php echo $fetseminar['address']; ?><br>
									<b>Booking No : </b> <?php echo $fetbooking['booking_no']; ?><br>
									</td>															
									<?php if($fetbooking['approval_status']=='accepted')
									 {
									?>
									<td><p style=" color:green; font-weight: bold; "><?php echo $fetbooking['approval_status']; ?> </p>
									<div class="text-uppercase dawonlod-ticket" data-toggle="modal" data-target="#myModal" onclick="booked('<?php echo $fetbooking['id'];?>');" >Download Ticket
									</div>
									</td>	
									 <?php
									 }	
									else
									{?>
										<td><p style=" color: #FF0000; font-weight: bold; "><?php echo $fetbooking['approval_status']; ?> </p>
									<?}										
									?>													
									</tr>						
									</tbody>				
									<?php					
									}	
									}
									 }
									else
									{?>
	                                   <div style="color:red;font-weight:bold;padding:10px;" align="center">
			                             No Seminars Found ...!
	                                  </div>
									<?
									}	
									
									?>
								</table>
								
						<div class="modal fade" id="myModal" role="dialog">

							<div class="modal-dialog">

							  <!-- Modal content-->

							  <div class="modal-content modal-c">

							  

								<div class="modal-header model-head">
									
								  <button type="button" class="close" data-dismiss="modal">&times;</button>
								  <h4 class="modal-title semibold-o">Download Ticket</h4>
								
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
							<h5>Your Previous Bookings</h5>
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
											<td style="width:100px;"><strong><strong>Booked On</strong></strong></td>
											<td style="width:100px"><strong>Property Name</strong></td>
											<td style="width:100px"><strong>Host</strong></td>
											<td style="width:140px"><strong>Dates and Location</strong></td>
											
											<td style="width:50px"><strong>Host Approval</strong></td>
											
										</tr>
									</thead>								
									<?php	
									$selbooking=mysql_query("select * from seminar_booking where uid=$_SESSION[jpmeetou][id]");									
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
										<td><img src="img/<?php echo $fetsemiphoto['image']; ?>" width="100" height="100" alt="Big Office - Electra City Tower"class="table-img"><a href="infomation.php?id=<?php echo $fetseminar['id']; ?>"><br><?php echo $fetseminar['title']; ?></a></td>		
										<td><?php echo $fetseminar['hostperson_name']; ?></td>					
										<td class="text-left"><br> <b>From Date :</b> <br><?php echo $fetbooking['from_date']; ?> <br><b>To Date :</b> <br><?php echo $fetbooking['to_date']; ?> <br><b>Address: </b><br><?php echo $fetseminar['address']; ?><br><label style="font-weight:bold;">Booking No :</label><?php echo $fetbooking['booking_no']; ?></td>			
										<td><p style=" color: #000; font-weight: bold; "><?php echo $fetbooking['approval_status']; ?>  </p></td>	
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

