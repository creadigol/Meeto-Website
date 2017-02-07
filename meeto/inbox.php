<?php 
require_once('db.php');   
 require_once('condition.php');
 
  $seminardetail=mysql_query("select * from seminar where uid = '".$_SESSION['jpmeetou']['id']."' order by id");
  
?>
<!DOCTYPE html>
<html lang="en">

<?php
	require_once('head1.php'); 
?>
<script>
 function sendmail(id)
 {
	 
 }
</script>
	
<style>
a.inbox_menu, a.inbox_menu:hover{
	background-color:#f9f9f9 !important;
	color:#7323DC !important;
	border-bottom:none !important;
	font-weight:bold !important;
	border-top:5px solid #7323dc !important;
	padding-top:7px !important;
}
</style>		
	
	<!-- NAVBAR================================================== -->
	<body>   
	<?php	require_once('header1.php');   ?>
	<?php	require_once('usermenu.php');   ?>
	<!-- pop up start -->
	<div class="container-flude container-margin full-container">	
	  <div class="container">		
	    <div class="row">
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-md-10 col-md-offset-1">	
				<div class="top-margin-20"> </div>	
					<div class="row hedding-row">				
							<div class="clearfix"></div>
							
						
							<div class="col-md-12 tabel-scroll">
								<table width="95%" border="0" cellspacing="0" cellpadding="0" class="center-block li-padding" id=" ">
								    <thead>
										
									     <h3 class="Required-head">Your Seminar Booking List</h3>
										 
 										<tr class="border-n inbox table-head inbox-table">
											<td width="5%"><strong>Sno</strong></td>
											<td width="13%"><strong>Date</strong></td>
											<td width="17%"><strong>Seminar</strong></td>
											<td width="17%"><strong>User</strong></td>
											<td width="17%"><strong>Total seat</strong></td>
											<td width="13%"><strong>Booking No</strong></td>
											<td width="17%"><strong>Action</strong></td>
										</tr>
									</thead>
									<tbody>
										<?php
                                             $i=1;
                                            while($seminar=mysql_fetch_array($seminardetail))
                                            {
                                             $bkseminars=mysql_query("select * from seminar_booking where seminar_id='".$seminar['id']."' order by id desc ");
                                       
                                              while($bookseminar=mysql_fetch_array($bkseminars))
                                              {
                                                
                                              $date = date("d-m-Y",$bookseminar['created_date']/1000);
                                                $bookseminaruser=mysql_fetch_array(mysql_query("select * from user where id='".$bookseminar['uid']."'"));  
											  
										?>
										 <tr class="border-n inbox table-head">
											<td><?php echo $i; ?></td>
											<td><?php echo $date; ?></td>
											<td><?php echo  $seminar['title'];?></td>
											<td><?php echo  $bookseminaruser['fname'];?></td>
											<td><?php echo  $bookseminar['book_seat'];?></td>
											<td><?php echo $bookseminar['booking_no']; ?></td>
											<td id="status123">
											<?php
											if($bookseminar['approval_status']=='pending')
											{
											?>
											<button type="button" value="accepted" class="green-button" onclick="seminarstatus('<?php echo $bookseminar['id'];?>',this.value);">Accept</button>
											<button type="button" value="declined" class="red-button" onclick="seminarstatus('<?php echo $bookseminar['id'];?>',this.value);">Decline</button>
											<?php
											}
											elseif($bookseminar['approval_status']=='accepted')
											{
											$status=$bookseminar['approval_status'];
											?>
                                            <p style="color:green;font-weight:bold;"> <? echo $status; ?> </p>                                            
											<?php
											}
											else
											{
												$status=$bookseminar['approval_status'];
											?>
                                            <p style="color:red;font-weight:bold;"> <? echo $status; ?> </p>                                            
											<?php 
											}
											
				
											?>
											</td>
										 </tr>
										<?php
										$i++;
										 }
										
										}
									
										?>
									</tbody>
								</table>
							</div>
							
						<div class="clearfix"></div>
					</div>
				<div class="top-margin-30">&nbsp;</div>						

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
