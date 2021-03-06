<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Woffice</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	
	<!-- font awesome -->
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">	
	
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

	<!-- price-slider -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="css/carousel.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	
  </head>
<!-- NAVBAR
================================================== -->
  <body>
    <div class="navbar-wrapper menu nevbar-position">
      <div class="container header-container">
        <nav class="navbar navbar-inverse navbar-static-top toggal-back menu-h">
          <div class="container">
            <div class="navbar-header">
				<div class="left">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand menu-h navbar-logo" href="#">Your LOGO</a>
				</div>
				
				<div class="nav-input-box">
				<input type="text" class="nav-input" placeholder="Pick Your Workspace." />
				</div>
				<div class="browse menu-h">Browse<span class="caret"></span></div>	
																																				
            </div>
			
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav text-center font-menu">
                <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm">Sign Up</a></li>
                <li><a href="#" data-toggle="modal" data-target=".bc-example-modal-sm">Login</a></li>
                <li><a href="how-work.html">How It Works</a></li>
                <li><a href="list_space.html" class="blue-button"> List Your Space</a></li>
				
              </ul>
			  
            </div>
          </div>
        </nav>

      </div>
    </div> 
	

<!-- pop up start -->


			<!-- Sing in modal -->
				<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				  <div class="modal-dialog modal-sm" role="document">

					<div class="modal-content">
						  
								<div class="social-buttons">
									<a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
									<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
									<a href="#"  class="btn btn-go"><i class="fa fa-google-plus"></i>&nbsp; Google</a>
								<!--	<a href="#" class="btn btn-ln"><i class="fa fa-linkedin"></i>&nbsp; Linkedin</a> -->
									<a class="text-center center-block margin-main"><span class="text-center">OR</span></a>
									<a href="#" data-toggle="modal" data-target=".ac-example-modal-sm" class="btn btn-email"><i class="fa fa-envelope-o"></i>&nbsp; Sign With Email</a>
									<hr />
									
									<span>Already a member?<a href="#" data-toggle="modal" data-target=".bc-example-modal-sm" class="forgot">login</a></span>
								</div>
								
					</div>
				  </div>
				</div>
				
				
				<!-- Logi in modal -->
				<div class="modal fade bc-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				  <div class="modal-dialog modal-sm" role="document">

					<div class="modal-content">
						 
								<div class="social-buttons">
									<a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
									<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
									<a href="#" class="btn btn-go"><i class="fa fa-google-plus"></i>&nbsp; Google</a>
									<a class="text-center center-block margin-main"><span class="text-center"><b>OR</b></span></a>
									
									<div class="top-margin-10"></div>
									 <form>
										<div class="form-group">
										  <input type="text" class="form-control" id="usr" placeholder="Email Address">
										</div>
										<div class="form-group">
										  <input type="password" class="form-control" id="pwd" placeholder="Password">
										</div>
										
										 <span class=""><input class="check" id="remember" type="checkbox"> &nbsp; Remember Me</span>
										 
										<span class="text-right r-left">
										<a href="#" class="forgot">Forgot Password?</a>
										</span>
										
									  </form>
									  
									<a href="#" class="btn btn-lo">LOGIN</a> 
									<span>Don't have an account?<a href="#" data-toggle="modal" data-target=".ac-example-modal-sm"  class="forgot">Create Account</a></span>
									  
								</div>
								
					</div>
				  </div>
				</div>
				
				
				
				
				
				
			<!-- sing with email - modal -->
				<div class="modal fade ac-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				  <div class="modal-dialog modal-sm" role="document">

					<div class="modal-content">
						 
								<div class="social-buttons">
									<a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
									<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
									<a href="#" class="btn btn-go"><i class="fa fa-google-plus"></i>&nbsp; Google</a>
									<a class="text-center center-block margin-main"><span class="text-center"><b>OR</b></span></a>
									
									<div class="top-margin-10"></div>
									 <form>
										<div class="form-group">
										  <input type="text" class="form-control" id="usr" placeholder="First Name">
										</div>
										
										<div class="form-group">
										  <input type="text" class="form-control" id="usr" placeholder="Last Name">
										</div>
										
										<div class="form-group">
										  <input type="text" class="form-control" id="usr" placeholder="Email Address">
										</div>
										<div class="form-group">
										  <input type="password" class="form-control" id="pwd" placeholder="Password">
										</div>
										
										<div class="form-group">
										  <input type="password" class="form-control" id="pwd" placeholder="confirm Password">
										</div>
										
										 <span class=""><input class="check" id="remember" type="checkbox"> &nbsp; Inform me about Latest news</span>
										 
										 		<div class="top-margin-10"></div>	
												
										<p class="">
										 By Signing up, you confirm that you accept our <a href="#" class="forgot">  Terms of Service </a> and <a href="#" class="forgot">Privacy Policy.</a>
										</p>
										
										<div class=" ">
										<span class="form-group f-left" style="width:35%;">
											<input type="text" class="form-control" id=" " placeholder="captcha">
										</span> 
										
										
										<a href="#">
											<img src="img/refresh.png" style="height:12px; width:12px; margin:10px 20px;">
										</a>
										
										<span class="form-group r-left" style="width:50%;">
											<input type="text" class="form-control" id=" " placeholder="code">
										</span> 
										
										</div>
									  </form>
									  
									<a href="#" class="btn btn-lo">Create Account</a> 
									<span>Already a member?<a href="#" class="forgot">Login</a></span>
									  
								</div>
								
					</div>
				  </div>
				</div>
					

 <!-- pop up end-->
 
 
 
 
 
 
 
 
	
 
 <!-- slide -->
	<div class="container-flude slide-border full-container">
	
		<div class="slide f-left">
			<ul>
				<li class="li-padding border-li">
					<h6>Dates</h6>
					<div class="group-control r-left margin-r">
						<input type="text" placeholder="Check in" value="" id=" " name="checkin" class=" ">
						<input type="text" placeholder="Check Out" id=" " value="" name="checkout" onchange=" " class=" ">
						
						<select class="input-medium" name="time_in">
							<option value="">Time In</option>
							<option value="0:00:00">0:00:00</option>
							<option value="1:00:00">1:00:00</option>
							<option value="2:00:00">2:00:00</option>
							<option value="3:00:00">3:00:00</option>
							<option value="4:00:00">4:00:00</option>
							<option value="5:00:00">5:00:00</option>
							<option value="6:00:00">6:00:00</option>
							<option value="7:00:00">7:00:00</option>
							<option value="8:00:00">8:00:00</option>
							<option value="9:00:00">9:00:00</option>
							<option value="10:00:00">10:00:00</option>
							<option value="11:00:00">11:00:00</option>
							<option value="12:00:00">12:00:00</option>
							<option value="13:00:00">13:00:00</option>
							<option value="14:00:00">14:00:00</option>
							<option value="15:00:00">15:00:00</option>
							<option value="16:00:00">16:00:00</option>
							<option value="17:00:00">17:00:00</option>
							<option value="18:00:00">18:00:00</option>
							<option value="19:00:00">19:00:00</option>
							<option value="20:00:00">20:00:00</option>
							<option value="21:00:00">21:00:00</option>
							<option value="22:00:00">22:00:00</option>
							<option value="23:00:00">23:00:00</option>			
					    </select>
						
						<select class="input-medium" name="time_Out">
							<option value="">Time Out</option>
							<option value="0:00:00">0:00:00</option>
							<option value="1:00:00">1:00:00</option>
							<option value="2:00:00">2:00:00</option>
							<option value="3:00:00">3:00:00</option>
							<option value="4:00:00">4:00:00</option>
							<option value="5:00:00">5:00:00</option>
							<option value="6:00:00">6:00:00</option>
							<option value="7:00:00">7:00:00</option>
							<option value="8:00:00">8:00:00</option>
							<option value="9:00:00">9:00:00</option>
							<option value="10:00:00">10:00:00</option>
							<option value="11:00:00">11:00:00</option>
							<option value="12:00:00">12:00:00</option>
							<option value="13:00:00">13:00:00</option>
							<option value="14:00:00">14:00:00</option>
							<option value="15:00:00">15:00:00</option>
							<option value="16:00:00">16:00:00</option>
							<option value="17:00:00">17:00:00</option>
							<option value="18:00:00">18:00:00</option>
							<option value="19:00:00">19:00:00</option>
							<option value="20:00:00">20:00:00</option>
							<option value="21:00:00">21:00:00</option>
							<option value="22:00:00">22:00:00</option>
							<option value="23:00:00">23:00:00</option>			
					    </select>
						
						<select class="input-medium" name="guests" id=" " >
							<option value="">Renters</option>
							<option value="1">1 Renters</option>
							<option value="2">2 Renters</option>
							<option value="3">3 Renters</option>
							<option value="4">4 Renters</option>
							<option value="5">5 Renters</option>
							<option value="6">6 Renters</option>
							<option value="7">7 Renters</option>
							<option value="8">8 Renters</option>
							<option value="9">9 Renters</option>
							<option value="10-14">10-14 Renters</option>
							<option value="15-19">15-19 Renters</option>
							<option value="20-29">20-29 Renters</option>
							<option value="30-49">30-49 Renters</option>
							<option value="50-74">50-74 Renters</option>
							<option value="75-99">75-99 Renters</option>
							<option value="100+">100+ Renters</option>
						</select>
					</div>
					<div class="bottom-margin-20">&nbsp;</div>	
				</li>
				
				<li class="li-padding border-li">
					<span class="f-left">
					<h6>Purpose</h6>
					</span>
					
					
					<span class="l-left">
						<label>
							<input type="checkbox" class="room_type" value="Dr &amp; Therapists" />
								<span class="check">Dr &amp; Therapists</span>
						</label>
						<label>
							<input type="checkbox" class="room_type" value="General"  />
							<span class="check">General</span>
						</label>
						<label>
							<input type="checkbox" class="room_type" value="Lawyers" />
							<span class="check">Lawyers</span>
						</label>
					</span>
				</li>
				
				<li class="li-padding border-li text-center">
					<span class="price-r f-left">Price range</span>
					<span id="price-slider">
					  <p>
						
						<input type="text" id="amount-min" readonly style="border:0; color:#000000; font-weight:normal;">
						<input type="text" id="amount-max" readonly style="border:0; color:#000000; font-weight:normal;">
					  </p>

					  <div id="slider-range"></div>

					</span>
				</li>
				
				<li class="li-padding border-li text-center">
					<a class="blue-button"> More Filters </a>
				</li>
				
				
				<div class="li-padding border-li text-center border-n">
					<nav aria-label="Page navigation">
					  <ul class="pagination pag-nation">
						<li>
						  <a href="#" aria-label="Previous"  class="pagination-botton">
							<span aria-hidden="true">Previous &nbsp; <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></span>
						  </a>
						</li>
						<li class="active"><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li>
						  <a href="#" aria-label="Next"  class="pagination-botton">
							<span aria-hidden="true"> Next &nbsp; <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
						  </a>
						</li>
					  </ul>
					</nav>
				</div>
			</ul>
			
						
			<div class="row center-block">
				<div class="col-mg-6 col-sm-6 col-xs-12 f-left office-img-text box-height">
					<img src="img/london/home-3.jpg" class="img-responsive center-block img-width" />
					
						<a href="#"><button class="blue-button border-n blue book-button bule-smaal">BOOK</button></a>
						
						<img src="img/london/small-img-3.jpg" class="img-responsive small-img"/>
						
						<i class="fa fa-star-o star" aria-hidden="true"></i> 
						
						<div class="top-margin-10"></div>
						<span>Impressive meeting Room for 12 people</span>
						<p>Meeting Room- Tel- Aviv</p>
						
						<div class="bottom-margin-20">&nbsp;</div>
				</div>
				
				<div class="col-mg-6 col-sm-6 col-xs-12 f-left office-img-text box-height">
					<img src="img/london/home-4.jpg" class="img-responsive center-block img-width" />
					
						<a href="#"><button class="blue-button border-n blue book-button bule-smaal">BOOK</button></a>
						
						<img src="img/london/small-img-4.jpg" class="img-responsive small-img"/>
						
						<i class="fa fa-star-o star" aria-hidden="true"></i> 
						
						<div class="top-margin-10"></div>
						<span>Meeting room for 12 ppl (אלפא קטן)</span>
						<p>Meeting Room- Tel Aviv-Yafo</p>
						
						<div class="bottom-margin-20">&nbsp;</div>
				</div>
				
			</div>
			
			<div class="row center-block">
				<div class="col-mg-6 col-sm-6 col-xs-12 f-left office-img-text box-height">
					<img src="img/london/home-9.jpg" class="img-responsive center-block bule-smaal img-width" />
					
						<a href="#"><button class="blue-button border-n blue book-button">BOOK</button></a>
						
						<img src="img/london/small-img-2.jpg" class="img-responsive small-img"/>
						
						<i class="fa fa-star-o star" aria-hidden="true"></i> 
						
						<div class="top-margin-10"></div>
						<span>An amazing office for 4 ppl (n 5/19/23/25)</span>
						<p>Private Office- Tel Aviv-Yafo</p>
						
						<div class="bottom-margin-20">&nbsp;</div>
				</div>
				
				<div class="col-mg-6 col-sm-6 col-xs-12 f-left office-img-text box-height">
					<img src="img/london/home-10.jpg" class="img-responsive center-block bule-smaal img-width" />
					
						<a href="#"><button class="blue-button border-n blue book-button">BOOK</button></a>
						
						<img src="img/london/small-img-2.jpg" class="img-responsive small-img"/>
						
						<i class="fa fa-star-o star" aria-hidden="true"></i> 
						
						<div class="top-margin-10"></div>
						<span>New office for 5 ppl (n 4/20/27/28/29/30)</span>
						<p>Private Office- Tel Aviv-Yafo</p>
						
						<div class="bottom-margin-20">&nbsp;</div>
				</div>
				
			</div>
			
			
			<div class="row center-block">
				<div class="col-mg-6 col-sm-6 col-xs-12 f-left office-img-text box-height">
					<img src="img/london/home-5.jpg" class="img-responsive center-block img-width" />
					
						<a href="#"><button class="blue-button border-n blue book-button bule-smaal">BOOK</button></a>
						
						<img src="img/london/small-img-1.jpg" class="img-responsive small-img"/>
						
						<i class="fa fa-star-o star" aria-hidden="true"></i> 
						
						<div class="top-margin-10"></div>
						<span>Big Office - Electra City Tower</span>
						<p>Private Office- Tel Aviv-Yafo</p>
						
						<div class="bottom-margin-20">&nbsp;</div>
				</div>
				
				<div class="col-mg-6 col-sm-6 col-xs-12 f-left office-img-text box-height">
					<img src="img/london/home-6.jpg" class="img-responsive center-block img-width" />
					
						<a href="#"><button class="blue-button border-n blue book-button bule-smaal">BOOK</button></a>
						
						<img src="img/london/small-img-2.jpg" class="img-responsive small-img"/>
						
						<i class="fa fa-star-o star" aria-hidden="true"></i> 
						
						<div class="top-margin-10"></div>
						<span>Conference room at Kiryat-Atidim (forum 8)</span>
						<p>Classroom & Conferences- Holon</p>
						
						<div class="bottom-margin-20">&nbsp;</div>
				</div>
				
			</div>
			
			
			<div class="row center-block">
				<div class="col-mg-6 col-sm-6 col-xs-12 f-left office-img-text box-height">
					<img src="img/london/home-7.jpg" class="img-responsive center-block img-width" />
					
						<a href="#"><button class="blue-button border-n blue book-button bule-smaal">BOOK</button></a>
						
						<img src="img/london/small-img-3.jpg" class="img-responsive small-img"/>
						
						<i class="fa fa-star-o star" aria-hidden="true"></i> 
						
						<div class="top-margin-10"></div>
						<span>Big meeting room for 18 ppl (אלפא גדול)</span>
						<p>Meeting Room- Tel Aviv-Yafo</p>
						
						<div class="bottom-margin-20">&nbsp;</div>
				</div>
				
				<div class="col-mg-6 col-sm-6 col-xs-12 f-left office-img-text box-height">
					<img src="img/london/home-8.jpg" class="img-responsive center-block bule-smaal img-width" />
					
						<a href="#"><button class="blue-button border-n blue book-button">BOOK</button></a>
						
						<img src="img/london/small-img-2.jpg" class="img-responsive small-img"/>
						
						<i class="fa fa-star-o star" aria-hidden="true"></i> 
						
						<div class="top-margin-10"></div>
						<span>Manager Office</span>
						<p>Private Office- Herzliya</p>
						
						<div class="bottom-margin-20">&nbsp;</div>
				</div>
				
			</div>
			
			
			
			<div class="row center-block">
				<div class="col-mg-6 col-sm-6 col-xs-12 f-left office-img-text box-height">
					<img src="img/london/home-1.jpg" class="img-responsive center-block img-width" />
					
						<a href="#"><button class="blue-button border-n blue book-button bule-smaal">BOOK</button></a>
						
						<img src="img/london/small-img-1.jpg" class="img-responsive small-img"/>
						
						<i class="fa fa-star-o star" aria-hidden="true"></i> 
						
						<div class="top-margin-10"></div>
						<span>Big Office - Electra City Tower</span>
						<p>Private Office- Tel Aviv-Yafo</p>
						
						<div class="bottom-margin-20">&nbsp;</div>
				</div>
				
				<div class="col-mg-6 col-sm-6 col-xs-12 f-left office-img-text box-height">
					<img src="img/london/home-2.jpg" class="img-responsive center-block img-width" />
					
						<a href="#"><button class="blue-button border-n blue book-button bule-smaal">BOOK</button></a>
						
						<img src="img/london/small-img-2.jpg" class="img-responsive small-img"/>
						
						<i class="fa fa-star-o star" aria-hidden="true"></i> 
						
						<div class="top-margin-10"></div>
						<span>Sea View meeting room for 4 people</span>
						<p>Meeting Room- Tel- Aviv</p>
						
						<div class="bottom-margin-20">&nbsp;</div>
				</div>
				
			</div>
			
			<div class="li-padding border-li text-center border-n">
					<nav aria-label="Page navigation">
					  <ul class="pagination pag-nation">
						<li>
						  <a href="#" aria-label="Previous"  class="pagination-botton">
							<span aria-hidden="true">Previous &nbsp; <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></span>
						  </a>
						</li>
						<li class="active"><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li>
						  <a href="#" aria-label="Next"  class="pagination-botton">
							<span aria-hidden="true"> Next &nbsp; <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
						  </a>
						</li>
					  </ul>
					</nav>
			</div>

		</div>
		
		
		<div class="map f-left">
			
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255281.1156505529!2d103.7069304654426!3d1.3150700353272982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da11238a8b9375%3A0x887869cf52abf5c4!2sSingapore!5e0!3m2!1sen!2sin!4v1472462671739" width="100%" height="100%" frameborder="0" style="position:fixed;" style="border:0" allowfullscreen></iframe>
		</diV>
		
	</div>
 
 <!-- slide END -->
	


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
	
	<!-- price-slider -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 
      <script type="text/javascript" src="price_range.js"></script>
	  <script src="js/index.js"></script>
	  <script>
				$(function() {
			$( "#slider-range" ).slider({
			  range: true,
			  min: 0,
			  max: 1000,
			  values: [ 0, 450 ],
			  animate:true,
			  step:5,
			  slide: function( event, ui ) {
				$( "#amount-min" ).val( "min : " + ui.values[ 0 ] + "$");
				$( "#amount-max" ).val( "max : " + ui.values[ 1 ] + "$");
			  }
			});

			$( "#amount-min" ).val("min : " + $( "#slider-range" ).slider( "values", 0 ) + "$");
			$( "#amount-max" ).val( "max : " + $( "#slider-range" ).slider( "values", 1 ) + "$");
		  });
	  </script>
	
	
  </body>
</html>


    
