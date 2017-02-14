<?php 
include('config.php');
if($_REQUEST['kon']=='ConvertEntoJp')
{
	    $EntoJP=$_REQUEST['EntoJP'];
		$marutra = explode('"',translate(str_replace(" ","+",$_REQUEST['EntoJP']))); 
		echo $marutra[1]; 
}

if($_REQUEST['kon']=='ConvertJPtoEn')
{
	    $JPtoEn=$_REQUEST['JPtoEn'];
		$marutra = explode('"',translate(str_replace(" ","+",$_REQUEST['JPtoEn']))); 
		echo $marutra[1]; 
}
?>