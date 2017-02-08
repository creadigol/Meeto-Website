<?php     
   require_once('condition.php');
	$micro=round(microtime(true)*1000);
	if(isset($_REQUEST['subbtn']))
	{	
       $deletefaci=mysql_query("delete from seminar_facility where seminar_id='".$_REQUEST['id']."'");
	   $deletepurpose=mysql_query("delete from seminar_purpose where seminar_id='".$_REQUEST['id']."'");
	   $deleteindustry=mysql_query("delete from seminar_industry where seminar_id='".$_REQUEST['id']."'");
	   
		$title = mysql_real_escape_string($_REQUEST['title']);	
		$tagline = mysql_real_escape_string($_REQUEST['tagline']);	
		$description = mysql_real_escape_string($_REQUEST['description']);	
		$address = mysql_real_escape_string($_REQUEST['streetaddress']);	
		$hostname = mysql_real_escape_string($_REQUEST['hostname']);
		$fromday = $_REQUEST['fromdate']." ".$_REQUEST['fromtime'];
	    $from_day =strtotime($fromday) * 1000;
        $today = $_REQUEST['todate']." ".$_REQUEST['totime'];
	    $to_day =strtotime($today) * 1000;

        $editseminar=mysql_query("update seminar set title='".$title."',tagline='".$tagline."',description='".$description."',total_seat='".$_REQUEST['seats']."',total_booked_seat='0',address='".$address."',typeid='".$_REQUEST['type']."',zipcode='".$_REQUEST['zipcode']."',phoneno='".$_REQUEST['contactno']."',countryid='".$_REQUEST['country']."',stateid='".$_REQUEST['state']."',cityid='".$_REQUEST['city']."',hostperson_name='".$hostname."',contact_email='".$_REQUEST['contactemail']."',modified_date='".$micro."' where id='".$_REQUEST['id']."' ");
		
		
		
		$sid=mysql_insert_id();
		$inseminarday=mysql_query("update seminar_day set from_date='".$from_day."',to_date='".$to_day."' where seminar_id=$_REQUEST[id]");
		$countfaci=count($_REQUEST['facility']);
		for($i=0;$i<$countfaci;$i++)
		{
			$fid=$_REQUEST['facility'][$i];
			$insemifaci=mysql_query("insert into seminar_facility (seminar_id,facility_id,status) values ('".$_REQUEST['id']."',$fid,1)");
		}
		$countattendees=count($_REQUEST['purpose']);
		for($i=0;$i<$countattendees;$i++)
		{
			$aid=$_REQUEST['purpose'][$i];
			$insemiattendees=mysql_query("insert into seminar_purpose (seminar_id,attendees_id,status) values ('".$_REQUEST['id']."',$aid,1)");
		}
		$countindustry=count($_REQUEST['industry']);
		for($i=0;$i<$countindustry;$i++)
		{
			$fid=$_REQUEST['industry'][$i];
			$inindustry=mysql_query("insert into seminar_industry (seminar_id,industry_id,status) values ('".$_REQUEST['id']."',$fid,1)");
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
				$insemiimg=mysql_query("insert into seminar_photos (seminar_id,image,rotateval) values ('".$_REQUEST['id']."','".$curname."','$rtr')");
				
				//echo "insert into seminar_photos (seminar_id,image) values ($sid,'$curname')";
				move_uploaded_file($_FILES['semiimage']['tmp_name'][$i], $newname);  
				
			}
		}
		mysql_query("delete from seminar_photos where rotateval=0");
		if($editseminar)
		{
			echo "<script>alert('編集セミナーに成功');</script>";
		}
		 echo "<script>location.href='your-listing.php'</script>";
	}
	//print_r($_FILES['semiimage']['name']);
	//print_r($_REQUEST['txtrotatevalue']);
$seminar = mysql_fetch_array(mysql_query("select * from seminar where id = '".$_REQUEST['id']."' "));	
$seminardate =  mysql_fetch_array(mysql_query("select * from seminar_day where seminar_id = '".$seminar['id']."'"));

	
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
function deletepic(photoid)
 {
	 if(confirm("消去してもよろしいですか  ?"))
	 {
		 $.ajax({
		url: "miss.php?kon=deletephoto&id="+photoid, 
		type: "POST",
		success: function(data)
		{ 
		
		}
		}); 
	 }
		 
 }
 
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

</script>
<style>
        .upperdivche,#show_pic0
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
						<div  class="col-md-6" align="left" style="color:blcak;">
                        <h3>セミナーイメージ</h3>
						</div>
						<div  class="col-md-6 " align="right" >
						<div class="col-md-2 col-md-offset-10 btn btn-danger" onclick="tgg();">X</div>
						</div>
                    </div>
					<div class="col-md-12"> 
						
											<div class="col-md-8 col-md-offset-2">
											
												<label   style="border:1px solid black;" align="center"><img align="center" src="" width="500" height="500"  class="" id="semimgfulldis" /></label>
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
			<h3 class="space">
あなたのセミナーを一覧表示</h3>
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
						<label>
セミナー・プレイス :</label>
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
								<input required type="radio" class="semitype list-redio" name="type" id="home_type10" value="<?php echo $fettype['id']; ?>"<? if($seminar['typeid']==$fettype['id']) echo CHECKED;?>>				
								</span>
							</a>
						<div class="bottom-margin-30"></div>	
					</li>
					<?php
						}
					?>
					</ul>
					<a href="#" class="validation" id="typevalidation">
セミナー場所を選択してください</a>
				</div>
			</div>	
		
			<div class="top-margin-20">&nbsp;</div>
		
			<div class="col-md-12 seminar-type"> 
				<div class="col-md-2 list-name">
					<div class="list-label">
						<label>
セミナー参加者：</label>
					</div>	
				</div>

				<div class="col-md-10 list-type">
					<ul class="type_field_btn slider-width">
						<?php
						$arrypurpose=array();
						$seminarpurpose =mysql_query("select * from seminar_purpose where seminar_id = '".$seminar['id']."' and status=1");
					   while($purpose=mysql_fetch_array($seminarpurpose))
					   {
					   array_push($arrypurpose,$purpose['attendees_id']);
					   }
						$selpurpose=mysql_query("select * from purpose where status=1");
						while($fetpurpose=mysql_fetch_array($selpurpose))
						{
						?>
						<li class="field_btn list-seminar-box">
							<a href="#">
								<img src="../img/<?php echo $fetpurpose['image']; ?>" class="list-img img-responsive">	
								<span class="img-name">
								<?php $marutra = explode('"',translate(str_replace(" ","+",$fetpurpose['name']))); echo $marutra[1] ; ?>
								<input type="checkbox" class="semipurpose checkbox-button" name="purpose[]" id="attendees" value="<?php echo $fetpurpose['id']; ?>" <?php if(in_array($fetpurpose['id'],$arrypurpose)) echo checked;?> >			
								</span>
							</a>
							<div class="bottom-margin-30"></div>	
						</li>
						<?php
						}
						?>
					</ul>
					<br><br><a href="#" class="validation" id="purposevalidation">セミナーの参加者を選択してください</a>
				</div>
			</div>
			
			<div class="top-margin-20">&nbsp;</div>

			<div class="col-md-12 seminar-type seminar-type-right">
				<div class="col-md-2 list-name">
					<div class="list-label">
						<label>
産業タイプ:</label>
					</div>	
				</div>

				<div class="col-md-10 list-type">
					<ul class="type_field_btn slider-width">
					<?php
					  $arryindustry=array();
						$seminarindustry =mysql_query("select * from seminar_industry where seminar_id = '".$seminar['id']."' and status=1");
					   while($industry=mysql_fetch_array($seminarindustry))
					   {
					   array_push($arryindustry,$industry['industry_id']);
					   }
					
						$selindustry=mysql_query("select * from  industry where status=1");
						while($fetindustry=mysql_fetch_array($selindustry))
						{
					?>
					<li class="field_btn list-seminar-box">
							<a href="#">
								<img src="../img/<?php echo $fetindustry['image']; ?>" class="list-img img-responsive">	
								<span class="img-name">
								<?php $marutra = explode('"',translate(str_replace(" ","+",$fetindustry['name']))); echo $marutra[1] ; ?>
								<input type="checkbox" class="semipurpose1 checkbox-button" name="industry[]" id="industry" value="<?php echo $fetindustry['id']; ?>" <?php if(in_array($fetindustry['id'],$arryindustry)) echo checked;?>>			
								</span>
							</a>
						<div class="bottom-margin-30"></div>	
					</li>
					<?php
						}
					?>
					</ul>
					<a href="#" class="validation" id="Industry">
でも業界を選択してください</a>
				</div>
			</div>		
			
			
			<div class="col-md-6 col-md-offset-3 top-margin-30"> 
				<div class="col-md-4 list-name">
					<div class="list-label">
						<label>
総席 :</label>
					</div>	
				</div>

				<div class="col-md-8 list-type">
					<ul class="type_field_btn">
						<li class="field_btn">
						<a>
							<img src="../img/list-page/group12.png" class="list-img img-responsive">
							<input name="seats" onkeyup="showcontinue(this.value);" required pattern="[0-9]{1,}" type="text" placeholder="Total Seats" class="input-medium input-Accommodates" value="<?php  echo $seminar['total_seat'];?>">
						</a>
						</li>
					</ul>
				<!--	<br><a href="#" class="validation" id="seatvalidation">Please Enter Total Seats </a>-->
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
						<a class="blue-button list-continue" id="continue" style="pointer-events: all;" onclick="checkvalid();">
持続する</a>

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

			<div class="col-md-3"> 
				<div class="row">
					<ul class="tab nav left_side left_back">
						<span>基本</span>
					  <li class="tablinks active" onclick="openCity(event, 'Pricing')"><span>
接触</span>
					  	<span id="valtrue" class="glyphicon glyphicon-ok" style="color:green; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>
						
						 <span id="valfalse" class="glyphicon glyphicon-remove" style="color:red; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>
					  
					  </li>
					  <li class="tablinks" onclick="openCity(event, 'Calendar')"><span>日</span>
					  	<span id="daytrue" class="glyphicon glyphicon-ok" style="color:green; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>
						
						 <span id="dayfalse" class="glyphicon glyphicon-remove" style="color:red; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>				  
					  </li>
					</ul>

					

					<ul class="tab nav left_side left-menu left_back">
						<span>
説明</span>
					  <li class="tablinks" onclick="openCity(event, 'Overview')"><span>
概要</span>
					  	<span id="Overviewtrue" class="glyphicon glyphicon-ok" style="color:green; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>
						
						 <span id="Overviewfalse" class="glyphicon glyphicon-remove" style="color:red; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>							  
					  </li>
					  <li class="tablinks" onclick="openCity(event, 'Photos')"><span>写真</span>
					  	<span id="Photostrue" class="glyphicon glyphicon-ok" style="color:green; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>
						
						 <span id="Photosfalse" class="glyphicon glyphicon-remove" style="color:red; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>							  
					  </li>
					</ul>



					<ul class="tab nav left_side left-menu left_back">
						<span>設定</span>
					  <li class="tablinks" onclick="openCity(event,'Amenities')"><span>ファシリティ</span>					  
					  </li>
					  <li class="tablinks" onclick="openCity(event, 'Location')"><span>
ロケーション</span>
					  	<span id="Locationtrue" class="glyphicon glyphicon-ok" style="color:green; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>
						
						 <span id="Locationfalse" class="glyphicon glyphicon-remove" style="color:red; font-size:20px; display:none; position: absolute; left: 100px;top:0px; padding:0px !important;"></span>							  
					  </li>
					 <!-- <li><a href="#" class="tablinks list-submit" onclick="openCity(event, 'Policy')">提出します</a></li>-->
					  <!--<li><a class="tablinks list-submit" onclick="openCity(event, 'Policy')">Submit</a></li>-->
					  <li style="padding-left: 14px;"><input type="submit"  class="tablinks list-submit" onclick="semivalidation()" name="subbtn" value="Submit"  style="width:100%;padding-left:0;text-align:left;background:none;border:none;"/></li>
					</ul>
				</div>
			</div>

			

			<div class="col-md-9">
				<div class="row">
					<div id="Pricing" class="tabcontent">
						<div class="col-md-12 right_side">
						<div class="clearfix"></div>
							<div class="row price-border price-margin Location-row">
								<div class="col-md-8 center">
									 <h3>
基本</h3>
									 <p>
日々の価格の賃借人は、あなたのリストを参照するデフォルトを設定します。 </p>
								</div>
								<div class="col-md-9">
									<div class="overview_title">									
										<label class="overview-label">
人のホスト名</label>
										<input name="hostname" type="text" id="hostname" placeholder="Host Person Name" class="overview-input" required value="<?php $marutra = explode('"',translate(str_replace(" ","+",$seminar['hostperson_name']))); echo $marutra[1] ;?>" >
									</div>
									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									
										<label class="overview-label">
連絡先メールアドレス</label>
										<input name="contactemail" type="email" id="contactemail" placeholder="Contact Email" class="overview-input" required value="<?php echo $seminar['contact_email'];?>">
									</div>
									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									
										<label class="overview-label">
連絡先番号</label>
										<input name="contactno" type="text" id="contactno" placeholder="Contact No" class="overview-input" required value="<?php echo $seminar['phoneno'];?>" >
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

									 <h3>日</h3>

									 <p>
日々の価格の賃借人は、あなたのリストを参照するデフォルトを設定します。 </p>

								</div>

								<div class="col-md-9">

									<div class="overview_title">									

										<label class="overview-label">日から</label>
										 <input type="text" name="fromdate" value="<?php echo date("Y-m-d",$seminardate['from_date']/1000);?>" id="txtFrom" placeholder="From Date" class="overview-input" />
										<!--<input type="date" required min="<?php echo $dt; ?>" id="semifromdate" name="fromdate" placeholder="From Date" class="overview-input" value="<?php echo date("Y-m-d",$seminardate['from_date']/1000);?>">-->
										<label class="overview-label">現在まで</label>
										<input type="text" name="todate" value="<?php echo date("Y-m-d",$seminardate['to_date']/1000);?>" id="txtTo" placeholder="To Date" class="overview-input" />
										<!--<input type="date" required min="<?php echo $dt; ?>" id="semitodate" name="todate" placeholder="To Date" class="overview-input" value="<?php 
                                         echo date("Y-m-d",$seminardate['to_date']/1000);?>">-->

									</div>
									
									<div class="bottom-margin-20"> </div>

									<div class="overview_title">									
<link href="css/bootstrap_time.css" rel="stylesheet">

									<!-- Custom styles for this template -->
 
										<link href="css/timepicki.css" rel="stylesheet">
										<label class="overview-label">時から</label>

										<input id="timepicker1" style="cursor:pointer;" class="timepicker1" type="text" name="fromtime" placeholder="Select Time" value="<?php echo date("g:i a",$seminardate['from_date']/1000);?>" />
										<label class="overview-label">
時間に</label>

										<input id="timepicker1" style="cursor:pointer;" class="timepicker1" type="text" name="totime" placeholder="Select Time" value="<?php 
                                         echo date("g:i a",$seminardate['to_date']/1000);?>"/>
                                        <!--<label class="overview-label">" 
例：午前11時または午後11時00分 "</label>-->
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

									 <h3>
概要</h3>

									 <p>
日々の価格の賃借人は、あなたのリストを参照するデフォルトを設定します。 </p>

								</div>

								<div class="col-md-9">

									<div class="overview_title">									
										<label class="overview-label">タイトル</label>
										<input type="text" required name="title" value="<?php $marutra = explode('"',translate(str_replace(" ","+",$seminar['title']))); echo $marutra[1] ;?>" id="title" placeholder="Title" class="overview-input">

									</div>

									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									

										<label class="overview-label">
キャッチフレーズ</label>

										<input type="text"  name="tagline" value="<?php $marutra = explode('"',translate(str_replace(" ","+",$seminar['tagline']))); echo $marutra[1] ;?>" id="tagline" placeholder="Tagline" class="overview-input">

									</div>

									<div class="bottom-margin-20"> </div>
									<!--<div class="overview_title">									

										<label class="overview-label">資格</label>
										<select name="qualification" class="overview-input" value="<?php/* $marutra = explode('"',translate(str_replace(" ","+",$seminar['qualification']))); echo $marutra[1] ;?>">
											
											<option <?php if($seminar['qualification']=="10th Pass") echo selected; ?>>第10回パス</option>
											<option <?php if($seminar['qualification']=="12th Pass") echo selected; ?>>第12回パス</option>
											<option <?php if($seminar['qualification']=="Graduate") echo
											selected; ?> >
卒業</option>
											<option <?php if($seminar['qualification']=="Post Graduate") echo selected; */?> >大学院</option>
										</select>
										

									</div>-->

									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									

										<label class="overview-label">説明 &nbsp;&nbsp;</label>
										<textarea  class="overview-input" name="description" placeholder="説明" rows="8" style="color:#000 !important;"><?php $marutra = explode('"',translate(str_replace(" ","+",$seminar['description']))); echo $marutra[1] ;?></textarea>	
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

										 <h3>写真または2を追加！</h3>

										 <span>
または3つ、またはそれ以上！賃借人は、あなたのスペースの特徴を強調写真と場所に行くことを好みます。</span>

												<span id="choosefileset"></span>
												<input class="add-photo choose-img" id="jsimgid0" type="file" name="semiimage[]" onchange="setimg(0, this);addimgmaru()"/>
												<input type="hidden" id="rotateniid0" value="360" name="txtrotatevalue[]">
												<br>

									<div class="bottom-margin-10">&nbsp;</div>	

								</div>

								
                                  
							   <center>
							   
							   
							  <div class="col-md-12">
								  <?php
								     $seminarpic=mysql_query("select * from seminar_photos where seminar_id='".$_REQUEST['id']."'");
					                 while($fetphoto=mysql_fetch_array($seminarpic))
					                 {
								  ?>
								  <div class="col-xs-12 col-sm-6 col-md-3 img_div">
								  <img src="../img/<?php echo $fetphoto['image']; ?>" style="transform:rotate(<?php echo $fetphoto['rotateval']; ?>deg)" class="img-height img-responsive center-block">
								  <div class="btn_div"><button class="imges-editremove" onclick="deletepic(<?php echo $fetphoto['id'];?>);">X</button></div><div class="bottom-margin-10"></div>	
								  </div>
								   <?php
									}
								   ?>
								   <div   id="show_picmain" ><div id="show_pic"></div>
								 </div>
								 </div>
								  <div class="col-md-12"><br><br></div>
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
			imgnuarr[c]=a;
            if (a.files && a.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#dppic' + id).attr('src', e.target.result);
                   $("#show_pic"+id).show();
                }
                reader.readAsDataURL(a.files[0]);
            }
			$(".disclose").show();
            
        }
        
        function addimgmaru()
        {
			$("#jsimgid"+c).hide();
            c++;
          var sdf='<div id="file_in'+c+'"><input class="add-photo choose-img" type="file"  name="semiimage[]" id="jsimgid'+c+'"  onchange="setimg('+c+',this);addimgmaru()"></div>';
          
            var setdiv = '<div id="show_pic'+c+'" class="col-md-3" style="display:none; min-height:140px;"><img class="img-height" src="" width="150" id="dppic'+c+'" onclick=facilityshow('+c+',this);><input type="hidden" id="rotateniid'+c+'" value="360" name="txtrotatevalue[]">';
            setdiv += '<br><button type="button" class="img-remove" onclick=remove('+c+',"rmv_div");> x </button></div>';
           
            
            var cc=c-1;
            $("#show_pic"+cc).after(setdiv);
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
					}
					else{
						 $("#file_in"+rmv).remove();
						   $("#show_pic"+rmv).remove();
						   
							if(c==rmv)
							{
								c=c-1;
							}
					}
			   
           }
            
        }
        
    </script>
								<div id="main0" class="col-md-12">
								  <div id="show_pic0" class="col-md-3" style="min-height:140px;">
									 <img class="img-height" src="" width="150" onclick="facilityshow(0,this);" id="dppic0">
									 <button type="button" class="upperdivche disclose images-edit" onclick='remove(0,"rmv_div");'>X</button>	
								  </div>
								</div>
									
							
							<div class="clearfix"></div>	
						</div>

						<div class="col-md-8">

							<div class="bottom-margin-20">&nbsp;</div>	

						</div>

					</div>

                 </div>

					<div id="Amenities" class="tabcontent">

					  <div class="col-md-12 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row left-side-height">

								<div class="col-md-6 center">

									 <h3>
ファシリティ</h3>

									 <p>ほとんどのホストのリストで、一般的な設備。
 </p>
								</div>
								<div class="col-md-12">
									<ul class="nav facility">
										<?php
										$array=array();
										$seminarfaci =mysql_query("select * from seminar_facility where seminar_id = '".$seminar['id']."'");
										while($fecility=mysql_fetch_array($seminarfaci))
									    {
										  array_push($array,$fecility['facility_id']);
									    }
										$selfaci=mysql_query("select * from facility where status=1");
										while($fetfaci=mysql_fetch_array($selfaci))
										{
										 ?>
											<li>
											<input type="checkbox" class="checkbox-check" name="facility[]" value="<?php echo $fetfaci['id']; ?>" <?php if(in_array($fetfaci['id'],$array)) echo checked;?>>
											<span><?php $marutra = explode('"',translate(str_replace(" ","+",$fetfaci['name']))); echo $marutra[1] ; ?></span>
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
					
					<div id="Location" class="tabcontent">
					  <div class="col-md-12 right_side">
						<div class="clearfix"></div>
							<div class="row price-border price-margin Location-row left-side-height">

								<div class="col-md-5 center">
								<div class="col-md-12">

										<ul class="nav add-pop-up">
																					
											<li>											
												<div class="overview_title">									
													<label class="overview-label" for="">
国<span style="color:red;">*</span></label>
													<select id="country" class="overview-input"  name="country" onchange="setstate(this.value);">
														<?php
															$selcountry=mysql_query("select * from countries ");
															while($fetcountry=mysql_fetch_array($selcountry))
															{
																$marutra = explode('"',translate(str_replace(" ","+",$fetcountry['name'])));
														?>
																<option <?php if($seminar['countryid']==$fetcountry['id']){echo "selected"; }?> value="<?php echo $fetcountry['id']; ?>"> <?php echo $marutra[1];?>
																</option>
														<?php
															}
														?>
													</select>
													
												</div>

											</li>

											<li>

												<div class="overview_title">	
													<label class="overview-label">
状態<span style="color:red;">*</span></label>
													<select id="allstate" class="overview-input" name="state"  onchange="setcity(this.value);" >
													<?php
															$selstate=mysql_query("select * from states where country_id='".$seminar['countryid']."'");
															while($fetstate=mysql_fetch_array($selstate))
															{
																$marutra = explode('"',translate(str_replace(" ","+",$fetstate['name'])));
														?>
															<option <?php if($seminar['stateid']==$fetstate['id'])echo "selected"; ?> value="<?php echo $fetstate['id']; ?>"><?php echo $marutra[1]; ?></option>
														<?php
															}
														?>
													</select>
												</div>

											</li>

											<li>

												<div class="overview_title">									
													<label class="overview-label">シティ<span style="color:red;">*</span></label>
													<select id="allcity" class="overview-input" name="city" onchange="">
														<?php
															$selcountry=mysql_query("select * from cities where state_id='".$seminar['stateid']."'");
															while($fetcountry=mysql_fetch_array($selcountry))
															{
																$marutra = explode('"',translate(str_replace(" ","+",$fetcountry['name'])));
														?>
																<option <?php if($seminar['cityid']==$fetcountry['id'])echo "selected"; ?> value="<?php echo $fetcountry['id']; ?>"><?php echo $marutra[1]; ?></option>
														<?php
															}
														?>
													</select>
												</div>

											</li>

											<li>

												<div class="overview_title">									
													<label class="overview-label">
住所<span style="color:red;">*</span></label>
													<input type="text" name="streetaddress" class="overview-input"
													value="<?php $marutra = explode('"',translate(str_replace(" ","+",$seminar['address']))); echo $marutra[1] ;?>" >
												</div>

											</li>

											<li>

												<div class="overview_title">									
													<label class="overview-label">郵便番号<span style="color:red;">*</span></label>
													<input type="text" id="zipcode" name="zipcode" class="overview-input" value="<?php echo $seminar['zipcode'];?>">

												</div>

											</li>

											<div class="bottom-margin-20"></div>

										</ul>

									</div>

									<!-- <h3>住所</h3>

									 <p>
あなたの正確なアドレスはプライベートのみ予約後のお客様と共有している賃借人が自分の仕事の日を計画することができるようにするために、宿泊施設の正確な通りの名前を提供するために責任があるホストconfirmed.Howeverです。</p>-->

								</div>

								<div class="col-md-7 text-center">
									

												<div class="overview_title">									
													<label class="overview-label">
ロケーション</label>

													<input type="text" id="pac-input" placeholder="
場所を入力してください。" class="overview-input" value="<?php $marutra = explode('"',translate(str_replace(" ","+",$seminar['address']))); echo $marutra[1] ;?>">
													
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
										<div class="top-margin-10">&nbsp;</div>

											<a href="#" class="text-uppercase blue-button add-button" data-toggle="modal" data-target="#myModal">
アドレスを追加</a>

										<div class="bottom-margin-10">&nbsp;</div>	

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

								  <h4 class="modal-title semibold-o">
住所を入力してください</h4>

								</div>

								<div class="modal-body">

								

									

								

								</div>

								<div class="clearfix"></div>

								<div class="modal-footer model-head">

								  <button type="button" class="blue-button f-left border-n" data-dismiss="modal">キャンセル</button>

								  <button type="button" class="blue-button f-right border-n" data-dismiss="modal">
提出します</button>
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

										 <span>

											
あなたのリストを見ることができるように、送信ボタンをクリックしてください。</a>

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
 <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<!-- jQuery Code executes on Date Format option ----->
<script src="js/script.js"></script>

</html>



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



