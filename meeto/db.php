<?php
ini_set('error_reporting', 0);
ini_set('display_errors', 0);
session_start();

date_default_timezone_set('Asia/Tokyo');

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'meeto123');
define('DB_PASSWORD', 'meeto@123');
define('DB_NAME', 'jobmatch1');
define('APPROVED', 'approved');
define('PENDING', 'pending');
$con = mysql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD);
mysql_select_db(DB_NAME,$con) or die(mysql_error());

mysql_set_charset('utf8',$con); 

header('Content-Type: text/html; charset=UTF-8');

?>
	
