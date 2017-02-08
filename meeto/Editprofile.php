<?php  
header('Content-Type: text/html; charset=UTF-8');
require_once('db.php'); 
require_once('condition.php');  

  if($_POST)
 {	
  $fname = mysql_real_escape_string($_POST['user_fname']);	
  $lname = mysql_real_escape_string($_POST['user_lname']);	
  $gender = mysql_real_escape_string($_POST['gender']);		
  $email = mysql_real_escape_string($_POST['email']);	
  $dob=$_REQUEST['sel_date']."-".$_REQUEST['sel_month']."-".$_REQUEST['sel_year'];
  
  $mobile = $_POST['phone_no'];	
  $faxno = $_POST['fax_no'];
  $url = $_POST['url'];
  $address = mysql_real_escape_string($_POST['address']);	
   $yourself = mysql_real_escape_string($_POST['yourself']);
   $companyname = mysql_real_escape_string($_POST['companyname']);
   $companydesc = mysql_real_escape_string($_POST['companydesc']);
  $created_at = round(microtime(true) * 1000);	
  if(isset($_POST['email']) && isset($_POST['email']) != '' && isset($_POST['user_fname']) && isset($_POST['user_fname']) != '')	
  { 
    $uppf=$_SESSION['jpmeetou']['id'];
	$checkemail = mysql_query("select * from user where email = '".$email."' and id!='".$uppf."'");	
	if(mysql_num_rows($checkemail) > 0)	
	  {				 
		echo "<script>alert('Email ID Already Exist..!');</script>";	
	  }	
    else
    {
	   
		$updateprofile = mysql_query("update user set fname='".$fname."',lname='".$lname."',email='".$email."', modified_date='".$created_at."' where id = '".$uppf."'"); 
		$seluserdetailid=mysql_query("select * from user_detail where uid='".$uppf."'");
		if(mysql_num_rows($seluserdetailid) > 0)
		{
			$updateuserdetail=mysql_query("update user_detail set gender='".$gender."',phoneno='".$mobile."',dob='".$dob."',address='".$address."',yourself='".$yourself."',countryid='".$_REQUEST['country']."',stateid='".$_REQUEST['state']."',cityid='".$_REQUEST['city']."' where uid = '".$uppf."' ");
		}
		else
		{
			$insertuserdetail=mysql_query("insert into user_detail (uid,gender,dob,phoneno,countryid,stateid,cityid,address,yourself,photo) values ('".$uppf."','".$gender."','".$dob."','".$mobile."','".$_REQUEST['country']."','".$_REQUEST['state']."','".$_REQUEST['city']."','".$address."','".$yourself."','')");
			
		}
		$seluserdetailid=mysql_query("select * from user_company where uid=$uppf");
		if(mysql_num_rows($seluserdetailid) > 0)
		{
			$updateusercompany=mysql_query("update user_company set name='".$companyname."',description='".$companydesc."',organization='".$_REQUEST['Organization']."',faxno='".$faxno."',url='".$url."',timezoneid='".$_REQUEST['timezone']."' where uid = '".$uppf."'");
		}
		else
		{
			if($_REQUEST['timezone']=="")
				$timezone="";
			$insertuserdetail=mysql_query("insert into user_company (uid,name,description,organization,faxno,url,timezoneid) values ('".$uppf."','".$companyname."','".$companydesc."','".$_REQUEST['Organization']."','".$faxno."','".$url."','".$timezone."')");
			
		}
		$dellanguage=mysql_query("delete from user_language where uid=$uppf");
		$count=count($_REQUEST['languages']);
		for($i=0;$i<$count;$i++)
		{
			$lid=$_REQUEST['languages'][$i];
			$inlang=mysql_query("insert into user_language (id,uid,lid,created_date,modified_date) values(0,$uppf,$lid,'$created_at','$created_at')");
		}
		$checkemail = mysql_query("select * from user where email ='".$email."' and  id='".$uppf."'");
		if(mysql_num_rows($checkemail) > 0)	
	     {
			
		 }
		 else
		 {
			$updateprofile = mysql_query("update user set  email_verify='0' where id = '".$uppf."'"); 
            $key= md5($email);
	        $url = "http://www.meeto.jp/Verification.php?uid=".$uppf."&key=".$key;
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
			
				
		}	
		echo "<script>alert('Update Profile Successfully..');</script>";
    }	   
  		   	 	  
  }	 
}
$usid=$_SESSION['jpmeetou']['id'];
$row = mysql_fetch_array(mysql_query("select * from user where id = '".$usid."'")); 
$rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = '".$usid."'")); 
$rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = '".$usid."'")); 
 
?>
<script>
function validateEmail(email) {
	
   if(email.length > 0)
	{	
       $("#emptyemail").hide();
	}
	else
	{
	 $("#emptyemail").show();
	}	  
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,15})?$/;
    if (!emailReg.test(email)) {
		$("#emailvali").show();
        //alert('Please Enter Valid Email ID');
      }
	else
	{
	  $("#emailvali").hide();
	}
   }
   function validateContact(phone)
   {
	var phoneReg = /^[0-9]+$/;
    if (!phoneReg.test(phone)) {
		$("#phonevali").show();
        //alert('Please Enter Valid Email ID');
      } 
	  else
	  {
		  $("#phonevali").hide();
	  }
	   
   }
  </script>





<!DOCTYPE html>
<html lang="en">  
<?php	
	require_once('head1.php'); 
	?>
	
<style>
a.Editprofile_menu, a.Editprofile_menu:hover{
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
					<a href="Verification_app.php" class="">Trust and Verification</a>				
				</li>			
				</ul>		
				<div class="top-margin-20"></div>
				<span class="center-block">	
				<a class="blue-button button-a" href="view-profile.php?id=<?php echo $usid; ?>">View Profile</a>	
				</span>			
				
				<div class="top-margin-30"></div>
			</div>
			
			<div class="clear"></div>
			
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-lg-8 col-md-8 col-sm-8 profile-box">	
				<div class="top-margin-20"></div>			
				<div class="row hedding-row">
				<div class="col-md-12 Required-head">	
				   <h5>Required</h5>		
				   </div>					
				   <ul class="nav">			
				   <li class="li-input">	
				     <div class="top-margin-10">&nbsp;</div>	
				     <label class="users">First Name :</label>				
				     <input type="text" class="input-name" name="user_fname" id="" pattern="[A-Z a-z]{3,}" required title="At least Three and only character" value="<?php echo isset($_POST['user_fname']) ? $_POST['user_fname'] : $row['fname']?>">		
					</li>				
					<div class="clearfix"></div>
					<li class="li-input">			
					<label class="users">Last Name :</label>		
					<input type="text" class="input-name" name="user_lname" id="" required  value="<?php echo isset($_POST['user_lname']) ? $_POST['user_lname'] : $row['lname']?>">									</br>									<span class="tips-text">
					This is only shared once you have a confirmed booking with another user.						
					</span>	
					
					</li>								
					  <div class="clearfix"></div>	
					<li class="li-input">		
					<label class="users" for="">I Am:</label>								
					<select class="gends input-name" id="gender" name="gender">								
					    <option value="Male" <?php if($rowuserdetail['gender']=='Male') echo "selected"; ?> >Male</option>	
					    <option value="Female"  <?php if($rowuserdetail['gender']=='Female') echo "selected"; ?>>Female</option>
						<option value=""  <?php if($rowuserdetail['gender']=='') echo "selected"; ?>>Unspecified</option>
					</select>								
					<br>								
					<span class="tips-text">		
					We use this data for analysis and never share it with other users.								
					</span>							
					</li>							
					<div class="clearfix"></div>
					<li class="li-input">			
					<label class="users" for="">Birth Date:</label>	
						<?php
						
							$userdob=explode("-",$rowuserdetail['dob']);
						?>
					     <select class="mnths gends input-name" name="sel_month" >	
							 <option  value="">Select Month</option>
							 <option <?php if($userdob[1]=="01")echo "selected" ?> value="01">January</option>	
							 <option <?php if($userdob[1]=="02")echo "selected" ?> value="02">February</option>		
							 <option <?php if($userdob[1]=="03")echo "selected" ?> value="03">March</option>	
							 <option <?php if($userdob[1]=="04")echo "selected" ?> value="04">April</option>
							 <option <?php if($userdob[1]=="05")echo "selected" ?> value="05">May</option>	
							 <option <?php if($userdob[1]=="06")echo "selected" ?> value="06">June</option>
							 <option <?php if($userdob[1]=="07")echo "selected" ?> value="07">July</option>
							 <option <?php if($userdob[1]=="08")echo "selected" ?> value="08">August</option>
							 <option <?php if($userdob[1]=="09")echo "selected" ?> value="09">September</option>
							 <option <?php if($userdob[1]=="10")echo "selected" ?> value="10">October</option>
							 <option <?php if($userdob[1]=="11")echo "selected" ?> value="11">November</option>	
							 <option <?php if($userdob[1]=="12")echo "selected" ?> value="12">December</option>
						 </select>										
						 <select class="mnths2 gends input-name" name="sel_date">
							<option value="">Select Date</option>
						<?php 
                           for ($x = 01; $x <= 31; $x++) 
						   {
							    ?>
								
								<option <?php if($userdob[0]==$x)echo "selected" ?>><?php echo $x; ?></option>
							  <?php
                           } 
                          ?>
						 </select>						
						 <select class="dob21 gends input-name" name="sel_year"  >
						       <option value="">Select Year</option>
							<?php 
                           for ($x =2001; $x >= 1921; $x--) 
						   {
							  ?>
								<option <?php if($userdob[2]==$x)echo "selected" ?>><?php echo $x; ?></option>
							  <?php
                           } 
                          ?>
						 </select>			
									
						 </li>					
						 <div class="clearfix"></div>
	                        <center><label id="emailvali" style="color:red; font-size:15px; display:none;">Please Enter Valid Email ID</label></center>
							<center><label id="emptyemail" style="color:red; font-size:15px; display:none;">Please Enter Email ID</label></center>
						 <li class="li-input">		
							 <label class="users" for="">Email Address:</label>	
                             	
							 <input type="email" class="input-name" name="email"  onkeyup="validateEmail(this.value);" onmouseout="validateEmail(this.value);" id="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : $row['email']?>">										</br>											 							
						 </li>								
						 <div class="clearfix"></div>
						 <center><label id="phonevali" style="color:red; font-size:15px; display:none;">Please Enter Valid Contact No</label></center>
						 <li class="li-input">
							<label class="users" for="">Phone Number:</label>	
							<input name="phone_no" id="phone_no" title="You can enter only numeric" onkeyup="validateContact(this.value);" pattern="[0-9+]{1,}" class="input-name" type="text" value="<?php echo isset($_POST['phone_no']) ? $_POST['phone_no'] : $rowuserdetail['phoneno']?>">
						
							
						 </li>
						 <div class="clearfix"></div>
						<!-- <li class="li-input">				
							<label class="users" for="">Fax number:</label>	
							<input name="fax_no" title="You can enter only numeric" pattern="[0-9+]{1,}" class="input-name" type="text" value="<?php echo $rowusercompany['faxno']; ?>">
						</li>-->
								<div class="clearfix"></div>
								<li class="li-input">
									<label class="users" for="">Country:</label>
									<select id="country" class="input-name"  name="country" onchange="setstate(this.value);">
										 <option value="">--Select--</option>
										<?php
											$selcountry=mysql_query("select * from countries where id='109'");
											while($fetcountry=mysql_fetch_array($selcountry))
											{
										?>
											<option <?php if($rowuserdetail['countryid']==$fetcountry['id'])echo "selected"; ?> value="<?php echo $fetcountry['id']; ?>"><?php echo $fetcountry['name']; ?></option>
										<?php
											}
										?>
									</select>
									<label class="users" for="">State:</label>
									<select id="allstate" class="input-name" name="state"  onchange="setcity(this.value);">
										 <option value="">--Select State--</option>
										<?php
											$selcountry=mysql_query("select * from states where country_id=$rowuserdetail[countryid]");
											while($fetcountry=mysql_fetch_array($selcountry))
											{
										?>
												<option <?php if($rowuserdetail['stateid']==$fetcountry['id'])echo "selected"; ?> value="<?php echo $fetcountry['id']; ?>"><?php echo $fetcountry['name']; ?></option>
										<?php
											}
										?>
									</select>
									<label class="users" for="">City:</label>
									<select id="allcity" class="input-name" name="city" onchange="">
										 <option value="">--Select City--</option>
										<?php
											$selcountry=mysql_query("select * from cities where state_id=$rowuserdetail[stateid]");
											while($fetcountry=mysql_fetch_array($selcountry))
											{
										?>
												<option <?php if($rowuserdetail['cityid']==$fetcountry['id'])echo "selected"; ?> value="<?php echo $fetcountry['id']; ?>"><?php echo $fetcountry['name']; ?></option>
										<?php
											}
										?>
									</select>
								</li>
								
								<li class="li-input">
								
										<label class="users" for="">Where You Live:</label>
										<input type="text" class="input-name" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : $rowuserdetail['address']?>">
								</li>
							
								<li class="li-input">
									<label class="users">Describe Yourself:</label>
									<textarea class="input-name" style="height:200px;" name="yourself"><?php echo isset($_POST['yourself']) ? $_POST['yourself'] : $rowuserdetail['yourself']?> </textarea>
									<br>
									
									<span class="tips-text">
										<div class="text-muted">
											We are built on trust. Help other people to know you.<br>
											<br>
											Tell them about your job: What do you do for a living, what your profession, how much experience you have, how many employees you company, etc.<br>
											<br>
											Tell them what's important to you.<br>
											<br>
											You can add anything you think might help other people to know you better.</div>
									</span>
								</li>								
															
							</ul>
					</div>
					<div class="top-margin-20">&nbsp;</div>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="col-md-8 col-md-offset-3 col-sm-8 col-sm-offset-3 col-xs-12 profile-box">
				
					<div class="top-margin-20"></div>
					<div class="row hedding-row">
						<div class="col-md-12 Required-head">
							<h5>Company Details</h5>
						</div>
							<ul class="nav">
								<li class="li-input">
								<div class="top-margin-10">&nbsp;</div>
									<label class="users">Company Name:</label>
									<input type="text" name="companyname" class="input-name"  id="" value="<?php echo isset($_POST['companyname']) ? $_POST['companyname'] : $rowusercompany['name']?>">	
								</li>
									<div class="clearfix"></div>
								<li class="li-input">
									<label class="users">Company Description:</label>
									<input type="text" name="companydesc" class="input-name" id="" value="<?php echo isset($_POST['companydesc']) ? $_POST['companydesc'] : $rowusercompany['description']?>">	
								</li>   
								    <div class="clearfix"></div>
								<li class="li-input">
									<label class="users">Organization Type :</label>
									<select id="Organization" class="input-name" name="Organization">
										 <option value="">--Select Organization--</option>
										 <option value="Profit Organization" <?php if($rowusercompany['organization']=='Profit Organization' || $rowusercompany['organization']=='組織を選択します' ) echo "selected";?>>Profit Organization</option>
										 <option value="Non-Profit Organization" <?php if($rowusercompany['organization']=='Non-Profit Organization' || $rowusercompany['organization']=='営利団体' ) echo "selected";?>>Non-Profit Organization</option>
									</select>
								</li>
								<li class="li-input">
									<label class="users">Fax number:</label>
									<input name="fax_no" title="You can enter only numeric" pattern="[0-9+]{1,}" class="input-name" type="text" value="<?php echo isset($_POST['fax_no']) ? $_POST['fax_no'] : $rowusercompany['faxno']?>">	
								</li>
								<li class="li-input">
									<label class="users">URL:</label>
									<input type="text" name="url" class="input-name"  id="url" value="<?php echo isset($_POST['url']) ? $_POST['url'] : $rowusercompany['url']?>">	
								</li>
								<li>
								<label class="users">Time Zone:</label>
									<select class="input-name time-zone" id="" name="timezone">
									<?php
									$seltimedfl=mysql_fetch_array(mysql_query("select * from timezone where id='1'")); ?>
									<option selected value="<?echo $seltimedfl['id']; ?>"><?echo $seltimedfl['name']; ?></option>
										<?php
										/*
										$seltime=mysql_query("select * from timezone");
										while($fettime=mysql_fetch_array($seltime))
										{
										?>  
											<option <?php if($fettime['id']==$rowusercompany['timezoneid'])echo "selected"; ?> value="<?php echo $fettime['id']; ?>"><?php echo $fettime['name']; ?></option>
										<?php
										}*/
										?>
									</select>

									<span class="tips-text">Your time zone</span>

								</li>
								<div class="clearfix"></div>
								<li class="li-input">
									<label class="users">Language :</label>
									<span class="no-numbr">
										<ul class="nav">
										  <?php
											$seluserlang=mysql_query("select * from user_language where uid=$usid");
											$arr=array();
											while($fetuserlang=mysql_fetch_array($seluserlang))
											{
												array_push($arr,$fetuserlang['lid']);
											}
											
											$sellang=mysql_query("select * from language where status='1'");
											while($fetlang=mysql_fetch_array($sellang))
											{
											?>
											<li>
												<input <?php if(in_array($fetlang['id'],$arr))echo "checked"; ?> type="checkbox" name="languages[]" value="<?php echo $fetlang['id']; ?>" alt="<?php echo $fetlang['name']; ?>">
												<label><?php echo $fetlang['name']; ?></label>
											</li>
											<?php	
											}
										   ?>
											<li><span style="width:100%" class="tips-text">Languages you speak</span></li>
										</ul>
									</span>
								</li>
								<div class="clearfix"></div>
					
								<li class="li-input">
									<div class="col-md-8 col-md-offset-4 col-sm-8 col-sm-offset-4 col-xs-8 col-xs-offset-4">
									<button type="submit" name="save" class="blue-button save border-n">SAVE</button>
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