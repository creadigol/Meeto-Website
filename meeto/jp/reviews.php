<?php  
require_once('db.php'); 
require_once('condition.php');  

  if($_POST)
 {	
  $fname = $_POST['user_fname'];	
  $lname = $_POST['user_lname'];	
  $gender = $_POST['gender'];		
  $email = $_POST['email'];	
  $dob=$_REQUEST['sel_date']."-".$_REQUEST['sel_month']."-".$_REQUEST['sel_year'];
  
  $mobile = $_POST['phone_no'];	
  $address = mysql_real_escape_string($_POST['address']);	
   $yourself = mysql_real_escape_string($_POST['yourself']);
   $companyname = mysql_real_escape_string($_POST['companyname']);
   $companydesc = mysql_real_escape_string($_POST['companydesc']);
  $created_at = round(microtime(true) * 1000);	
  if(isset($_POST['email']) && isset($_POST['email']) != '' && isset($_POST['user_fname']) && isset($_POST['user_fname']) != '')	
  { 
    /*
	$checkemail = mysql_query("select * from registration where email = '".$email."'");			
	if(mysql_num_rows($checkemail) > 0)	
	  {				 
		echo "<script>alert('Email Id Already Exist..!');</script>";	
	  }		
    else		
	  {			
			if($_REQUEST['country']=="")
				$countryid="";
			if($_REQUEST['state']=="")
				$stateid="";
			if($_REQUEST['city']=="")
				$cityid="";
			*/
		$updateprofile = mysql_query("update user set fname='".$fname."',lname='".$lname."',email='".$email."', modified_date='".$created_at."' where id = '".$_SESSION['jpmeetou']['id']."'"); 
		$seluserdetailid=mysql_query("select * from user_detail where uid=$_SESSION[jpmeetou][id]");
		if(mysql_num_rows($seluserdetailid) > 0)
		{
			$updateuserdetail=mysql_query("update user_detail set gender='".$gender."',phoneno='".$mobile."',dob='".$dob."',address='".$address."',yourself='".$yourself."',countryid='".$_REQUEST['country']."',stateid='".$_REQUEST['state']."',cityid='".$_REQUEST['city']."' where uid = '".$_SESSION[jpmeetou]['id']."' ");
		}
		else
		{
			$insertuserdetail=mysql_query("insert into user_detail (uid,gender,dob,phoneno,countryid,stateid,cityid,address,yourself,photo) values ('".$_SESSION[jpmeetou]['id']."','".$gender."','".$dob."','".$mobile."','".$_REQUEST['country']."','".$_REQUEST['state']."','".$_REQUEST['city']."','".$address."','".$yourself."','')");
			
		}
		$seluserdetailid=mysql_query("select * from user_company where uid=$_SESSION[jpmeetou][id]");
		if(mysql_num_rows($seluserdetailid) > 0)
		{
			$updateusercompany=mysql_query("update user_company set name='".$companyname."',description='".$companydesc."',timezoneid='".$_REQUEST['timezone']."' where uid = '".$_SESSION['jpmeetou']['id']."'");
		}
		else
		{
			if($_REQUEST['timezone']=="")
				$timezone="";
			$insertuserdetail=mysql_query("insert into user_company (uid,name,description,timezoneid) values ('".$_SESSION[jpmeetou]['id']."','".$companyname."','".$companydesc."','".$timezone."')");
			
		}
		$dellanguage=mysql_query("delete from user_language where uid=$_SESSION[jpmeetou][id]");
		$count=count($_REQUEST['languages']);
		for($i=0;$i<$count;$i++)
		{
			$lid=$_REQUEST['languages'][$i];
			$inlang=mysql_query("insert into user_language (id,uid,lid,created_date,modified_date) values(0,$_SESSION[jpmeetou][id],$lid,'$created_at','$created_at')");
		}
		if($updateprofile==1)		
		{				
			echo "<script>alert(Update Profile Successfully..!);</script>";	
		}	         
			    
	 	  
	}	 
}

$row = mysql_fetch_array(mysql_query("select * from user where id = '".$_SESSION[jpmeetou]['id']."'")); 
$rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = '".$_SESSION['jpmeetou']['id']."'")); 
$rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = '".$_SESSION['jpmeetou']['id']."'")); 
 
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
					<a href="Editprofile.php">Edit Profile</a>
				</li>						
				<li>						
					<a href="photos.php" class="">Photos</a>	
				</li>			
				<li>	
					<a href="Verification.php" class="">Trust and Verification</a>				
				</li>	
				<li>	
     				<a href="reviews.php" class="">Reviews</a>
				</li>		
				</ul>		
				<div class="top-margin-20"></div>
				<span class="center-block">	
				<a class="blue-button button-a" href="view-profile.php?id=<?php echo $_SESSION['jpmeetou']['id']; ?>">View Profile</a>	
				</span>			
				
				<div class="top-margin-30"></div>
			</div>
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