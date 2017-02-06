<?php
$db = mysql_connect("jobmatch1.db.12566969.hostedresource.com", "jobmatch1", "Job@1234") or die("Could not connect.");

if(!$db) 

	die("no db");

if(!mysql_select_db("jobmatch1",$db))

 	die("No database selected.");
?>
