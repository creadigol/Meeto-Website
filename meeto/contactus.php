<!DOCTYPE html>
<html lang="en">  
<?php 
	require_once('db.php');
	require_once('head1.php'); ?>
	
<style>
body{color:#5b5b5b;
    font-size:15px;}
header{
	position:fixed !important;
	background:#000 !important;	
}
.full-container{
	margin-top:84px;
	overflow-x:hidden;
	background-color:#f9f9f9;
}
a.dashboard_menu, a.dashboard_menu:hover{
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
<?php require_once('header1.php');   ?>
<?php	require_once('loginsignup.php'); 	?>	
<!-- pop up start -->
	<div class="container-flude full-container">	
	  <div class="container" style="width:80%;">		
	    <h3 style="color:#7323dc;">Contact Us</h3><br>

	    <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeJlT6wBot6hY8xfcBl8VMVCa1Xn_j14hN5IERKzK77kfVdZQ/viewform?embedded=true" width="760" height="820" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
	 </div>
	</div>
</div>

<div class="top-margin-20"></div>

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