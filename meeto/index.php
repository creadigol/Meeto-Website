<?php
require_once('db.php'); 
require_once('head1.php');
/*if(($_SESSION[myjp33]!="japan" || $_SESSION[myjp33]=="japan") && $_SESSION[myjp33]!="english")
{
	$_SESSION[myjp33]="japan";
	$url="jp/index.php";
echo '<script type="text/javascript">window.location.href="' . $url . '";</script>';
}else{
	$url="index.php";
	echo '<script type="text/javascript">window.location.href="' . $url . '";</script>';
}*/
$fgh=0;
	if(isset($_POST['signup']))
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
					$checkemail1 = mysql_query("select * from user where email = '".$email."' and type ='1'");	
					if(mysql_num_rows($checkemail1) > 0)	
					{		
						//echo "<script>alert('Email Id Already Exist..!');</script>";
						$fgh=1;			
					}else{
						//echo "<script>alert('This Email id attached with other account!');</script>";
						$fgh=3;	
					}		
			}		
			else	
			{	
				$insert_edetail = mysql_query("insert into user (fname,lname,email,password,type,fb_id,email_verify,status,created_date,modified_date) values('".$fname."','".$lname."','".$email."','".$password_hash."',1,0,0,1,'".$created_at."','".$created_at."')");	
				//echo "insert into user (fname,lname,email,password,type,fb_id,email_verify,status,created_date,modified_date) values('".$fname."','".$lname."','".$email."','".$password_hash."',1,'',0,1,'".$created_at."','".$created_at."')";
			}		
			if($insert_edetail==1)
			{
			    $checkemail = mysql_query("select * from user where id in (select max(id) from user)");	
				$fet=mysql_fetch_array($checkemail);
				$_SESSION['jpmeetou']['id']=$fet['id'];
				$seluserdetail=mysql_query("select * from user_detail where uid=$fet[id]");
				$fetuserdetail=mysql_fetch_array($seluserdetail);
				$_SESSION['jpmeetou']['email']=$fet['email'];
				$_SESSION['jpmeetou']['fname']=$fet['fname'];
				$_SESSION['jpmeetou']['lname']=$fet['lname'];
				$_SESSION['jpmeetou']['profileimage']=$fetuserdetail['photo'];
				
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

				
				
				echo "<script>window.location.href='index.php'</script>";		
			}	
		}
	}
	if(isset($_REQUEST['login']))
	{
		$email = $_POST['user_email'];	
		$password = md5($_POST['password']);
		$checkemail = mysql_query("select * from user where email = '".$email."' and password = '".$password."'");	
		if(mysql_num_rows($checkemail)>0)		
		{	
			$fet=mysql_fetch_array($checkemail);
			if($fet['status']==1)
			{
			$_SESSION['jpmeetou']['id']=$fet['id'];
			$seluserdetail=mysql_query("select * from user_detail where uid='".$fet[id]."'");
			$fetuserdetail=mysql_fetch_array($seluserdetail);
			$_SESSION['jpmeetou']['email']=$fet['email'];
			$_SESSION['jpmeetou']['fname']=$fet['fname'];
			$_SESSION['jpmeetou']['lname']=$fet['lname'];
			$_SESSION['jpmeetou']['profileimage']=$fetuserdetail['photo'];
			$_SESSION['jpmeetou']['type']=$fet['type'];
			echo "<script>window.location.href='index.php'</script>";	
			}
			else
			{
				$fgh=2;	
			}	
		}
		else
		{
			$fgh=7;
			//echo "<script>alert('Invalid Login Detail..!');</script>";
		}
	}
	if(isset($_SESSION['jpmeetou']['facebook_access_token']))
	{
		
		$email = $_SESSION['jpmeetou']['email'];
		$fname = $_SESSION['jpmeetou']['fname'];
		$lname = $_SESSION['jpmeetou']['lname'];
		$fb_id = $_SESSION['jpmeetou']['fb_id'];
		$created_at = round(microtime(true) * 1000);
		$_SESSION['jpmeetou']['type'] ="2";
	   $checkfbid = mysql_query("select * from user where fb_id = '".$fb_id."'");	
			if(mysql_num_rows($checkfbid) > 0)	
			{		
		
				$fet=mysql_fetch_array($checkfbid);
				if($fet['status']==1)
				{
					$selfbuser = mysql_query("select * from user where fb_id='".$fb_id."'");	
					$fetfbuser=mysql_fetch_array($selfbuser);
					$_SESSION['jpmeetou']['id']=$fetfbuser['id'];
					
					$uppro=mysql_query("update user_detail set photo='".$_SESSION['jpmeetou']['user_picture']."' where uid='".$fetfbuser['id']."'");
				}
				else
				{
					$fgh=2;
				}
			}		
			else	
			{	
		        $checkemail = mysql_query("select * from user where email = '".$email."'");
		       if(mysql_num_rows($checkemail) > 0)
		       {
			    echo "<script>alert('This Email id attached with other account.');</script>";
				unset($_SESSION['jpmeetou']);
				echo "<script>window.location.href='index.php'</script>";
		       }
			   else
			   {
				$insert_edetail = mysql_query("insert into user (fname,lname,email,password,type,fb_id,email_verify,status,created_date,modified_date) values('".$fname."','".$lname."','".$email."','',2,'".$fb_id."',0,1,'".$created_at."','".$created_at."')");
				
				$selfbuser = mysql_query("select * from user where fb_id='".$fb_id."'");	
				$fetfbuser=mysql_fetch_array($selfbuser);
				$_SESSION['jpmeetou']['id']=$fetfbuser['id'];
				
				$insertuserdetail=mysql_query("insert into user_detail (uid,gender,dob,phoneno,countryid,stateid,cityid,address,yourself,photo) values ('".$fetfbuser['id']."','','','','','','','','','".$_SESSION['jpmeetou']['user_picture']."')");
		    if(!empty($fetfbuser['email']))
			{
			   
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
			
			echo "<script>window.location.href='index.php'</script>";
			}		
		   }
	     }				
	}
	$milliseconds = round(microtime(true) * 1000);
	//$dttt=date("Y-m-d");
	//echo "<br><br><br><br><br><br><br><br><br><br><br> ";
	mysql_query("update seminar set status=0 where id in(select seminar_id from seminar_day where to_date < '$milliseconds')");
?>

<style>
.submit-cityname{
    position: relative;
    z-index: 100;
}
.city-submit{
	background:#fff;
	margin:10px 0px;
}
.city-submit a li{
	padding:15px;
	color:#000 !important;
}
.city-submit a li:hover{
	background:#7323DC;
	color:#fff !important;fff
}
</style>
<script> 
	
	var i=0;
	  	var j=0;
 /*function hideserchcity()
 {
	  $("#citysuggetion").hide();
 } */
	
  function seachcity()
  {
	 var city = document.getElementById('city').value
	 if(city == "" || city == null)
     {
       $("#citysuggetion").hide();
     }
	 else
	 {
		$("#citysuggetion").show(); 
		$.ajax({
		url: "miss2.php?kon=seachcity&city="+city, 
		type: "POST",
		success: function(data)
		{
		    $("#citysuggetion").html(data);
				
		}
		}); 
	 }
  }
  function cityname()
  {
	 var city = document.getElementById('city').value
	 $.ajax({
		url: "miss2.php?kon=cityname&city="+city, 
		type: "POST",
		success: function(data)
		{
		    $("#citysuggetion").html(data);	
		}
		});
  }
 function gonext(totalSeminar)
 {
		
		//alert("hii");
		var totalSeminar = totalSeminar-4;
		i++;
		var k=i*293;
		var ts=totalSeminar*293;
		var res=j-k;
		//if(res<=-2531)
		if(res<=-ts)
		{
			$("#gonext").hide();
			$("#goback").show();
		}
		else
		{
			$("#goback").show();
		}
		//alert(i); alert(k); alert(res);
	$(".slider-wrapper").css("transform","translateX("+res+"px)");
		

 }
 function goback()
 {
		
		//alert("hii");
		i--;
		var k=i*275;
		var res=j-k;
		if(res==0)
		{
			$("#goback").hide();
			$("#gonext").show();
		}
		else
		{
			$("#gonext").show();
		}
		//alert(i); alert(k); alert(res);
	$(".slider-wrapper").css("transform","translateX("+res+"px)");
		

 }
</script>


<!DOCTYPE html>
<html lang="en">
  <?php
	
	
  ?>
  
  <script>
		$(window).scroll(function () {
			 var sc = $(window).scrollTop()
			if (sc > 40) {
				$("body.buy-service-home-page header").css("background","rgba(0,0,0,0.9)");
				$("body.buy-service-home-page header").css("position","fixed")
			} else {
				$("header").css("background","none");
			}
		});
	</script>

  
<!-- NAVBAR
================================================== -->
  <body>
    <?php
	if($fgh==1)
	{
		$fgh=0;
	?>
		<div class="" id='hidenewfac12' style='width:100%;height:149%;background: rgba(0,0,0,0.5);padding: 2%;position: fixed;z-index: 999;'>
            <div class="row" >
                <div class="col-md-12">
                <br><br><br><br><br><br><br><br><br><br><br><br>
                    <div class="col-md-5 col-md-offset-4" style="border:1px solid #333; background:#fff">
                        
                        
                        <div class="col-md-12" id="deleteusermsg" style="padding:20px;"> 
                            <h4 style="color:red;font-weight:bolder;">Email Id Already Exist..!</h4>
                            <div class="col-md-2 col-md-offset-10 btn btn-primary" style="color:black;font-weight:bolder;" onclick="$('#hidenewfac12').hide();">
                            Ok</div>
                        </div>
                 
                    </div>
                    
                </div>
            </div>
		</div>
	<?php
	}
	?>
    
    <?php
	if($fgh==2)
	{
		unset($_SESSION['jpmeetou']);
		$fgh=0;
		?>
		<div class="" id='hidenewfac123' style='width:100%;height:149%;background: rgba(0,0,0,0.5);padding: 2%;position: fixed;z-index: 999;'>
		<div class="row" >
			<div class="col-md-12">
			<br><br><br><br><br><br><br><br><br><br><br><br>
				<div class="col-md-5 col-md-offset-4" style="border:1px solid #333; background:#fff">
					
                    
					<div class="col-md-12" id="deleteusermsg" style="padding:20px;"> 
						<h4 style="color:red;font-weight:bolder;">Your Account Block By Admin...</h4>
						<div class="col-md-2 col-md-offset-10 btn btn-primary" style="color:black;font-weight:bolder;" onclick="$('#hidenewfac123').hide();">
						Ok</div>
					</div>
             
				</div>
				
			</div>
		</div>
</div>
		<?php
	}
?>

 <?php
	if($fgh==3)
	{
		unset($_SESSION['jpmeetou']);
		$fgh=0;
		?>
		<div class="" id='hidenewfac123' style='width:100%;height:149%;background: rgba(0,0,0,0.5);padding: 2%;position: fixed;z-index: 999;'>
		<div class="row" >
			<div class="col-md-12">
			<br><br><br><br><br><br><br><br><br><br><br><br>
				<div class="col-md-5 col-md-offset-4" style="border:1px solid #333; background:#fff">
					
                    
					<div class="col-md-12" id="deleteusermsg" style="padding:20px;"> 
						<h4 style="color:red;font-weight:bolder;">This Email id attached with other account!</h4>
						<div class="col-md-2 col-md-offset-10 btn btn-primary" style="color:black;font-weight:bolder;" onclick="$('#hidenewfac123').hide();">
						Ok</div>
					</div>
             
				</div>
				
			</div>
		</div>
</div>
		<?php
	}
?>
<?php
	if($fgh==7)
	{
		unset($_SESSION['jpmeetou']);
		$fgh=0;
		?>
		<div class="" id='hidenewfac123' style='width:100%;height:149%;background: rgba(0,0,0,0.5);padding: 2%;position: fixed;z-index: 999;'>
		<div class="row" >
			<div class="col-md-12">
			<br><br><br><br><br><br><br><br><br><br><br><br>
				<div class="col-md-5 col-md-offset-4" style="border:1px solid #333; background:#fff">
					
                    
					<div class="col-md-12" id="deleteusermsg" style="padding:20px;"> 
						<h4 style="color:red;font-weight:bolder;">Invalid Login Detail..!</h4>
						<div class="col-md-2 col-md-offset-10 btn btn-primary" style="color:black;font-weight:bolder;" onclick="$('#hidenewfac123').hide();$('#logindiv').show();">
						Ok</div>
					</div>
             
				</div>
				
			</div>
		</div>
</div>
		<?php
	}
?>
<script>
function hideselect()
{
	$("body.city-select-on").css("overflow","auto");
		$(".city-select").css("position","absolute");
		$(".city-select").css("top","-315px");
		$("body").removeClass("city-select-on");
		//$("header .header-group").css("top","335px");
		$("header .header-group.header-main").css("top","315px");
		$("header .header-group.header-right").css("top","335px");
		$(".city-toggle").css("top","335px");
	
}
$(document).ready(function(e) {
	
    $(".close-city-selection,.city-link,.displaycitylist").click(function(){
		//$("body.city-select-on .city-select-overlay").css("display","none");
		//$(".city-select").css("display","none");
		//$("body.city-select-on .city-toggle:before").css("display","none");
		$("body.city-select-on").css("overflow","auto");
		$(".city-select").css("position","absolute");
		$(".city-select").css("top","-315px");
		$("body").removeClass("city-select-on");
		//$("header .header-group").css("top","335px");
		$("header .header-group.header-main").css("top","315px");
		$("header .header-group.header-right").css("top","335px");
		$(".city-toggle").css("top","335px");
	});
	
	$(".city-toggle").click(function(){
		$("body").addClass("city-select-on");
		$("body.city-select-on").css("overflow","hidden");
		$(".city-select").css("position","relative");
		$(".city-select").css("top","0");
		$("header .header-group").css("top","0");
		$(".city-toggle").css("top","0");
	});
	$(".Select-placeholder").click(function(){
		$(".search-city-container .is-searchable").addClass("is-focused");
		$(".search-city-container .is-searchable").addClass("is-open");
	});
});
</script>

    
  <?php
	require_once('header2.php'); 
  ?>
<!-- pop up start -->
			<!-- Sing in modal -->
				<?php
					require_once('loginsignup.php'); 
				?>
 <!-- pop up end-->
 
 
    <!-- Carousel
    ================================================== -->
	<?
		$slider=mysql_query("select * from sliders where status=1");
		$fet=mysql_fetch_array($slider);
		
	
	?>
	
    <div class="pos_rel">
        <div class="container-flude pos_rel" id="slider" style="transform:rotate(<?php echo $fet['totateval']; ?>deg); background-image: url(img/<?php echo $fet['name']; ?>);"></div>
    	<div class="img_layer">
            <div class="container slider-text text-center s-text">
                <h1>Welcome To Meeto</h1>
                <h3>work according to your needs</h3>
            </div>
            <div class=""></div>
            <div class="submit-box">
                <div class="submit">
                
                    <input type="text" value="" id="city" class="submit-input" onkeyup="seachcity();" placeholder="Search Seminar City">
                    
                    <div class="blue-button submit-button" style="line-height:44px !important;" onclick="cityname();">Submit</div>
                    <div class="submit-cityname" id="citysuggetion"></div>
                </div>
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
	<!--<?php 
	/*$i=0;
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
		$i=0;*/
		?>-->
        <?php 
	$i=0;
	//$seminardetail =mysql_query("select * from cities where id in (select cityid from seminar where status=1 order by id desc) limit 0,6");
  $citydetail =mysql_query("select * from cities where status ='1' ");
   while($city12=mysql_fetch_array($citydetail))
   {
	   $i++;
	  ?>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<a href="seminarlist.php?id=<?php echo $city12['id']; ?>">
				<div class="top-margin-20"></div>	
					<div class="lon-border">
					<img src="img/<?php echo $city12['city_img']; ?>" style="transform:rotate(<?php echo $city12['rotateval']; ?>deg); height:198px;width:100%;" class="center-block lon-img"  />
					</div>
					<div class="overlay-text">
				    <span class="opan-b"><?php echo $city12['name']; ?></span>
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


<div class="home-containers" data-reactid="27"><!-- react-empty: 28 -->
	<div id="featured-projects" class="featured-project-container container">
    	<h2 class="header"><CENTER><B>Upcoming Seminar</B></CENTER></h2>
    	<span style="font-size: 0px;"></span>
        <div class="featured-projects-wrapper">
        	<div class="slider-container loaded">
                <div class="go-previous goto-nav">
                	<div class="goto-prev nav-btn" style="display:none;" id="goback" onclick="goback()"><i class="icon-forward-arrow goto-prev-icon"></i></div>
                </div>
                <div class="row">
                    <div class="slider-wrapper"><!-- style="transform: translateX(219px);"-->
                    	<div class="dis_flex">
								<?php
                                $i=0;
                                $selseminar=mysql_query("select * from seminar where status=1 and approval_status='approved' order by id DESC limit 0,10");
                                $totalSeminar=mysql_num_rows($selseminar);
                                while($fetseminar=mysql_fetch_array($selseminar))
                                {
                                    $selsemiphoto=mysql_query("select * from seminar_photos where seminar_id=$fetseminar[id] limit 0,1");
                                    $fetsemiphoto=mysql_fetch_array($selsemiphoto);
                                    $selsemitype=mysql_query("select * from seminar_type where id=$fetseminar[typeid]");
                                    $fetsemitype=mysql_fetch_array($selsemitype);
                                    $seluserdetail=mysql_query("select * from user_detail where uid=$fetseminar[uid]");
                                    $fetuserdetail=mysql_fetch_array($seluserdetail);
                                    $selcity=mysql_query("select * from cities where id=$fetseminar[cityid]");
                                    $fetcity=mysql_fetch_array($selcity);
                                ?>
							
                            <!--<div class="center-slide col-xs-12 col-sm-6 col-md-3" style="width:12%;" data-index="<?php /*echo $i;*/ ?>" style="display:table;">--><!--slide -->
                            <a href="infomation.php?id=<?php echo $fetseminar['id']; ?>" data-bypass="true" data-category="home_screen" data-action="open_card" data-label="{&quot;card_type&quot;:&quot;featured_projects&quot;,&quot;id&quot;:4932,&quot;uuid&quot;:&quot;94194ed7fe3a7423e9e5&quot;}" class="center-slide col-xs-12 col-sm-6 col-md-3" style="width:12%;" data-index="<?php echo $i; ?>" style="display:table;">
							<!--<a href="infomation.php?id=<?php echo $fetseminar['id']; ?>">-->
                                <div class="slide-content">
                                    <div class="fp-wrapper">
                                        <div class="fp-content">
                                            <!--<a class="fp-link h-track" href="infomation.php?id=<?php echo $fetseminar['id']; ?>" data-bypass="true" data-category="home_screen" data-action="open_card" data-label="{&quot;card_type&quot;:&quot;featured_projects&quot;,&quot;id&quot;:4932,&quot;uuid&quot;:&quot;94194ed7fe3a7423e9e5&quot;}">-->
                                                <div class="ic fp-image">
                                                    <div class="ic-image" style="transform:rotate(<?php echo $fetsemiphoto['rotateval']; ?>deg); background-image: url('<?php echo "img/".$fetsemiphoto[image]; ?>');">
                                                    </div>
                                                </div>
                                                <div class="fp-name"><?php echo $fetseminar['title']; ?></div>
                                                <div class="fp-developer">by <?php echo $fetseminar['hostperson_name']; ?>.</div>
                                                <div class="fp-configs grey-color"><?php echo $fetseminar['tagline']; ?></div>
                                               
                                                <div class="fp-price"><span><?php echo $fetcity['name']; ?></span></div>
                                             <!--</a>-->
                                        </div>
                                    </div>
                                </div>
								<!--</a>-->
                            <!--</div>-->
                            </a>
								<?php
                                $i++;
                                }
                                ?>
                        
                    	</div>
                    </div>
                </div>
                <div class="go-next goto-nav">
                	<div class="goto-next nav-btn" id="gonext" onclick="gonext(<? echo $totalSeminar; ?>)"><i class="icon-forward-arrow goto-next-icon"></i></div>
                </div>
            </div>
        </div>
    </div>

</div>


	<!--<div class="container owner-img">		
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
    </div>-->
	
	<!-- footer -->	

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
  </body>
</html>
