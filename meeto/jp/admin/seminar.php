<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- Mirrored from webthemez.com/demo/matrix-free-bootstrap-admin-template/table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 May 2016 11:33:21 GMT -->
<? include('header.php');
	include('config.php');
	include('condition.php'); ?>
	<script>
	function approvalsam(status,sid){
		$.ajax({
		url: "miss.php?kon=approvalsam&status="+status+"&sid="+sid, 
		type: "POST",
		success: function(data)
		{
			alert('セミナー '+status+' うまく');
			window.location.href='seminar.php';
		}
		});
	}
	function seminardetails(sid){
		window.location.href='seminardetails.php?sid='+sid;
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
                           
セミナー一覧
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               
				<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             
セミナー一覧
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>写真</th>
                                            <th>
タイトル</th>
                                            <th>
ホスト名</th>
											<th>ホストメール</th>
											<!--<th>Description</th>
                                            <th>Total Seat</th>
                                            <th>Booked Seat</th>-->
                                            <th>資格</th>
                                            <th>
承認状況</th>
                                            <th>
状態</th>
                                            <th>
アクション</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from seminar");
										while($data=mysql_fetch_array($query)){
											$detailquery = mysql_query("select * from user where id='".$data['uid']."' ");
											$detaildata=mysql_fetch_array($detailquery);
											$photoquery = mysql_query("select * from seminar_photos where seminar_id='".$data['id']."' ");
											$photodata=mysql_fetch_array($photoquery);
									?>
                                        <tr class="odd gradeX">
											<td>
											<?
												if(strlen($photodata["image"])>0){
											?>
												
												<img src="../../img/<? echo $photodata['image'];?>" width="70" height="70" class="img-circle" />
											<?
												}else{
											?>		
												<img src="../../img/no-photo.jpg" width="70" height="70" class="img-circle" />
											<?
												}
											?>
											</td>
                                            <td><? $marutra = explode('"',translate(str_replace(" ","+", $data['title']))); echo $marutra[1]; ?></td>
                                           
                                            <td><? $mf= $detaildata['fname']." ".$detaildata['lname']; $marutra = explode('"',translate(str_replace(" ","+",$mf))); echo $marutra[1]?></td>
                                            <td><? echo $detaildata['email']; ?></td>
											<!--<td><? echo $data['description']; ?></td>
                                            <td><? echo $data['total_seat']; ?></td>
                                            <td><? echo $data['total_booked_seat']; ?></td>-->
                                            <td><? $marutra = explode('"',translate(str_replace(" ","+",$data['qualification']))); echo $marutra[1] ; ?></td>
                                            <td><center><? if($data['approval_status']=='approved'){
											?>
												<i class="fa fa-thumbs-o-up" title="Approved Seminar" style="color:green;cursor:pointer;" onclick="approvalsam('rejected','<?php echo $data['id']; ?>');"></i>
											<?
											}else if($data['approval_status']=='rejected'){
											?>
												<i class="fa fa-thumbs-o-down" onclick="approvalsam('approved','<?php echo $data['id']; ?>');" title="Rejected seminar" style="color:red;cursor:pointer;"></i>
											<?
											}else{ ?>
												<span class="glyphicon glyphicon-remove" title="Reject Seminar" style="color:red; margin-right:5px;cursor:pointer;" onclick="approvalsam('rejected','<?php echo $data['id']; ?>');" ></span>
												<i class="fa fa-check" area-hidden="true" title="Approve Seminar" style="color:green;cursor:pointer" onclick="approvalsam('approved','<?php echo $data['id']; ?>');"></i>
												
											<? } ?>
											</center></td>
                                            <td><? if($data[20] == "rejected"){$marutra = explode('"',translate(str_replace(" ","+",'Rejected'))); echo $marutra[1] ;}elseif($data[20] == "approved"){ $marutra = explode('"',translate(str_replace(" ","+",'Approved'))); echo $marutra[1] ; }else{ $marutra = explode('"',translate(str_replace(" ","+","Pending"))); echo $marutra[1] ;} ?></td>
                                            <td><span class="fa fa-eye" title="View Details" style="cursor:pointer;" area-hidden="true" onclick="seminardetails('<?php echo $data['id']; ?>');"></span></td>
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
