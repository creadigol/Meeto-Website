<?php
require_once('../db.php'); 
//require_once('../condition.php');
function translate_new($text,$sl,$tl)
{
		if(preg_match('/^[a-zA-Z+0-9-,?\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]*$/',$text))
		{
			return $data = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&sl=".$sl."&tl=".$tl."&dt=t&q=$text");
		}
		else
		{
			return '[[["'.$text;
		}
}
if(isset($_REQUEST['send']))
{
	$marutra = explode('"',translate_new(str_replace(" ","+",$_REQUEST['name']),'ja','en'));
	$name=$marutra[1];
	$marutra = explode('"',translate_new(str_replace(" ","+",$_REQUEST['email']),'ja','en'));
	$pass=$marutra[1];
	$marutra = explode('"',translate_new(str_replace(" ","+",$_REQUEST['pass']),'ja','en'));
	$email=$marutra[1];
	$in=mysql_query("insert into demo_langs values(0,'$email','$pass','$name')");
	echo $in;
}
?>
<html>
	<head>
		<title>
		
		</title>
	</head>
	<body>
	<form method="post" action="">
		<input type="email" placeholder="email" name="email"><br>
		<input type="password" placeholder="password" name="pass"><br>
		<input type="text" placeholder="Name" name="name"><br>
		<br>
		<button name="send">send</button>
	</form><br>
	<a href='demo.php'>china</a>
	</body>
</html>