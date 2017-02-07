<?php 
	require_once('db.php');    
	require_once('condition.php');
	$usphoid=$_SESSION['jpmeetou']['id'];
	if(isset($_REQUEST['subbtn']))	
	{	
     if($_SESSION['jpmeetou']['type']==1)
	 {
		$tt=$_FILES['profile'][type];		
		$s=substr($tt,6);	
		if($s=="jpeg" || $s=="jpg" || $s=="png")	
		{		
			$dt=date("Y-m-d");		
			$dt2=(int)round(microtime($dt)*1000);
			$oldname=$_FILES[profile][name];
			$ran=rand(0,999999);	
			$curname="profileimg".$ran.".".$s;	
			$newname="../img/".$curname;
			$seluserdetailid=mysql_query("select * from user_detail where uid=$usphoid");
			if(mysql_num_rows($seluserdetailid) > 0)
			{
				$uppro=mysql_query("update user_detail set photo='$curname' where uid=$usphoid");	
			}
			else
			{
				$insertuserdetail=mysql_query("insert into user_detail (uid,gender,dob,phoneno,countryid,stateid,cityid,address,yourself,photo) values ($usphoid,'','','','','','','','','$curname')");
			}
			move_uploaded_file($_FILES['profile']['tmp_name'], $newname);  
 			$_SESSION['jpmeetou']['profileimage']=$curname;
			
		}	
	  }
	}
$row = mysql_fetch_array(mysql_query("select * from user where id = '".$usphoid."'")); 
$rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = '".$usphoid."'")); 
$rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = '".$usphoid."'")); 
 
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
	      
	        <div class="col-md-3">				
	           <div class="top-margin-20">
         	   </div>					
				<ul class="nav edit">	
				<li>	
					<a href="Editprofile.php">
プロファイル編集</a>
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
					<a href="Verification.php" class="">
信頼と検証</a>				
				</li>			
				</ul>		
				<div class="top-margin-20"></div>
				<span class="center-block">	
				<a class="blue-button" href="view-profile.php?id=<?php echo $usphoid; ?>">プロフィールを見る</a>	
				</span>					
				<div class="top-margin-30"></div>
			</div>
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-md-8">	
				<div class="top-margin-20"></div>			
				<div class="row hedding-row">
				<div class="col-md-12 Required-head">	
				   <h5>
写真</h5>		
				   </div>					
						<div class="col-md-8 photo-right">
							<div class="top-margin-20"></div>
							<p>
								
ホストと賃借人がお互いを知っているためにクリア正面の顔写真が重要です。風景は明らかにあなたの顔を示している写真をアップロードしてくださいお互いを知ることができ、あなたの信頼性を損なうものではありません。
							</p>
							
							<center>
								<!--<button class="take-photo">Upload a file from your computer</button>-->								<input required type="file"  name="profile" class="take-photo" onchange="changeimg(this);" accept="image/*"/>
							</center>
							
							<div class="top-margin-10"></div>
							
							<center>
							
							<div class="clearfix"></div>
							<div class="top-margin-10"></div>
							
							<button type="submit" name="subbtn" class="blue-button border-n">
写真を更新する</button>
							
							<div class="top-margin-10">&nbsp;</div>
							</center>
							
						</div>					
						<div class="col-md-4">	
						<div class="top-margin-20"></div>	
						<center>						
						<?php						
						if($rowuserdetail['photo']=="" || !file_exists("../img/".$rowuserdetail['photo']))
							{				
						?>				
						<img src="#" id="profileimg" style="width:100%;display:none;" class="img img-responsive" />		
						<?php					
						}						
						else					
							{					
						?>						
						<img src="../img/<?php echo $rowuserdetail['photo']; ?>" id="profileimg" style="width:100%;" class="img img-responsive" />	
						<?php				
						}					
						?>					
						</center>			
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