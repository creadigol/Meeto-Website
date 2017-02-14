<?php 
if($_REQUEST['kon']=="convertfacility")
{
		echo "<script>alert('jihhih')</script>";
		 $enfacility=$_REQUEST['enfacility'];
		//echo "<script>alert($enfacility)</script>";
		$marutra = explode('"',translate(str_replace(" ","+",$_REQUEST['enfacility']))); 
		echo $marutra[1]; 
}
if($_REQUEST['kon']=="convertfacility2")
{
		$jpfacility=$_REQUEST['jpfacility'];
		//echo "<script>alert($jpfacility)</script>";
		$marutra = explode('"',translate(str_replace(" ","+",$_REQUEST['jpfacility']))); 
		echo $marutra[1]; 
}

?>