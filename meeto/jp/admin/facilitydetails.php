<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- Mirrored from webthemez.com/demo/matrix-free-bootstrap-admin-template/form.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 May 2016 11:33:25 GMT -->
<? require_once('header.php');
	include('config.php');
	include('condition.php');
	if(isset($_REQUEST['btn_save']))
	{
		
		$title=$_REQUEST['title'];
		$description=$_REQUEST['description'];
		$hostname=$_REQUEST['hostname'];
		$hostemail=$_REQUEST['hostemail'];
		$qualification=$_REQUEST['qualification'];
		$total_seat=$_REQUEST['total_seat'];
		$booked_seat=$_REQUEST['booked_seat'];
		$type=$_REQUEST['type'];
		$address=$_REQUEST['address'];
		$tagline=$_REQUEST['tagline'];
		$country=$_REQUEST['country'];
		$state=$_REQUEST['state'];
		$city=$_REQUEST['city'];
		$purpose=$_REQUEST['purpose'];
		$contact=$_REQUEST['contact'];
		
		if($title == ""){
			$errortitle='Please Enter Title';
		}else{
			$errortitle="";
		}
		if($description == ""){
			$errordescription='Please Enter Description';
		}else{
			$errordescription="";
		}
		if($hostemail == ""){
			$erroremail='Please enter Host email Address';
		}else{
			$erroremail="";
		}
		if($hostname == ""){
			$errorname='Please enter Host Name';
		}else{
			$errorname="";
		}
		if($contact == ""){
			$errorcontact='Please enter contact Number';
		}else{
			$errorcontact="";
		}
		/*if($type == ""){
			$errortype='Please enter type ';
		}else{
			$errortype="";
		}
		 if($purpose == ""){
			$errorpurpose='Please enter Purpose ';
		}else{
			$errorpurpose="";
		} */ 
		
		if($title != "" || $hostemail != "" || $contact != "" || $hostname != "" || $purpose != "" || $description != ""  )
		{
			$updateseminar=mysql_query("UPDATE  `seminar` SET  `title` =  '$title',`hostperson_name` =  '$hostname',`contact_email` =  '$hostemail',`description` =  '$description',`qualification` =  '$qualification',`address` =  '$address',`phoneno` =  '$contact',`countryid` =  '$country',`stateid` =  '$state',`cityid` =  '$city' WHERE  `id` =$_REQUEST[sid] ");
			echo "<script>alert('Data Updated Sucessfully');</script>";  
		}
	} 
	 
	?>
<style>
	.error{color:red;}
	
</style>
<script>
	function seminardetails(sid){
		$.ajax({
		url: "miss.php?kon=seminardetails&sid="+sid, 
		type: "POST",
		success: function(data)
		{
			$("#seminardetails").html(data);
		}
		});
	}
	function seminarfacility(sid){
		$.ajax({
		url: "miss.php?kon=seminarfacility&sid="+sid, 
		type: "POST",
		success: function(data)
		{
			$("#seminarfacility").html(data);
		}
		});
	}
	function facilitystatus(status,id,sid){
		$.ajax({
		url: "miss.php?kon=facilitystatus&status="+status+"&id="+id, 
		type: "POST",
		success: function(data)
		{
			seminarfacility(sid);
		}
		});
	}
</script>
<body onload="seminardetails('<? echo $_REQUEST['sid']; ?>');seminarfacility('<? echo $_REQUEST['sid']; ?>');">
    <div id="wrapper">
        <? include('navbar.php'); ?>
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Seminar Details <small></small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
				 <div class="seminardetails" id="seminardetails" >
				
                </div>

                <div class="seminarfacility" id="seminarfacility" >
				
                </div>
			<?php include('footer.php');?>
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
