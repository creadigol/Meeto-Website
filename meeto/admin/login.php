<?php
error_reporting(0);
require_once('config.php');
include('header.php');
	if($_SESSION['enmeeto']['adminid'] != "")
	{
		echo "<script>window.location.href='index.php'</script>";
	} 
	if(isset($_REQUEST['btn_save']))
	{
		if($_REQUEST['txt_uname'] == "" && $_REQUEST['txt_password'] == "")
		{
			echo "<script>alert('Please Enter Username And Password');</script>";
		}else{
				$u=mysql_real_escape_string($_REQUEST['txt_uname']);
				$pwd=mysql_real_escape_string($_REQUEST['txt_password']);
				//echo "select * from admin WHERE username=$_REQUEST[txt_uname] and password=$_REQUEST[txt_password] ";
				$result=mysql_query("SELECT * FROM `admin` WHERE username='".$u."' and password='".$pwd."' ");
                if(mysql_num_rows($result)==0){
					echo "<script>alert('Incorrect Username And Password');</script>";
				}else{
						$data=mysql_fetch_array($result);
						$_SESSION['jpmeeto']['adminname']=$data[name];
						$_SESSION['jpmeeto']['adminid']=$data[id];  
						$_SESSION['jpmeeto']['adminimage']=$data[image];
                        echo "<script>window.location='index.php' </script>";
                    }
		}
    }
	$milliseconds = round(microtime(true) * 1000);
	mysql_query("update seminar set status=0 where id in(select seminar_id from seminar_day where to_date < '$milliseconds')");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Responsive Bootstrap Advance Admin Template</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body style="background-color: #E2E2E2;">
    <div class="container">
        <div class="row text-center " style="padding-top:100px;">
            <div class="col-md-12">
                <img src="../img/header_logo.png" />
            </div>
        </div>
        <div class="row ">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
				<div class="panel-body">
                    <form role="form" method = "post" action = "login.php" enctype="multipart/form-data">
                        <hr />
                            <h5>Enter Details to Login</h5>
                            <br />
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                    <input type="text" name="txt_uname" class="form-control" placeholder="Your Username " />
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                    <input type="password" name="txt_password" class="form-control"  placeholder="Your Password" />
                                </div>
							<input type="submit" name="btn_save" class="btn btn-primary " value="Login Now" >
                        <hr />
                    </form>
                </div>
            </div>    
        </div>
    </div>
</body>
</html>