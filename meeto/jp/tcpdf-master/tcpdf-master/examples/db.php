<?php
ini_set('error_reporting', 0);
ini_set('display_errors', 0);
session_start();

date_default_timezone_set('Asia/Kolkata');

define('DB_HOST', 'jobmatch1.db.12566969.hostedresource.com');
define('DB_USERNAME', 'jobmatch1');
define('DB_PASSWORD', 'Job@1234');
define('DB_NAME', 'jobmatch1');
define('APPROVED', 'approved');
define('PENDING', 'pending');
$con = mysql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD);
mysql_select_db(DB_NAME,$con) or die(mysql_error());

?>
<?php
function translate($text)
{
		if(preg_match('/^[a-zA-Z+0-9-,?\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]*$/',$text))
		{
			return $data = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=ja&dt=t&q=$text");
		}
		else
		{
			return '[[["'.$text;
		}
}
?>