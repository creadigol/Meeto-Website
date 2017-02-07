<?php
if(!session_id()) {
    session_start();
}
require_once __DIR__ . '/php-graph-sdk-5.0.0/src/Facebook/autoload.php';
  
$fb = new Facebook\Facebook([
  'app_id' => '236568240079026',
  'app_secret' => '5b21076154292bdc6b6b05428e0ff3ef',
  'default_graph_version' => 'v2.8'
]);

$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (!isset($accessToken)) {
    if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
    }
    exit;
}

if (isset($accessToken)) 
  {
	foreach ($_COOKIE as $k=>$v) 
	{
    if(strpos($k, "FBRLH_")!==FALSE) {
        $_SESSION['jpmeetou'][$k]=$v;
     }
    } 
		  // Logged in!
	    $_SESSION['jpmeetou']['facebook_access_token'] = (string) $accessToken;
		 
		$fb->setDefaultAccessToken($accessToken);

		try {
		  $response = $fb->get('/me?fields=name,email,location,gender,first_name,last_name,picture.width(800).height(800)',$_SESSION['jpmeetou']['facebook_access_token']);
		  $userNode = $response->getGraphUser();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}
		
		 $_SESSION['jpmeetou']['fb_id'] = $userNode['id'];
		 $_SESSION['jpmeetou']['fname'] = $userNode['first_name'];
		 $_SESSION['jpmeetou']['lname'] = $userNode['last_name'];
		 $_SESSION['jpmeetou']['email'] = $userNode['email'];
		 $_SESSION['jpmeetou']['gender'] = $userNode['gender']; 
		 $_SESSION['jpmeetou']['user_picture'] = $userNode['picture']['url'];
		 
		 if(isset($_SESSION['jpmeetou']['facebookjp']))
		 {
			 echo "<script>window.location='http://www.meeto.jp/jp/index.php';</script>";
		 }
		 else
		 {
			 echo "<script>window.location='index.php';</script>";
		 }
		
  }
  ?>