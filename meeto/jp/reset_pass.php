<?php
require_once('db.php'); 
if($_POST)
{
  $id=$_REQUEST['uid'];
  $new_password = $_POST['new_password'];	
  $confirm_password  = $_POST['confirm_password'];	
  $pwd = mysql_fetch_array(mysql_query("select * from user where id='".$id."'"));
  $data_pwd=$pwd['password'];
  
		if($new_password==$confirm_password)
		{ 
	      $new_pass=md5($new_password);
		  $update_pwd = mysql_query("update user set password='".$new_pass."',password_varify='0' where id='".$id."'");
		  echo "<script>alert('パスワードSucessfullyをリセット！');</script>";
		  echo "<script>location.href='index.php'</script>";
		}
		else
		{
		echo "<script>alert('あなたの新しいパスワードの確認が一致しませんです！');</script>";
		}
}
?>
<!DOCTYPE html>
<html lang="en">  
<?php	
require_once('head1.php'); 
require_once('header1.php');
	?>
<!-- NAVBAR================================================== -->
<body>   
<?php
 $id=$_REQUEST['uid'];
 $key=$_REQUEST['key'];
  
$seluserdetail=mysql_fetch_array(mysql_query("select * from user where id='".$id."'"));
   if($key == $seluserdetail['password_varify'])
   {
	 ?>
	  <div class="container-flude background-container">	
	  <div class="container">		
	    <div class="row full-container">
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-md-8 col-md-offset-2">	
				<div class="top-margin-20"></div>			
				<div class="row hedding-row">
				<div class="col-md-12 Required-head">	
				   <h5><?php echo RESET_YOUR_PASSWORD;?></h5>		
				   </div>					
				   <ul class="nav">						
					<div class="clearfix"></div>
					<li class="li-input">			
					<label class="users">新しいパスワード ：</label>		
					<input type="password" class="input-name" name="new_password" id="" required pattern=".{6,}" title="Password should be minimum 6 character"value="">	
					</br>
					</li>								
					  <div class="clearfix"></div>	
					<li class="li-input">			
					<label class="users">パスワードを認証する ：</label>		
					<input type="password" class="input-name" name="confirm_password" id="" required pattern=".{6,}" required title="Password should be minimum 6 character" value=""></br>
					</li>
					<li class="li-input">
					  <div class="col-md-8 col-md-offset-4">
					   <button type="submit" name="submit_butto" class="blue-button save border-n"><?php echo UPDATE_PASSWORD;?></button>
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
   }
 else
   {
	?>
	 <div class="container-flude background-container">	
	  <div class="container">		
	    <div class="row full-container">		
				<div class="col-md-8 col-md-offset-2">	
				<div class="top-margin-20"></div>			
				<div class="row hedding-row">
				<div class="col-md-12 Required-head">	
				   <h5>
あなたのパスワードをリセット</h5>		
				   </div>		
				   
				   <ul class="nav">						
					<div class="clearfix"></div>
					<li class="li-input">			
					<label class="users">
あなたはalredyあなたのパスワードをリセット</label>		
					</li>
				 <div class="top-margin-20">&nbsp;</div>
				</ul>		
		  </div>
	     </div>
	    <div class="top-margin-20">&nbsp;</div>
     </div>
   </div>
</div>
<?php 
   }
?>
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
