<?php
	if($_SESSION['jpmeeto']['adminid'] == "")
	{
		//echo $_SESSION['jpmeeto']['adminid'];
		echo "<script>window.location.href='login.php'</script>";
	}

?>