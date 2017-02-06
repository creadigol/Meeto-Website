<?php
require_once('db.php');
session_start();
unset($_SESSION['jpmeetou']);
//session_destroy();
echo "<script>window.location.href='index.php'</script>";
	
?>