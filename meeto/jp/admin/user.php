<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<? include('header.php');
include('config.php');
include('condition.php'); 

if($_REQUEST[id]!="")
	{
		if($_REQUEST[shuup]=="dec")
		{
			$up=mysql_query("update user set status=0 where id=$_REQUEST[id]");
		}
		if($_REQUEST[shuup]=="act")
		{
			$up=mysql_query("update user set status=1 where id=$_REQUEST[id]");
		}
		header("location:user.php");
	}
		$ff=0;
if($_REQUEST['deluser']=="dd")
{
		$sel=mysql_query("select id from seminar where uid=$_REQUEST[idd]");
		while($fet=mysql_fetch_array($sel))
		{
			mysql_query("delete from seminar_day where seminar_id=$fet[id]");
			mysql_query("delete from seminar_industry where seminar_id=$fet[id]");
			mysql_query("delete from seminar_purpose where seminar_id=$fet[id]");
		}
		mysql_query("delete from seminar where uid=$_REQUEST[idd]");
		mysql_query("delete from user where id=$_REQUEST[idd]");
		$ff=1;
}
?>
 <script>
 function marudeleteuser(id,shu)
 {
	 if(shu==0)
	 {
		$dd='<h4 style="color:red;font-weight:bolder;">消去してもよろしいですか...？</h4>';
		$dd+='<div class="col-md-2 col-md-offset-7 btn btn-primary" style="margin-right:2px;" onclick="marudeleteuser('+id+',1);">';
		$dd+='Ok</div>';
		$dd+='<div class="col-md-2 btn btn-danger" onclick="facilityshow();">';
		$dd+='キャンセル</div>';
		$("#deleteusermsg").html($dd);
		$("#hidenewfac").toggle(100);	
	 }
	 else if(shu==1)
	 {
		 window.location.href="user.php?deluser=dd&idd="+id;
	 }
 }
 function facilityshow()
	{
		$dd='<h4 style="color:red;font-weight:bolder;">最初にこのユーザーを無効にしてから削除してください...！</h4>';
		$dd+='<div class="col-md-2 col-md-offset-10 btn btn-danger" onclick="facilityshow();">';
		$dd+='閉じる</div>';
		$("#deleteusermsg").html($dd);
		$("#hidenewfac").toggle(100);
	}
</script>
<style>
        .upperdivche
        {
			
           display:none;
        }
        </style>
<body>
<div class="upperdivche" id='hidenewfac' style='width:100%;height:149%;background: rgba(0,0,0,0.5);padding: 2%;position: fixed;z-index: 999;'>
		<div class="row" >
			<div class="col-md-12">
			<br><br><br><br><br><br><br><br><br><br><br><br>
				<div class="col-md-5 col-md-offset-4" style="border:1px solid #333; background:#fff">
					
                    <div class="col-md-12 page-header">
						<div  class="col-md-6" align="left" style="color:black;">
                        <h3 >
                            削除
                        </h3>
						</div>
                    </div>
					<div class="col-md-12" id="deleteusermsg" style="padding:20px;"> 
						
					</div>
             
				</div>
				
			</div>
		</div>
</div>
<?php
	if($ff==1)
	{
		?>
		<div class="" id='hidenewfac12' style='width:100%;height:149%;background: rgba(0,0,0,0.5);padding: 2%;position: fixed;z-index: 999;'>
		<div class="row" >
			<div class="col-md-12">
			<br><br><br><br><br><br><br><br><br><br><br><br>
				<div class="col-md-5 col-md-offset-4" style="border:1px solid #333; background:#fff">
					
                    
					<div class="col-md-12" id="deleteusermsg" style="padding:20px;"> 
						<h4 style="color:green;font-weight:bolder;">削除に成功しました...</h4>
						<div class="col-md-2 col-md-offset-10 btn btn-primary" onclick="$('#hidenewfac12').hide();">
						Ok</div>
					</div>
             
				</div>
				
			</div>
		</div>
</div>
		<?php
	}
?>
    <div id="wrapper">
        <? include('navbar.php'); ?>
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            ユーザーリスト
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             ユーザーリスト
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>
写真</th>
                                            <th>
名</th>
                                            <th>Eメール</th>
                                            <th>
電話番号。</th>
	<th>状態</th>
	<th>削除</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from user order by id desc");
										while($data=mysql_fetch_array($query)){
											$detailquery = mysql_query("select * from user_detail where uid='".$data['id']."' ");
											$detaildata=mysql_fetch_array($detailquery);
									?>
                                        <tr class="odd gradeX">
											<td>
											<?
												if(strlen($detaildata["photo"])>0){
												
												if($data[type] == 2){
											?>
												<img src="<? echo $detaildata['photo'];?>" width="70" height="70" class="img-circle" />
											<?
												}else{
											?>
												<img src="../../img/<? echo $detaildata['photo'];?>" width="70" height="70" class="img-circle" />
											<?
												}
												}else{
											?>		
												<img src="../../img/no-photo.jpg" width="70" height="70" class="img-circle" />
											<?
												}
											?>
											</td>
                                            <td><a href="user_detail.php?user_id=<? echo $data['id']; ?>" /><? $myf=$data['fname']." ".$data['lname']; $marutra = explode('"',translate(str_replace(" ","+",$myf))); echo $marutra[1];?></a></td>
                                            <td><? $marutra = explode('"',translate(str_replace(" ","+",$data['email']))); echo $marutra[1] ; ?></td>
                                            <td><? $marutra = explode('"',translate(str_replace(" ","+",$detaildata['phoneno']))); echo $marutra[1] ; ?></td>
											<? if($data['status']==1){
											?>
												<td><center><i class="fa fa-thumbs-o-up" title="Active" style="color:green;cursor:pointer;" onclick="window.location='user.php?id=<?php echo $data['id'];?>&shuup=dec'"></i></center></td>
												<td>
												<center><i class="fa fa-trash-o" title="Active" style="color:red;cursor:pointer;"onclick="facilityshow();"></i></center>
											</td>
											<?
											}else{
											?>
												<td><center><i class="fa fa-thumbs-o-down" onclick="window.location='user.php?id=<?php echo $data['id'];?>&shuup=act'" title="Inactive" style="color:red;cursor:pointer;"></i></center></td>
												<td>
												<center><i class="fa fa-trash-o" title="Active" style="color:red;cursor:pointer;"onclick="marudeleteuser('<?php echo $data['id']; ?>',0)"></i></center>
											</td>
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
			<? include('footer.php'); ?>
        </div>
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
    
   
</body>

<!-- Mirrored from webthemez.com/demo/matrix-free-bootstrap-admin-template/table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 May 2016 11:33:25 GMT -->
</html>
