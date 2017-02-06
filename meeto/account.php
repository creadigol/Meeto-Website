<?php  
require_once('db.php'); 
require_once('condition.php');  

if($_POST)
{
  $old_password = md5($_POST['old_password']);	
  $new_password = $_POST['new_password'];	
  $confirm_password  = $_POST['confirm_password'];
	
  $pwd = mysql_fetch_array(mysql_query("select * from user where id='".$_SESSION['jpmeetou']['id']."'"));
  $data_pwd=$pwd['password'];
  
   if($data_pwd==$old_password)
   {
	  // echo "<script>alert('hiii');</script>";
	   
		if($new_password==$confirm_password)
		{ 
	    $new_pass=md5($new_password);
		$update_pwd=mysql_query("update user set password='".$new_pass."' where id='".$_SESSION['jpmeetou']['id']."'");
		echo "<script>alert('Update Sucessfully !!!');</script>";
		}
		else
		{
		echo "<script>alert('Your New and Confirm password is not match !!!');</script>";
		}
	}
	else
	{
		echo "<script>alert('Your old password is wrong !!!!');</script>";
	}
	
}
?>

<!DOCTYPE html>
<html lang="en">  
<?php	
	require_once('head1.php'); 
	?>
	
<style>
a.account_menu, a.account_menu:hover{
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
	<div class="container-flude container-margin background-container">	
	  <div class="container">		
	    <div class="row password-box">
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-md-8 col-md-offset-2">	
				<div class="top-margin-20"></div>			
				<div class="row hedding-row">
				<div class="col-md-12 Required-head">	
				   <h5>Change Your Password</h5>		
				   </div>				
				   <ul class="nav">			
				   <li class="li-input">	
				     <div class="top-margin-10">&nbsp;</div>	
				     <label class="users">Old Password :</label>				
				     <input type="password" class="input-name" name="old_password" id="" required  value="">		
					</li>				
					<div class="clearfix"></div>
					<li class="li-input">			
					<label class="users">New Password :</label>		
					<input type="password" class="input-name" name="new_password" id="" required pattern=".{6,}" title="Password should be minimum 6 character" value="">									</br>
					</li>								
					  <div class="clearfix"></div>	
					<li class="li-input">			
					<label class="users">confirm Password :</label>		
					<input type="password" class="input-name" name="confirm_password" id="" required pattern=".{6,}" title="Password should be minimum 6 character" value="">									</br>
					</li>
					<li class="li-input">
					  <div class="col-md-8 col-md-offset-4 col-sm-8 col-sm-offset-4 col-xs-8 col-xs-offset-4">
					   <button type="submit" name="submit_butto" class="blue-button save border-n">Update Password</button>
					  </div>
					</li>
					<div class="top-margin-20">&nbsp;</div>
					</ul>
					</div>
				</div>
			</form>		
	        			
		</div>
	</div>
	<div class="top-margin-20">&nbsp;</div>
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