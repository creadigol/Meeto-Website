<?php 
	include('header.php');
	include('config.php');
	include('condition.php');
	$p=30;
?>
<?php 
	if($_REQUEST['kon'] =='state')
	{
		echo "<script>";
				$querystate=mysql_query("select * from  states where cid=$_REQUEST['cid'] ");
				while($states=mysql_fetch_array($querystate))
				{
					if($states['id'] == $userdata['stateid']){
						echo "<option value='$states[id]' selected>$states[name]</option>";
					}else{
						echo "<option value='$states[id]' >$states[name]</option>";
					}
				}	
	}
?>