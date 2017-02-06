<?php
session_start();
//print_r($_SESSION);
//echo "<br>";
error_reporting(0);
echo "<h3>PHP List All Session Variables</h3>";
foreach($_SESSION as $key => $val){
	if($key=='enmeetou')
	{
		echo "English <br>";
		foreach($val as $key1 => $vall)
		{
		echo $key1." = ".$vall."<br>";
		}
		echo "<br>";
	}else
	{
		echo "Japanese<br>";
		foreach($val as $key1 => $vall)
		{
		echo $key1." = ".$vall."<br>";
		}
		echo "<br>";
	}
	
	
}
?>