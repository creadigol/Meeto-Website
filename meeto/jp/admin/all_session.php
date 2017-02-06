<?php
session_start();
//print_r($_SESSION);
//echo "<br>";
echo "<h3>PHP List All Session Variables</h3>";
foreach($_SESSION as $key => $val){
	echo $key." = ".$val."<br>";
}
print_r($_SESSION['jpmeeto']);
?>
