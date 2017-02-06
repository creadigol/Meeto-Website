<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- Mirrored from webthemez.com/demo/matrix-free-bootstrap-admin-template/form.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 May 2016 11:33:25 GMT -->
<? require_once('header.php');
	include('config.php');
	include('condition.php');
	if(isset($_REQUEST['btn_save']))
	{
		
		$fname=$_REQUEST['fname'];
		$email=$_REQUEST['email'];
		$contact=$_REQUEST['contact'];
		$gender=$_REQUEST['gender'];
		$dob=$_REQUEST['dob'];
		$country=$_REQUEST['country'];
		$state=$_REQUEST['state'];
		$city=$_REQUEST['city'];
		$address=$_REQUEST['address'];
		$about=$_REQUEST['about'];
		$county=$_REQUEST['county'];
		$state=$_REQUEST['state'];
		$city=$_REQUEST['city'];
		$company=$_REQUEST['company'];
		$cdescription=$_REQUEST['cdescription'];
		
		if($fname == ""){
			$errorname='Please Enter Name';
		}else{
			$errorname="";
		}
		if($email == ""){
			$erroremail='Please enter email Address';
		}else{
			$erroremail="";
		}
		if($contact == ""){
			$errorcontact='Please enter contact Number';
		}else{
			$errorcontact="";
		}
		if($address == ""){
			$erroraddress='Please enter address Number';
		}else{
			$erroraddress="";
		}
		if($about == ""){
			$errorabout='Please enter about Number';
		}else{
			$errorabout="";
		}
		
		if($fname != "" || $email != "" || $contact != "" || $address != "" || $about != "")
		{
			$name=explode(" ","$fname");
			$updateuser=mysql_query("UPDATE  `user` SET  `fname` =  '$name[0]',`lname` =  '$name[1]',`email` =  '$email' WHERE  `id` =$_REQUEST[user_id] ");
			$updateuserdetails=mysql_query("UPDATE  `user_detail` SET  `gender` =  '$gender',`address` =  '$address',`yourself` =  '$about' ,`yourself` =  '$about' ,`countryid` =  '$country' ,`stateid` =  '$state' ,`cityid` =  '$city' WHERE  `uid` =$_REQUEST[user_id] ");
			//echo "UPDATE  `user_company` SET  `name` =  '$company' and `description`='$cdescription' WHERE  `uid` =$_REQUEST[user_id]   "; 
			$insertcompany=mysql_query("UPDATE  `user_company` SET  `name` =  '$company' and `description`='$cdescription' WHERE  `uid` =$_REQUEST[user_id]"); 
		
			echo "<script>alert('Data Updated Sucessfully');</script>";  
		}
	}
	 
	?>
<style>
	.error{color:red;}
	
</style>
<script>
	function deletesam(did,uid){
		$.ajax({
		url: "miss.php?kon=deletesam&did="+did, 
		type: "POST",
		success: function(data)
		{
			alert('Seminar Deleted Sucessfully');
			hostseminar(uid);
		}
		});
	}
	
	function user(sid,cscid,state,city){
		$.ajax({
		url: "miss.php?kon=user&user_id="+sid+"&cscid="+cscid+"&city="+city+"&statet="+state, 
		type: "POST",
		success: function(data)
		{
			$("#user").html(data);
		}
		});
	}
	function hostseminar(uid){
		$.ajax({
		url: "miss.php?kon=hostseminar&user_id="+uid, 
		type: "POST",
		success: function(data)
		{
			$("#hostseminar").html(data);
		}
		});
	}
	function state(cid,sid){
		alert(cid);
		alert(sid);
		$.ajax({
		url: "miss.php?kon=state&cid="+cid+"&sid="+sid, 
		type: "POST",
		success: function(data)
		{
			$("#state").html(data);
		}
		});
	}
</script>
<body onload="hostseminar('<? echo $_REQUEST[user_id]; ?>');user('<? echo $_REQUEST[user_id]; ?>');">
    <div id="wrapper">
        <? include('navbar.php'); ?>
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            User Details <small></small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
				 <div class="user" id="user" >
				
                </div>
                <!-- /.col-lg-12 -->
                <div class="hostseminar" id="hostseminar" >
				
                </div>
			<footer><p>All right reserved. Template by: <a href="http://webthemez.com/">WebThemez</a></p></footer>
			</div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
   
    
   
</body>

<!-- Mirrored from webthemez.com/demo/matrix-free-bootstrap-admin-template/form.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 May 2016 11:33:25 GMT -->
</html>
