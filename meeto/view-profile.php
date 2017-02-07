<?php 
require_once('db.php');
require_once('condition.php');   
$row = mysql_fetch_array(mysql_query("select * from user where id = $_REQUEST[id]"));
 $rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = $_REQUEST[id]")); 
 $rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = $_REQUEST[id]"));
 $rowuserlang=mysql_query("select * from user_language where uid = $_REQUEST[id]"); 
$countlist=mysql_num_rows(mysql_query("select * from seminar where uid = $_REQUEST[id]"));
$countwishlist=mysql_num_rows(mysql_query("select * from wishlist where uid = $_REQUEST[id]"));
?>
<!DOCTYPE html>
<html lang="en">  
<?php	require_once('head1.php'); ?>
	
<style>
header{
	position:fixed !important;
	background:#000 !important;	
}
.full-container{
	margin-top:130px;
	overflow-x:hidden;
	background-color:#f9f9f9;
}
a.dashboard_menu, a.dashboard_menu:hover{
	background-color:#f9f9f9 !important;
	color:#7323DC !important;
	border-bottom:none !important;
	font-weight:bold !important;
	border-top:5px solid #7323dc !important;
	padding-top:7px !important;
}
</style>

    
    <!-- NAVBAR================================================== -->
<body>   
<?php	require_once('header1.php');   ?>
<?php	require_once('usermenu.php');   ?>
<!-- pop up start -->
	<div class="container-flude full-container view_profile_page">	
	  <div class="container ">		
	    <div class="main_view_profile">
		
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<?php
						if($_SESSION['jpmeetou']['type']==2)
						{ 
                    ?>
                <img src="<?php echo $_SESSION['jpmeetou']['user_picture'] ?>" class="center-block img img-responsive dashboard-profile" style="width:100%; height:150px" />
                    <?php
						}
						elseif($rowuserdetail['photo']=="" || !file_exists("img/".$rowuserdetail['photo']))	
						{				
                    ?>						
                <img src="img/profile.png" class="center-block dashboard-profile"  style="width:100%; height:150px"  />						
                    <?php				
						}				
						else			
						{			
                    ?>				
                <img src="img/<?php echo $rowuserdetail['photo']; ?>" class="center-block img img-responsive dashboard-profile"  style="width:100%; height:150px"  />
                    <?php			
                    	}				
                    ?>
                <div class="verifierid">
                    <h2 class="profile-heads">Verifications</h2>
                    <div class="clearfix"></div>
                    <ul class="nav virify-method">
                        <li>
                        <div class="media-area">							
                                <?php 								
                                    if($row['email_verify']==0)			
                                    {							
                                ?>								
                            <!--<i class="img-not"></i>-->
                            <span class="glyphicon glyphicon-remove" style="color:red; margin-right:5px;"></span>			
                                <?php							
                                    }								
                                    else							
                                    {							
                                ?>		
                            <!--<i class="img-yes"></i>-->
                            <span class="glyphicon glyphicon-ok" style="color:green; margin-right:5px;"></span>
                                <?php				
                                    }				
                                ?>
                            
                            
                                <span class="emaild-text"> Email Address </span>
                            </div>
                        </li> 
                        <!-- <li>
                            <div class="media-area">
                            <!--<i class="img-not"></i>
                            <span class="glyphicon glyphicon-remove" style="color:red; margin-right:5px;"></span>
                            
                                <span class="emaild-text">Phone Number</span>
                            </div>
                        </li> -->
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="verifierid">
                    <h2 class="profile-heads">About List</h2>
                    <div class="clearfix"></div>
                    <ul class="nav virify-method about-me">
                        <!--<li>
                            <span class="emaild-text"><b>Company Description:</b> 								
                                <?php
                                   /* if($rowusercompany['description']=="" || empty($rowusercompany))	
                                    {				
                                    echo " Not Specified";
                                    }						
                                    else					
                                    {				
                                    echo $rowusercompany['description'];	
                                    }					
                                ?>
                            </span>
                        </li>
                        <li>
                            <span class="emaild-text"> <b>Company Name :</b> 								  								  
                                <?php				
                                    if($rowusercompany['name']=="" || empty($rowusercompany))							
                                    {						
                                    echo " Not Specified";
                                    }							
                                    else						
                                    {					
                                     echo $rowusercompany['name'];								
                                    }									
                                ?> 
                            </span>
                        </li>
                        <li>
                            <span class="emaild-text"><b>Languages :</b> 			
                                <?php						
                                    if(mysql_num_rows($rowuserlang)==0)							
                                    {			
                                    echo " Not Specified";						
                                    }						
                                    else		
                                    {		
                                        while($fetuserlang=mysql_fetch_array($rowuserlang))	
                                        {					
                                        $sellang=mysql_query("select * from language where id=$fetuserlang[lid]");					
                                        $fetlang=mysql_fetch_array($sellang);						
                                        $lang=$lang.$fetlang['name'].",";
                                    }									
                                    echo trim($lang,",");				
                                    }		*/							
                                  ?>
                            </span>
                        </li>-->
                        
                        <li>
                            <div class="opt_div"><!--emaild-text-->
                            	<a href="your-listing.php"><span>Listings  :</span> <span><b>(<?php echo $countlist; ?>)</b></span></a>
                            </div>                          
                             
                        </li>
                        <li>
                            <div class="opt_div"><!--emaild-text-->
                            	<a href="my-wish-list.php"><span>Wishlist :</span> <span><b>(<?php echo $countwishlist; ?>)</b></span></a>
                            </div>                          
                            
                        </li>
                    </ul>
				
                    <div class="clearfix"></div>
                </div>
					<div class="top-margin-20"></div>
            </div>
            			
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <div class="right_detail">	
                    <div class="right-profile">
                        <div class="namd-space"><?php echo $row['fname']." ".$row['lname'] ?></div>						
                        <div>						
                            <?php							
                                if(!empty($rowuserdetail) && $rowuserdetail['yourself'])							
                                {								
                                echo $rowuserdetail['yourself'];							
                                }						
                            ?>						
                        </div>
                    </div>
                    
                    <!--<div class="clearfix"></div>
                    <div class="top-margin-20"></div>-->
                    
                    <div class="comp_detail_div">
                    	<div class="head_div">About Me</div>
                        <div class="cont_div">
                        	<span>Company Name :</span>
                            <span>
                            	<?php				
                                    if($rowusercompany['name']=="" || empty($rowusercompany))							
                                    {						
                                    echo " Not Specified";
                                    }							
                                    else						
                                    {					
                                     echo $rowusercompany['name'];								
                                    }									
                                ?> 
                            </span>
                        </div>
                        <div class="cont_div">
                        	<span>Company Description :</span>
                            <span>
                            	<?php
                                    if($rowusercompany['description']=="" || empty($rowusercompany))	
                                    {				
                                    echo " Not Specified";
                                    }						
                                    else					
                                    {				
                                    echo $rowusercompany['description'];	
                                    }					
                                ?>
                            </span>
                        </div>
                        <div class="cont_div">
                        	<span>Languages :</span>
                            <span>
                            	<?php						
                                    if(mysql_num_rows($rowuserlang)==0)							
                                    {			
                                    echo " Not Specified";						
                                    }						
                                    else		
                                    {		
                                        while($fetuserlang=mysql_fetch_array($rowuserlang))	
                                        {					
                                        $sellang=mysql_query("select * from language where id=$fetuserlang[lid]");					
                                        $fetlang=mysql_fetch_array($sellang);						
                                        $lang=$lang.$fetlang['name'].",";
                                    }									
                                    echo trim($lang,",");				
                                    }									
                                  ?>
                            </span>
                        </div>
                    </div>
                    
                    <!--<div class="Listings-profile">
                        <label><a href="your-listing.php">Listings</a><span>(<?php //echo $countlist; ?>)</span></label>
                    </div>-->
                    
                    <div class="comp_detail_div">
                    	<div class="head_div">About Review</div>

						    <ul class="nav nav-tabs Review-tab" role="tablist">
								<li role="presentation" class="Listings-profile active">
									<a href="#home" aria-controls="home" role="tab" data-toggle="tab">
										<label>Your Review<span></span></label>
									</a>
								</li>
								
							<!--	<li role="presentation" class="Listings-profile">
									<a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
										<label>Host Review<span></span></label>
									</a>
								</li>-->
								
								<li role="presentation" class="Listings-profile">
									<a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">
										<label>User Review<span></span></label>
									</a>
								</li>
							</ul>
							
							<div class="tab-content tab-content-text">
					<div role="tabpanel" class="tab-pane active" id="home">
					  <div class="panel panel-default">
                        <div class="panel-heading">
                             Your Reviews
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
									 <?php
									 $rwuserid=$_SESSION['jpmeetou']['id'];
									 $semireview=mysql_query("select * from review where uid=$rwuserid");
								  if(mysql_num_rows($semireview)>0)
								  {
                                    ?>
								   <thead>
                                        <tr>
                                            <th><center>Seminar</center></th>
											<th><center>Reviews</center></th>
									    </tr>
                                    </thead>
                                    <tbody>
									<?php 
					            
                                  while($fetreview=mysql_fetch_array($semireview))
                                  {
									$seminar=mysql_fetch_array(mysql_query("select * from seminar where id='".$fetreview['seminar_id']."'"));
									?>
						             <tr class="odd gradeX">
											<td><?php echo $seminar['title'];?></td>
                                            <td><?php echo $fetreview['notes']; ?></td>
                                     </tr>
					              <?php
						          }  
								  }								  
						         ?>	
                                 </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
							 							 
					</div>
							 <!--  
							 <div role="tabpanel" class="tab-pane" id="profile">Host Review
							  </div>-->
							   <div role="tabpanel" class="tab-pane" id="messages">
							   <div class="panel panel-default">
                        <div class="panel-heading">
                             User Review
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
								 <?php 
								  $seminardetail=mysql_query("select * from seminar where uid = '".$_SESSION['jpmeetou']['id']."' order by created_date DESC");
								  if(mysql_num_rows($seminardetail)>0)
								  {
									$c=0;
						         ?>
								 
								 <?php
								  while($seminar=mysql_fetch_array($seminardetail))				
	                              {
					                $semireview=mysql_query("select * from review where seminar_id='".$seminar['id']."'");
								
                                     while($fetreview=mysql_fetch_array($semireview))
                                     {
										 
								      $user = mysql_fetch_array(mysql_query("select * from user where id='".$fetreview[uid]."'"));
										if($c==0)
										{
											$c=1;
									
									  ?>
									  <thead>
                                        <tr>
                                            <th><center>Username</center></th> 
											<th><center>Seminar</center></th>
                                            <th><center>Reviews</center></th>
											
											  
                                        </tr>
									
                                    </thead>
										<?php
										}
										?>
                                    <tbody>
                                        <tr class="odd gradeX">
											 <td><?php echo $user['fname'].$user['lname']; ?></td>
											 <td><?php echo $seminar['title']; ?></td>
											 <td><?php echo $fetreview['notes']; ?></td>
                                            
                                           
                                        </tr>
									<?php
										
						             }  
								  }	
								  if($c==0)
								  {
									  ?>
									  <tr class="odd gradeX">
											<td style="color:red;">No Records Found...!</td>
                                            
                                        </tr>
									  <?php
								  }
								}								  
						         ?>	
									
                                   </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
							  </div>
							</div>							
					</div>
				</div>
                    
                </div>
            </div>			
		</div>
	</div>
</div>

<div class="top-margin-20"></div>

<?php
require_once('footer1.php');
?>
<!-- footer END-->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>