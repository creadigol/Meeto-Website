<?php 
require_once('db.php');    
require_once('condition.php'); 
$row = mysql_fetch_array(mysql_query("select * from `seminar_booking` where seminar_id = '".$_REQUEST['id']."'"));
	
	//$rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = '".$row['uid']."'")); 
//$rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = '".$_SESSION['id']."'")); 
?>
<!DOCTYPE html>
<html lang="en">  
<?php	
	require_once('head1.php'); 
	?>
	<!-- NAVBAR================================================== -->
	<body onload="viewlisting('<?php echo $_REQUEST['id']; ?>');" style="overflow:auto !important">   
	<?php	require_once('header1.php');   ?>
	<!-- pop up start --> 
	<?php	require_once('usermenu.php');   ?>
	
	 
	
	<div class="container-flude container-margin background-container">	
	  <div class="container">		 
	    <div class="row">
	      
	        <div class="col-md-3">				
	           <div class="top-margin-20">
         	   </div>					
								
				<div class="top-margin-30"></div>
			</div>				
				<div class="col-md-8">	
				  <div class="top-margin-20"></div>	
				
				  <div class="row hedding-row tabcontent" id="Listings" style="display:block;">				
						<div class="col-md-12 Required-head listing-menu-button">
							
						</div>
						<div class="clearfix"></div>	
						<div class="row" id="viewlisting">
							
						</div>
						<div class="clearfix"></div>
				   </div>
				   
				
						
				</div>
			
						
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

