<?php
if(!session_id()) {
   session_start();
}
 require_once('db.php'); 
	if($_POST)
	{	
		$fname = $_POST['user_fname'];
		$lname = $_POST['user_lname'];	
		$email = $_POST['email'];	
		$password = $_POST['pass'];	
		$password_hash = md5($password);	
		$created_at = round(microtime(true) * 1000);		
		if(isset($_POST['email']) && isset($_POST['email']) != '' && isset($_POST['user_fname']) && isset($_POST['user_fname']) != '')
		{		
			$checkemail = mysql_query("select * from user where email = '".$email."'");	
			if(mysql_num_rows($checkemail) > 0)	
			{		
				echo "<script>alert('Email Id Already Exist..!');</script>";		
			}		
			else	
			{	
				$insert_edetail = mysql_query("insert into user (fname,lname,email,password,type,fb_id,email_verify,status,created_date,modified_date) values('".$fname."','".$lname."','".$email."','".$password_hash."',1,'',0,1,'".$created_at."','".$created_at."')");	
				//echo "insert into user (fname,lname,email,password,type,fb_id,email_verify,status,created_date,modified_date) values('".$fname."','".$lname."','".$email."','".$password_hash."',1,'',0,1,'".$created_at."','".$created_at."')";
			}		
			if($insert_edetail==1)
			{		
				$checkemail = mysql_query("select * from user where id in (select max(id) from user)");	
				$fet=mysql_fetch_array($checkemail);
				$_SESSION['id']=$fet['id'];
				$seluserdetail=mysql_query("select * from user_detail where uid=$_SESSION[id]");
				$fetuserdetail=mysql_fetch_array($seluserdetail);
				$_SESSION['email']=$fet['email'];
				$_SESSION['fname']=$fet['fname'];
				$_SESSION['lname']=$fet['lname'];
				$_SESSION['profileimage']=$fetuserdetail['photo'];
				echo "<script>window.location.href='index.php'</script>";		
			}	
		}
	}
	if(isset($_POST['login']))
	{
		$email = $_POST['user_email'];	
		$password = md5($_POST['password']);
		$checkemail = mysql_query("select * from user where email = '".$email."' and password = '".$password."'");	
		if(mysql_num_rows($checkemail)>0)		
		{	
			$fet=mysql_fetch_array($checkemail);
			
			$_SESSION['id']=$fet['id'];
			$seluserdetail=mysql_query("select * from user_detail where uid=$_SESSION[id]");
			$fetuserdetail=mysql_fetch_array($seluserdetail);
			$_SESSION['email']=$fet['email'];
			$_SESSION['fname']=$fet['fname'];
			$_SESSION['lname']=$fet['lname'];
			$_SESSION['profileimage']=$fetuserdetail['photo'];
			$_SESSION['type']=$fet['type'];
			echo "<script>window.location.href='index.php'</script>";		
		}
		else
		{
			echo "<script>alert('Invalid Login Detail..!');</script>";
		}
	}
	if(isset($_SESSION['facebook_access_token']))
	{
		
		$email = $_SESSION['email'];
		$fname = $_SESSION['fname'];
		$lname = $_SESSION['lname'];
		$fb_id = $_SESSION['fb_id'];
		$created_at = round(microtime(true) * 1000);
		$_SESSION['type'] ="2";
		$checkemail = mysql_query("select * from user where fb_id = '".$fb_id."'");	
			if(mysql_num_rows($checkemail) > 0)	
			{		
				$selfbuser = mysql_query("select * from user where fb_id=$fb_id");	
				$fetfbuser=mysql_fetch_array($selfbuser);
				$_SESSION['id']=$fetfbuser['id'];	
			}		
			else	
			{	
				$insert_edetail = mysql_query("insert into user (fname,lname,email,password,type,fb_id,email_verify,status,created_date,modified_date) values('".$fname."','".$lname."','".$email."','',2,'".$fb_id."',0,1,'".$created_at."','".$created_at."')");
				
				$selfbuser = mysql_query("select * from user where fb_id=$fb_id");	
				$fetfbuser=mysql_fetch_array($selfbuser);
				$_SESSION['id']=$fetfbuser['id'];
				echo "<script>window.location.href='index.php'</script>";
			}	
		  
	}
?>
<script> 
  function seachcity()
  {
	  var city = document.getElementById('city').value
	  $.ajax({
		url: "miss2.php?kon=seachcity&city="+city, 
		type: "POST",
		success: function(data)
		{
		    $("#citysuggetion").html(data);
				
		}
		});
  }
  function citylist()
  {
	  var city = document.getElementById('cityname').value
	  alert(city);
	  $.ajax({
		url: "miss2.php?kon=citylist&city="+city, 
		type: "POST",
		success: function(data)
		{
		    $("#city").html(data);
			$("#citysuggetion").hide;	
		}
		});
  }
</script>
<!DOCTYPE html>
<html lang="en">
  <?php
	require_once('head.php');
	
  ?>
<!-- NAVBAR
================================================== -->
  <body>
    
  <?php
	require_once('header.php'); 
	
  ?>

	
<!-- pop up start -->


			<!-- Sing in modal -->
				<?php
					require_once('loginsignup.php'); 
				?>
					

 <!-- pop up end-->
 
 
    <!-- Carousel
    ================================================== -->
	<div class="container-flude" id="slider">
		<div class="container slider-text text-center s-text">
			<h1>Welcome To Meeto</h1>
			<h3>work according to your needs</h3>
		</div>
		<div class="submit-box">
			<div class="submit">
				<input type="text" id="city" class="submit-input" placeholder="Pick Your Workspace.">
				<a href="seminarlist.php?id=">
				<div class="blue-button submit-button">Submit</div></a>
				<div id="citysuggetion"></div>
			</div>
		</div>
	</div>
				<!-- /.carousel -->

<div class="container-flude countrie"> 
    <div class="container">
		<div class="row">
		<div class="top-margin-20"></div>
			<div class="col-lg-12 col-xs-12 text-center work">
				<h2><b>Find Your New Seminar</b></h2>
				<p>pick a seminar to work anywhere, anytime</p>
			
				<div class="top-margin-30"></div>	
			</div>
		</div>
		<div class="row">
	<?php 
	$i=0;
	$seminardetail =mysql_query("select * from cities where id in (select cityid from seminar order by id desc) limit 0,6");
   while($seminar=mysql_fetch_array($seminardetail))
   {
	   $i++;
	  ?>
	 
		
			<div <?php if($i==1){echo "class=col-md-8 col-sm-8 col-xs-12";} else {echo "class=col-md-4 col-sm-4 col-xs-12";} ?> >
				<a href="seminarlist.php?id=<?php echo $seminar['id']; ?>">
				<div class="top-margin-20"></div>	
					<div class="lon-border">
					<img src="img/<?php echo $i; ?>.jpg" style="<?php if($i!=1) echo 'height:198px;width:100%;'; ?>" class="img-responsive center-block lon-img"  />
					</div>
					<div class="overlay-text">
								<span class="opan-b"><?php echo $seminar['name']; ?></span>
					</div>
				<div class="bottom-margin-10"></div>
				</a>
			</div>
			
			
		<?php 
		}
		$i=0;
		?>
		</div>		
    </div><!-- /.container -->
</div>

	<div class="container owner-img">		
		<div class="row">
			<div class="top-margin-20">&nbsp;</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="top-margin-20"></div>
					<span class="owner opan-b">"Meetoで、私たちは私のプロジェクトでセミナーを実施する会場を見つけることについて再度心配する必要はありません チーム。 「エリック、起業家"</span>
					<img src="img/owner-1.jpg" class="img-responsive center-block"  />
					
				<div class="bottom-margin-10"></div>		
			</div>
			
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="top-margin-20"></div>
					<span class="owner opan-b">
					"私がセミナーを行うための一時的な会場を借りるする必要が私の出張では、 Meetoは私に最適なソリューションを見つけました。 」アニフ、ビジネスマン"</span>
					
					<img src="img/owner-2.jpg" class="img-responsive center-block"  />
					
				<div class="bottom-margin-10"></div>		
			</div>
			
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="top-margin-20"></div>
					<span class="owner opan-b">"Meetoは新入生のエントリを増加しました！今、私のクラスがあっても週末いっぱいです。 」リタ、 オンライン家庭教師 "</span>
					
					<img src="img/owner-3.jpg" class="img-responsive center-block"  />
					
				<div class="bottom-margin-10"></div>		
					
			</div>
			<div class="bottom-margin-20">&nbsp;</div>	
		</div>		
    </div>
	
	<!-- footer -->	

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
  </body>
</html>
