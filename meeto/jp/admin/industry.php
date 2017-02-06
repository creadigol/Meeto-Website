<?php
include('config.php');
	include('condition.php');
	if(isset($_REQUEST[sub_fac]))
	{
		$industry = $_REQUEST['addnewfac']; 
		$in=mysql_query("insert into industry values(0,'$industry','$industry','list-page/category.png',1)");
		echo "<script>alert('Sucessfullyを追加しました');</script>"; 
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- Mirrored from webthemez.com/demo/matrix-free-bootstrap-admin-template/table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 May 2016 11:33:21 GMT -->
<? include('header.php');
	 ?>
	<script>
	
	function adm_facility(id,shu)
	{
		var textt=$("#facility_new_text").val();
		if(shu=="delete_fac")
		{
			if(confirm('あなたは確かにレコードの削除されていますか...？'))
			{
				
			}
			else{
				shu="cancel";
				
			}
		}
		
		$.ajax({
		url: "miss.php?kon=admin_industry_up&id="+id+"&shu="+shu+"&textt="+textt, 
		type: "POST",
		success: function(data)
		{
			$("#admin_industry").html(data);
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
                            
新産業を追加
                        </h3>
						</div>
						<div  class="col-md-6 " align="right" >
						<div class="col-md-2 col-md-offset-10 btn btn-danger" onclick="facilityshow();">
							X
						</div>
						</div>
                    </div>
					<div class="col-md-12"> 
						<form method="post" role="form">
							 <div class="form-group">
                                            <label>
タイトル</label>
                                            <input class="form-control" type="text" name="addnewfac" required="" placeholder="
新産業を追加" >
                                        </div>
										<div class="col-lg-12">
											<center>
												<input type="submit" name="sub_fac" class="btn btn-primary" value="
加えます">
												
											</center>
										</div>
						</form>
					  <br><br>
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
                           
産業
                        </h1>
						</div>
						<div  class="col-md-6 " align="right" >
						<div class="col-md-4 col-md-offset-8 btn btn-primary" onclick="facilityshow();">
							
新産業を追加 <i class="fa fa-plus" style="font-size:10px;"></i>
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
                             
業種一覧
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" id="admin_industry">
							<!-- dataTables-example -->
                                <table class="table table-striped table-bordered table-hover animated jello infinte" id="">
                                    <thead>
                                        <tr>
                                            <th><center>
名</center></th>
                                        
                                            
											<th><center>
更新</center></th>
											<th><center>
削除</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `industry` ");
										while($data=mysql_fetch_array($query)){
									?>
                                        <tr class="odd gradeX">
                                            <td><? $marutra = explode('"',translate(str_replace(" ","+", $data['name']))); echo $marutra[1]; ?></td>
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
