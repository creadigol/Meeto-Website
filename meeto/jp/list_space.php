<?php     
	require_once('db.php'); 
	require_once('condition.php');  
	$micro=round(microtime(true)*1000);
	$dt=date("Y-m-d");
	//echo "<br><br><br><br><br><br><br><br><br><br>hi";
	if(isset($_REQUEST['subbtn']))
	{	
		//echo "hi";
		$title = mysql_real_escape_string($_REQUEST['title']);	
		$tagline = mysql_real_escape_string($_REQUEST['tagline']);	
		$description = mysql_real_escape_string($_REQUEST['description']);	
		$address = mysql_real_escape_string($_REQUEST['streetaddress']);	
		$hostname = mysql_real_escape_string($_REQUEST['hostname']);	
		$idddd=$_SESSION['jpmeetou']['id'];
		
		$fromday = $_REQUEST['fromdate']." ".$_REQUEST['fromtime'];
	    $from_day =strtotime($fromday) * 1000;
        $today = $_REQUEST['todate']." ".$_REQUEST['totime'];
	    $to_day =strtotime($today) * 1000;
		//print_r($idddd);
		//echo $idddd;
		//echo $_REQUEST['type'];
		$inseminar=mysql_query("insert into seminar (uid,title,tagline,description,total_seat,total_booked_seat,qualification,address,typeid,countryid,stateid,cityid,zipcode,phoneno,hostperson_name,contact_email,status,approval_status,created_date,modified_date,lat,lng) values ($idddd,'$title','$tagline','$description',$_REQUEST[seats],0,'','$address',$_REQUEST[type],$_REQUEST[country],$_REQUEST[state],$_REQUEST[city],'$_REQUEST[zipcode]','$_REQUEST[contactno]','$hostname','$_REQUEST[contactemail]',1,'pending','$micro','$micro','$_REQUEST[lat]','$_REQUEST[lng]')");
		/*echo "insert into seminar (uid,title,tagline,description,total_seat,total_booked_seat,qualification,address,typeid,countryid,stateid,cityid,zipcode,phoneno,hostperson_name,contact_email,status,approval_status,created_date,modified_date,lat,lng) values ($idddd,'$title','$tagline','$description',$_REQUEST[seats],0,'$_REQUEST[qualification]','$address',$_REQUEST[type],$_REQUEST[country],$_REQUEST[state],$_REQUEST[city],'$_REQUEST[zipcode]','$_REQUEST[contactno]','$hostname','$_REQUEST[contactemail]',1,'pending','$micro','$micro','$_REQUEST[lat]','$_REQUEST[lng]')";*/
		
		$sid=mysql_insert_id();
		$inseminarday=mysql_query("insert into seminar_day (seminar_id,from_date,to_date,from_time,to_time) values($sid,'".$from_day."','".$to_day."','','') ");
		$countfaci=count($_REQUEST['facility']);
		for($i=0;$i<$countfaci;$i++)
		{
			$fid=$_REQUEST['facility'][$i];
			$insemifaci=mysql_query("insert into seminar_facility (seminar_id,facility_id,status) values ($sid,$fid,1)");
		}
		$countattendees=count($_REQUEST['purpose']);
		for($i=0;$i<$countattendees;$i++)
		{
			$aid=$_REQUEST['purpose'][$i];
			$insemiattendees=mysql_query("insert into seminar_purpose (seminar_id,attendees_id,status) values ($sid,$aid,1)");
		}
		$countindustry=count($_REQUEST['industry']);
		for($i=0;$i<$countindustry;$i++)
		{
			$fid=$_REQUEST['industry'][$i];
			$inindustry=mysql_query("insert into seminar_industry (seminar_id,industry_id,status) values ($sid,$fid,1)");
		}
		$countsemi=count($_FILES['semiimage']['name']);
		for($i=0;$i<$countsemi;$i++)
		{
			$tt=$_FILES['semiimage'][type][$i];	
			//echo "type >> ".$tt."<br>";
			$s=substr($tt,6);	
			if($s=="jpeg" || $s=="jpg" || $s=="png")	
			{		
				$dt=date("Y-m-d");		
				$dt2=(int)round(microtime($dt)*1000);
				$oldname=$_FILES[semiimage][name][$i];
				$ran=rand(0,999999);	
				$curname="semiimage".$ran.".".$s;	
				$newname="../img/".$curname;
				$rtr=$_REQUEST['txtrotatevalue'][$i];
				$insemiimg=mysql_query("insert into seminar_photos (seminar_id,image,rotateval) values ($sid,'$curname','$rtr')");
				//echo "insert into seminar_photos (seminar_id,image) values ($sid,'$curname')";
				move_uploaded_file($_FILES['semiimage']['tmp_name'][$i], $newname);  
			}
			
		}	
   //	mysql_query("delete from seminar_photos where rotateval=0");		
		if($inseminar)	
		{       
		    if($inseminarday)
			 {		
		       if($insemiimg)	
		     	{			
		          echo "<script>alert('あなたのセミナーが成功裏に追加されました。');</script>";
		        }						
			}	      					 	
		}
		echo "<script>location.href='your-listing.php'</script>";
	}
?>
<!DOCTYPE html>
<html lang="en">
  <?php	require_once('head1.php');   ?>
  <!-- NAVBAR================================================== -->
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"
type="text/javascript"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css"
rel="Stylesheet"type="text/css"/>
<script type="text/javascript">
$(function () {
    $("#txtFrom").datepicker({
        numberOfMonths: 1,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#txtTo").datepicker("option", "minDate", dt);
        }
    });
    $("#txtTo").datepicker({
        numberOfMonths: 1,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#txtFrom").datepicker("option", "maxDate", dt);
        }
    });
});
</script>
  
  <script>
  /*
$(function() 
 { 
      $( "#semifromdate,#semitodate" ).datepicker({
      changeMonth:true,
      changeYear:true,
      yearRange:"-100:+0",
	   maxDate : new Date(),
      dateFormat:"dd-mm-yy"
     });
 });
 */
  </script>
  <script type="text/javascript"> 

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 

function datelimit()
{
	var fromdate = document.getElementById('semifromdate').value;
	document.getElementById('semitodate').min=fromdate;
	
	var fromdate = document.getElementById('semitodate').value;
	document.getElementById('semifromdate').max=fromdate;
}
</script>
  <script>
var myCenter;
var lat=0;
var lng=0;
function getmaplatlng()
{
	var lat=document.getElementById("us2-lat").value;
	var lng=document.getElementById("us2-lon").value;
	
	myCenter=new google.maps.LatLng(lat,lng);
	
	google.maps.event.addDomListener(window, 'load', initialize());
}


function initialize()
{
	//alert(lat);
	//alert(lng);
	var marker;
var mapProp = {
  center:myCenter,
  zoom:12,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("map"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
 
  });

marker.setMap(map);
document.getElementById('lat').value=lat;
document.getElementById('lng').value=lng
	$("#pinimg").hide();
}
var glbid=0;
function facilityshow(id,aa)
	{
		
		a=imgnuarr[id];
		if (a.files && a.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#semimgfulldis').attr('src', e.target.result);
         
                }
                reader.readAsDataURL(a.files[0]);
            }
			//$("#rotateniid"+id).val(id);
		glbid=id;
			tgg();
	}
	 function tgg()
	 {
		 $("#hidenewfac").toggle(100);
	 }
	 function rotateImage(degree) {
		
	$('#semimgfulldis').animate({  transform: degree }, {
    step: function(now,fx) {
        $(this).css({
            '-webkit-transform':'rotate('+now+'deg)', 
            '-moz-transform':'rotate('+now+'deg)',
            'transform':'rotate('+now+'deg)'
        });
    }
    });
	$("#rotateniid"+glbid).val(degree);
	$('#dppic'+glbid).animate({  transform: degree }, {
    step: function(now,fx) {
        $(this).css({
            '-webkit-transform':'rotate('+now+'deg)', 
            '-moz-transform':'rotate('+now+'deg)',
            'transform':'rotate('+now+'deg)'
        });
    }
    });
	 }
	 
	function validateEmail(email) {
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
	 <style>
        .upperdivche,.img-remove
        {
           display:none;
        }
        </style>
  <body>
  <div class="upperdivche" id='hidenewfac' style='width:100%;height:149%;background: rgba(0,0,0,0.5);padding: 2%;position: fixed;z-index: 999;'>
		<div class="row" >
			<div class="col-md-12">
				<div class="col-md-5 col-md-offset-4" style="border:1px solid #333; background:#fff;">
					
                    <div class="col-md-12 page-header">
						<div  class="col-md-6" align="left" style="color:black;">
                        <h3>
                            <?php echo SEMINAR_IMAGE;?>
                        </h3>
						</div>
						<div  class="col-md-6 " align="right" >
						<div class="col-md-2 col-md-offset-10 btn btn-danger" onclick="tgg();">
							X
						</div>
						</div>
                    </div>
					<div class="col-md-12"> 
						
						<div class="col-md-8 col-md-offset-2">
						
							<label style="border:1px solid black;" align="center"><img align="center" src="" class="img-responsive" class="" id="semimgfulldis" /></label>
						</div>
						
						
						<div class="col-md-6 col-md-offset-2">
						<input type="hidden" class="btnRotate" value="90" id="deg90" />
						<input type="hidden" class="btnRotate" value="-90" id="deg990" />
						<input type="hidden" class="btnRotate" value="180" id="deg180" />
						<input type="hidden" class="btnRotate" value="360" id="deg360" />
							<div class="col-md-3" onClick="rotateImage($('#deg90').val());"><i style="color:red;" class="fa fa-rotate-right"></i></div>
							<div class="col-md-3" onClick="rotateImage($('#deg990').val());"><i style="color:red;"class="fa fa-rotate-left" ></i></div>
							<div class="col-md-3" onClick="rotateImage($('#deg180').val());"><i class="fa fa-refresh" style="transform:rotate(90deg);color:red;"></i></div>
							<div class="col-md-3" onClick="rotateImage($('#deg360').val());"><i style="color:red;"class="fa fa-refresh"></i></div>
						<br><br>
						</div>
					
					  <br><br><br>
					</div>
             
				</div>
				
			</div>
		</div>
</div>
  <?php	require_once('header1.php');   ?>
  <!-- pop up start -->
  <!-- Sing in modal -->
  
  <?php				
	require_once('loginsignup.php'); 	
	?>
  <!-- pop up end-->
  
<div  class="container-flude back-container full-container">
	<div class="text-center">
	<div id="firstscreenhead" class="clearfix"><div>
		<div class="top-margin-10 margin-main">&nbsp;</div>
			<h3 class="space"><?php echo LIST_YOUR_SEMINAR;?></h3>
		<div class="top-margin-20"></div>		
	</div>
	</div>
</div>
<form action="" method="post" enctype="multipart/form-data" name="addseminar" role="form">
<div id="firstscreen" class="container-flude slider-width">
	<div class="container">
		<div class="row list_field">
		<!--<form action="" method="post" name="addseminar">-->
			<div class="col-md-12 seminar-type seminar-type-right">
				<div class="col-md-2 list-name">
					<div class="list-label">
						<label><?php echo SEMINAR_PLACE;?>:</label>
					</div>	
				</div>

				<div class="col-md-10 list-type">
					<ul class="type_field_btn slider-width">
					<?php
						$seltype=mysql_query("select * from seminar_type where status=1");
						while($fettype=mysql_fetch_array($seltype))
						{
					?>
					<li class="field_btn list-seminar-box">
							<a href="#">
								<img src="../img/<?php echo $fettype['image']; ?>" class="list-img img-responsive">
								<span class="img-name">
									<?php $marutra = explode('"',translate(str_replace(" ","+",$fettype['name']))); echo $marutra[1] ; ?>	
								<input required type="radio" class="semitype list-redio" name="type" id="home_type10" value="<?php echo $fettype['id']; ?>">				
								</span>
							</a>
						<div class="bottom-margin-30"></div>	
					</li>
					<?php
						}
					?>
					</ul>
					<a href="#" class="validation" id="typevalidation"><?php echo PLEASE_SELECT_SEMINAR_PLACE;?></a>
				</div>
				<div class="clearfix"></div>
			</div>	
		
			<div class="top-margin-20">&nbsp;</div>
		
			<div class="col-md-12 seminar-type"> 
				<div class="col-md-2 list-name">
					<div class="list-label">
						<label><?php echo SEMINAR_ATTENDES;?>:</label>
					</div>	
				</div>

				<div class="col-md-10 list-type"> 
					<ul class="type_field_btn slider-width">
						<?php
						$selpurpose=mysql_query("select * from purpose where status=1");
						while($fetpurpose=mysql_fetch_array($selpurpose))
						{
						?>
						<li class="field_btn list-seminar-box">
							<a href="#">
								<img src="../img/<?php echo $fetpurpose['image']; ?>" class="list-img img-responsive">	
								<span class="img-name">
								<?php $marutra = explode('"',translate(str_replace(" ","+",$fetpurpose['name']))); echo $marutra[1] ; ?>
								<input type="checkbox" class="semipurpose checkbox-button" name="purpose[]" id="attendees" value="<?php echo $fetpurpose['id']; ?>">			
								</span>
							</a>
							<div class="bottom-margin-30"></div>	
						</li>
						<?php
						}
						?>
					</ul>
					<br><br><a href="#" class="validation" id="purposevalidation"><?php echo PLEASE_SELECT_SEMINAR_PLACE;?></a>
				</div>
				<div class="clearfix"></div>
			</div>
			
			<div class="top-margin-20">&nbsp;</div>

			<div class="col-md-12 seminar-type seminar-type-right">
				<div class="col-md-2 list-name">
					<div class="list-label">
						<label><?php echo INDUSTRY_TYPE;?>:</label>
					</div>	
				</div>

				<div class="col-md-10 list-type">
					<ul class="type_field_btn slider-width">
					<?php
						$selindustry=mysql_query("select * from  industry where status=1");
						while($fetindustry=mysql_fetch_array($selindustry))
						{
					?>
					<li class="field_btn list-seminar-box">
							<a href="#">
								<img src="../img/<?php echo $fetindustry['image']; ?>" class="list-img img-responsive">	
								<span class="img-name">
								<?php $marutra = explode('"',translate(str_replace(" ","+",$fetindustry['name']))); echo $marutra[1] ; ?>
								<input type="checkbox" class="semipurpose1 checkbox-button" name="industry[]" id="industry" value="<?php $marutra = explode('"',translate(str_replace(" ","+", $fetindustry['id']))); echo $marutra[1]; ?>">			
								</span>
							</a>
						<div class="bottom-margin-30"></div>	
					</li>
					<?php
						}
					?>
					</ul>
					<a href="#" class="validation" id="Industry"><?php echo PLEASE_SELECT_ANY_INDUSTRY;?></a>
				</div>
				<div class="clearfix"></div>
			</div>		
			
			
			<div class="col-md-6 col-md-offset-3 top-margin-30"> 
				<div class="col-md-4 list-name">
					<div class="list-label">
						<label><?php echo TOTAL_SEAT;?>:</label>
					</div>	
				</div>

				<div class="col-md-8 list-type">
					<ul class="type_field_btn">
						<li class="field_btn">
							<a>
								<img src="../img/list-page/group12.png" class="list-img img-responsive">
								<input id="seats" name="seats" required  type="number"  min="1" placeholder="総席" class="input-medium input-Accommodates price-border" />
							</a>
						</li>
					</ul>
			<!--		<br><br><a href="#" class="validation" id="seatvalidation">Please Enter Total Seats </a>  -->
				</div>
			</div>
			<!--<div class="list-name">
				<div class="list-label">
					<label>city</label>
				</div>	
			</div>

			<div class="list-type">
				<ul class="type_field_btn">
					<li class="field_btn">
						<a>
							<img src="img/list-page/map-marker.png" class="list-img img-responsive">
								<input type="text" class="city-location" placeholder="Your Location">
						</a>
					</li>
				</ul>
			</div>-->
			
			
			<div class="col-md-12 text-center">
				<div class="top-margin-20">&nbsp;</div>	
						<a class="blue-button list-continue" id="continue" style="pointer-events: all;" onclick="checkvalid();"><?php echo CONTINUE1;?></a>

			</div>	
		
		</div>
	</div>
</div>

<div id="secondscreen" class="container-flude" style="display:none;">
<script type="text/javascript">
   openCity(event, 'Pricing');
</script>

	<div class="container small-container">
		<div class="row">

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
				<div class="row">
					<ul class="tab nav left_side left_back">
						<span><?php echo BASIC;?></span>
					  <li class="tablinks active" onclick="openCity(event, 'Pricing')"><span><?php echo CONTACT;?></span>
					  	
					  </li>
					  <li class="tablinks" onclick="openCity(event, 'Calendar')"><span><?php echo DAY;?></span>
					  	<span id="daytrue" class="glyphicon glyphicon-ok" style="color:green; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>
						
						 <span id="dayfalse" class="glyphicon glyphicon-remove" style="color:red; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>				  
					  </li>
					</ul>

					

					<ul class="tab nav left_side left-menu left_back">
						<span><?php echo DISCRIPTION;?></span>
					  <li class="tablinks" onclick="openCity(event, 'Overview')"><span><?php echo OVERVIEW;?></span>
					  	<span id="Overviewtrue" class="glyphicon glyphicon-ok" style="color:green; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>
						
						 <span id="Overviewfalse" class="glyphicon glyphicon-remove" style="color:red; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>							  
					  </li>
					  <li class="tablinks" onclick="openCity(event, 'Photos')"><span><?php echo PHOTOS;?></span>
					  							  
					  </li>
					</ul>



					<ul class="tab nav left_side left-menu left_back">
						<span><?php echo SETTING;?></span>
					  <li class="tablinks" onclick="openCity(event, 'Amenities')"><span><?php echo FACILITIES;?></span>
					  				  
					  </li>
					  <li class="tablinks" onclick="openCity(event, 'Location')"><span><?php echo LOCATION;?></span>
					  	<span id="Locationtrue" class="glyphicon glyphicon-ok" style="color:green; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>
						
						 <span id="Locationfalse" class="glyphicon glyphicon-remove" style="color:red; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>							  
					  </li>
					  <!--<li><a href="#" class="tablinks list-submit" onclick="openCity(event, 'Policy')">提出します</a></li>-->
					  <!--<li><a class="tablinks list-submit" onclick="openCity(event, 'Policy')">提出します</a></li>-->
					  <li style="padding-left: 14px;"><input type="submit"  class="tablinks list-submit" onclick="semivalidation()" name="subbtn" value="<?php echo SUBMIT;?>"  style="width:100%;padding-left:0;text-align:left;background:none;border:none;"/></li>
					</ul>
				</div>
			</div>

			

			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				<div class="row">
					<div id="Pricing" class="tabcontent">
						<div class="col-md-12 right_side">
						<div class="clearfix"></div>
							<div class="row price-border price-margin Location-row">
								<div class="col-md-8 center">
									 <h3><?php echo BASIC;?></h3>
									 <p><?php echo SET_THE_CONTACT_DETAIL_FOR_SEMINAR_LISTING;?></p>
								</div>
								<div class="col-md-9">
									<div class="overview_title">									
										<label class="overview-label"><?php echo HOST_PERSON_NAME;?></label>
										<input name="hostname" value="<?php echo $_SESSION['jpmeetou']['fname']." ".$_SESSION['jpmeetou']['lname']; ?>" type="text" id="hostname" placeholder="<?php echo HOST_PERSON_NAME;?>" class="overview-input">
									</div>
									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									
										<label class="overview-label"><?php echo CONTACT_EMAIL;?></label>
										<label id="emailvali" style="color:red; font-size:15px; display:none;"><?php echo PLEASE_ENTER_VALID_EMAIL_ID;?></label>
										<input name="contactemail" value="<?php echo $_SESSION['jpmeetou']['email']; ?>" type="email" onkeyup="validateEmail(this.value);" id="contactemail" placeholder="<?php echo CONTACT_EMAIL;?>" class="overview-input">
									</div>
									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									
										<label class="overview-label"><?php echo CONTACT_NO;?></label>
										<label id="phonevali" style="color:red; font-size:15px; display:none;"><?php echo PLEASE_ENTER_VALID_CONTACT_NO;?></label>
										<input name="contactno" type="text" id="contactno" placeholder="<?php echo CONTACT_NO;?>" onkeyup="validateContact(this.value);" class="overview-input">
									</div>
								</div>
									<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div id="Calendar" class="tabcontent">
					  <div class="col-md-12 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row">

								<div class="col-md-8 center">

									 <h3><?php echo DAY;?></h3>

									 <p><?php echo SET_DAY_TIME_DATAIL_FOR_SEMINAR_LISTING;?> </p>

								</div>

								<div class="col-md-9">

									<div class="overview_title">									

										<label class="overview-label"><?php echo FROM_DATE;?></label>
										<input type="text" name="fromdate" id="txtFrom" placeholder="<?php echo FROM_DATE;?>" class="overview-input" />
										<!--<input type="date" required min="<?php echo $dt; ?>" onchange="datelimit();" id="semifromdate" name="fromdate" placeholder="From Date" class="overview-input">-->
										<label class="overview-label"><?php echo TO_DATE;?></label>
										<input type="text" name="todate" id="txtTo" placeholder="<?php echo TO_DATE;?>" class="overview-input" />
										<!--<input type="date" required min="<?php echo $dt; ?>" onchange="datelimit();" id="semitodate" name="todate" placeholder="To Date" class="overview-input">-->

									</div>
									
									<div class="bottom-margin-20"> </div>

									<div class="overview_title">									
									<link href="css/bootstrap_time.css" rel="stylesheet">

									<!-- Custom styles for this template -->
 
										<link href="css/timepicki.css" rel="stylesheet">
										<label class="overview-label"><?php echo START_SEMINAR_TIME;?></label>
										<input id="timepicker1" style="cursor:pointer;" class="timepicker1" type="text" name="fromtime" placeholder="<?php echo START_SEMINAR_TIME;?>"/>
										
										<label class="overview-label"><?php echo END_SEMINAR_TIME;?></label>

										<input id="timepicker1" style="cursor:pointer;" class="timepicker1" type="text" name="totime" placeholder="<?php echo END_SEMINAR_TIME;?>"/>
                                        
									</div>

									<div class="bottom-margin-20"> </div>
								</div>

								
						

							</div>

							<div class="clearfix"></div>

							

							

						</div>

					</div>



					<div id="Overview" class="tabcontent">

					  <div class="col-md-12 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row">

								<div class="col-md-8 center">

									 <h3><?php echo OVERVIEW;?></h3>

									 <p><?php echo SET_SEMINAR_DETAIL_FOR_SEMINAR_LISTING;?></p>

								</div>

								<div class="col-md-9">

									<div class="overview_title">									
										<label class="overview-label"><?php echo TITLE;?></label>
										<input type="text" required name="title" value="" id="title" placeholder="タイトル" class="overview-input">

									</div>

									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									

										<label class="overview-label"><?php echo TAGLINE;?></label>

										<input type="text"  name="tagline" id="tagline" placeholder="キャッチフレーズ" class="overview-input">

									</div>

									<div class="bottom-margin-20"> </div>
									<!--<div class="overview_title">									

										<label class="overview-label">
資格</label>
										<select name="qualification" id="qualification" required class="overview-input">
											<option value="">
- 選択 -</option>
											<option>
第10回パス</option>
											<option>
第12回パス</option>
											<option>卒業</option>
											<option>大学院</option>
										</select>
										

									</div>-->

									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									

										<label class="overview-label"><?php echo DISCRIPTION;?> &nbsp;&nbsp;</label>

										<textarea  class="overview-input" name="description" placeholder="
説明" id="description" rows="8" style="color:#000 !important;"></textarea>
									</div>
								</div>
									<div class="clearfix"></div>									
							</div>
							<div class="clearfix"></div>	
						</div>
						

					</div>

					

					<div id="Photos" class="tabcontent">

					  <div class="col-md-12 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row left-side-height">

								<div class="col-md-12 text-center photo-head">

										<img src="../img/cam.png" class="img-responsive center-block">

										 <h3><?php echo ADD_A_PHOTO;?></h3>

										 <span><?php echo SET_SEMINAR_PHOTOS_FOR_SEMINAR_LISTING;?></span>
										 <span id="choosefileset"></span>
												<input class="add-photo choose-img" id="jsimgid0" type="file" name="semiimage[]" onchange="setimg(0, this);addimgmaru()"/>
												<input type="hidden" id="rotateniid0" value="360" name="txtrotatevalue[]">
												<br>

									<div class="bottom-margin-10">&nbsp;</div>	

								</div>

								<center>

									<!--<span class="forgot">
										
								注：画像サイズ1349px X 500pxなど
									</span>-->
								</center>
							<script>
		loadd();
		function loadd()
		{
			 $("#show_pic0").css('display','none');
		}
		var c=0;
		var imgnuarr = new Array();
        function setimg(id, a)
        {
			
				$(".img-remove").show();
			
			imgnuarr[c]=a;
            if (a.files && a.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#dppic' + id).attr('src', e.target.result);
                   $("#show_pic"+id).show();
                }
                reader.readAsDataURL(a.files[0]);
            }
            
        }
        
        function addimgmaru()
        {
			$("#jsimgid"+c).hide();
            c++;
          
            var sdf='<div id="file_in'+c+'"><input type="file" class="add-photo choose-img" name="semiimage[]" id="jsimgid'+c+'"  onchange="setimg('+c+',this);addimgmaru()"></div>';
            var setdiv = '<div class="col-md-3" id="show_pic'+c+'" style="display:none;min-height:140px;"><img class="img-height" width="150" class="" id="dppic'+c+'" onclick=facilityshow('+c+',this);><input type="hidden" id="rotateniid'+c+'" value="360" name="txtrotatevalue[]">';
            setdiv += '<br><button type="button" class="img-remove" onclick=remove('+c+',"rmv_div");> x </button></div>';
           
            
            var cc=c-1;
			
            $("#show_pic"+cc).after(setdiv);
			$("#file_in"+c).hide();
			$("#choosefileset").append(sdf);
        }
        function remove(rmv,a)
        {
           if(a=="rmv_div"){
			   if(rmv==0)
			   {
				   $("#jsimgid0").hide();
					$("#show_pic0").hide(); 
					$("#rotateniid0").val('0');
			   }else{
				  $("#file_in"+rmv).remove();
               $("#show_pic"+rmv).remove(); 
			   }
			    
			   
                if(c==rmv)
                {
                    c=c-1;
                }
           }
            
        }
        
    </script>
								<div id="main0" class="col-md-12">
								     <div id="show_pic0" class="col-md-3" style="min-height:140px;">
									 <img  src="" onclick="facilityshow(0,this);" id="dppic0">
									<br><button type="button" class="img-remove" onclick='remove(0,"rmv_div")';> x </button>
									</div>
									</div>
							</div>
							<div class="clearfix"></div>	
						</div>

						<div class="col-md-8">

							<div class="bottom-margin-20">&nbsp;</div>	

						</div>

					</div>



					<div id="Amenities" class="tabcontent">

					  <div class="col-md-12 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row left-side-height">

								<div class="col-md-6 center">

									 <h3><?php echo FACILITIES;?></h3>

									 <p><?php echo COMMON_FACILITIES_AT_MOST_HOSTS_LISTINGS;?></p>
								</div>
								<div class="col-md-12">
									<ul class="nav facility">
										<?php
										$selfaci=mysql_query("select * from facility where status=1");
										while($fetfaci=mysql_fetch_array($selfaci))
										{
											?>
											<li>
											<input type="checkbox" class="checkbox-check" name="facility[]" id="facility" value="<?php echo $fetfaci['id']; ?>">
											<span><?php $marutra = explode('"',translate(str_replace(" ","+",$fetfaci['name']))); echo $marutra[1] ; ?>
											</span>
										    </li>
											<?php
										}
										?>
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>	
						</div>

						<div class="col-md-8">

							<div class="bottom-margin-20">&nbsp;</div>	
						</div>
					</div>
					</div>
					<div id="Location" class="tabcontent">

					  <div class="col-md-12 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row left-side-height">

								<div class="col-md-5 center">
                                   <div class="modal-body">

								

									<div class="col-md-12">

										<ul class="nav add-pop-up">
																					
											<li>											
												<div class="overview_title">									
													<label class="overview-label" for=""><?php echo COUNTRY;?><span style="color:red;">*</span></label>
												<select id="country" class="overview-input"  name="country" onchange="setstate(this.value);">
														 <option value="">-<?php echo SELECT_COUNTRY;?>-</option>
													<?php
															$selcountry=mysql_query("select * from countries where id!=101");
															while($fetcountry=mysql_fetch_array($selcountry))
															{
														?>
																<option value="<?php echo $fetcountry['id']; ?>"><?php $marutra = explode('"',translate(str_replace(" ","+", $fetcountry['name'])));echo $marutra[1] ; ?></option>
														<?php
															}
														?>
													</select>
												
												</div>

											</li>

											<li>

												<div class="overview_title">	
													<label class="overview-label"><?php echo STATE;?><span style="color:red;">*</span></label>
													<select id="allstate" class="overview-input" name="state"  onchange="setcity(this.value);">
														<option value="">- <?php echo SELECT_STATE;?> -</option>
													</select>
													
												</div>

											</li>

											<li>

												<div class="overview_title">									

													<label class="overview-label"><?php echo CITY;?><span style="color:red;">*</span></label>
													<select id="allcity" class="overview-input" name="city" onchange="">
														 <option value="">- <?php echo SELECT_CITY;?> -</option>
														
													</select>
												</div>
											</li>

											<li>

												<div class="overview_title">									

													<label class="overview-label"><?php echo STREET_ADDRESS;?></label>

													<input type="text" id="streetaddress" name="streetaddress" class="overview-input">
													<input type="text" hidden name="lat" id="lat" class="overview-input">
													<input type="text" hidden name="lng" id="lng" class="overview-input">
												</div>

											</li>

											<li>

												<div class="overview_title">									
													<label class="overview-label"><?php echo ZIP_CODE;?><span style="color:red;">*</span></label>
													<input type="text" id="zipcode" name="zipcode" class="overview-input">

												</div>

											</li>

											<div class="bottom-margin-20"></div>

										</ul>

									</div>

								

								</div>
								
									<!-- <h3>
住所</h3>

									 <p>
あなたの正確なアドレスはプライベートのみ予約後のお客様と共有している賃借人が自分の仕事の日を計画することができるようにするために、宿泊施設の正確な通りの名前を提供するために責任があるホストconfirmed.Howeverです。</p>-->
								</div>
								<div class="col-md-7 text-center">
									

												<div class="overview_title">									
													<label class="overview-label"><?php echo LOCATION;?><span style="color:red;">*</span></label>

													<input type="text" id="pac-input" required placeholder="場所を入力してください。"  class="overview-input">
													
												<script>
										  // This example adds a search box to a map, using the Google Place Autocomplete
										  // feature. People can enter geographical searches. The search box will return a
										  // pick list containing a mix of places and predicted search terms.

										  // This example requires the Places library. Include the libraries=places
										  // parameter when you first load the API. For example:
										  // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

										  function initAutocomplete() {
											 
											var map = new google.maps.Map(document.getElementById('map'), {
											  center: {lat: 22.5726, lng: 88.3639}, 
											  zoom: 13,
											  mapTypeId: 'roadmap'
											});

											// Create the search box and link it to the UI element.
											var input = document.getElementById('pac-input');
											var searchBox = new google.maps.places.SearchBox(input);
											//map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

											// Bias the SearchBox results towards current map's viewport.
											map.addListener('bounds_changed', function() {
											  searchBox.setBounds(map.getBounds());
											});
											
											var markers = [];
											// Listen for the event fired when the user selects a prediction and retrieve
											// more details for that place.
											searchBox.addListener('places_changed', function() {
											  var places = searchBox.getPlaces();

											  if (places.length == 0) {
												return;
											  }

											  // Clear out the old markers.
											  markers.forEach(function(marker) {
												marker.setMap(null);
											  });
											  markers = [];
											 
											  // For each place, get the icon, name and location.
											  var bounds = new google.maps.LatLngBounds();
											  places.forEach(function(place) {
												  
												if (!place.geometry) {
												  console.log("Returned place contains no geometry");
												
												  return;
												}
												var icon = {
												  url: place.icon,
												  size: new google.maps.Size(71, 71),
												  origin: new google.maps.Point(0, 0),
												  anchor: new google.maps.Point(17, 34),
												  scaledSize: new google.maps.Size(25, 25)
												};

												// Create a marker for each place.
												markers.push(new google.maps.Marker({
												  map: map,
												  icon: icon,
												  title: place.name,
												  position: place.geometry.location
												}));

												if (place.geometry.viewport) {
												  // Only geocodes have viewport.
												  bounds.union(place.geometry.viewport);
												} else {
												  bounds.extend(place.geometry.location);
												}
												 lat = place.geometry.location.lat();
												 lng = place.geometry.location.lng(); 
												 //document.getElementById('us2-lat').value=lat;
												 //document.getElementById('us2-lon').value=lng;
												  ll=1;
													
											  });
											  map.fitBounds(bounds);
											  myCenter=new google.maps.LatLng(lat,lng);
											  google.maps.event.addDomListener(window, 'load', initialize());
											});
											 
										  }

										</script>
											<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnWG6DJ5dpqNjBC1CZI8xdS3L769lQHuc&libraries=places&callback=initAutocomplete"
											async defer></script>
												</div>

											
									<div class="price-border">
										<div id="map" style="height:200px;width:100%;"></div>
							
										<img src="../img/map-pin.png" id="pinimg" class="img-responsive map-pin">
																			
										<div class="clearfix"></div>										
										<!--<div class="top-margin-10">&nbsp;</div>

											<a href="#" class="text-uppercase blue-button add-button" data-toggle="modal" data-target="#myModal">アドレスを追加</a>

										<div class="bottom-margin-10">&nbsp;</div>-->	

									</div>
									

								</div>

							</div>

							<div class="clearfix"></div>

							

						<!--Address Pop-up  -->

						<!--<div class="modal fade" id="myModal" role="dialog">

							<div class="modal-dialog">

							  

							  <div class="modal-content modal-c">

							  

								<div class="modal-header model-head">

								  <button type="button" class="close" data-dismiss="modal">&times;</button>

								  <h4 class="modal-title semibold-o">住所を入力してください</h4>

								</div>

								

								<div class="clearfix"></div>

								<div class="modal-footer model-head">

								  <button type="button" class="blue-button f-left border-n" data-dismiss="modal">キャンセル</button>

								  <button type="button" class="blue-button f-right border-n" data-dismiss="modal">提出します</button>
								</div>								
							  </div>
							  
							</div>
					    </div>						
						<!--Address Pop-up END -->
						</div>

						

						

					</div>



					<!--<div id="Policy" class="tabcontent">

						  <div class="col-md-12 right_side left-side-height">

							<div class="clearfix"></div>

								<div class="row price-border price-margin Location-row">

									<div class="col-md-12 center policy">

										 <span>あなたのリストを見ることができるように、送信ボタンをクリックしてください。</a>

										 </span>

									</div>

								</div>

								<div class="clearfix"></div>

								

								<div class="row price-border price-margin Location-row">

									<div class="col-md-12">
										<div class="top-margin-20"></div>
										
									<button class="blue-button" onclick="semivalidation();" name="subbtn" type="submit">
提出します</button>									
									</div>
											<div class="clearfix"></div>
										<div class="bottom-margin-20">&nbsp;</div>
									</div>

								</div> 

							</div>-->

					</div>

				</div>

				

			</div>

			<div class="col-md-4"></div>

			

		</div>

</form>

<div class="top-margin-30">&nbsp;</div>
</div>
  </body>

 

 

	<!-- footer -->	

<?php    require_once('footer1.php');	?>

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

	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

 <script src="js/timepicki.js"></script>
    <script>
	$('.timepicker1').timepicki();
    </script>

</html>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<!-- jQuery Code executes on Date Format option ----->
<script src="js/script.js"></script>
<script>

function openCity(evt, cityName) {

    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");

    for (i = 0; i < tabcontent.length; i++) {

        tabcontent[i].style.display = "none";

    }

    tablinks = document.getElementsByClassName("tablinks");

    for (i = 0; i < tablinks.length; i++) {

        tablinks[i].className = tablinks[i].className.replace(" active", "");

    }

    document.getElementById(cityName).style.display = "block";

    evt.currentTarget.className += " active";

}

</script>




<!--
<style>
.field_btn { border: none !important; float: none !important;}
.field_btn a { float: left !important;}
.selected {background-color: #dededf;}


</style> -->

