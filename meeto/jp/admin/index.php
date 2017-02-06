<?php 
require_once('config.php');
require('condition.php');
require_once('header.php');
 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<script>
function countmaru(c1, id)
{
    var st = 1;
    var ed = c1;
    a = setInterval(function () {
            if (st <= ed)
            {
               $("#"+id).text(st);
				 st++;
                if (st == ed)
                {
                    clearInterval(a);
                }
            }       
    }, 300);
};
</script>
<body >
    <div id="wrapper">
        <? include('navbar.php'); ?>
        <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            
ダッシュボード <small>
あなたのWebの概要</small>
                        </h1>
                    </div>
                </div>
				
				
                <!-- /. ROW  -->

                <div class="row">
					<a href="seminar.php">
                     <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-red">
                            <div class="panel-left pull-left green">
                                <i class="fa fa-adjust fa-5x"></i>
                            </div>
                            <div class="panel-right pull-right">
							<?php
								$sel=mysql_query("select count(*) from seminar where approval_status='pending'");
								$fet=mysql_fetch_array($sel);
							?>
							<script>countmaru('<?php echo $fet[0]; ?>','das1');</script>
								<h3 id="das1">
								
								</h3>
                               <strong> 保留中のセミナー</strong>
                            </div>
                        </div>
                    </div>
					</a>
							<a href="user.php">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-blue">
                              <div class="panel-left pull-left blue">
                                <i class="fa fa-User fa-5x"></i>
								</div>
                            <div class="panel-right pull-right">
							<?php
								$sel=mysql_query("select count(*) from registration");
								$fet=mysql_fetch_array($sel);
								
							?>
							<script>countmaru('<?php echo $fet[0]; ?>','das2');</script>
								<h3 id="das2">
							
								</h3>
                               <strong> ユーザー </strong>
                            </div>
                        </div>
                    </div>
					</a>
					<a href="seminar.php">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-red">
                            <div class="panel-left pull-left red">
                                <i class="fa fa fa-Users fa-5x"></i>
                            </div>
                            <div class="panel-right pull-right">
							<?php
								$sel=mysql_query("select count(*) from seminar");
								$fet=mysql_fetch_array($sel);
								
							?>
								<script>countmaru('<?php echo $fet[0]; ?>','das33');</script>
								
								<script>countmaru(0,'noneche');</script>
								<h3 id="das33">
								
								</h3>
                               <strong> セミナー</strong>
                            </div>
                        </div>
                    </div>
                  </a>
                </div>
				
				
				
				
                

	   
		
		
			
				
				
				
				
                
                <!-- /. ROW  -->
				<? include('footer.php'); ?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    
</body>


<!-- Mirrored from webthemez.com/demo/matrix-free-bootstrap-admin-template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 May 2016 11:33:08 GMT -->
</html>