<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- Mirrored from webthemez.com/demo/matrix-free-bootstrap-admin-template/table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 May 2016 11:33:21 GMT -->
<? include('header.php');
	include('config.php');
	include('condition.php'); 
	if($_REQUEST[rid]!="")
	{
		if($_REQUEST[shuup]=="dec")
		{
			$up=mysql_query("update review set status=0 where id=$_REQUEST[rid]");
		}
		if($_REQUEST[shuup]=="act")
		{
			$up=mysql_query("update review set status=1 where id=$_REQUEST[rid]");
		}
	}

	?>
	<script>
	function approvalsam(status,sid){
		$.ajax({
		url: "miss.php?kon=approvalsam&status="+status+"&sid="+sid, 
		type: "POST",
		success: function(data)
		{
			alert('Seminar '+status+' Successfully');
			window.location.href='seminar.php';
		}
		});
	}
	function seminardetails(sid){
		window.location.href='reviewdetail.php?sid='+sid;
	}
	</script>
<body >
    <div id="wrapper">
        <? include('navbar.php'); ?>
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                           <?php echo SEMINAR_REVIEWS;?>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               <div class="col-md-12">
				<?php
					$query=mysql_query("select s.*,sp.* from seminar s,seminar_photos sp where s.id=sp.seminar_id and s.id=$_REQUEST[sid]");
					
					$data=mysql_fetch_array($query);
				?>
					<div class="col-md-1" align="center"> 
						<?
						if(strlen($data['image'])>0){
											?>
												<img src="../../img/<? echo $data[image]; ?>" width="70" height="70">
											<?
												}else{
											?>		
												<img src="../../img/no-photo.jpg" width="70" height="70" class="" />
											<?
												}
											?>
					</div>
					<div class="col-md-6"> 
					<h3><br>
                            <?php $marutra = explode('"',translate(str_replace(" ","+",$data[title]))); echo $marutra[1] ; ?>
                        </h3>
					</div>
					<div class="col-md-12"> <br><br></div>
				</div>
				<div class="row">
                <div class="col-md-12">
				
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <?php echo SEMINAR_REVIEWS;?>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            
                                            <th><?php echo REVIEWS;?></th>
											<th><?php echo USERNAME;?></th>
											<th><?php echo STATUS;?></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select r.*,u.* from review r,user u where r.uid=u.id and r.seminar_id=$_REQUEST[sid]");
										
										while($data=mysql_fetch_array($query)){
										
									?>
                                        <tr class="odd gradeX">
											<td><? $marutra = explode('"',translate(str_replace(" ","+",$data[3]))); echo $marutra[1] ; ?></td>
                                            <td><? $marutra = explode('"',translate(str_replace(" ","+",$data[8]))); echo $marutra[1] ; ?></td>
                                            <td><center><? if($data[6]==1){
											?>
												<i class="fa fa-thumbs-o-up" title="Active" style="color:green;cursor:pointer;" onclick="window.location='reviewdetail.php?sid=<?php echo $_REQUEST['sid'];?>&rid=<?php echo $data[0];?>&shuup=dec'"></i>
											<?
											}else{
											?>
												<i class="fa fa-thumbs-o-down" onclick="window.location='reviewdetail.php?sid=<?php echo $_REQUEST['sid'];?>&rid=<?php echo $data[0];?>&shuup=act'" title="Inactive" style="color:red;cursor:pointer;"></i>
											<? } ?>
											</center></td>
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
               <? include('footer.php'); ?>
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
