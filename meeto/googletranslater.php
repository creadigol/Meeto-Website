<?php
require_once('db.php'); 
require_once('head1.php');
function translate($text)
{
		
			return $data = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=ja&dt=t&q=$text");
		
}

/* function recur(){
	$sel=mysql_query("select * from cities where jp_name=''");
	if(mysql_num_rows($sel)>0)
	{
		$row=mysql_fetch_array($sel);
		$marutra = explode('"',translate(str_replace(" ","+",$row['name'])));
		echo "<br>Result--".mysql_query("update cities set jp_name=$marutra[1] where id=$row[id] and name=$row[name]");
		recur();
	}
}
 recur(); */
$sel=mysql_query("select * from cities where jp_name=''");
while($row=mysql_fetch_array($sel))
{
	$marutra = explode('"',translate(str_replace(" ","+",$row['name'])));
	//echo $marutra[1]."<br>";
	$nn=mysql_real_escape_string($marutra[1]);	
	mysql_query("update cities set jp_name='$nn' where id=$row[id] ");

} 
//echo "done";
?>