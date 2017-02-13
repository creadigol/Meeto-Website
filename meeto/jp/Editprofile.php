<?php  
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
		echo "<script>alert('メールIdはすでに存在しています..！');</script>";	
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
     echo "<script>alert('プロフィールを正常に更新..！');</script>";		
    }	   
  		   	 	  
  }	 
}
$usid=$_SESSION['jpmeetou']['id'];
$row = mysql_fetch_array(mysql_query("select * from user where id = '".$_SESSION['jpmeetou']['id']."'")); 
$rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = '".$_SESSION['jpmeetou']['id']."'")); 
$rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = '".$_SESSION['jpmeetou']['id']."'")); 
 
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
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
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
	<?php	require_once('usermenu.php');  ?>
	<!-- pop up start -->
	<div class="container-flude container-margin background-container">	
	  <div class="container">		
	    <div class="row">
	      
	        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 side-menu">				
	           <div class="top-margin-20">
         	   </div>					
				<ul class="nav edit">	
				<li class="activet">	
					<a href="#"><?php echo EDIT_PROFILE; ?></a>
				</li>
		<?php 
           if($_SESSION['jpmeetou']['type']==1)
            {?>   
				<li>						
					<a href="photos.php" class=""><?php echo PHOTOS; ?></a>	
				</li>
			<?
			}
		  ?>						
				<li>	
					<a href="Verification_app.php" class=""><?php echo TRUST_AND_VERIFICATION; ?></a>				
				</li>			
				</ul>		
				<div class="top-margin-20"></div>
				<span class="center-block">	
				<a class="blue-button button-a" href="view-profile.php?id=<?php echo $_SESSION['jpmeetou']['id']; ?>"><?php echo VIEW_PROFILE; ?></a>	
				</span>			
				
				<div class="top-margin-30"></div>
			</div>
			
			<div class="clear"></div>
			
			<form method="post" action="" enctype="multipart/form-data">				
				<div class="col-lg-8 col-md-8 col-sm-8 profile-box">	
				<div class="top-margin-20"></div>			
				<div class="row hedding-row">
				<div class="col-md-12 Required-head">	
				   <h5><?php echo REQUIRED; ?></h5>		
				   </div>					
				   <ul class="nav">			
				   <li class="li-input">	
				     <div class="top-margin-10">&nbsp;</div>	
				     <label class="users"><?php echo FIRST_NAME; ?> ：</label>				
				     <input type="text" class="input-name" name="user_fname" id="" pattern=".{3,}" required title="名前は最小3文字でなければなりません" value="<?php $marutra = explode('"',translate(str_replace(" ","+",$row['fname']))); echo $marutra[1];?> ">		
					</li>				
					<div class="clearfix"></div>
					<li class="li-input">			
					<label class="users"><?php echo LAST_NAME; ?> ：</label>		
					<input type="text" class="input-name" name="user_lname" id="" required value="<?php $marutra = explode('"',translate(str_replace(" ","+",$row['lname']))); echo $marutra[1]; ?> "></br>									<span class="tips-text">
					<?php echo THIS_IS_ONLY_SHARED_ONCE_YOU_HAVE_A_CONFIRMED_BOOKING_WITH_ANOTHER_USER; ?>。</span>	
					</li>								
					  <div class="clearfix"></div>	
					<li class="li-input">		
					<label class="users" for="">
<?php echo I_AM; ?>：</label>								
					<select class="gends input-name" id="gender" name="gender">								
					    <option value="Male" <?php if($rowuserdetail['gender']=='Male') echo "selected"; ?> ><?php echo MALE; ?></option>	
					    <option value="Female"  <?php if($rowuserdetail['gender']=='Female') echo "selected"; ?>>
<?php echo FEMALE; ?></option>
						<option value=""  <?php if($rowuserdetail['gender']=='') echo "selected"; ?>><?php echo UNSPECIFIED; ?>
</option>
					</select>								
					<br>								
					<span class="tips-text">		
					<?php echo WE_USE_THIS_DATA_FOR_ANALYSIS_AND_NEVER_SHARE_IT_WITH_OTHER_USERS; ?>。							
					</span>							
					</li>							
					<div class="clearfix"></div>
					<li class="li-input">			
					<label class="users" for=""><?php echo BIRTH_DATE; ?>：</label>	
						<?php
						
							$userdob=explode("-",$rowuserdetail['dob']);
						?>
					     <select class="mnths gends input-name" name="sel_month" >	
							 <option  value="">
<?php echo SELECT_MONTH; ?></option>
							 <option <?php if($userdob[1]=="01")echo "selected" ?> value="01">
<?php echo JANUARY; ?></option>	
							 <option <?php if($userdob[1]=="02")echo "selected" ?> value="02">
<?php echo FEBRUARY; ?></option>		
							 <option <?php if($userdob[1]=="03")echo "selected" ?> value="03">
<?php echo MARCH; ?></option>	
							 <option <?php if($userdob[1]=="04")echo "selected" ?> value="04"><?php echo APRIL; ?></option>
							 <option <?php if($userdob[1]=="05")echo "selected" ?> value="05">
<?php echo MAY; ?></option>	
							 <option <?php if($userdob[1]=="06")echo "selected" ?> value="06">
<?php echo JUNE; ?></option>
							 <option <?php if($userdob[1]=="07")echo "selected" ?> value="07"><?php echo JULY; ?></option>
							 <option <?php if($userdob[1]=="08")echo "selected" ?> value="08">
<?php echo AUGUST; ?></option>
							 <option <?php if($userdob[1]=="09")echo "selected" ?> value="09"><?php echo SEPTEMBER; ?></option>
							 <option <?php if($userdob[1]=="10")echo "selected" ?> value="10">
<?php echo OCTOMBER; ?></option>
							 <option <?php if($userdob[1]=="11")echo "selected" ?> value="11"><?php echo NOVEMBER; ?></option>	
							 <option <?php if($userdob[1]=="12")echo "selected" ?> value="12"><?php echo DECEMBER; ?></option>
						 </select>										
						 <select class="mnths2 gends input-name" name="sel_date">
							<option value=""><?php echo SELECT_DATE; ?></option>
						<?php 
                           for ($x = 01; $x <= 31; $x++) 
						   {
							    ?>
								
								<option <?php if($userdob[0]==$x)echo "selected" ?>><?php echo $x ?></option>
							  <?php
                           } 
                          ?>
						 </select>						
						 <select class="dob21 gends input-name" name="sel_year"  >
						       <option value="">
<?php echo SELECT_YEAR; ?></option>
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
						 <center><label id="emailvali" style="color:red; font-size:15px; display:none;"><?php echo PLEASE_ENTER_VALID_EMAIL_ID; ?></label></center>
						<center><label id="emptyemail" style="color:red; font-size:15px; display:none;"><?php echo PLEASE_ENTER_EMAIL_ID; ?></label></center>
						 <li class="li-input">		
							 <label class="users" for="">
<?php echo EMAIL_ADDRESS; ?>：<i class="lock"></i></label>										
							 <input type="email"  readonly class="input-name" name="email" id="email" required value="<?php $marutra = explode('"',translate(str_replace(" ","+",$row['email']))); echo $marutra[1];?> ">										</br>										
							 							
						 </li>								
						 <div class="clearfix"></div>
						 <center><label id="phonevali" style="color:red; font-size:15px; display:none;"><?php echo PLEASE_ENTER_VALID_CONTACT_NO; ?></label></center>
						 <li class="li-input">				
							<label class="users" for="">
<?php echo PHONE_NUMBER; ?>：</label>	
							<input name="phone_no" id="phone_no" title="You can enter only numeric" pattern="[0-9+]{1,}" class="input-name" type="text" value="<?php echo $rowuserdetail['phoneno']; ?>">
						
							
						 </li>
						 <div class="clearfix"></div>
						<!-- <li class="li-input">				
							<label class="users" for="">Fax number:</label>	
							<input name="fax_no" title="You can enter only numeric" pattern="[0-9+]{1,}" class="input-name" type="text" value="<?php //$marutra = explode('"',translate(str_replace(" ","+",$rowusercompany['faxno']))); echo $marutra[1]; ?>">
						</li>-->
								<div class="clearfix"></div>
								<li class="li-input">
									<label class="users" for=""><?php echo COUNTRY; ?>：</label>
									<select id="country" class="input-name"  name="country" onchange="setstate(this.value);">
										 <option value="">
- <?php echo SELECT_COUNTRY; ?> -</option>
										<?php
											$selcountry=mysql_query("select * from countries");
											while($fetcountry=mysql_fetch_array($selcountry))
											{
										   $marutra = explode('"',translate(str_replace(" ","+",$fetcountry['name'])));?>
											<option <?php if($rowuserdetail['countryid']==$fetcountry['id'])echo "selected"; ?> value="<?php echo $fetcountry['id']; ?>"><?php echo $marutra[1]; ?></option>
										<?php
											}
										?>
									</select>
									<label class="users" for="">
<?php echo STATE; ?>：</label>
									<select id="allstate" class="input-name" name="state"  onchange="setcity(this.value);">
										 <option value="">
- <?php echo SELECT_STATE; ?> -</option>
										<?php
											$selcountry=mysql_query("select * from states where country_id=$rowuserdetail[countryid]");
											while($fetcountry=mysql_fetch_array($selcountry))
											{
											$marutra = explode('"',translate(str_replace(" ","+",$fetcountry['name'])));
										?>
												<option <?php if($rowuserdetail['stateid']==$fetcountry['id'])echo "selected"; ?> value="<?php echo $fetcountry['id']; ?>"><?php echo $marutra[1]; ?></option>
										<?php
											}
										?>
									</select>
									<label class="users" for=""><?php echo CITY; ?>：</label>
									<select id="allcity" class="input-name" name="city" onchange="">
										 <option value="">
- <?php echo SELECT_CITY; ?> -</option>
										<?php
											$selcountry=mysql_query("select * from cities where state_id=$rowuserdetail[stateid]");
											while($fetcountry=mysql_fetch_array($selcountry))
											{
												$marutra = explode('"',translate(str_replace(" ","+",$fetcountry['name']))); 
										?>
												<option <?php if($rowuserdetail['cityid']==$fetcountry['id'])echo "selected"; ?> value="<?php echo $fetcountry['id']; ?>"><?php echo $marutra[1]; ?></option>
										<?php
											}
										?>
									</select>
								</li>
								
								<li class="li-input">
								
										<label class="users" for="">
 <?php echo WHERE_YOU_LIVE; ?> ：</label>
										<input type="text" class="input-name" name="address"  value="<?php $marutra = explode('"',translate(str_replace(" ","+",$rowuserdetail['address']))); echo $marutra[1]; ?>" >
								</li>
							
								<li class="li-input">
									<label class="users">
<?php echo DESCRIBE_YOURSELF; ?>：</label>
									<textarea class="input-name" style="height:200px;" name="yourself"><?php $marutra = explode('"',translate(str_replace(" ","+",$rowuserdetail['yourself']))); echo $marutra[1];  ?> </textarea>
									<br>
									
									<span class="tips-text">
										<div class="text-muted">
											
私たちは信頼に基づいて構築されています。他の人があなたを知っているのに役立ちます。<br>
											<br>
											
あなたの仕事についてのそれらを教える：あなたは生活のために何をしますか、あなたが持っているどのくらいの経験をどのようなあなたの職業、どのように多くの従業員あなたの会社など<br>
											<br>
											あなたに何が重要かを伝えます。<br>
											<br>
										
あなたが他の人がより良いあなたが知っているのに役立つかもしれないと思う何かを追加することができます。</div>
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
							<h5>
<?php echo COMPANY_DETAILS; ?></h5>
						</div>
							<ul class="nav">
								<li class="li-input">
								<div class="top-margin-10">&nbsp;</div>
									<label class="users"><?php echo COMPANY_NAME; ?>：</label>
									<input type="text" name="companyname" class="input-name"  id="" value="<?php $marutra = explode('"',translate(str_replace(" ","+",$rowusercompany['name']))); echo $marutra[1]; ?>">	
								</li>
									<div class="clearfix"></div>
								<li class="li-input">
									<label class="users"><?php echo COMPANY_DESCRIPTION; ?>：</label>
									<input type="text" name="companydesc" class="input-name" id="" value="<?php $marutra = explode('"',translate(str_replace(" ","+",$rowusercompany['description']))); echo $marutra[1];  ?>">	
								</li>
								    <div class="clearfix"></div>
								<li class="li-input">
									<label class="users"><?php echo ORGANIZATION_TYPE; ?>：</label>
									<select id="Organization" class="input-name" name="Organization">
										 <option value="">
- <?php echo SELECT_ORGANIZATION; ?> -</option>
										 <option value="営利団体" <?php if($rowusercompany['organization']=='Profit Organization' || $rowusercompany['organization']=='組織を選択します') echo "selected";?>>
<?php echo PROFIT_ORGANIZATION; ?></option>
										 <option value="非営利団体" <?php if($rowusercompany['organization']=='Non-Profit Organization' || $rowusercompany['organization']=='営利団体') echo "selected";?>>
<?php echo NON_PROFIT_ORGANIZATION; ?></option>
									</select>
								</li>
								<li class="li-input">
									<label class="users"><?php echo FAX_NUMBER; ?>：</label>
									<input name="fax_no" title="You can enter only numeric" pattern="[0-9+]{1,}" class="input-name" type="text" value="<?php $marutra = explode('"',translate(str_replace(" ","+",$rowusercompany['faxno']))); echo $marutra[1];  ?>">	
								</li>
								<li class="li-input">
									<label class="users">
<?php echo URL; ?> ：</label>
									<input type="text" name="url" class="input-name"  id="url" value="<?php $marutra = explode('"',translate(str_replace(" ","+",$rowusercompany['url']))); echo $marutra[1]; ?>">	
								</li>
								<li>
									<label class="users"><?php echo TIME_ZONE; ?>：</label>
									<select class="input-name time-zone" id="" name="timezone">
										<?php
									$seltimedfl=mysql_fetch_array(mysql_query("select * from timezone where id='1'")); 
									$marutra = explode('"',translate(str_replace(" ","+",$seltimedfl['name'])));
									?>
									<option selected value="<?echo $seltimedfl['id']; ?>"><?echo $marutra[1]; ?></option>
										<?php
										/*
										$seltime=mysql_query("select * from timezone");
										while($fettime=mysql_fetch_array($seltime))
										{
											$marutra = explode('"',translate(str_replace(" ","+",$fettime['name']))); 
										?>
											<option <?php if($fettime['id']==$rowusercompany['timezoneid'])echo "selected"; ?> value="<?php echo $fettime['id']; ?>"><?php echo $marutra[1]; ?></option>
										<?php
										}
										*/?>
									</select>

									<span class="tips-text"><?php echo YOUR_TIME_ZONE; ?></span>

								</li>
								<div class="clearfix"></div>
								<li class="li-input">
									<label class="users"><?php echo LANGUAGES; ?></label>
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
											<li><span style="width:100%" class="tips-text"><?php echo LANGUAGES_YOU_SPEAK; ?></span></li>
										</ul>
									</span>
								</li>
								<div class="clearfix"></div>
								<li class="li-input">
									<div class="col-md-8 col-md-offset-4 col-sm-8 col-sm-offset-4 col-xs-8 col-xs-offset-4">
									<button type="submit" name="save" class="blue-button save border-n"><?php echo SAVE; ?></button>
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