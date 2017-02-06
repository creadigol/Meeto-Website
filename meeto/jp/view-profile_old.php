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
<?php	
	require_once('head.php'); 
	?>
	<!-- NAVBAR================================================== -->
	<body>   
	<?php	require_once('header.php');   ?>
	<?php	require_once('usermenu.php');   ?>
	<!-- pop up start -->
	<div class="container-flude">	
	  <div class="container ">		
	    <div class="row">
	      				<div class="top-margin-20">&nbsp;</div>
				<div class="col-md-3">	
				<?php
				if($_SESSION['type']==2)
				{ 
				?>
				  <img src="<?php echo $_SESSION['user_picture'] ?>" class="center-block"  style="width:50%;" class="img img-responsive"/>
       			<?php
				}
					
				elseif($rowuserdetail['photo']=="" || !file_exists("img/".$rowuserdetail['photo']))	
				{				
				?>						
					<img src="img/profile.png" class="center-block" />						
				<?php				
				}				
				else			
				{			
				?>				
				<img src="img/<?php echo $rowuserdetail['photo']; ?>" class="center-block"  style="width:100%;" class="img img-responsive" />
				<?php			
				}				
				?>
					<div class="col-md-12">
						<div class="verifierid">
						  <h2 class="profile-heads">Verifications</h2>
						   <div class="clearfix"></div>
						  <ul class="nav virify-method">
							<li>							
							<?php 								
							if($row['email_verify']==0)			
								{							
							?>								
							<i class="img-not"></i>			
							<?php							
							}								
							else							
							{							
							?>		
							<i class="img-yes"></i>
							<?php				
							}				
							?>
								
								<div class="media-area">
								<span class="emaild-text"> Email Address </span>
								</div>
							</li> 
							<li>
								<i class="img-not"></i>
								<div class="media-area">
								<span class="emaild-text">Phone Number</span>
								</div>
							</li>
						  </ul>
						  <div class="clearfix"></div>
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="verifierid">
						  <h2 class="profile-heads">About Me</h2>
						   <div class="clearfix"></div>
								<ul class="nav virify-method about-me">
								  <li>
								  <span class="emaild-text"><b>Company Description:</b> 								
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
								  </li>
								  
								  <li>
								  <span class="emaild-text"> <b>Company Name :</b> 								  								  <?php				
								  if($rowusercompany['name']=="" || empty($rowusercompany))							
									  {						
								  echo " Not Specified";
								  }							
								  else						
									  {					
								     echo $rowusercompany['name'];								
								  }									?> </span>
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
									  }									
									  ?>
									  </span>
								  </li>
								 </ul>
						  <div class="clearfix"></div>
						</div>
					</div>
					 

				</div>			
				<div class="col-md-9">	
					<div class="right-profile">
						<label class="namd-space"><?php echo $row['fname']." ".$row['lname'] ?></label>						<div>						<?php							if(!empty($rowuserdetail) && $rowuserdetail['yourself'])							{								echo $rowuserdetail['yourself'];							}						?>						</div>
					</div>
					
					<div class="clearfix"></div>
					 <div class="top-margin-20"></div>
					
					<div class="Listings-profile">
						<label><a href="your-listing.php">Listings</a><span>(<?php echo $countlist; ?>)</span></label>
					</div>
					<div class="top-margin-10">&nbsp;</div>
					
					<div class="Listings-profile">
						<label>Review<span>(0)</span></label>
					</div>
					<div class="Listings-profile">
						<label>Host Review<span> (0)</span></label>
					</div>
					<div class="Listings-profile">
						<label>User Review<span> (0)</span></label>
					</div>

					<div class="top-margin-10">&nbsp;</div>
					
					<div class="Listings-profile">
						<label><a href="my-wish-list.php">Wishlist </a><span> (<?php echo $countwishlist; ?>)</span></label>
					</div>
					<div> 
					   <?php
					   $wishlist=mysql_query("select * from wishlist where uid = $_REQUEST[id]");
					   while($wishsid=mysql_fetch_array($wishlist))
					   { 
					   $seminarphoto=mysql_query("select * from seminar_photos where seminar_id='".$wishsid['seminar_id']."' limit 0,1");
					  $photos=mysql_fetch_array($seminarphoto);
					  ?>
					  <div class="col-xs-12 col-sm-6 col-md-4 img_div">
						<a href="infomation.php?id=<?php echo $photos['seminar_id'];  ?>">
						<img src="img/<?php echo $photos['image']; ?>" style="width:100%;height:180px;" class="center-block">
						</a>
					 </div>
					 <br> 
					 <?php  
					   }
					 ?>
					</div>
					
									
				</div>			
		</div>
	</div>
	<div class="top-margin-20">&nbsp;</div>
</div>

<?php
require_once('footer.php');
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