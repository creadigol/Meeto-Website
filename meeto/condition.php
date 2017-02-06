<?php
	require_once('db.php');
	if($_SESSION['jpmeetou']['id']=='')
	{
		echo "<script>window.location='index.php?for=login';</script>";
	}
?>