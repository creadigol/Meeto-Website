<?php
session_start();

if($_REQUEST['for']=='login')
{
	?>
	<script>
	$(document).ready(function(e) {
		$("#logindiv").css("display","block");
	});
	</script>
	<?
}
?>
<script>
	$(document).ready(function(e) {
		$(".main_signup").click(function() {
			$(".bs-example-modal-sm").css("display","block");
		});
		
		$(".main_login").click(function() {
			$(".bc-example-modal-sm").css("display","block");
		});
		
		$(".main_signup_op, .main_signup_login_btn").click(function() {
			$(".bs-example-modal-sm").css("display","none");
		});
		
		$(".main_signup_op").click(function() {
			$(".ac-example-modal-sm").css("display","block");
		});
		
		$(".main_signup_login_btn").click(function() {
			$(".bc-example-modal-sm").css("display","block");
		});
		
		$(".signup_page_btn").click(function() {
			$(".bc-example-modal-sm").css("display","none");
		});
		
		$(".login_page_btn").click(function() {
			$(".ac-example-modal-sm").css("display","none");
			$(".bc-example-modal-sm").css("display","block");
		});
		
		$(".signup_page_btn").click(function() {
			$(".ac-example-modal-sm").css("display","block");
			$(".bc-example-modal-sm").css("display","none");
		});
		
		$(".modal-backdrop").click(function() {
			$(".modal").css("display","none");
			
		});
		
	});
</script>


<div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-backdrop"></div>
				  <div class="modal-dialog modal-sm" role="document" id="firstdiv">
					<div class="modal-content">						  
								<div class="social-buttons">
								<?php
									require_once __DIR__ . '/php-graph-sdk-5.0.0/src/Facebook/autoload.php';  
									$fb = new Facebook\Facebook([
									  'app_id' => '236568240079026',
									  'app_secret' => '5b21076154292bdc6b6b05428e0ff3ef',
									  'default_graph_version' => 'v2.8'
									]);

									$helper = $fb->getRedirectLoginHelper();
									$permissions = ['email', 'user_likes']; 
									$loginUrl = $helper->getLoginUrl('http://www.meeto.jp/login-callback.php', $permissions);
									
								?>
									<a href="<? echo $loginUrl;?>" class="btn btn-fb"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
									<!--<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
									<a href="#"  class="btn btn-go"><i class="fa fa-google-plus"></i>&nbsp; Google</a>
								<!--	<a href="#" class="btn btn-ln"><i class="fa fa-linkedin"></i>&nbsp; Linkedin</a> -->
									<a class="text-center center-block margin-main"><span class="text-center">OR</span></a>
									<a href="#" class="btn btn-email main_signup_op"><i class="fa fa-envelope-o"></i>&nbsp; Sign With Email</a><!-- data-toggle="modal" data-target=".ac-example-modal-sm"-->
									<hr />								
									<span>Already a member?<a href="#" class="forgot main_signup_login_btn">login</a><!-- data-toggle="modal" data-target=".bc-example-modal-sm"--></span>
								</div>							
					</div>
				  </div>
				</div>		
                
                
                
				<!-- Logi in modal -->
				<div class="modal bc-example-modal-sm" id="logindiv" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                
                	<div class="modal-backdrop"></div>
                
				  <div class="modal-dialog modal-sm" role="document" id="second">
					<div class="modal-content">					 
								<div class="social-buttons">
									<a href="<?php echo $loginUrl;?>" class="btn btn-fb"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
									<!--<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
									<a href="#" class="btn btn-go"><i class="fa fa-google-plus"></i>&nbsp; Google</a>
									<a class="text-center center-block margin-main"><span class="text-center"><b>OR</b></span></a>-->
									
									<div class="top-margin-10"></div>
									 <form action="index.php" method="post" enctype="multipart/form-data" >
										<div class="form-group">
										  <input type="email" name="user_email" class="form-control" id="usr" placeholder="Email Address" required>
										</div>
										<div class="form-group">
										  <input type="password" name="password" class="form-control" id="pwd" placeholder="Password" required>
										</div>
										
										 <span class=""><input class="check" id="remember" type="checkbox"> &nbsp; Remember Me</span>
										 
										<span class="text-right r-left">
										<a href="forget_pass.php" class="forgot">Forgot Password?</a>
										</span>
										<button type="submit" name="login" class="btn btn-lo">LOGIN</button> 
				                     </form>
									<span>Don't have an account?<a href="#" class="forgot signup_page_btn">Create Account</a><!-- data-toggle="modal" data-target=".ac-example-modal-sm"--></span>  
								</div>				
					</div>
				  </div>
				</div>
			<!-- sing with email - modal -->
				<div class="modal ac-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                
                	<div class="modal-backdrop"></div>
                    
				  <div class="modal-dialog modal-sm" role="document" id="third" >

					<div class="modal-content">
						 
								<div class="social-buttons">
									<a href="<?php echo $loginUrl;?>" class="btn btn-fb"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
									<!--<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
									<a href="#" class="btn btn-go"><i class="fa fa-google-plus"></i>&nbsp; Google</a>-->
									<a class="text-center center-block margin-main"><span class="text-center"><b>OR</b></span></a>
									
									<div class="top-margin-10"></div>
									 <form action="index.php" method="post" enctype="multipart/form-data">
										<div class="form-group">
										  <input type="text" name="user_fname" class="form-control" id="usr" placeholder="First Name" pattern=".{3,}" required title="Name should be minimum 3 character">
										</div>
										
										<div class="form-group">
										  <input type="text" name="user_lname" class="form-control" id="usr" placeholder="Last Name" required >
										</div>
										
										<div class="form-group">
										  <input type="email" name="email" class="form-control" id="usr" placeholder="Email Address" required >
										</div>
										<div class="form-group">
										  <input type="password" name="pass" class="form-control" id="pwd" placeholder="Password" pattern=".{6,}" required title="Password should be minimum 6 character">
										</div>
										 <span class=""><!--<input class="check" id="remember" type="checkbox"> &nbsp; Inform me about Latest news--></span>
										 
										 		<div class="top-margin-10"></div>	
												
										<!--<p class="">
										 By Signing up, you confirm that you accept our <a href="#" class="forgot">  Terms of Service </a> and <a href="#" class="forgot">Privacy Policy.</a>
										</p>
										
										<div class=" ">
										<span class="form-group f-left" style="width:35%;">
											<input type="text"  class="form-control" id=" " placeholder="captcha"  >
										</span> 
										
										
										<a href="#">
											<img src="img/refresh.png" style="height:12px; width:12px; margin:10px 20px;">
										</a>
										
										<span class="form-group r-left" style="width:50%;">
											<input type="text" class="form-control" id=" " placeholder="code">
										</span> 
										
										</div>-->
									 
									<button type="submit" name="signup" class="btn btn-lo">Create Account</button> 									
									  </form>
									<span>Already a member?<a href="#" class="forgot login_page_btn">Login</a><!-- data-toggle="modal" data-target=".bc-example-modal-sm"--></span>
								</div>
								
					</div>
				  </div>
				</div>
				