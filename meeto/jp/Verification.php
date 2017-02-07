<?php 
require_once('db.php');
 $_SESSION['jpmeetou']['id']=$_REQUEST['uid'];
//require_once('condition.php'); 
if(isset($_REQUEST['subbtn']))
{	   
			$email=$_SESSION['jpmeetou']['uemail'];
			$uid=$_SESSION['jpmeetou']['id'];
            $key= md5($email);
	        $url = "http://www.meeto.jp/jp/Verification.php?uid=".$uid."&key=".$key;
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
			
			echo "<script>alert('確認メールを送信しました...あなたのメールをチェックして、アカウントを検証するために有効化]ボタンをクリックしてください！');</script>";
			
}

$row = mysql_fetch_array(mysql_query("select * from user where id = '".$_SESSION['jpmeetou']['id']."'")); 
$_SESSION['jpmeetou']['uemail']=$row['email'];
$rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = '".$_SESSION['jpmeetou']['id']."'")); 
$rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = '".$_SESSION['jpmeetou']['id']."'")); 

if($_REQUEST['uid']==$_SESSION['jpmeetou']['id'] )
{
	if ($row['email_verify']==0)
	{  
		$upuser=mysql_query("update user set email_verify=1 where id='".$_SESSION['jpmeetou']['id']."'"); 
		echo "<script>alert('
メールSucessfullyを確認します');</script>";
		echo "<script>location.href='index.php'</script>";
	}
	else
	{
	 echo "<script>alert('あなたの電子メールは、すでに検証されます');</script>";
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
					<a href="#">プロファイル編集</a>
				</li>	
		<?php 
           if($_SESSION['jpmeetou']['type']==1)
            {?>   
				<li>						
					<a href="photos.php" class="">写真</a>	
				</li>
			<?
			}
		  ?>							
				<li>	
					<a href="Verification.php" class="">信頼と検証</a>				
				</li>			
				</ul>		
				<div class="top-margin-20"></div>
				<span class="center-block">	
				<a class="blue-button button-a" href="view-profile.php?id=<?php echo $_SESSION['jpmeetou']['id']; ?>">プロフィールを見る</a>	
				</span>			
				
				<div class="top-margin-30"></div>
			</div>
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-md-8">	
				<div class="top-margin-20"></div>			
				<div class="row hedding-row">				
						<div class="col-md-8 verify-id">
							<p><b>あなたのIDを確認します</b></p> 
							<p>
あなたの認証IDを取得すると、コミュニティの信頼関係の構築を支援する最も簡単な方法です。私たちは、公式のIDにオンラインアカウントからの情報を照合することによって、あなたを確認します。</p> 
							<p>
または、あなただけが下記する検証を追加することを選択することができます。</p> 
						</div>

						<div class="col-md-4 text-center verify-button">
						<div class="clearfix"></div>	
						<?php
						if($row['email_verify']==0)	
						{						
						?>							
						<button type="submit"  name="subbtn" class="blue-button">私を確認します</button>								
						<?php					
						}						
						?>
							
						</div>
				   </div>
				   
				   <div class="top-margin-20">&nbsp;</div>
				   
				   <div class="row hedding-row">
						<div class="col-md-12 Required-head Verification-head">	
							<h5>検証	
							<img src="img/quest.png" class="r-left" onMouseOver="show_sidebar()" onMouseOut="hide_sidebar()" />
							
							<div id="sidebar" class="verifi">
							
検証は、賃借人とホスト間の信頼関係を構築し、より簡単に予約することができます助けます。 
							</div>
													
							</h5>	
						</div>					
						<div class="col-md-8 photo-right">
							<div class="notification_action viewd">
							  <p class="nothing">   </p>
							  <h5 class="black-tetx"><b>
メールアドレスの確認</b></h5>
							  <br>
							  <?php		
							  if($row['email_verify']==0)
							  {
								  echo "Not Verified";
							  }						
							  else	
							  {
								  echo "Verified"; 
							  }								 					
							  ?>
							  
							  <p class="nothing"></p>
							  <br>
							  <h5 class="black-tetx"><b>電話番号の確認</b></h5>
							  <br>
							 
検証されていない			 
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


