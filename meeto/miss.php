<?php

require_once('db.php');
$missid=$_SESSION['jpmeetou']['id'];
if($_REQUEST['kon']=="setstate")
{ 
?>
<option value="">-- Select State -- </option>
<?php
	$selcity=mysql_query("select * from states where country_id=$_REQUEST[id] order by name");
	while($fetcity=mysql_fetch_array($selcity))
	{
?>
		<option value="<?php echo $fetcity[0]; ?>"><?php echo $fetcity['name']; ?></option>
<?php
		
	}
}
if($_REQUEST['kon']=="setcity")
{ 
?>
<option value="">-- Select City -- </option>
<?php
	$selcity=mysql_query("select * from cities where state_id=$_REQUEST[id] order by name");
	while($fetcity=mysql_fetch_array($selcity))
	{
?>
		<option value="<?php echo $fetcity[0]; ?>"><?php echo $fetcity['name']; ?></option>
<?php
		
	}
}
?>
<?php
if($_REQUEST['kon']=='listseminar')	
{	
	if($_REQUEST['did']!="")
	{
		$del=mysql_query("delete from seminar where id=$_REQUEST[did]");
	}
	if($_REQUEST['status']=="")
		$seminardetail=mysql_query("select * from seminar where uid = '".$missid."' order by created_date DESC");		
	elseif($_REQUEST['status']==APPROVED)
		$seminardetail=mysql_query("select * from seminar where uid = '".$missid."' and approval_status='".APPROVED."' order by created_date DESC");		
	elseif($_REQUEST['status']==PENDING)
		$seminardetail=mysql_query("select * from seminar where uid = '".$missid."'  and approval_status='".PENDING."' order by created_date DESC");			
	while($seminar=mysql_fetch_array($seminardetail))				
	{
   
?>

	<div class="row listing-img-button">	
		<a href="infomation.php?id=<?php echo $seminar['id']; ?>">
		<div class="col-md-3">		
		<?php						
			$seminarphoto=mysql_fetch_array(mysql_query("select * from seminar_photos where seminar_id = '".$seminar['id']."' limit 0,1"));		
			if($seminarphoto['image']=="" || !file_exists("img/".$seminarphoto['image']))	
			{?>	
               <img src="img/no-photo.jpg" class="img-responsive center-block" style="width:100%; height:150px"  />		
            <?
			}
			else
			{?>
			   <img src="img/<?php echo $seminarphoto['image']; ?>" style="transform:rotate(<?php echo $seminarphoto['rotateval']; ?>deg);" class="img-responsive center-block">	
			<?
			}
            ?>			
		</div>		
		</a>
		<div class="col-md-3 text-center">
			<a href="infomation.php?id=<?php echo $seminar['id']; ?>">
			<h4 class="semibold-o black-tetx"><?php echo  $seminar['title'];?></h4>
			<h5 class="semibold-o black-tetx"><?php echo  $seminar['tagline'];?> </h5></a>
			<?php if($seminar['status']=='0'){?>
			<h5 class="forgot">*Seminar Expired*</h5>
			<?
			 }
			?>
			
		</div>
		<div class="col-md-2 col-xs-4 text-center steps-button">
			<a href="Editseminar.php?id=<?php echo $seminar['id']; ?>" class="blue-button steps-button-list"><i class="fa fa-pencil"></i></a>
		</div>
		<div class="col-md-2 col-xs-4 text-center steps-button">
			<a href="viewlisting.php?id=<?php echo $seminar['id']; ?>" class="blue-button steps-button-list"><i class="fa fa-eye"></i></a>
		</div>
		<div class="col-md-2 col-xs-4 text-center steps-button">
			<a href="#" class="blue-button steps-button-list" onclick="showlisting('','<?php echo $seminar['id']; ?>','<?php echo $_REQUEST['status']; ?>')"><i class="fa fa-trash-o"></i></a>
		</div>
	</div>						
	<?  					
	}		
}				
?>

<?php
if($_REQUEST['kon']=='viewlisting')	
{	
	$samquery=mysql_query("select * from `seminar` where `id` = $_REQUEST[sid]");
	$sam=mysql_fetch_array($samquery);
	$seminarphoto=mysql_fetch_array(mysql_query("select * from  seminar_photos where seminar_id=$_REQUEST[sid] "));
	?>
		
	<div class="col-md-12 reservation">
	    
	    <span>
		<?
		if($seminarphoto['image']=="" || !file_exists("img/".$seminarphoto['image']))	
			{?>	
               <img src="img/no-photo.jpg" class="seminar-title-img img-responsive" style="width:100%; height:150px"  />		
            <?
			}
			else
			{?>
		     <img src="img/<?php echo $seminarphoto['image']; ?>"  style="transform:rotate(<?php echo $seminarphoto['rotateval']; ?>deg)" class="seminar-title-img img-responsive">
			<?
			}
			?>
		<a class="seminar-title" href="infomation.php?id=<?php echo $_REQUEST['sid'];?>"<h4 class="semibold-o black-tetx"><?php echo  $sam['title'];?></h4></a></span>
		
		<?php 
		$seminardetail=mysql_query("select * from `seminar_booking` where `seminar_id` = $_REQUEST[sid] order by created_date DESC");
		if(mysql_num_rows($seminardetail)>0)
		{
		?>
		
								<table width="100%">
									<thead>
										<tr height="40px" class="table-padding table-head">
											<td style="width:100px;"><strong><strong>User </strong></strong></td>
											<td style="width:100px"><strong>Name</strong></td>
											<td style="width:100px"><strong>Email</strong></td>
											<td style="width:140px"><strong>Booked Seat</strong></td>
											
										</tr>
									</thead>
	<?php	
	while($seminar=mysql_fetch_array($seminardetail))				
	{	
		$userquery=mysql_query("select * from `user` where `id` = $seminar[uid] ");
		$user=mysql_fetch_array($userquery);
		$userdetailquery=mysql_query("select * from `user_detail` where `uid` = $seminar[uid] ");
		$userdetail=mysql_fetch_array($userdetailquery);
?>
	 
	<tbody>					
										<tr class="table-padding">	
										<td>
										<?php if($user['type'] == 2){?>
										<img src="<?php echo $userdetail['photo']; ?>" width="100" height="100" alt="<?php echo $user['fname']." ".$user['lname']." photo"; ?>"class="table-img">
										<?php }else{?>
										<img src="img/<?php echo $userdetail['photo']; ?>" width="100" height="100" alt="<?php echo $user['fname']." ".$user['lname']." photo"; ?>"class="table-img">
										<?php } ?></td>		
										<td><?php echo $user['fname']." ".$user['lname']; ?></td>					
										<td><?php echo $user['email']; ?></td>								
										<td><?php echo $seminar['book_seat']; ?></td>								
										</tr>								
										</tbody>						
					<?  					
					}	
					?>
								</table>
		           <?
				   }
				   else
				   {?>
			        <div class="clearfix"></div><br/><br/>	
					<div><center>Seminar Did Not Book Anyone</center></div>
				   <?}
				   ?>
	</div>
<?	
}				
?>


<?php
if($_REQUEST['kon']=='setwishlist')
{
	$fetseminar=mysql_fetch_array(mysql_query("select * from seminar where id=$_REQUEST[id] and status=1"));
	$fetsemiphoto=mysql_fetch_array(mysql_query("select * from seminar_photos where seminar_id=$_REQUEST[id] limit 0,1"));
?>

	<div class="modal-dialog">
							  <!-- Modal content-->
	  <div class="modal-content modal-c">
		<div class="modal-header model-head">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Save to Wish List</h4>
		</div>
		<div class="modal-body">
		  <div class="row">
			<div class="col-md-12 text-center">
				<img src="img/<?php echo $fetsemiphoto['image']; ?>" style="transform:rotate(<?php echo $fetsemiphoto['rotateval']; ?>deg); height:200px;" class="img-responsive center-block seminar-pop-img">
				
				<h4 class="semibold-o black-tetx"><?php echo $fetseminar['title']; ?></h4>
				<h5 class="black-tetx"><?php echo $fetseminar['tagline']; ?></h5>
			</div>
			<div class="col-md-8 col-md-offset-2 text-center seminar-pop">
			<div class="top-margin-10"></div>	
				<span>Add Notes</span>
				<textarea name="add-notes" class="add-notes" id="wishnotes" rows="5" placeholder='note...'></textarea>
			<div class="top-margin-10"></div>	
			</div>
		
			<div class="col-md-12 text-center seminar-pop">
				<div class="modal-footer">
				  <button type="button" onclick="addtowishlist(<?php echo $_REQUEST['id']; ?>);" class="blue-button f-right border-n" data-dismiss="modal">Done</button>
				</div>									
			</div>									
		  </div>
		</div>
	  </div>
	  
	</div>
<?php
}
if($_REQUEST['kon']=='addwishlist')
{
	$micro=round(microtime(true)*1000);
	$wishid=$_SESSION['jpmeetou']['id'];
	$inwish=mysql_query("insert into wishlist (seminar_id,uid,notes,created_date,modified_date,status) values ($_REQUEST[id],$wishid,'$_REQUEST[note]','$micro','$micro',1)");
}
?>

<?php
if($_REQUEST['kon']=='cityseminarlist')
{    
     $startdate1 = $_REQUEST['startdate'];
	 $startdate =strtotime($startdate1) * 1000;
	 $enddate1 = $_REQUEST['enddate'];
	 $enddate =strtotime($enddate1) * 1000;
	
	//$startdate=$_REQUEST['startdate'];
	//$enddate=$_REQUEST['enddate'];
   
	$array=array_map('intval', explode(',', $_REQUEST['purposeid']));
    $purposeid = implode("','",$array);
	
	$industry=array_map('intval', explode(',', $_REQUEST['industryid']));
    $industryid = implode("','",$industry);
	
	$semitype=array_map('intval', explode(',', $_REQUEST['semitype']));
    $semitype = implode("','",$semitype);
	 
    //echo "<script>alert($array);</script>";
   
	
	if($_REQUEST['enddate'])
	{  
	   if($_REQUEST['purposeid']!="")
		{
			if($_REQUEST['industryid']!="")
			{
			  if($_REQUEST['semitype']!="")
			  {
				// echo "all selected";
			     $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and approval_status='approved' and typeid in('".$semitype."') and id in (SELECT seminar_id FROM `seminar_day` WHERE `from_date` BETWEEN '".$startdate."' AND '".$enddate."' or `to_date` BETWEEN '".$startdate."' and  '".$enddate."' and `from_date`<='".$startdate."' and `to_date`>='".$enddate."') and id in (select seminar_id from seminar_purpose where attendees_id in ('".$purposeid."')) and id in (select seminar_id from seminar_industry where industry_id in ('".$industryid."')) "); 
			  }
			  else
			  {
				//  echo "purpose & date & industry";
				 $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved'  and id in (SELECT seminar_id FROM `seminar_day` WHERE `from_date` BETWEEN '".$startdate."' AND '".$enddate."' or `to_date` BETWEEN '".$startdate."' and  '".$enddate."' and `from_date`<='".$startdate."' and `to_date`>='".$enddate."') and id in (select seminar_id from seminar_purpose where attendees_id in ('".$purposeid."')) and id in (select seminar_id from seminar_industry where industry_id in ('".$industryid."')) ");  
				  
			  }
			 
			}
			else
			{
				if($_REQUEST['semitype']!="")
				{
				//echo "type & date & purpose";
			    $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and typeid in('".$semitype."') and id in (SELECT seminar_id FROM `seminar_day` WHERE `from_date` BETWEEN '".$startdate."' AND '".$enddate."' or `to_date` BETWEEN '".$startdate."' and  '".$enddate."' and `from_date`<='".$startdate."' and `to_date`>='".$enddate."') and id in (select seminar_id from seminar_purpose where attendees_id in ('".$purposeid."')) ");
				}
				else
				{
				//echo "date & purpose";
			   $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and id in (SELECT seminar_id FROM `seminar_day` WHERE `from_date` BETWEEN '".$startdate."' AND '".$enddate."' or `to_date` BETWEEN '".$startdate."' and  '".$enddate."' and `from_date`<='".$startdate."' and `to_date`>='".$enddate."') and id in (select seminar_id from seminar_purpose where attendees_id in ('".$purposeid."')) ");
				}
			}
			
		}
		else
		{ 
	        if($_REQUEST['industryid']!="")
			{
				if($_REQUEST['semitype']!="")
				{
				//echo "type & date & industry";
				$selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and typeid in('".$semitype."') and id in (SELECT seminar_id FROM `seminar_day` WHERE `from_date` BETWEEN '".$startdate."' AND '".$enddate."' or `to_date` BETWEEN '".$startdate."' and  '".$enddate."' or (`from_date`<='".$startdate."' and `to_date`>='".$enddate."')) and id in (select seminar_id from seminar_industry where industry_id in ('".$industryid."'))");	
				}
				else
				{
				// echo "date & industry";
				$selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and id in (SELECT seminar_id FROM `seminar_day` WHERE `from_date` BETWEEN '".$startdate."' AND '".$enddate."' or `to_date` BETWEEN '".$startdate."' and  '".$enddate."' or (`from_date`<='".$startdate."' and `to_date`>='".$enddate."')) and id in (select seminar_id from seminar_industry where industry_id in ('".$industryid."'))");	
				}	
			}
			else
			{ 
		       if($_REQUEST['semitype']!="")
			   {
				// echo "type & date";
			   $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and typeid in('".$semitype."') and id in (SELECT seminar_id FROM `seminar_day` WHERE `from_date` BETWEEN '".$startdate."' AND '".$enddate."' or `to_date` BETWEEN '".$startdate."' and  '".$enddate."' or (`from_date`<='".$startdate."' and `to_date`>='".$enddate."'))"); 
			   }
			   else
			   {
				//echo "only date";
			   $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and id in (SELECT seminar_id FROM `seminar_day` WHERE `from_date` BETWEEN '".$startdate."' AND '".$enddate."' or `to_date` BETWEEN '".$startdate."' and  '".$enddate."' or (`from_date`<='".$startdate."' and `to_date`>='".$enddate."'))"); 
			   
			   }
				
			}
		}  
	}
    else
	{
		if($_REQUEST['purposeid']!="")
		{
           if($_REQUEST['industryid']!="")
           {
			   if($_REQUEST['semitype']!="")
			   {
				 // echo "type & industry & purpose";
		         $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and typeid in('".$semitype."') and id in (select seminar_id from seminar_purpose where attendees_id in ('".$purposeid."')) and id in (select seminar_id from seminar_industry where industry_id in ('".$industryid."'))");  
			   }
			   else
			   {
			  // echo "industry & purpose";
		       $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and id in (select seminar_id from seminar_purpose where attendees_id in ('".$purposeid."')) and id in (select seminar_id from seminar_industry where industry_id in ('".$industryid."'))");
			   
			  
			   }
			   
		   }	
   		 else
		  {
			  if($_REQUEST['semitype']!="")
			  {
			 //echo "type & purpose";
		     $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and typeid in('".$semitype."') and id in (select seminar_id from seminar_purpose where attendees_id in ('".$purposeid."'))");   
			  }
			  else
			  {
			// echo "only purpose";
		     $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and id in (select seminar_id from seminar_purpose where attendees_id in ('".$purposeid."'))");   
			  }
			
            // echo "select * from seminar where cityid=$_REQUEST[cityid] and approval_status='approved' and id in (select seminar_id from seminar_purpose where attendees_id in ('".$purposeid."'))";			 
		  }		   
		}
		else
		{ 
	       if($_REQUEST['industryid']!="")
		   {
			   if($_REQUEST['semitype']!="")
			   {
				// echo "type & industry";
		       $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and typeid in('".$semitype."') and id in (select seminar_id from seminar_industry where industry_id in ('".$industryid."')) order by created_date DESC");  
			   }
			   else
			   {
			//  echo "only industry";
		       $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and id in (select seminar_id from seminar_industry where industry_id in ('".$industryid."')) order by created_date DESC");  
			   }
			  			 
		   }
		   else
		   {
			   if($_REQUEST['semitype']!="")
			   {
			//	 echo "only type";
		      $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' and typeid in('".$semitype."') order by created_date DESC");  
			   }
			   else
			   {
			 // echo "nothing select";
		      $selseminar=mysql_query("select * from seminar where cityid=$_REQUEST[cityid] and status='1' and approval_status='approved' order by created_date DESC"); 
			 // echo "select * from seminar where cityid=$_REQUEST[cityid] and approval_status='approved' order by created_date DESC";
			   }
			    
		   }
	     	
		}
	}	
	if(mysql_num_rows($selseminar)>0)
	{
		 while($fetseminar=mysql_fetch_array($selseminar))
		 {
			$selsemiphoto=mysql_query("select * from seminar_photos where seminar_id=$fetseminar[id] limit 0,1");
			$fetsemiphoto=mysql_fetch_array($selsemiphoto);
			$selsemitype=mysql_query("select * from seminar_type where id=$fetseminar[typeid]");
			$fetsemitype=mysql_fetch_array($selsemitype);
			$seluser=mysql_query("select * from user where id=$fetseminar[uid]");
			$fetuser=mysql_fetch_array($seluser);
			
			$seluserdetail=mysql_query("select * from user_detail where uid=$fetseminar[uid]");
			$fetuserdetail=mysql_fetch_array($seluserdetail);
			$seminarcity=mysql_fetch_array(mysql_query("select * from cities where id='".$_REQUEST['cityid']."' "))
?>
		<div class="col-xs-12 office-img-text" style="padding-right:0;">
            <div class="box-height">
                <a class="img_bar" href="infomation.php?id=<?php echo $fetseminar['id']; ?>">
                    <!--<img src="img/<?php /*echo $fetsemiphoto['image'];*/ ?>" class="img-responsive center-block img-width" style="width:100%;height:240px;"/>-->
                    <div class="img_div" style="background-image:url(img/<?php echo $fetsemiphoto['image']; ?>);transform:rotate(<?php echo $fetsemiphoto['rotateval']; ?>deg);"></div>
                </a>
                <div class="host_info">
                    
                    <div class="seminar_info">
                       <a href="infomation.php?id=<?php echo $fetseminar['id']; ?>">
						<div class="seminar_name"><?php echo $fetseminar['title']; ?></div>
					   </a>
                        <div class="host_name"><?php echo $fetseminar['tagline']; ?></div><!--tag line-->
                    </div>
                    <div class="sem_on_det">
						<div style="margin-bottom:7px;">
							<span>Seminar Place :</span><span><?php echo $fetsemitype['name']; ?></span>
						</div>
						<div>
							<span>Seminar City :</span><span><?php echo $seminarcity['name']; ?></span>
						</div>
                    </div>
					   
                    <div class="sem_dit_div">
                        <div class="oner_detail">
						<?php 
						if($fetuser['type']==2)
						{?>
							<span class="host_logo" style="background-image:url(<?php if($fetuserdetail['photo']!="") echo $fetuserdetail['photo']; else echo 'profile.png'; ?>);"></span><span><?php echo $fetseminar['hostperson_name']; ?></span>
						<?php
						}
						else
						{?>
							<span class="host_logo" style="background-image:url(img/<?php if($fetuserdetail['photo']!="") echo $fetuserdetail['photo']; else echo 'profile.png'; ?>);"></span><span><?php echo $fetseminar['hostperson_name']; ?></span>
						
						<?php
						}
						?>
                        </div>
                        <div class="btn_bar_div">
                            <div class="wish_list_div">
                                <?php
                                        if(isset($_SESSION['jpmeetou']['id']))
                                        {
                                            $seluserwish=mysql_query("select * from wishlist where seminar_id=$fetseminar[id] and uid=$missid");
                                            if(mysql_num_rows($seluserwish)>0)
                                            {
                                    ?>
                                <i class="fa fa-heart-o wish_list" style="color:#fff;background:#e62878;pointer-events:none;" data-toggle="modal" data-target="#myModal" aria-hidden="true" ></i> 
                                    <?php
                                            }
                                            else
                                            {
                                    ?>
                                <i class="fa fa-heart-o wish_list" style="" data-toggle="modal" data-target="#myModal" aria-hidden="true" onclick="showwishlist('<?php echo $fetseminar['id']; ?>');" ></i> 
                                    <?php
                                            }
                                        }
                                        else
                                        {			
                                    ?>
                                <i class="fa fa-heart-o wish_list" style="color:#e62878; /*background:#fff;*/" data-toggle="modal" data-target="#myModal" aria-hidden="true" onclick="showlogin();" ></i> 
                                    <?php	
                                        }
                                    ?>
                            </div>
							<?php
								if(isset($_SESSION['jpmeetou']['id']))
								{
									$seluserwish=mysql_query("select * from seminar_booking where seminar_id=$fetseminar[id] and uid=$missid");
									if(mysql_num_rows($seluserwish)>0)
									{
							?>
								<a href="infomation.php?id=<?php echo $fetseminar['id']; ?>">
									<!--<button class="border-n blue book-button bule-smaal">BOOK</button>-->
									<div style="color:white; background-color:#7323DC" class="book_btn">Book</div>
								</a><!--blue-button-->
							<?php
									}
									else
									{
							?>
								<a href="infomation.php?id=<?php echo $fetseminar['id']; ?>">
									<!--<button class="border-n blue book-button bule-smaal">BOOK</button>-->
									<div class="book_btn">Book</div>
								</a><!--blue-button-->
							<?php
									}
								}
								else
								{
							?>
								<a href="infomation.php?id=<?php echo $fetseminar['id']; ?>">
									<!--<button class="border-n blue book-button bule-smaal">BOOK</button>-->
									<div class="book_btn">Book</div>
								</a><!--blue-button-->
							<?php
								}
							?>
                        </div>
                    </div>
                </div>
                
                    
                
                    
                <!--<img src="img/<?php /*if($fetuserdetail['photo']!="") echo $fetuserdetail['photo']; else echo 'profile.png';*/ ?>" class="img-responsive small-img" />-->
                    
                    
                    
                    <!--<div class="top-margin-10"></div>-->
                    <!--<span><?php /*echo $fetseminar['title'];*/ ?></span>-->
                    <!--<p><?php /*echo $fetsemitype['name'];*/ ?>-<?php /*echo $fetseminar['hostperson_name'];*/ ?></p>-->
                    
                    <!--<div class="bottom-margin-20">&nbsp;</div>-->
            </div>
        </div>
<?php
	 }
	}
	else
	{
		 ?>
		
			<div class="col-md-12" >
				<div align="center" style="color:red;font-weight:bold;">
							Seminar Not Found In This City...!
				</div>
			</div>
		 <?php
	}
			
}
elseif($_REQUEST['kon']=="deletephoto")
{
    $deletephoto=mysql_query("delete from seminar_photos where id='".$_REQUEST['id']."'");
	//echo "delete from seminar_photos where id='".$_REQUEST['id']."'";
}
elseif($_REQUEST['kon']=="wishlist")
{		
	if($_REQUEST['did']!="")
	{
		 $deletephoto=mysql_query("delete from wishlist where id=$_REQUEST[did]");
	}
	$shosiwh=$_SESSION['jpmeetou']['id'];
	 $selwish=mysql_query("select * from wishlist where uid=$shosiwh");		
	 if(mysql_num_rows($selwish)>0)
	{
	 while($fetwish=mysql_fetch_array($selwish))		
	{		
      $selsemidetail=mysql_query("select * from seminar where id=$fetwish[seminar_id] and status=1");			
	  $fetsemidetail=mysql_fetch_array($selsemidetail);
	  $numrow=mysql_num_rows($selsemidetail);
	  if($numrow>=1)
	  {
	  $selsemiphoto=mysql_query("select * from seminar_photos where seminar_id=$fetwish[seminar_id]");		
?>		
        <div class="row noMargin main_row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">		
                <div id="myCarousel" class="carousel-small carousel carousel-width slide" data-ride="carousel">					
                <!-- Indicators -->		
                    <ol class="carousel-indicators carousel-indicators-small">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>		
                        <li data-target="#myCarousel" data-slide-to="2"></li>		
                    </ol>					
                <!-- Wrapper for slides -->	
                    <div class="carousel-inner carousel-inner-small" role="listbox">
                            <?php						
                            $i=0;						
                            while($fetsemiphoto=mysql_fetch_array($selsemiphoto))	
                                {					
                               $i++;					
                            ?>						
                        <div class="item item-small <?php if($i==1) echo 'active'; ?>">					
                            <img src="img/<?php echo $fetsemiphoto['image'] ?>" style="transform:rotate(<?php echo $fetsemiphoto['rotateval']; ?>deg);"  alt="Chania" >					
                        </div>	
                            <?php		
                                }				
                                $i=0;			
                            ?>				
                    </div>			
                <!-- Left and right controls -->	
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">					  
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>					 
                        <span class="sr-only">Previous</span>				
                    </a>					
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>					  
                        <span class="sr-only">Next</span>			
                    </a>				
                </div>			
            </div>				
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wish-border wish_detail">			
                <h4>					
                    <a href="infomation.php?id=<?php echo $fetwish['seminar_id']; ?>" class=""><?php echo $fetsemidetail['title']; ?></a>				
                </h4>	
                <span><?php echo $fetsemidetail['tagline']; ?></span>
                <!--<div class="bottom-margin-10"></div>-->
                <p><?php echo $fetwish['notes']; ?></p>		
            </div>		
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center wish-border wish_detail">
            	<button class="blue-button border-n" onclick="wishlist('<?php echo $fetwish['id'];?>');">Delete</button>	
            </div>		
        </div>	
<?php	
		}
	}
	}
	else
	{
		?>
			<div style="color:red;font-weight:bold;padding:10px;" align="center">
				Seminars not in wish list...!
			</div>
		<?
	}
}
if($_REQUEST['kon']=="seminarstatus")
{
  $bookid=$_REQUEST['bid'];
  $status=$_REQUEST['status'];
  $status1=mysql_query("update seminar_booking set approval_status='".$status."' where id='".$bookid."'");
 
  $bookseminar=mysql_fetch_array(mysql_query("select * from seminar_booking where id='".$bookid."'"));
  $userdetail=mysql_fetch_array(mysql_query("select * from user where id='".$bookseminar['uid']."'"));
  $seminardetail=mysql_fetch_array(mysql_query("select * from seminar where id='".$bookseminar['seminar_id']."'"));
  if($status=='declined')
  {
	$fetseminar=mysql_fetch_array(mysql_query("select * from seminar where id='".$bookseminar['seminar_id']."'"));
    $totalseats= $fetseminar['total_booked_seat']-$bookseminar['book_seat'];
    $upsemi=mysql_query("update seminar set total_booked_seat='".$totalseats."' where id='".$bookseminar['seminar_id']."'");
  }
  
  
   echo $bookseminar['approval_status'];
   
        if($status)
        {
	        $email= $userdetail['email'];
            $to = $email;
			$subject = "Seminar Booking Ticket";
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: <creadigol.in@gmail.com>' . "\r\n";
			
			$message  = '<html>';	
			$message .= '<body>';
			$message .= '<h2>Your Seminar Booking is '.$status.'</h2>';
			$message .= '<table>';
			
			$message .= '<tr>';
			$message .= '<td>Seminar Title : '.$seminardetail['title'].'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td>Your Booked Seats : '.$bookseminar['book_seat'].'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td> From date : '.date("Y-m-d",$bookseminar['from_date']/1000).'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td> To date : '.date("Y-m-d",$bookseminar['to_date']/1000).'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td>Your Ticket No : '.$bookseminar['booking_no'].'</td>';
			$message .= '</tr>';
			$message .= '</table>';
			$message .= '</div>';
			$message .= '</body>';
			$message .= '</html>';
			
			$sentmail = mail($to,$subject,$message,$headers);
          }
 
}
if($_REQUEST['kon']=="booked")
{
 
  ?>
						<div class="col-md-12 col-sm-12 col-xs-12">
										<ul class="nav dawonlod-ticket-pop-up">
										<?php
										$bookedtiket=mysql_fetch_array(mysql_query("select * from seminar_booking where id='".$_REQUEST['btid']."'"));
                                        $bookedseminar=mysql_fetch_array(mysql_query("select * from seminar where id='".$bookedtiket['seminar_id']."'"));
										
										?>
											<li>
												<div class="col-md-4 col-sm-4 col-xs-12 text-right download-text"><strong>User Name :</strong></div>
												<div class="col-md-8 col-sm-8 col-xs-12 download-margin"><?php echo $_SESSION['jpmeetou']['fname'];?> <?php echo $_SESSION['jpmeetou']['lname']; ?> </div>
											</li>
											<li>
												<div class="col-md-4 col-sm-4 col-xs-12 text-right download-text"><strong>Seminar Title :</strong></div>
												<div class="col-md-8 col-sm-8 col-xs-12 download-margin"><?php echo $bookedseminar['title']; ?></div>
											</li>

											<li>
												<div class="col-md-4 col-sm-4 col-xs-12 text-right download-text"><strong>Seminar From Date :</strong></div>
												<div class="col-md-8 col-sm-8 col-xs-12 download-margin"><?php echo date("d-m-Y",$bookedtiket['from_date']/1000);?></div>
											</li>
											<li>
												<div class="col-md-4 col-sm-4 col-xs-12 text-right download-text"><strong>Seminar To Date :</strong></div>
												<div class="col-md-8 col-sm-8 col-xs-12 download-margin"><?php echo date("d-m-Y",$bookedtiket['to_date']/1000);?></div>
											</li>

											<li>
												<div class="col-md-4 col-sm-4 col-xs-12 text-right download-text"><strong>Total Book Seat :</strong></div>
												<div class="col-md-8 col-sm-8 col-xs-12 download-margin"><?php echo $bookedtiket['book_seat'];?></div>
											</li>
											
											<li>
												<div class="col-md-4 col-sm-4 col-xs-12 text-right download-text"><strong>Booking No. :</strong></div>
												<div class="col-md-8 col-sm-8 col-xs-12 download-margin"><?php echo $bookedtiket['booking_no'];?></div>
											</li>
											
										</ul>
						</div>
									<div class="clearfix"></div>
								<div class="modal-footer model-head">
								  <button type="button" class="blue-button f-left border-n" data-dismiss="modal">Cancel</button>
								 <a target="_blank" download  href="tcpdf/examples/print_pdf.php?bkid=<?php echo $_REQUEST['btid']; ?>&sem_id=<?php echo $bookedtiket['seminar_id'];?>">
								  <button type="button" class="blue-button f-right border-n">Download</button>
								  </a>
								</div>	
  <?php
}
if($_REQUEST['kon']=="review")
{
	
	$sid = $_REQUEST['sid'];
	$uid = $_SESSION['jpmeetou']['id'];
	$notes = $_REQUEST['notes'];
	$created_at = round(microtime(true) * 1000);
	
	$checkreview = mysql_query("select * from review where seminar_id = '".$sid."' and uid = '".$uid."'");	
	if(mysql_num_rows($checkreview)>0)		
	{
	    echo "<script>alert('You already Give Your Review For This Seminar');</script>";
	}
	else
	{
		
		 $insertreview=mysql_query("insert into review (seminar_id,uid,notes,created_date,modified_date,status) values ('".$sid."','".$uid."','".$notes."','".$created_at."','".$created_at."','1')");
	}
	?>
	 <table class="table table-striped table-bordered table-hover" id="dataTables-example">
				   <?php
				    $semireview=mysql_query("select r.notes,u.fname from review r,user u where u.id=r.uid and r.seminar_id=$sid and r.status ='1' order by r.id desc");
								if(mysql_num_rows($semireview)>0)
							   { 
				        ?>
					          <?php 
								 
								while($fetreview=mysql_fetch_array($semireview))
								  {?>
									<span class="review-user">
										<label><?php echo $fetreview['fname']; ?></label>
										<p><i class="fa fa-star" aria-hidden="true"></i><?echo $fetreview['notes'];?></p>
									</span>  
									<?php
						             }  
								  }	 
				   else
				   {
					   ?>
						<tr><div id="noreview">
					    <h4>No Reviews Yet </h4>
                        <p> Stay here and you could give this host their first review! </p> 
                      </div>
						</tr>
					   <?php
				   }?>	
									
                    </tbody>
                   </table>
<?
} 
?>
