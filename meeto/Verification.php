<?php 
require_once('db.php');
 $_SESSION['jpmeetou']['id']=$_REQUEST['uid'];
 
//require_once('condition.php'); 
if(isset($_REQUEST['subbtn']))
{	   
			$email=$_SESSION['jpmeetou']['email'];
			$uid=$_SESSION['jpmeetou']['id'];
            $key= md5($email);
	        $url = "http://www.meeto.jp/Verification.php?uid=".$uid."&key=".$key;
			//echo "<script>alert('".$url."');</script>"; 
			$subject = "Email Verification";
			$to = $email;
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From:meeto.japan@gmail.com';
			$message  = '<html>';	
			$message .= '<body>';
			$message .= '<h2>To Verification your account please click on Activate buttton</h2>';
			$message .= '<table>';
			$message .= '<tr>';
			$message .= '<td align="center" width="300" height="40" bgcolor="#000091" style="border-radius:5px;color:#ffffff;display:block"><a href='.trim($url).' style="color:#ffffff;font-size:16px;font-weight:bold;font-family:Helvetica,Arial,sans-serif;text-decoration:none;line-height:40px;width:100%;display:inline-block">Verify Your Account</a></td>';
			$message .= '</tr>';
			$message .= '</table>';
			$message .= '</div>';
			$message .= '</body>';
			$message .= '</html>';
			$sentmail = mail($to,$subject,$message,$headers);
			
			echo "<script>alert('A Verification email has been sent... Please check your mail and click on the Activate Button to Verification your account!');</script>";
			
}

$row = mysql_fetch_array(mysql_query("select * from user where id = '".$_SESSION['jpmeetou']['id']."'")); 
$_SESSION['jpmeetou']['email']=$row['email'];
$rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = '".$_SESSION['jpmeetou']['id']."'")); 
$rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = '".$_SESSION['jpmeetou']['id']."'")); 

if($_REQUEST['uid']==$_SESSION['jpmeetou']['id'] )
{
	if ($row['email_verify']==0)
	{  
		$upuser=mysql_query("update user set email_verify=1 where id='".$_SESSION['jpmeetou']['id']."'"); 
		echo "<script>alert('Email verify Sucessfully');</script>";
		echo "<script>location.href='index.php'</script>";
	}
	else
	{
	 echo "<script>alert('you  Email is Already Verified');</script>";
	 echo "<script>location.href='index.php'</script>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">  
<?php	
	require_once('head1.php'); 
	?>
	<!-- NAVBAR================================================== -->
	<body>   
	<?php	require_once('header1.php');   ?>
	<?php	require_once('usermenu.php');   ?>
	<!-- pop up start -->
	<div class="container-flude container-margin background-container">	
	  <div class="container">		
	    <div class="row">
	      
	        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 side-menu">				
	           <div class="top-margin-20">
         	   </div>					
				<ul class="nav edit">	
				<li class="activet">	
					<a href="#">Edit Profile</a>
				</li>						
				<?php 
			if($_SESSION['jpmeetou']['type']==1)
			{?>   
				<li>						
					<a href="photos.php" class="">Photos</a>	
				</li>
			<?
			}
		    ?>		
				<li>	
					<a href="Verification.php" class="">Trust and Verification</a>				
				</li>			
				</ul>		
				<div class="top-margin-20"></div>
				<span class="center-block">	
				<a class="blue-button button-a" href="view-profile.php?id=<?php echo $_SESSION['jpmeetou']['id']; ?>">View Profile</a>	
				</span>			
				
				<div class="top-margin-30"></div>
			</div>
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-md-8">	
				<div class="top-margin-20"></div>			
				<div class="row hedding-row">				
						<div class="col-md-8 verify-id">
							<p><b>Verify your ID</b></p> 
							<p>Getting your Verified ID is the easiest way to help build trust in the community. We'll verify you by matching information from an online account to an official ID.</p> 
							<p>Or, you can choose to only add the verifications you want below.</p> 
						</div>

						<div class="col-md-4 text-center verify-button">
						<div class="clearfix"></div>	
						<?php
						if($row['email_verify']==0)	
						{						
						?>							
						<button type="submit"  name="subbtn" class="blue-button">Verifyme</button>								
						<?php					
						}
                        else
						 {
							 echo "<h5>Verified</h5>"; 
						 }						
						?>
							
						</div>
				   </div>
				   
				   <div class="top-margin-20">&nbsp;</div>
				   
				   <div class="row hedding-row">
						<div class="col-md-12 Required-head Verification-head">	
							<h5>Verifications 	
							<img src="img/quest.png" class="r-left" onMouseOver="show_sidebar()" onMouseOut="hide_sidebar()" />
							
							<div id="sidebar" class="verifi">
							Verifications help build trust between renters and hosts and can make booking easier. 
							</div>
													
							</h5>	
						</div>					
						<div class="col-md-8 photo-right">
							<div class="notification_action viewd">
							  <p class="nothing">   </p>
							  <h5 class="black-tetx"><b>Email Address Verification</b></h5>
							  <br>
							  <?php		
							  if($row['email_verify']==0)
							  {
								  echo "<h5>Not Verified</h5>";
							  }						
							  else	
							  {
								  echo "<h5>Verified</h5>"; 
							  }								 					
							  ?>
							  
							 <!-- <p class="nothing"></p>
							  <br>
							  <h5 class="black-tetx"><b>Phone Number Verification</b></h5>
							  <br>
							  Not Verified-->			 
							</div>
						</div>
				   </div>
					<div class="top-margin-20">&nbsp;</div>
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
	
<script type="text/javascript">
function show_sidebar()
{
document.getElementById('sidebar').style.visibility="visible";
}

function hide_sidebar()
{
document.getElementById('sidebar').style.visibility="hidden";
}
</script>


