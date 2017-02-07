<?php 
require_once('db.php');     
if(isset($_REQUEST['submit_butto']))
{
	  $email=$_REQUEST['useremail'];
	  $checkemail = mysql_query("select * from user where email = '".$email."' and type ='1'");	
	   if(mysql_num_rows($checkemail) > 0)	
	   {  
        $fetchemail=mysql_fetch_array($checkemail);
	     if($email==$fetchemail['email']) 
		 {
		    $num = mt_rand(100000,999999);
			$key = md5($num);
			$id = $fetchemail['id']; 
	        $url = "http://www.meeto.jp/Verification.php?uid=".$id."&key=".$key;
			$subject = "Forget password";
			$to = $email;
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From:meeto.japan@gmail.com';
			
			$message  = '<html>';	
			$message .= '<body>';
			$message .= '<h2>Forget Your account password... Click the Button for Reset Your Password</h2>';
			$message .= '<table>';
			$message .= '<tr>';
			$message .= '<td align="center" width="300" height="40" bgcolor="#000091" style="border-radius:5px;color:#ffffff;display:block"><a href='.trim($url).' style="color:#ffffff;font-size:16px;font-weight:bold;font-family:Helvetica,Arial,sans-serif;text-decoration:none;line-height:40px;width:100%;display:inline-block">Reset  Your Account Password</a></td>';
			$message .= '</tr>';
			$message .= '</table>';
			$message .= '</div>';
			$message .= '</body>';
			$message .= '</html>';
			$sentmail = mail($to,$subject,$message,$headers);
			
			$insert_edetail=mysql_query("update user set password_varify='".$key."' where id='".$id."'");
            echo "<script>alert('
新しいパスワード送信されたメールについてメールをチェックし、パスワードをリセットしてください！');</script>";    
			echo "<script>location.href='index.php'</script>";
		 }
	   } 
       else
	   {
		   $checkemail = mysql_query("select * from user where email = '".$email."' and type ='2'");	
		   if(mysql_num_rows($checkemail) > 0)	
		   {  
				echo "<script>alert('このメールID Facebookアカウントで添付します。');</script>";  
		   }
		   else
		   {
			   echo "<script>alert('無効な電子メールID');</script>";  
		   }  
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
	<!-- pop up start -->
	<div class="container-flude background-container">	
	  <div class="container">		
	    <div class="row full-container">
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-md-8 col-md-offset-2">	
				<div class="top-margin-20"></div>			
				<div class="row hedding-row">
				<div class="col-md-12 Required-head">	
				   <h5>あなたのパスワードを忘れます</h5>		
				   </div>					
				   <ul class="nav">							
					<div class="clearfix"></div>
					<li class="li-input">			
					<label class="users">メールアドレスを入力 :</label>		
					<input type="email" class="input-name" name="useremail" id="" required value=""></br>
					<li class="li-input">
					  <div class="col-md-8 col-md-offset-4">
					   <button type="submit" name="submit_butto" class="blue-button save border-n">
提出します</button>
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
			
			

