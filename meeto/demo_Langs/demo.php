<?php
require_once('../db.php'); 
//require_once('../condition.php');
function translate_new($text)
{
		/* if(preg_match('/^[a-zA-Z+0-9-,?\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]*$/',$text))
		{ */
			return $data = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&sl=ja&tl=en&dt=t&q=$text");
		/* }
		else
		{
			return '[[["'.$text;
		} */
}
if(isset($_REQUEST['send']))
{
		echo $_REQUEST['name'];
	$marutra = explode('"',translate_new(str_replace(" ","+",$_REQUEST['name'])));
	$name=$marutra[1];
	$marutra = explode('"',translate_new(str_replace(" ","+",$_REQUEST['email'])));
	$pass=$marutra[1];
	$marutra = explode('"',translate_new(str_replace(" ","+",$_REQUEST['pass'])));
	$email=$marutra[1];
	print_r($marutra);
	$in=mysql_query("insert into demo_langs values(0,'$email','$pass','$_REQUEST[name]')");
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
	</form>
	<br>
	<a href='japan.php'>japan</a>
	<?php
		$sel=mysql_query("select * from demo_langs");
		while($row=mysql_fetch_array($sel))
		{
			echo $row['email'];
		}
	?>
	</body>
</html>