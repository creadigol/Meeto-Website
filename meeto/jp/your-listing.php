<?php 
require_once('db.php');    
require_once('condition.php'); 
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
a.listing_menu, a.listing_menu:hover{
	background-color:#f9f9f9 !important;
	color:#7323DC !important;
	border-bottom:none !important;
	font-weight:bold !important;
	border-top:5px solid #7323dc !important;
	padding-top:7px !important;
}
</style>
	
	
	<!-- NAVBAR================================================== -->
	<body onload="showlisting('','','');" style="overflow:auto !important">   
	<?php	require_once('header1.php');   ?>
	<!-- pop up start --> 
	<?php	require_once('usermenu.php');   ?>
	
	 
	
	<div class="container-flude container-margin background-container">	
	  <div class="container">		 
	    <div class="row">
	      
	       <!-- <div class="col-md-3">				
	           <div class="top-margin-20">
         	   </div>					
				<ul class="nav edit listing">	
					<li><a href="#" class="tablinks active" onclick="openCity(event,'Listings')">
掲載を管理します</a></li>
					<li><a href="#" class="tablinks" onclick="openCity(event,'Reservations')">
ご予約</a></li>			
					<li><a href="#" class="tablinks" onclick="openCity(event,'Verified')">
予約の要件</a></li>
				</ul>					
				<div class="top-margin-30"></div>
			</div>-->
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-md-8 col-md-push-2">	
				<div class="top-margin-20"></div>	
				
				<div class="row less-row hedding-row tabcontent" id="Listings" style="display:block;">				
						<div class="col-md-12 Required-head listing-menu-button">
							<div class="row">
							<select name="listing" onchange="showlisting('','',this.value);" >
							<option value=""><?php echo SHOW_ALL_LISTING; ?></option>
							<option value="approved"><?php echo SHOW_APPROVED; ?></option>
							<option value="pending"><?php echo SHOW_PENDING; ?></option>
							</select>          
															
							</div>
						</div>
							<div class="clearfix"></div>	
							<div class="row" id="listseminar">
							
							</div>
							<div class="clearfix"></div>
				   </div>
				   
				<div class="row hedding-row tabcontent" id="Reservations">				
							<div class="clearfix"></div>
							<div class="col-md-8 reservation">
							<div class="top-margin-10"></div>
							<br>
								<p><a href="#" class="forgot"><?php echo VIEW_PAST_RESERVATION_HISTORY; ?></a></p>
							</div>
				   </div>
						
	 
				   
				   
				<!--<div class="row hedding-row tabcontent" id="Verified">				
						<div class="col-md-12 Required-head">
							<h5>認証ID</h5s>
						</div>
							<div class="clearfix"></div>
							<div class="col-md-8 reservation">
								<p>あなたのゲストはあなたと一緒に予約する前に、自分のIDを確認する必要があります。<a href="#" class="forgot">
もっと詳しく知る</a></p>
								<p> 
あなたは自分のIDを確認するために、ゲストを必要とする前に、あなたはあなたを確認する必要があります！</p>
								<p><a href="#" class="forgot">
あなたのIDを確認します</a> 
この要件を有効にします。</p>
								<span>
									<input name="verify_id" class="f-left" id=" " type="checkbox" disabled="disabled">
									<p>&nbsp;
検証を通過するゲストを必要とします </p>
									<div class="top-margin-20"></div>
								</span>
							</div>
							<div class="clearfix"></div>
							<hr>
							
							<div class="col-md-6 reservation">
								&nbsp;
							</div>
							<div class="col-md-6 reservation text-right">
								<a href="#" class="blue-button">
予約の要件</a>
								<div class="top-margin-10"></div>
							</div>
							
				   </div>-->
				</div>
			
			</form>				
		</div>
	</div>
	<div class="bottom-margin-20">&nbsp;</div>




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

