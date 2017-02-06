<?php     
	require_once('db.php'); 
	require_once('condition.php');  
	$micro=round(microtime(true)*1000);
	$dt=date("Y-m-d");
	if(isset($_REQUEST['subbtn']))
	{	
		$title = mysql_real_escape_string($_REQUEST['title']);	
		$tagline = mysql_real_escape_string($_REQUEST['tagline']);	
		$description = mysql_real_escape_string($_REQUEST['description']);	
		$address = mysql_real_escape_string($_REQUEST['streetaddress']);	
		$hostname = mysql_real_escape_string($_REQUEST['hostname']);	
		$inseminar=mysql_query("insert into seminar (uid,title,tagline,description,total_seat,total_booked_seat,qualification,address,typeid,countryid,stateid,cityid,zipcode,phoneno,hostperson_name,contact_email,puposeid,status,approval_status,created_date,modified_date,lat,lng) values ($_SESSION[id],'$title','$tagline','$description',$_REQUEST[seats],0,'$_REQUEST[qualification]','$address',$_REQUEST[type],$_REQUEST[country],$_REQUEST[state],$_REQUEST[city],'$_REQUEST[zipcode]','$_REQUEST[contactno]','$hostname','$_REQUEST[contactemail]',$_REQUEST[purpose],1,'pending','$micro','$micro','$_REQUEST[lat]','$_REQUEST[lng]')");
		$sid=mysql_insert_id();
		$inseminarday=mysql_query("insert into seminar_day (seminar_id,from_date,to_date,from_time,to_time) values($sid,'$_REQUEST[fromdate]','$_REQUEST[todate]','$_REQUEST[fromtime]','$_REQUEST[totime]') ");
		$countfaci=count($_REQUEST['facility']);
		for($i=0;$i<$countfaci;$i++)
		{
			$fid=$_REQUEST['facility'][$i];
			$insemifaci=mysql_query("insert into seminar_facility (seminar_id,facility_id,status) values ($sid,$fid,1)");
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
				$newname=(__DIR__)."/img/".$curname;
				$insemiimg=mysql_query("insert into seminar_photos (seminar_id,image) values ($sid,'$curname')");
				//echo "insert into seminar_photos (seminar_id,image) values ($sid,'$curname')";
				move_uploaded_file($_FILES['semiimage']['tmp_name'][$i], $newname);  
				//echo "insert into seminar (uid,title,tagline,description,total_seat,total_booked_seat,qualification,address,typeid,countryid,stateid,cityid,zipcode,phoneno,hostperson_name,contact_email,puposeid,status,created_date,modified_date) values ($_SESSION[id],'$title','$tagline','$description',$_REQUEST[seats],0,'$_REQUEST[qualification]','$address',$_REQUEST[type],$_REQUEST[country],$_REQUEST[state],$_REQUEST[city],'$_REQUEST[zipcode]','$_REQUEST[contactno]','$hostname','$_REQUEST[contactemail]',$_REQUEST[purpose],1,'$micro','$micro')";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
  <?php	require_once('head.php');   ?>
  <!-- NAVBAR================================================== -->
  <script>
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
	alert(lat);
	alert(lng);
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


</script>
  <body>
  <?php	require_once('header.php');   ?>
  <!-- pop up start -->
  <!-- Sing in modal -->
  
  <?php				
	require_once('loginsignup.php'); 	
	?>
  <!-- pop up end-->
  
<div  class="container-flude full-container">
	<div class="text-center">
	<div id="firstscreenhead" class="clearfix"><div>
			<h3 class="space">List Your Seminar</h3>
		<div class="top-margin-20"></div>		
	</div>
	</div>
</div>
<form action="" method="post" enctype="multipart/form-data" name="addseminar" role="form">
<div id="firstscreen" class="container-flude dashboard">
	<div class="container">
		<div class="list_field">
		<!--<form action="" method="post" name="addseminar">-->
			<div class="list-name">
				<div class="list-label">
					<label>Seminar Type</label>
				</div>	
			</div>

			<div class="list-type" id="nav">
				<ul class="type_field_btn">
				<?php
					$seltype=mysql_query("select * from seminar_type where status=1");
					while($fettype=mysql_fetch_array($seltype))
					{
				?>
				<li class="field_btn">
						<a href="#" onclick="changeClass(this)" >
							<img src="img/<?php echo $fettype['image']; ?>" class="list-img img-responsive">
							<span class="img-name">
							<input required type="radio" class="semitype" name="type" id="home_type10" value="<?php echo $fettype['id']; ?>">
									<?php echo $fettype['name']; ?>				
							</span>
						</a>
				</li>
				<?php
					}
				?>
				</ul>
				<a href="#" class="validation" id="typevalidation">Please Select Seminar Type</a>
			</div>

			 
			<div class="list-name">
				<div class="list-label">
					<label>Purpose</label>
				</div>	
			</div>

			<div class="list-type">
				<ul class="type_field_btn">
					<?php
					$selpurpose=mysql_query("select * from seminar_purpose where status=1");
					while($fetpurpose=mysql_fetch_array($selpurpose))
					{
					?>
					<li class="field_btn">
						<a>
							<img src="img/<?php echo $fetpurpose['image']; ?>" class="list-img img-responsive">	
							<span class="img-name">
							<input required type="radio" class="semipurpose" name="purpose" id="home_type10" value="<?php echo $fetpurpose['id']; ?>	">
									<?php echo $fetpurpose['name']; ?>			
							</span>
						</a>
					</li>
					<?php
					}
					?>
					
					
				</ul>
				<br><BR><a href="#" class="validation" id="purposevalidation">Please Select Seminar Purpose</a>
			</div>
			
			
			
			<div class="list-name">
				<div class="list-label">
					<label>Total Seats</label>
				</div>	
			</div>

			<div class="list-type">
				<ul class="type_field_btn">
					<li class="field_btn">
						<a>
							<img src="img/list-page/group12.png" class="list-img img-responsive">
							<input id="seats" name="seats" required pattern="[0-9]{1,}" type="text" placeholder="Total Seats" class="input-medium input-Accommodates" />
						</a>
					</li>
				</ul>
				<br><BR><a href="#" class="validation" id="seatvalidation">Please Enter Total Seats </a>
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
			
			
			<div class="list-name">
				<div class="list-label">
					<label>&nbsp;</label>
				</div>	
			</div>
			<div class="list-type">
				<div class="top-margin-20">&nbsp;</div>	
						<a class="blue-button" id="continue" style="pointer-events: all;" onclick="checkvalid();Pricing();">Continue</a>
						
			</div>	
		
		</div>
	</div>
</div>

<div id="secondscreen" class="container-flude full-container" style="display:none;">
<script type="text/javascript">
function Pricing() {
    document.getElementById('Pricing').style.display = "block";
	document.getElementById("Pricing").className = "tablinks active";
}
</script>

	<div class="container list-container">

		<div class="row">

			<div class="top-margin-30"></div>

		

			<div class="col-md-2"> 

				<div class="row">

					<ul class="tab nav left_side left_back">

						<span>Basic</span>

					  <li><a href="#" class="tablinks active" onclick="openCity(event, 'Pricing')">Contact</a></li>

					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Calendar')">Day</a></li>

					</ul>

					

					<ul class="tab nav left_side left-menu left_back">

						<span>Description</span>

					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Overview')">Overview</a></li>

					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Photos')">Photos</a></li>

					</ul>



					<ul class="tab nav left_side left-menu left_back">

						<span>Settings</span>

					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Amenities')">Amenities</a></li>

					 

					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Location')">Location</a></li>

					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Policy')">Submit</a></li>

					</ul>

				</div>

			</div>

			

			<div class="col-md-10">

				<div class="row">

					

					<div id="Pricing" class="tabcontent">

						<div class="col-md-7 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row">

								<div class="col-md-8 center">

									 <h3>Basic</h3>

									 <p>Set the default daily price renters will see for your listing. </p>

								</div>

								<div class="col-md-9">

									<div class="overview_title">									

										<label class="overview-label">Host Person Name</label>

										<input name="hostname" type="text"  placeholder="Host Person Name" class="overview-input" required >

									</div>

									<div class="bottom-margin-20"> </div>

									<div class="overview_title">									

										<label class="overview-label">Contact Email</label>

										<input name="contactemail" type="email" placeholder="Contact Email" class="overview-input" required>

									</div>

									<div class="bottom-margin-20"> </div>

									<div class="overview_title">									

										<label class="overview-label">Contact No</label>

										<input name="contactno" type="text" placeholder="Contact No" class="overview-input" required >

									</div>
								</div>
									<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div id="Calendar" class="tabcontent">
					  <div class="col-md-7 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row">

								<div class="col-md-8 center">

									 <h3>Day</h3>

									 <p>Set the default daily price renters will see for your listing. </p>

								</div>

								<div class="col-md-9">

									<div class="overview_title">									

										<label class="overview-label">From Date</label>

										<input type="date" required min="<?php echo $dt; ?>" id="semifromdate" name="fromdate" placeholder="From Date" class="overview-input">
										<label class="overview-label">To Date</label>

										<input type="date" required min="<?php echo $dt; ?>" id="semitodate" name="todate" placeholder="To Date" class="overview-input">

									</div>
									
									<div class="bottom-margin-20"> </div>

									<div class="overview_title">									

										<label class="overview-label">From Time</label>

										<input type="text" pattern="[0-9]{1,2}[:]{1,1}[0-9]{2,2}[ ]{0,1}[ap]{1,1}[m]{1}[ ]{0,}" required title="Ex : 11:00 am or 11:00 pm " name="fromtime" placeholder="From Time" class="overview-input">
										<label class="overview-label">To Time</label>

										<input type="text" pattern="[0-9]{1,2}[:]{1,1}[0-9]{2,2}[ ]{0,1}[ap]{1,1}[m]{1}[ ]{0,}" required title="Ex : 11:00 am or 11:00 pm " name="totime" placeholder="To Time" class="overview-input">
                                        <label class="overview-label">" Ex : 11:00 am or 11:00 pm "</label>
									</div>

									<div class="bottom-margin-20"> </div>
								</div>

								
						

							</div>

							<div class="clearfix"></div>

							

							

						</div>

					</div>



					<div id="Overview" class="tabcontent">

					  <div class="col-md-7 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row">

								<div class="col-md-8 center">

									 <h3>Overview</h3>

									 <p>Set the default daily price renters will see for your listing. </p>

								</div>

								<div class="col-md-9">

									<div class="overview_title">									
										<label class="overview-label">Title</label>
										<input type="text" required name="title" value="" placeholder="Title" class="overview-input">

									</div>

									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									

										<label class="overview-label">Tagline</label>

										<input type="text" required name="tagline" placeholder="Tagline" class="overview-input">

									</div>

									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									

										<label class="overview-label">Qualification</label>
										<select name="qualification" required class="overview-input">
											<option value="">-- Select --</option>
											<option>10th Pass</option>
											<option>12th Pass</option>
											<option>Graduate</option>
											<option>Post Graduate</option>
										</select>
										

									</div>

									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									

										<label class="overview-label">Description &nbsp;&nbsp;</label>

										<textarea required class="overview-input" name="description" placeholder="Description" rows="8" style="color:#000 !important;"></textarea>
									</div>
								</div>
									<div class="clearfix"></div>									
							</div>
							<div class="clearfix"></div>	
						</div>
						<div class="col-md-5">

							<div class="col-md-2 col-md-offset-1 full-container modal-c">

								<img src="img/bulb.jpg" class="img-responsive center-block" >

							</div>

							<div class="col-md-8 right-text full-container modal-c">

								<span class="right-text-head">A great summary</span>

								<p>

								A great summary is rich and exciting! It should cover the major features of your space and neighborhood in 250 characters or less.

								</p>								
								<p>

								<strong>Example:</strong>

								My large and comfortable office has a true startup company feeling! It suitable for 2 to 5 people and is centrally located on a quiet street, just two blocks from Washington Park. and is centrally located on the main street, just two blocks from Washington Park. Enjoy an impressive office, wireless internet, whiteboard, Coffee and easy access to all major bus station lines!  

								</p>

							</div>							

						</div>

					</div>

					

					<div id="Photos" class="tabcontent">

					  <div class="col-md-8 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row left-side-height">

								<div class="col-md-12 text-center photo-head">

										<img src="img/cam.png" class="img-responsive center-block">

										 <h3>Add a photo or two! </h3>

										 <span>Or three, or more! Renters prefer to go to places with photos that highlight the features of your space.</span>

												<input class="add-photo" type="file" name="semiimage[]" multiple />
												Add Photos

									<div class="bottom-margin-10">&nbsp;</div>	

								</div>

								<center>

									<span class="forgot">
										Note:Image size 1349px X 500px 
									</span>
								</center>
							</div>
							<div class="clearfix"></div>	
						</div>

						<div class="col-md-8">

							<div class="bottom-margin-20">&nbsp;</div>	

						</div>

					</div>



					<div id="Amenities" class="tabcontent">

					  <div class="col-md-7 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row left-side-height">

								<div class="col-md-6 center">

									 <h3>Facilities</h3>

									 <p>Common facilities at most Hosts listings. </p>
								</div>
								<div class="col-md-12">
									<ul class="nav facility">
										<?php
										$selfaci=mysql_query("select * from facility where status=1");
										while($fetfaci=mysql_fetch_array($selfaci))
										{
											?>
											<li>
											<input type="checkbox" class="checkbox-check" name="facility[]" value="<?php echo $fetfaci['id']; ?>">
											<span><?php echo $fetfaci['name']; ?></span>
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

					  <div class="col-md-7 right_side">

						<div class="clearfix"></div>

							<div class="row price-border price-margin Location-row left-side-height">

								<div class="col-md-5 center">

									 <h3>Address</h3>

									 <p>Your exact address is private and only shared with guests after a reservation is confirmed.However the host are responsible to provide the exact street name of the accommodations in order for renter to be able to plan for their work day.</p>

								</div>

								<div class="col-md-7 text-center">
									

												<div class="overview_title">									
													<label class="overview-label">Location</label>

													<input type="text" id="pac-input" placeholder="Please Enter the Location" class="overview-input">
													
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
											<script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete"
											async defer></script>
												</div>

											
									<div class="price-border">
										<div id="map" style="height:200px;width:100%;"></div>
							
										<img src="img/map-pin.png" id="pinimg" class="img-responsive map-pin">
																			
										<div class="clearfix"></div>										
										<div class="top-margin-10">&nbsp;</div>

											<a href="#" class="text-uppercase blue-button add-button" data-toggle="modal" data-target="#myModal">ADD Address</a>

										<div class="bottom-margin-10">&nbsp;</div>	

									</div>
									

								</div>

							</div>

							<div class="clearfix"></div>

							

						<!--Address Pop-up  -->

						<div class="modal fade" id="myModal" role="dialog">

							<div class="modal-dialog">

							  <!-- Modal content-->

							  <div class="modal-content modal-c">

							  

								<div class="modal-header model-head">

								  <button type="button" class="close" data-dismiss="modal">&times;</button>

								  <h4 class="modal-title semibold-o">Enter Address</h4>

								</div>

								<div class="modal-body">

								

									<div class="col-md-12">

										<ul class="nav add-pop-up">
																					
											<li>											
												<div class="overview_title">									
													<label class="overview-label" for="">Country</label>
													<select id="country" class="overview-input"  name="country" onchange="setstate(this.value);">
														 <option value="">--Select Country--</option>
														<?php
															$selcountry=mysql_query("select * from countries");
															while($fetcountry=mysql_fetch_array($selcountry))
															{
														?>
																<option <?php if($rowuserdetail['countryid']==$fetcountry['id'])echo "selected"; ?> value="<?php echo $fetcountry['id']; ?>"><?php echo $fetcountry['name']; ?></option>
														<?php
															}
														?>
													</select>
													
												</div>

											</li>

											<li>

												<div class="overview_title">	
													<label class="overview-label">State</label>
													<select id="allstate" class="overview-input" name="state"  onchange="setcity(this.value);">
														<option value="">--Select State--</option>
													</select>
												</div>

											</li>

											<li>

												<div class="overview_title">									

													<label class="overview-label">city</label>
													<select id="allcity" class="overview-input" name="city" onchange="">
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
												</div>

											</li>

											<li>

												<div class="overview_title">									

													<label class="overview-label">Street Address</label>

													<input type="text" name="streetaddress" class="overview-input">
													<input type="text" hidden name="lat" id="lat" class="overview-input">
													<input type="text" hidden name="lng" id="lng" class="overview-input">
												</div>

											</li>

											<li>

												<div class="overview_title">									
													<label class="overview-label">ZIP Code</label>
													<input type="text" name="zipcode" class="overview-input">

												</div>

											</li>

											<div class="bottom-margin-20"></div>

										</ul>

									</div>

								

								</div>

								<div class="clearfix"></div>

								<div class="modal-footer model-head">

								  <button type="button" class="blue-button f-left border-n" data-dismiss="modal">Cancel</button>

								  <button type="button" class="blue-button f-right border-n" data-dismiss="modal">Submit</button>
								</div>								
							  </div>
							  
							</div>
					    </div>						
						<!--Address Pop-up END -->
						</div>

						

						<div class="col-md-5">

							<div class="col-md-2 col-md-offset-1 full-container modal-c">

								<img src="img/bulb.jpg" class="img-responsive center-block" >

							</div>

							<div class="col-md-8 right-text full-container modal-c">

								<span class="right-text-head">Your Address is Private</span>

								<p>

								It will only be shared with guests after a reservation is confirmed.

								</p>

							</div>							

						</div>

					</div>



					<div id="Policy" class="tabcontent">

						  <div class="col-md-7 right_side left-side-height">

							<div class="clearfix"></div>

								<div class="row price-border price-margin Location-row">

									<div class="col-md-12 center policy">

										 <span>

											Please click on submit button so you can see your listing.</a>

										 </span>

									</div>

								</div>

								<div class="clearfix"></div>

								

								<div class="row price-border price-margin Location-row">

									<div class="col-md-12">
										<div class="top-margin-20"></div>
										
									<button class="blue-button" name="subbtn" type="submit">Submit</button>									
									</div>
											<div class="clearfix"></div>
										<div class="bottom-margin-20">&nbsp;</div>
									</div>

								</div> 

							</div>

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

<?php    require_once('footer.php');	?>

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
	<!-- footer -->	
<?php    require_once('footer.php');	?>
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
  </body>
</html>

<script>
function changeClass(element) {
    document.getElementById("nav").getElementsByClassName("selected")[0].className = "";
    element.className = "selected";
}
</script>
<script type="text/javascript">
var previousElement = null;
function changeClass (newElement) {
     if (previousElement != null) {
          previousElement.className = "";
     }

     newElement.className = "selected";
     previousElement = newElement;
}

// just add a call to this function on the load of the page
function onload() {
     lis = document.getElementById("nav").getElementsByTagName("a");
     for (var i=0; i<lis.length; i++) {
          if (lis[i].className == "selected")
            previousElement = lis[i];
     }
}
</script>



