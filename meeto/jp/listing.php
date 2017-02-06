<?php 
require_once('db.php');    
if(isset($_REQUEST['subbtn'])){		$upuser=mysql_query("update user set email_verify=1 where id=$_SESSION[jpmeetou][id]");
}	 
$row = mysql_fetch_array(mysql_query("select * from user where id = '".$_SESSION['jpmeetou']['id']."'")); 
$rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = '".$_SESSION['jpmeetou']['id']."'")); 
$rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = '".$_SESSION['jpmeetou']['id']."'")); 
 
?>
<!DOCTYPE html>
<html lang="en">  
<?php	
	require_once('head.php'); 
	?>
	<!-- NAVBAR================================================== -->
	<body>   
	<?php	require_once('header.php');   ?>
	<!-- pop up start -->
	<div class="container-flude full-container background-container">	
	  <div class="container">		
	    <div class="row">
	      
	        <div class="col-md-3">				
	           <div class="top-margin-20">
         	   </div>					
				<ul class="nav edit">	
				<li class="activet">	
					<a href="#">Manage Listings</a>
				</li>						
				<li>						
					<a href="#">Your Reservations  </a>	
				</li>			
				<li>	
					<a href="#">Reservation Requirements</a>				
				</li>		
				</ul>					
				<div class="top-margin-30"></div>
			</div>
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-md-8">	
				<div class="top-margin-20"></div>			
				<div class="row hedding-row">				
						<div class="col-md-12 Required-head listing-menu-button">
							<span class="listing-menu" data-target="dropdown-menu" data-toggle="dropdown">show : All Listings<span class="caret"></span></span>
							  <div class="dropdown-menu sing-menu">
								<a class="dropdown-item f-left" href="#">Show all listings</a>
								<a class="dropdown-item f-left" href="#">Show active</a>
								<a class="dropdown-item f-left" href="#">Show hidden</a>
							  </div>							
						
						</div>
							<div class="clearfix"></div>
						<div class="row listing-img-button">
							<div class="col-md-3">
								<img src="img/dummyimage.jpg" class="img-responsive">
							</div>
							<div class="col-md-5">
								<h4 class="semibold-o black-tetx">img-name</h4>
								<a href="list-Continue.php"><h5 class="forgot">Manage Listing and Calendar </h5></a>
							</div>
							<div class="col-md-4 text-center steps-button">
								<a href="#" class="blue-button steps-button-list">6 steps to list</a>
							</div>
							<hr /> 
							
						</div>
						
						<div class="row listing-img-button">
							<div class="col-md-3">
								<img src="img/dummyimage.jpg" class="img-responsive">
							</div>
							<div class="col-md-5">
								<h4 class="semibold-o black-tetx">img-name</h4>
								<a href="list-Continue.php"><h5 class="forgot">Manage Listing and Calendar </h5></a>
							</div>
							<div class="col-md-4 text-center steps-button">
								<a href="#" class="blue-button steps-button-list">6 steps to list</a>
							</div>

						</div>
						
						<div class="row listing-img-button">
							<div class="col-md-3">
								<img src="img/dummyimage.jpg" class="img-responsive">
							</div>
							<div class="col-md-5">
								<h4 class="semibold-o black-tetx">img-name</h4>
								<a href="list-Continue.php"><h5 class="forgot">Manage Listing and Calendar </h5></a>
							</div>
							<div class="col-md-4 text-center steps-button">
								<a href="#" class="blue-button steps-button-list">6 steps to list</a>
							</div>	
						</div>
						
						<div class="row listing-img-button">
							<div class="col-md-3">
								<img src="img/dummyimage.jpg" class="img-responsive">
							</div>
							<div class="col-md-5">
								<h4 class="semibold-o black-tetx">img-name</h4>
								<a href="list-Continue.php"><h5 class="forgot">Manage Listing and Calendar </h5></a>
								
							</div>
							<div class="col-md-4 text-center steps-button">
								<a href="#" class="blue-button steps-button-list">6 steps to list</a>
							</div>
						</div>

						<div class="row listing-img-button">
							<div class="col-md-3">
								<img src="img/dummyimage.jpg" class="img-responsive">
							</div>
							<div class="col-md-5">
								<h4 class="semibold-o black-tetx">img-name</h4>
								<a href="list-Continue.php"><h5 class="forgot">Manage Listing and Calendar </h5></a>
								
							</div>
							<div class="col-md-4 text-center steps-button">
								<a href="#" class="blue-button steps-button-list">6 steps to list</a>
							</div>
						</div>

						<div class="row listing-img-button">
							<div class="col-md-3">
								<img src="img/dummyimage.jpg" class="img-responsive">
							</div>
							<div class="col-md-5">
								<h4 class="semibold-o black-tetx">img-name</h4>
								<a href="list-Continue.php"><h5 class="forgot">Manage Listing and Calendar </h5></a>
								
							</div>
							<div class="col-md-4 text-center steps-button">
								<a href="#" class="blue-button steps-button-list">6 steps to list</a>
							</div>
						</div>
							<div class="clearfix"></div>
				   </div>
				</div>
				
			</form>				
		</div>
	</div>
	<div class="top-margin-20">&nbsp;</div>
</div>


<?php
require_once('footer.php');
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
	


