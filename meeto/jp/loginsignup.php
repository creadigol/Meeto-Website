<?php 
session_start();
?>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				  <div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">						  
								<div class="social-buttons">
								<?php
									require_once __DIR__ . '/php-graph-sdk-5.0.0/src/Facebook/autoload.php';  
									$fb = new Facebook\Facebook([
									  'app_id' => '2125321327693933',
									  'app_secret' => 'fea1f1a69271f266d646a8abac0d5825',
									  'default_graph_version' => 'v2.5',
									  'persistent_data_handler' => 'session'
									]);

									$helper = $fb->getRedirectLoginHelper();
									$permissions = ['email', 'user_likes']; 
									$loginUrl = $helper->getLoginUrl('http://www.creadigol.biz/meeto/jp/login-callback.php', $permissions);
							
								?>
									<a href="<? echo $loginUrl;?>" class="btn btn-fb"><i class="fa fa-facebook"></i>&nbsp; 
フェイスブック</a>
									
								<!--	<a href="#" class="btn btn-ln"><i class="fa fa-linkedin"></i>&nbsp; Linkedin</a> -->
									<a class="text-center center-block margin-main"><span class="text-center">OR</span></a>
									<a href="#" data-toggle="modal" data-target=".ac-example-modal-sm" class="btn btn-email"><i class="fa fa-envelope-o"></i>&nbsp; 
メールでサイン</a>
									<hr />								
									<span>
既にメンバー？<a href="#" data-toggle="modal" data-target=".bc-example-modal-sm" class="forgot">ログイン</a></span>
								</div>							
					</div>
				  </div>
				</div>			
				<!-- Logi in modal -->
				<div class="modal fade bc-example-modal-sm" id="logindiv" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				  <div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">					 
								<div class="social-buttons">
									<a href="<?php echo $loginUrl;?>" class="btn btn-fb"><i class="fa fa-facebook"></i>&nbsp; 
フェイスブック</a>
									<!--<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i>&nbsp; 
ツイッター</a>
									<a href="#" class="btn btn-go"><i class="fa fa-google-plus"></i>&nbsp; グーグル</a>
									<a class="text-center center-block margin-main"><span class="text-center"><b>OR</b></span></a>-->
									
									<div class="top-margin-10"></div>
									 <form action="index.php" method="post" enctype="multipart/form-data" >
										<div class="form-group">
										  <input type="email" name="user_email" class="form-control" id="usr" placeholder="
電子メールアドレス" required>
										</div>
										<div class="form-group">
										  <input type="password" name="password" class="form-control" id="pwd" placeholder="パスワード" required>
										</div>
										
										 <span class=""><input class="check" id="remember" type="checkbox"> &nbsp;
私を覚えてますか</span>
										 
										<span class="text-right r-left">
										<a href="forget_pass.php" class="forgot">
パスワードをお忘れですか ？</a>
										</span> 										<button type="submit" name="login" class="btn btn-lo">
ログイン</button> 
				                     </form>
									<span>
アカウントを持っていないのですか？<a href="#" data-toggle="modal" data-target=".ac-example-modal-sm"  class="forgot">アカウントを作成する</a></span>  
								</div>				
					</div>
				  </div>
				</div>
			<!-- sing with email - modal -->
				<div class="modal fade ac-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				  <div class="modal-dialog modal-sm" role="document">

					<div class="modal-content">
						 
								<div class="social-buttons">
									<a href="<?php echo $loginUrl;?>" class="btn btn-fb"><i class="fa fa-facebook"></i>&nbsp; 
フェイスブック</a>

									<!--<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i>&nbsp; ツイッター</a>
									<a href="#" class="btn btn-go"><i class="fa fa-google-plus"></i>&nbsp; 
グーグル</a>-->
									<a class="text-center center-block margin-main"><span class="text-center"><b>OR</b></span></a>
									
									<div class="top-margin-10"></div>
									 <form action="index.php" method="post" enctype="multipart/form-data">
										<div class="form-group">
										  <input type="text" name="user_fname" class="form-control" id="usr" placeholder="
ファーストネーム" pattern=".{3,}" required title="名前は最小3文字でなければなりません">
										</div>
										
										<div class="form-group">
										  <input type="text" name="user_lname" class="form-control" id="usr" placeholder="
苗字" required >
										</div>
										
										<div class="form-group">
										  <input type="email" name="email" class="form-control" id="usr" placeholder="
電子メールアドレス" required >
										</div>
										<div class="form-group">
										  <input type="password" name="pass" class="form-control" id="pwd" placeholder="パスワード" pattern=".{6,}" required title="
パスワードは最小6文字でなければなりません">
										</div>
										 <span class=""><input class="check" id="remember" type="checkbox"> &nbsp; 
最新のニュースを私に知らせます</span>
										 
										 		<div class="top-margin-10"></div>	
												
										<!--<p class="">
										 
サインアップすることで、あなたは私たちを受け入れていることを確認します <a href="#" class="forgot">  
利用規約 </a> そして <a href="#" class="forgot">
個人情報保護方針.</a>
										</p>
										
										<div class=" ">
										<span class="form-group f-left" style="width:35%;">
											<input type="text"  class="form-control" id=" " placeholder="キャプチャ"  >
										</span> 
										
										
										<a href="#">
											<img src="img/refresh.png" style="height:12px; width:12px; margin:10px 20px;">
										</a>
										
										<span class="form-group r-left" style="width:50%;">
											<input type="text" class="form-control" id=" " placeholder="コード">
										</span> 
										
										</div>-->
									 
									<button type="submit" name="signup" class="btn btn-lo">
アカウントを作成する</button> 									
									  </form>
									  <span>
既にメンバー？<a href="#" data-toggle="modal" data-target=".bc-example-modal-sm" class="forgot">
ログイン</a></span>
								</div>
								
					</div>
				  </div>
				</div>