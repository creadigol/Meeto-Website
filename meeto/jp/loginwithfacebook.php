<?php
session_start();
	require_once __DIR__ . '/php-graph-sdk-5.0.0/src/Facebook/autoload.php';  
   $fb = new Facebook\Facebook([
 'app_id' => '236568240079026',
  'app_secret' => '5b21076154292bdc6b6b05428e0ff3ef',
									  'default_graph_version' => 'v2.5'
									]);

									$helper = $fb->getRedirectLoginHelper();
									$permissions = ['email', 'user_likes']; 
									$loginUrl = $helper->getLoginUrl('https://www.creadigol.biz/meeto/login-callback.php', $permissions);
								?>
								<a href="<? echo $loginUrl;?>" class="btn btn-fb"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>