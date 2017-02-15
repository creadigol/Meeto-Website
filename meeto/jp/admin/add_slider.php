<?php
include('config.php');
	include('condition.php');
	
	if(isset($_REQUEST[sub_fac]))
	{
			$ex = $_FILES[upsempic][type];
			$size=$_FILES[upsempic][size]/1024;
		
			if ( ($ex == "image/png" || $ex == "image/jpg" || $ex == "image/jpeg") && ($size<=500)) {
		
				$dt=date("Y-m-d");
			$sel=mysql_query("select id from sliders order by id desc");
			$fet=mysql_fetch_array($sel);
			$navuname = "admin-slider/admin_slider".$fet[0].".png";
			$in=mysql_query("insert into sliders values(0,'$navuname',1,'$dt','$_REQUEST[txtrotatevalue]')");
			$lst=mysql_insert_id();
			if($in==1)
			{
				$up=mysql_query("update sliders set status=0 where id!=$lst");
			}
			$path1 = "../../img/" . $navuname;
			//echo $in;
			//echo $path1;
			move_uploaded_file($_FILES[upsempic]['tmp_name'], $path1);
				echo "<script>alert('Sucessfullyを追加しました');</script>"; 
			}
	}
	
	if($_REQUEST[id]!="")
	{
		
		if($_REQUEST[shuup]=="act")
		{
			$up=mysql_query("update sliders set status=0 where id!=$_REQUEST[id]");
			mysql_query("update sliders set status=1 where id=$_REQUEST[id]");
		}
		if($_REQUEST[shuup]=="delete")
		{
			$slider=mysql_query("select * from sliders where id=$_REQUEST[id]");
			$fet=mysql_fetch_array($slider);
			unlink("../img".$fet['name']);
			$up=mysql_query("delete from sliders where id=$_REQUEST[id]");
		}
		header("location:add_slider.php");
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
				<div class="col-md-5 col-md-offset-4" style="border:1px solid #333; background:#fff;">
					
                    <div class="col-md-12 page-header">
						<div  class="col-md-6" align="left" style="color:black;">
                        <h3>
                           <?php echo ADD_NEW_WALLPAPER;?>
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
											<div class="col-md-10 col-md-offset-2">
											<input type="file" name="upsempic" id="id_upsempic" style="display:none;" onchange="changesempic(this);">
											<input type="hidden" id="rotateniid0" value="360" name="txtrotatevalue">
												<label  style="border:1px solid black;" align="center" for="id_upsempic"><img  align="center" src="../img/no-photo.jpg" width="300"  class="img-responsive" id="id_upsempicimgplace" /></label>
											</div>
						<div class="col-md-6 col-md-offset-2">
							<div class="col-md-3 deg90" ><i style="color:red;" class="fa fa-rotate-right"></i></div>
							<div class="col-md-3 deg990" ><i style="color:red;"class="fa fa-rotate-left" ></i></div>
							<div class="col-md-3 deg180" ><i class="fa fa-refresh" style="transform:rotate(90deg);color:red;"></i></div>
							<div class="col-md-3 deg360" ><i style="color:red;"class="fa fa-refresh"></i></div>
							
							
						<br><br>
						</div>
											
											
											<div class="col-md-3 col-md-offset-5">
												
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="sub_fac" class="btn btn-primary" value="加えます">
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
                          <?php echo WALLPAPER;?>
                        </h1>
						</div>
						<div  class="col-md-6 " align="right" >
						<div class="col-md-5 col-md-offset-7 btn btn-primary" onclick="facilityshow();">
							 <?php echo ADD_NEW_WALLPAPER;?><i class="fa fa-plus" style="font-size:10px;"></i>
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
                            <?php echo HOME_WALLPAPER_LIST;?>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" id="admin_place">
							<!-- dataTables-example -->
                                <table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
										<th><center><?php echo IMAGE;?></center></th>
                                            
											
                                            <th><center><?php echo STATUS;?></center></th>
                                             <th><center><?php echo DELETE1;?></center></th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `sliders` order by id desc");
										while($data=mysql_fetch_array($query)){
									?>
                                        <tr class="odd gradeX">
										<td ><center><img src="../../img/<? echo $data['name'];?>"style="width:150px;height:100px;transform:rotate(<?php echo $data['totateval']; ?>deg)" class="img-responsive" /></center></td>
                                           
                                            <? if($data['status']=='1'){
											?>
                                            <td><center>
												<font color="green" size="5" style="font-weight:bold;margin-top:30px;"><?php echo ACTIVE;?></font>
												</center></td>
												<td><center>
												<font color="green" size="5" style="font-weight:bold;margin-top:30px;"><?php echo ACTIVE;?></font>
												</center></td>
											<?
											}else{
											?>
												<td><center>
												<i class="fa fa-thumbs-o-down" onclick="window.location='add_slider.php?id=<?php echo $data['id'];?>&shuup=act'" title="Inactive" style="color:red;cursor:pointer;font-size:20px;margin-top:30px;"></i>
												</center></td>
												<td><center><span class="fa fa-trash-o" title="Delete" style="cursor:pointer;color:red;margin-top:30px;font-size:20px" area-hidden="true" onclick="window.location='add_slider.php?id=<?php echo $data['id'];?>&shuup=delete'" title="Inactive" ></span></center></td>
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
