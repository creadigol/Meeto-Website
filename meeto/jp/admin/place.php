<?php
include('config.php');
	include('condition.php');
	
	if(isset($_REQUEST[sub_fac]))
	{
			$ex = $_FILES[upsempic][type];
			$size=$_FILES[upsempic][size]/1024;
		
			if ($ex == "image/png" || $ex == "image/jpg" || $ex == "image/jpeg") 
			{	
			$sel=mysql_query("select id from seminar_type order by id desc");
			$fet=mysql_fetch_array($sel);
			$navuname = "list-page/new_purpose".$fet[0].".png";
			$in=mysql_query("insert into seminar_type values(0,'$_REQUEST[addnewfac]','$_REQUEST[addnewjpfac]','$navuname',1,'','')");
			$path1 = "../img/" . $navuname;
			//echo $in;
			//echo $path1;
			move_uploaded_file($_FILES[upsempic]['tmp_name'], $path1);
				echo "<script>alert('Sucessfully Added');</script>"; 
			}
	}
	if(isset($_REQUEST[sub_update]))
	{
		
			$ex = $_FILES[filesharing][type];
			$size=$_FILES[filesharing][size]/1024;
		
			if ($ex == "image/png" || $ex == "image/jpg" || $ex == "image/jpeg") {
		

			$navuname = $_REQUEST[pur_img];
		
			
				mysql_query("update seminar_type set name='$_REQUEST[pur_txt]',image='$navuname' where id=$_REQUEST[pur_id]");
			$path1 = "../img/" . $navuname;
			//echo $in;
			//echo $path1;
				move_uploaded_file($_FILES[filesharing]['tmp_name'], $path1);
				
			}
			else
				$in=mysql_query("update seminar_type set name='$_REQUEST[pur_txt]' where id=$_REQUEST[pur_id]");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	}
	if($_REQUEST[id]!="")
	{
		if($_REQUEST[shuup]=="dec")
		{
			$up=mysql_query("update seminar_type set status=0 where id=$_REQUEST[id]");
		}
		if($_REQUEST[shuup]=="act")
		{
			$up=mysql_query("update seminar_type set status=1 where id=$_REQUEST[id]");
		}
		header("location:place.php");
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
	
	function adm_facility(id,shu)
	{
		var textt=$("#facility_new_text").val();
		if(shu=="delete_fac")
		{
			if(confirm('Are You Sure Delete Record...?'))
			{
				
			}
			else{
				shu="cancel";
				
			}
		}
		
		$.ajax({
		url: "miss.php?kon=admin_place_up&id="+id+"&shu="+shu+"&textt="+textt, 
		type: "POST",
		success: function(data)
		{
			$("#admin_place").html(data);
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

        
        
<div class="upperdivche" id='hidenewfac' style='width:100%;height:149%;background: rgba(0,0,0,0.5);padding: 2%;position:fixed; z-index: 999;'>
		<div class="row" >
			<div class="col-md-12">
			<br><br>
				<div class="col-md-5 col-md-offset-4" style="border:1px solid #333; background:#fff;">
					
                    <div class="col-md-12 page-header">
						<div  class="col-md-6" align="left" style="color:black;">
                        <h3>
                            <?php echo ADD_NEW_PLACE;?>
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
											<div class="col-md-3 col-md-offset-5">
											<input type="file" name="upsempic" id="id_upsempic" style="display:none;" onchange="changesempic(this);">
												<label  for="id_upsempic" style="border:1px solid black;border-radius:100%;" align="center"><img align="center" src="../img/no-photo.jpg" style="border-radius:100%;" width="100" height="100" class="img-circle" id="id_upsempicimgplace" /></label>
											</div>
											<div class="form-group col-md-9 col-md-offset-4">
									
                                            <label><?php echo JAPANESE_PLACE;?></label>
												<input class="form-control" type="text" name="addnewjpfac" required="" placeholder="<?php echo ADD_PLACE;?>" style="width:50%;">
											</div>
											<div class="form-group col-md-9 col-md-offset-4">
									
                                            <label><?php echo ENGLISH_PLACE;?></label>
											<div><span style="color:red;">*</span><?php echo KINDLY_ENTER_ENGLISH_CONVERSATION_THE_SAME;?><br>
											<?php echo IF_REQUIRED_TAKE_HELP_OF_GOOGLE_TRANSLATER;?></div>
												<input class="form-control" type="text" name="addnewfac" required="" placeholder="<?php echo ADD_PLACE;?>" style="width:50%;">
											</div>
											
											<div class="col-md-3 col-md-offset-5">
												
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="sub_fac" class="btn btn-primary" value="<?php echo ADD;?>">
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
                            <?php echo PLACE;?>
                        </h1>
						</div>
						<div  class="col-md-6 " align="right" >
						<div class="col-md-5 col-md-offset-7 btn btn-primary" onclick="facilityshow();">
							 <?php echo ADD_NEW_PLACE;?> <i class="fa fa-plus" style="font-size:10px;"></i>
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
                             <?php echo PLACE_LIST;?>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" id="admin_place">
							<!-- dataTables-example -->
                                <table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
										<th><center><?php echo IMAGE;?></center></th>
                                            <th><center><?php echo NAME;?></center></th>
											
                                            <th><center><?php echo STATUS;?></center></th>
                                            
											<th><center><?php echo UPDATE;?></center></th>
											<th><center><?php echo DELETE1;?></center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `seminar_type` ");
										while($data=mysql_fetch_array($query)){
									?>
                                        <tr class="odd gradeX">
										<td ><center><img src="../img/<? echo $data['image'];?>" width="50" height="50" class="img-circle" /></center></td>
                                            <td><? //$marutra = explode('"',translate(str_replace(" ","+",$data['name']))); echo $marutra[1] ; ?><?php echo $data['name_jp'] ?></td>
                                            <td><center><? if($data['status']=='1'){
											?>
												<i class="fa fa-thumbs-o-up" title="Active" style="color:green;cursor:pointer;" onclick="window.location='place.php?id=<?php echo $data['id'];?>&shuup=dec'"></i>
											<?
											}else{
											?>
												<i class="fa fa-thumbs-o-down" onclick="window.location='place.php?id=<?php echo $data['id'];?>&shuup=act'" title="Inactive" style="color:red;cursor:pointer;"></i>
											<? } ?>
											</center></td>
                                            
											<td><center><span class="fa fa-upload" title="Update" style="cursor:pointer;color:green;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','update');"></span></center></td>
											<td><center><span class="fa fa-trash-o" title="Delete" style="cursor:pointer;color:red;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','delete_fac');"></span></center></td>
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
            });
    </script>
         <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    <script src="assets/js/all.js"></script>
    
   
</body>

<!-- Mirrored from webthemez.com/demo/matrix-free-bootstrap-admin-template/table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 May 2016 11:33:25 GMT -->
</html>
