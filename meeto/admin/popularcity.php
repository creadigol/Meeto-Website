<?php
include('config.php');
	include('condition.php');
	
	if(isset($_REQUEST[sub_fac]))
	{
		if($_REQUEST['city']!="city")
		{
			$ex = $_FILES[upsempic][type];
			$size=$_FILES[upsempic][size]/1024;
			
			if ( ($ex == "image/png" || $ex == "image/jpg" || $ex == "image/jpeg") && ($size<=500) ) 
			{
				$dt=date("Y-m-d");
			$sel=mysql_query("select id from cities where id=$_REQUEST[city]");
			$fet=mysql_fetch_array($sel);
			$navuname = "popular-city/admin_city".$fet[0].".png";
			$in=mysql_query("update cities set city_img='$navuname',status=1,rotateval='$_REQUEST[txtrotatevalue]' where id=$_REQUEST[city]");
			/* $lst=mysql_insert_id();
			if($in==1)
			{
				$up=mysql_query("update sliders set status=0 where id!=$lst");
			} */
			$path1 = "../img/" . $navuname;
			//echo $in;
			//echo $path1;
			move_uploaded_file($_FILES[upsempic]['tmp_name'], $path1);
				echo "<script>alert('Sucessfully Set');</script>"; 
			}else{
				echo "<script>alert('Please Set image less than 500 kb');</script>"; 
			}
		}
			else{
		echo "<script>alert('Please Select City...!');</script>"; 
		}
	}
	
	
	if($_REQUEST[id]!="")
	{
		
		if($_REQUEST[shuup]=="act")
		{
			$up=mysql_query("update cities set status=1 where id=$_REQUEST[id]");
			//mysql_query("update sliders set status=1 where id=$_REQUEST[id]");
		}
		if($_REQUEST[shuup]=="deact")
		{
		
			$up=mysql_query("update cities set status=0 where id=$_REQUEST[id]");
			
		}
		header("location:popularcity.php");
	}
	
?>

<!DOCTYPE html>
<html lang="gu">

<!-- Mirrored from webthemez.com/demo/matrix-free-bootstrap-admin-template/table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 May 2016 11:33:21 GMT -->
<? include('header.php');
	 ?>
	<script type="text/javascript">

	function changesempic(input)
{
	if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#id_upsempicimgplace')
        .attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
  }
}
	function changesempic1(input)
{
	if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#id_upsempicimgnewplace')
        .attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
  }
}
	
	function setstate(cid)
{
	//alert(cid);
	$.ajax({

		url: "miss.php?kon=setstate&id="+cid, 
		type: "POST",
		success: function(data)
		{
			//alert(data);
			$("#allstate").html(data);
		}
	}); 
}
function setcity(cid)
{
	//alert(cid);
	$.ajax({

		url: "miss.php?kon=setcity&id="+cid, 
		type: "POST",
		success: function(data)
		{
			//alert(data);
			$("#allcity").html(data);
		}
	}); 
}
	function facilityshow()
	{
		$("#hidenewfac").toggle(100);
	}
	 
	</script>
	 <style>
        .upperdivche
        {
           display:none;
        }
        </style>
<body >

        
        
<div class="upperdivche" id='hidenewfac' style='width:100%;height:149%;background: rgba(0,0,0,0.5);padding: 2%;position: fixed; z-index: 999;'>
		<div class="row" >
			<div class="col-md-12">
			<br><br>
				<div class="col-md-5 col-md-offset-4" style="border:1px solid #333;background:#fff;">
					
                    <div class="col-md-12 page-header">
						<div  class="col-md-6" align="left" style="color:#000;">
                        <h3>
                            Set City Image.
                        </h3>
						</div>
						<div  class="col-md-6 " align="right" >
						<div class="col-md-2 col-md-offset-10 btn btn-danger" onclick="facilityshow();">
							X
						</div>
						</div>
                    </div>
					<div class="col-md-12"> 
						<form method="post" role="form" enctype="multipart/form-data"> 
											<div class="col-md-8 col-md-offset-2">
											<input type="file" name="upsempic" id="id_upsempic" style="display:none;" onchange="changesempic(this);">
											<input type="hidden" id="rotateniid0" value="360" name="txtrotatevalue">
												<label  for="id_upsempic" style="border:1px solid black;" align="center"><img align="center" src="../img/no-photo.jpg" width="500"  class="img-responsive" id="id_upsempicimgplace" /></label>
											</div>
						<div class="col-md-6 col-md-offset-2">
							<div class="col-md-3 deg90" ><i style="color:red;" class="fa fa-rotate-right"></i></div>
							<div class="col-md-3 deg990" ><i style="color:red;"class="fa fa-rotate-left" ></i></div>
							<div class="col-md-3 deg180" ><i class="fa fa-refresh" style="transform:rotate(90deg);color:red;"></i></div>
							<div class="col-md-3 deg360" ><i style="color:red;"class="fa fa-refresh"></i></div>
							
							
						<br><br>
						</div>											
											<div class="col-md-8 col-md-offset-2">
											<div class="col-md-12">
									
									<select id="country" class="input-name"  name="country" style="width:100%!important;" onchange="setstate(this.value);">
										 <option value="">--Select Country--</option>
										<?php
											$selcountry=mysql_query("select * from countries");
											while($fetcountry=mysql_fetch_array($selcountry))
											{
										?>
											<option value="<?php echo $fetcountry['id']; ?>"><?php echo $fetcountry['name']; ?></option>
										<?php
											}
										?>
									</select>
									</div>
									<div class="col-md-12">
									
									<select id="allstate" class="input-name" name="state" style="width:100%!important;"  onchange="setcity(this.value);">
										 <option value="">--Select State--</option>
										<?php
											$selcountry=mysql_query("select * from states where country_id=$rowuserdetail[countryid]");
											while($fetcountry=mysql_fetch_array($selcountry))
											{
										?>
												<option value="<?php echo $fetcountry['id']; ?>"><?php echo $fetcountry['name']; ?></option>
										<?php
											}
										?>
									</select>
									
									</div>
									<div class="col-md-12">
									
									<select id="allcity" class="input-name" style="width:100%!important;" name="city" onchange="">
										 <option value="city">--Select City--</option>
										<?php
											$selcountry=mysql_query("select * from cities where state_id=$rowuserdetail[stateid]");
											while($fetcountry=mysql_fetch_array($selcountry))
											{
										?>
												<option  value="<?php echo $fetcountry['id']; ?>"><?php echo $fetcountry['name']; ?></option>
										<?php
											}
										?>
									</select>
									<br><br>
									</div>
							
											</div>
											<div class="col-md-3 col-md-offset-4">
												&nbsp;&nbsp;&nbsp;<input type="submit" name="sub_fac" class="btn btn-primary" value="Set / Update">
											<br><br>
										</div>
						</form>
					  <br><br><br>
					</div>
             
				</div>
				
			</div>
		</div>
</div>
    <div id="wrapper">
	
        <? include('navbar.php'); ?>
        <div id="page-wrapper" >
            <div id="page-inner">
			
			      
			 <div class="row">
                    <div class="col-md-12 page-header">
						<div  class="col-md-6" align="left">
                        <h1>
                            Popular City
                        </h1>
						</div>
						<div  class="col-md-6 " align="right" >
						<div class="col-md-5 col-md-offset-7 btn btn-primary" onclick="facilityshow();">
							 Set City Pic &nbsp;&nbsp;<i class="fa fa-pencil" style="font-size:15px;"></i>
						</div>
						</div>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               
				<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             City List
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" id="admin_place">
							<!-- dataTables-example -->
                                <table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
										<th><center>Image</center></th>
                                            <th><center>City Name</center></th>
											
                                            <th><center>Status</center></th>
                                            
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `cities` where city_img!='' order by id desc ");
										while($data=mysql_fetch_array($query)){
									?>
                                        <tr class="odd gradeX">
										<td><center><img src="../img/<? echo $data['city_img'];?>"style="width:150px;height:100px;transform:rotate(<?php echo $data['rotateval']; ?>deg)" class="img-responsive" /></center></td>
										<td><center><font color="black" size="5" style="font-weight:bold;margin-top:30px;"><?php echo $data['name']; ?></font></center></td>
                                           <? if($data['status']=='1'){
											?>
                                           <td><center>
												<i class="fa fa-thumbs-o-up" onclick="window.location='popularcity.php?id=<?php echo $data['id'];?>&shuup=deact'" title="Inactive" style="color:green;cursor:pointer;font-size:20px;margin-top:30px;"></i>
												</center></td>
												
											<?
											}else{
											?>
												<td><center>
												<i class="fa fa-thumbs-o-down" onclick="window.location='popularcity.php?id=<?php echo $data['id'];?>&shuup=act'" title="Inactive" style="color:red;cursor:pointer;font-size:20px;margin-top:30px;"></i>
												</center></td>
												
											<? } ?>
											
											
                                        </tr>
									<?
										}
									?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  -->

        </div>
               <?php include('footer.php'); ?>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
				//alert();
				$('.deg90').click(function(){
					$('#id_upsempicimgplace').css("transform","rotate(90deg)");
					$("#rotateniid0").val("90");
				});
				$('.deg990').click(function(){
					$('#id_upsempicimgplace').css("transform","rotate(-90deg)");
					$("#rotateniid0").val("-90");
				});
				$('.deg180').click(function(){
					$('#id_upsempicimgplace').css("transform","rotate(180deg)");
					$("#rotateniid0").val("180");
				});
				$('.deg360').click(function(){
					$('#id_upsempicimgplace').css("transform","rotate360deg)");
					$("#rotateniid0").val("360");
				});
            });
    </script>
         <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    <script src="assets/js/all.js"></script>
    
   
</body>

<!-- Mirrored from webthemez.com/demo/matrix-free-bootstrap-admin-template/table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 May 2016 11:33:25 GMT -->
</html>
