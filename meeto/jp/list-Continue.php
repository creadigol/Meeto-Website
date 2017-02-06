<?php     require_once('db.php'); ?>
<!DOCTYPE html>
<html lang="en"> 
 <?php	require_once('head.php');   ?>
 <!-- NAVBAR================================================== -->  
 <body> 
 <?php	require_once('header.php');   ?>
 <!-- pop up start -->	
 <!-- Sing in modal -->		
 <?php					
 require_once('loginsignup.php'); 				?>
 <!-- pop up end-->


<div class="container-flude full-container">
	<div class="container list-container">
		<div class="row">
			<div class="top-margin-30"></div>
		
			<div class="col-md-2">
				<div class="row">
					<ul class="tab nav left_side left_back">
						<span>Basic</span>
					  <li><a href="#" class="tablinks active" onclick="openCity(event, 'Pricing')">Pricing</a></li>
					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Calendar')">Calendar</a></li>
					</ul>
					
					<ul class="tab nav left_side left-menu left_back">
						<span>Description</span>
					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Overview')">Overview</a></li>
					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Photos')">Photos</a></li>
					</ul>

					<ul class="tab nav left_side left-menu left_back">
						<span>Settings</span>
					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Amenities')">Amenities</a></li>
					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Listing')">Listing</a></li>
					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Location')">Location</a></li>
					  <li><a href="#" class="tablinks" onclick="openCity(event, 'Policy')">Cancellation Policy</a></li>
					</ul>
				</div>
			</div>
			
			<div class="col-md-10">
				<div class="row">
					
					<div id="Pricing" class="tabcontent">
						<div class="col-md-7 right_side">
						<div class="clearfix"></div>
							<div class="row price-border price-margin Location-row">
								<div class="col-md-6 center">
									 <h3>Base Price</h3>
									 <p>Set the default daily price renters will see for your listing. </p>
								</div>
								<div class="col-md-6">
								<div class="row">
									<div class="top-margin-20"></div>
										<label class="price-month margin-main">Per Month</label>
										<div class="amoutnt-container">
											<span class="WebRupee">$</span>
											<input type="text" class="per_amount" >
										</div>

										<label class="price-month margin-main">Per Day</label>
										<div class="amoutnt-container">
											<span class="WebRupee">$</span>
											<input type="text" class="per_amount" >
										</div>

										<label class="price-month margin-main">Per Hour</label>
										<div class="amoutnt-container">
											<span class="WebRupee">$</span>
											<input type="text" class="per_amount" >
										</div>
										
										<label class="price-month">Currency</label>
										<div class="amoutnt-container">
											<select class="currency">
													<option value="USD" selected="selected">USD</option>
													<option value="GBP">GBP</option>
													<option value="ILS">ILS</option>
													<option value="EUR">EUR</option>						
											  </select>
											  
											  
										</div>
										<div class="clearfix"></div>
									<div class="bottom-margin-20">&nbsp;</div>
								
								</div>
								</div>
							</div>
							<div class="clearfix"></div>
							
							<!-- <div class="row price-margin">
								<div class="col-md-12 text-center">
								<div class="top-margin-20"></div>
											Want to offer a discount for longer stays? 
												<span class="onclick-text" data-target="price-margin" onclick="openCity(event, 'price-month')"> 
												You can also set weekly and monthly prices. 
												</span>
								<div class="bottom-margin-20">&nbsp;</div>	
								</div>
							</div> -->
							
							<div id="price-month" class="row price-border price-margin" style="display:block;">
								<div class="col-md-5 col-md-offset-1 center">
									 <h3>Long-Term Prices</h3>
									 <p>Set the default daily price renters will see for your listing.</p>
								</div>
								<div class="col-md-6">
								<div class="row">
									<div class="top-margin-20"></div>

										<label class="price-month margin-main">Per Week</label>
										<div class="amoutnt-container">
											<span class="WebRupee">$</span>
											<input type="text" class="per_amount" >
										</div>
										
										<label class="price-month margin-main">Per Month</label>
										<div class="amoutnt-container">
											<span class="WebRupee">$</span>
											<input type="text" class="per_amount" >
										</div>


										<div class="clearfix"></div>
									<div class="bottom-margin-20">&nbsp;</div>
							
								</div>
								</div>
							</div> 
						</div>
						
						<div class="col-md-5">
							<div class="col-md-2 col-md-offset-1 full-container modal-c">
								<img src="img/bulb.jpg" class="img-responsive center-block" >
							</div>
							<div class="col-md-8 right-text full-container modal-c">
								<span class="right-text-head">Setting a price</span>
								<p>
								For new listings with no reviews, its important to set a competitive price. Once you get your first booking and review, you can raise your price!
								</p>
								
								<p>
									<b>The suggested daily price tip is based on:</b>
								</p>
								<div class="right-text-in">
									<p>Seasonal travel demand in your area.</p>
									<p>The median daily price of recent bookings in your city.</p>
									<p>The details of your listing.</p>
								</div>
							</div>							
						</div>
					</div>

					<div id="Calendar" class="tabcontent">
					  <h3>Calendar</h3>
					  
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
										<input type="text" value="" placeholder="Title" class="overview-input">
									</div>
									<div class="bottom-margin-20"> </div>
									<div class="overview_title">									
										<label class="overview-label">Summary &nbsp;&nbsp;<small> Maximum 150 words</small></label>
										<textarea class="overview-input" placeholder="Maximum 150 words" rows="8" style="color:#000 !important;"></textarea>
									</div>
								</div>
								
									<div class="clearfix"></div>
								<div class="col-md-12 text-center overview-text">	
									<div class="bottom-margin-10"> </div>
									<p>Want to write even more? You can also<a href="#" class="onclick-text"> add a detailed description </a>to your listing</p>
								</div>								
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
										
										<div class="add-photo">
											<a href="#">
												Add Photos
											</a>
										</div>
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
										<li>
											<input type="checkbox" class="checkbox-check"  >
											<span>Wi-Fi</span>
										</li>
										<li>
											<input type="checkbox" class="checkbox-check" >
											<span>Whiteboard</span>
										</li>
										<li>
											<input type="checkbox" class="checkbox-check" >
											<span>LCD/Projector</span>
										</li>
										<li>
											<input type="checkbox" class="checkbox-check" >
											<span>Coffee/Tea</span>
										</li>
										<li>
											<input type="checkbox" class="checkbox-check" >
											<span>Printer</span>
										</li>
										<li>
											<input type="checkbox" class="checkbox-check" >
											<span>Scanner</span>
										</li>
										<li>
											<input type="checkbox" class="checkbox-check"  >
											<span>Copy Machine</span>
										</li>
										<li>
											<input type="checkbox" class="checkbox-check" >
											<span>Air Conditioner</span>
										</li>
										<li>
											<input type="checkbox" class="checkbox-check" >
											<span>Public Parking</span>
										</li>
										<li>
											<input type="checkbox" class="checkbox-check" >
											<span>Private Parking</span>
										</li>
										<li>
											<input type="checkbox" class="checkbox-check" >
											<span>Receptionist</span>
										</li>
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>	
						</div>
						<div class="col-md-8">
							<div class="bottom-margin-20">&nbsp;</div>	
						</div>
					</div>

					<div id="Listing" class="tabcontent">
					  <div class="col-md-7 right_side">
						<div class="clearfix"></div>
							<div class="row price-border price-margin Location-row left-side-height">
								<div class="col-md-5 center">
									 <h3>Listing Info</h3>
									 
								</div>
								<div class="col-md-7">
								<div class="row">
									<div class="top-margin-20"></div>
										<label class="price-month margin-main">Per Month</label>
											<select class="selectd">		  
											  <option>Private Office</option>
											  <option>Meeting Room</option>
											  <option>Open Space</option>	
											  <option>Classroom &amp; Conferences</option>
											  <option>Clinics</option>
											</select>
											
											
										<label class="price-month margin-main">Per Month</label>
											<select class="selectd">		  
												<option selected="selected">General</option>
												<option>Lawyers</option>
												<option>Dr &amp; Therapists</option>
											</select>											
										 

										<div class="clearfix"></div>
									<div class="bottom-margin-20">&nbsp;</div>
								
								</div>
								</div>
							</div>
							<div class="clearfix"></div>
							
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
									<div class="price-border">
										<img src="img/add-img.jpg" class="img-responsive center-block">
										
										<img src="img/map-pin.png" class="img-responsive map-pin">
										
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
							  <form>
								<div class="modal-header model-head">
								  <button type="button" class="close" data-dismiss="modal">&times;</button>
								  <h4 class="modal-title semibold-o">Enter Address</h4>
								</div>
								<div class="modal-body">
								
									<div class="col-md-12">
										<ul class="nav add-pop-up">
											<li>
												<div class="overview_title">									
													<label class="overview-label">Location</label>
													<input type="text" value="" placeholder="Please Enter the Location" class="overview-input">
												</div>
											</li>
											<li>
											
												<div class="overview_title">									
													<label class="overview-label">Country</label>
													<input type="text" value="" placeholder="Please Enter the County" class="overview-input">
												</div>
											</li>
											<li>
												<div class="overview_title">									
													<label class="overview-label">State</label>
													<input type="text" value="" placeholder="Please Enter the State" class="overview-input">
												</div>
											</li>
											<li>
												<div class="overview_title">									
													<label class="overview-label">city</label>
													<input type="text" value="" placeholder="Please Enter the City" class="overview-input">
												</div>
											</li>
											<li>
												<div class="overview_title">									
													<label class="overview-label">Street Address</label>
													<input type="text" value=""  class="overview-input">
												</div>
											</li>
											<li>
												<div class="overview_title">									
													<label class="overview-label">ZIP Code</label>
													<input type="text" value="" class="overview-input">
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
								</form>	
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
											Please select your cancellation policy. You can read more about the cancellation policy  <a href="#">here.</a>
										 </span>
									</div>
								</div>
								<div class="clearfix"></div>
								
								<div class="row price-border price-margin Location-row">
									<div class="col-md-12">
									
										<div class="top-margin-20"></div>

											<label class="price-month margin-main policy-label">Cancellation Policy</label>
											<select class="policy-select">
												<option value="">Select</option>
												<option value="Flexible">Flexible</option>
												<option value="Moderate">Moderate</option>
												<option value="Strict">Strict</option>
											</select>
											
										<div class="clearfix"></div>
										<div class="top-margin-20"></div>
										
											<label class="price-month margin-main policy-label">Security Deposit
											<span class="r-left">$&nbsp;</span>
											</label>
												<input type="text" class="policy-select" >
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

<div class="top-margin-30">&nbsp;</div>
 
 
 
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