<?php     require_once('db.php'); ?>
<!DOCTYPE html><html lang="en">  
<?php	require_once('head.php');   ?>
<!-- NAVBAR================================================== --> 
 
<body>     
  <?php	
    require_once('header.php');   
  ?>
<!-- pop up start -->		
	<!-- Sing in modal -->		
		<?php				
		  require_once('loginsignup.php'); 		
		?>		
		<!-- pop up end-->
<?php
$seminar_detail = mysql_fetch_array(mysql_query("select * from seminar where id = '".$_REQUEST['id']."'"));

$seminar_photo = mysql_query("select * from seminar_photos where seminar_id = '".$seminar_detail['id']."'");  
$selsemitype= mysql_fetch_array(mysql_query("select * from seminar_type where id=$seminar_detail[typeid]"));
$selsemipurpose= mysql_fetch_array(mysql_query("select * from seminar_purpose where id=$seminar_detail[puposeid]"));
$seluser=mysql_fetch_array(mysql_query("select * from user where id=$seminar_detail[uid]"));
$seluserdetail=mysql_fetch_array(mysql_query("select * from user_detail where uid=$seminar_detail[uid]"));
$selsemiday=mysql_query("select * from seminar_day where seminar_id=$_REQUEST[id]");
$fetsemiday=mysql_fetch_array($selsemiday);

$usercompany=mysql_fetch_array(mysql_query("select * from user_company where uid=$seminar_detail[uid]"));

 ?>
			 <!-- Carousel
				================================================== -->
				<div id="myCarousel" class="carousel" data-ride="carousel">
				  <!-- Indicators -->
				  <div class="carousel-inner" role="listbox">
					<?php
					$i=0;
					while($sphoto=mysql_fetch_array($seminar_photo))
					  { 
				  $i++;?>
					<div class="item <?php if($i==1)echo 'active'; ?>">
					  <img class="img-responsive" src="img/<?php echo $sphoto['image']; ?>" alt="First slide">
					</div>
					<?php  
					  }
					 ?>
				  </div>
				  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
				</div><!-- /.carousel -->
				
				
				
	
	
	
<div class="container ">	
	<div class="row">
		<div class="col-md-7 col-xs-12">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center">
			<?php
			if($seluser['type']==2)
			{
			?>
			<img src="<?php echo $seluserdetail['photo']; ?>" class="img-responsive user center-block">
			<?php
			}
			elseif($seluserdetail['photo']=="")	
			{						
			?>							
			<img src="img/profile.png" class="img-responsive user center-block"/>			
			<?php					
			}
			else					
			{						
			?>							
			<img src="img/<?php echo $seluserdetail['photo']; ?>" class="img-responsive user center-block">			
			<?php						
			}					
			?>
				<div class="top-margin-20">
				<span class="semibold-o user-text"><?php echo $seminar_detail['hostperson_name']; ?></span>
			</div>
			</div>

			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
				<h3 class="margin-main semibold-o"><?php echo $seminar_detail['title'];	 ?></h3>
				<span class="opan-r font-menu"><?php echo $seminar_detail['tagline'];	 ?></span>
				<ul class="nav propety-feature">
					<li class="icon-margin">
					<i class="fa fa-home icon-size" aria-hidden="true"></i>
					<span class="opan-r"><?php echo $selsemitype['name'];	 ?></span>
					</li>
					
					<li class="icon-margin">
					<i class="fa fa-users icon-size" aria-hidden="true"></i>
					<span class="opan-r"><?php echo $seminar_detail['total_seat']; ?> seats</span>
					</li>
					<li class="icon-margin">
					<i class="fa fa-user icon-size" aria-hidden="true"></i>
					<span class="opan-r"><?php echo $selsemipurpose['name'];	 ?></span>
					</li>
				</ul>
								<div class="top-margin-20"></div>
			</div>
		</div>
		
		<div class="col-md-4 col-sm-4 col-xs-12 information-price">
			<div class="top-title">
				<div class="botns-label">
                    	<span class="title" style="font-size:15px;">Total Seats</span>
						<label class="price-descri"><?php echo $seminar_detail['total_seat']; ?></label>		
				</div>
				<div class="botns-label">
                    	<span class="title" style="font-size:15px;">Total Available Seats</span>
						<label class="price-descri"><?php echo $avaliable=$seminar_detail['total_seat'] - $seminar_detail['total_booked_seat']; ?></label>		
				</div>
				<?php
				if($fetsemiday['from_date']==$fetsemiday['to_date'])
				{
					?>
					<div class="botns-label">
                    	<span class="title" style="font-size:15px;">Date</span>
						<label class="price-descri"><?php echo "Date : " .date("d-m-Y",strtotime($fetsemiday['from_date'])); ?></label>		
					</div>
					<?php
				}
				else
				{
					?>
					<div class="botns-label">
                    	<span class="title" style="font-size:15px;">From Date</span>
						<label class="price-descri"><?php echo date("d-m-Y",strtotime($fetsemiday['from_date'])); ?></label>		
					</div>
					<div class="botns-label">
                    	<span class="title" style="font-size:15px;">To Date</span>
						<label class="price-descri"><?php echo date("d-m-Y",strtotime($fetsemiday['to_date'])); ?></label>		
					</div>
					<?php
				}
				?>
			</div>
			<?php
			if($avaliable!=0)
			{
				?>
			
			<form action="book-now.php?id=<?php echo $_REQUEST['id']; ?>" method="POST">
	
			<div class="col-md-12 information-date" style="margin-top:20px;">
				<div class="col-md-12">
					<label>From Date</label>
					<input type="date" min="<?php echo $fetsemiday['from_date']; ?>" max="<?php echo $fetsemiday['to_date']; ?>" required class="form-control" name="fromdate" onchange="selectPlan('hour')">
				</div>
				<div class="col-md-12" style="margin-top:10px;">
					<label>To Date</label>
					<input type="date" min="<?php echo $fetsemiday['from_date']; ?>" max="<?php echo $fetsemiday['to_date']; ?>" required class="form-control" name="todate" onchange="selectPlan('hour')">
				</div>
				<div class="col-md-12" style="margin-top:10px;">
					<label>Total Seats</label>
					<input type="text" id="totseat" onkeyup="checkseat('<?php echo $avaliable; ?>')" required pattern="[0-9]{1,}" title="Please Enter Numeric Value" class="form-control" name="totalseats">
					<label style="color:red;display:none;" id="seatmsg">Sorry, Total Available Seats Is : <?php echo $avaliable; ?></label>
				</div>
			</div>
			<div id="price_div">
					<div class="submit-link"> 
					
							<button class="booking-btn" type="submit" id="booksub">Book Now</button>
						
					</div>	
			</div>
			</form>
			<?php
			}
			else
			{
				?>
				<div style="color:red;text-align:center;font-weight:bold;margin-top:10px;">Sorry, Total Available Seats Is : 0</div>
				<?php
			}
			?>
		</div>
	</div>
	<div class="top-margin-10">&nbsp;</div>
</div>

<div class="container-flude about-listing">
	<div class="container">
		<div class="col-md-7">
		<div class="clearfix"></div>
			<div class="top-margin-10"></div>
			<h4><a>About This Seminar</a></h4>
			<div class="top-margin-20"></div>
			<span class="about-info">
			<p><?php echo $seminar_detail['description']; ?></p><Br>
			<p>
				<?php
					
					if($fetsemiday['from_date']==$fetsemiday['to_date'])
					{
						echo "Date : " .date("d-m-Y",strtotime($fetsemiday['from_date']));
					}
					else
					{
						echo "From Date : ".date("d-m-Y",strtotime($fetsemiday['from_date']))."<br>";
						echo "To Date : ".date("d-m-Y",strtotime($fetsemiday['to_date']))."<br>";
						
					}
					$selsemiday=mysql_query("select * from seminar_day where seminar_id=$_REQUEST[id]");
					$fetsemiday=mysql_fetch_array($selsemiday);
					echo "From Time : ".$fetsemiday['from_time']."<br>";
					echo "To Time : ".$fetsemiday['to_time']."<br>";
				?>
			</p>
			
			</span>
			<div class="clearfix"></div>
			<div class="top-margin-20"></div>
			<!--
			<div class="descri-section">
				<span class="left-space">The Seminar</span>
				<ul class="nav right-space">
					<li>
						<span>Seminar Type : </span>
						<label><?php //echo $selsemitype['name']; ?></label>
					</li>
					<li>
						<span>Seminar Purpose : </span>
						<label><?php // echo $selsemipurpose['name']; ?></label>
					</li>
				</ul>
			</div>
			---->
			
			<div class="descri-section">		
				<span class="left-space">Facilities</span>
				<ul class="nav right-space">
					<?php
					$selfacility=mysql_query("select * from seminar_facility where seminar_id=$_REQUEST[id]");
					while($fetseminarfaci=mysql_fetch_array($selfacility))
					{
						$selfaciname=mysql_fetch_array(mysql_query("select * from facility where id=$fetseminarfaci[facility_id]"));
						?>
						<li>
							<span><img src="img/icon/wifi1.png" /> </span>
							<label><?php echo $selfaciname['name']; ?></label>
						</li>
						<?php
					}
					?>
					
				</ul>
			</div>
			
			
			<div class="descri-section">
			<div class="row">
				<?php
				$selsemiphoto=mysql_query("select * from seminar_photos where seminar_id=$_REQUEST[id]");
				while($fetsemiphoto=mysql_fetch_array($selsemiphoto))
				{
					?>
					<div class="fancy-img">
						<a class="fancybox-thumb" rel="fancybox-thumb" href="img/<?php echo $fetsemiphoto['image']; ?>" title="Big Office - Electra City Tower">
							<img src="img/<?php echo $fetsemiphoto['image']; ?>" alt="" class="fancy-width"/>
						</a>
					</div>	
				
					<?php
				}
				?>
			</div>
			</div>
		</div>
	</div>
</div>

		<div class="container">
		<div class="top-margin-10">&nbsp;</div>
			<div class="col-md-12 review">
				<h4>No Reviews Yet </h4>
				<p> Stay here and you could give this host their first review! </p>
			
			</div>
		<div class="bottom-margin-10">&nbsp;</div>				
		</div>

 
<div class="container-flude about-listing">
	<div class="container"> 
		<div class="col-md-12 host">
			<h3>About the Host, <?php echo $seminar_detail['hostperson_name']; ?></h3>
			<div class="top-margin-20"></div>
			         <?php  /* echo $usercompany['name'];
					     echo $usercompany['description'];
					     echo $seminar_detail['address'];
					     echo $seminar_detail['contact_email'];
					     echo $seminar_detail['phoneno']; */ ?>	
		</div>
		<div class="col-md-2 col-sm-2 col-xs-12 text-center">
			<?php
			if($seluser['type']==2)
			{
			?>
			<img src="<?php echo $seluserdetail['photo']; ?>"class="img-responsive Host-img center-block">
			<?php
			}
			elseif($seluserdetail['photo']=="")						{						
			?>							
			<img src="img/profile.png" class="img-responsive Host-img center-block"/>			
			<?php					
			}		
			else					
			{						
			?>							
			<img src="img/<?php echo $seluserdetail['photo']; ?>" class="img-responsive Host-img center-block"/>			
			<?php						
			}					
			?>
			<div class="top-margin-20"></div>		
			<div class="">&nbsp;</div>	
		</div>

	</div>
</div>


		<div class="container-flude">
		  <div class="container">
			<div class="events">
				<div class="clearfix bottom-margin-20">&nbsp;</div>
				<h3>Similar Listings</h3>
				<div class="clearfix bottom-margin-10">&nbsp;</div>
			  <div  style="width:90%;margin:auto">

				<div class="about-carousel text-center ">
				<?php
					$selsimilar=mysql_query("select * from seminar where id <> $_REQUEST[id] and (typeid=$selsemitype[id] or puposeid=$selsemipurpose[id])");
					
					while($fetsimilar=mysql_fetch_array($selsimilar))
					{
						$selsemiphoto=mysql_query("select * from seminar_photos where seminar_id=$fetsimilar[id] limit 0,1");
						$fetsemiphoto=mysql_fetch_array($selsemiphoto);
					?>
						 <div>
							<a href="infomation.php?id=<?php echo $fetsimilar['id']; ?>">
							<img src="img/<?php echo $fetsemiphoto['image']; ?>" style="height:250px;width:250px;" class="center-block" />
							</a>
							<h4 class="slick-f"><?php echo $fetsimilar['title']; ?></h4>
						 </div>
					<?php
					}
					//echo "select * from seminar where id <> $_REQUEST[id] and (typeid=$selsemitype[id] or puposeid=$selsemipurpose[id])";
				?>
				 
				</div>
				<div class="clearfix bottom-margin-20">&nbsp;</div>
			  </div>
			</div>
		  </div>
		</div>

<!-- footer -->	<?php    require_once('footer.php');	?>
	
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



	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<!-- price-slider -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 
      <script type="text/javascript" src="price_range.js"></script>
	  <script src="js/index.js"></script>
	<!-- Add fancyBox -->
	<script type="text/javascript" src="plugin/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script> 
	<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox-thumb").fancybox({
			prevEffect	: 'none',
			nextEffect	: 'none',
			helpers	: {
				title	: {
					type: 'outside'
				},
				thumbs	: {
					width	: 50,
					height	: 50
				}
			}
		});
	});
		</script>


		
<script src="plugin/slick/slick.js"></script> 		
<script type="text/javascript">
	 /* slick slider home page */
$(document).ready(function(){
$('.about-carousel').slick({
  dots: true,
  infinite: false,
  speed: 700,
  arrows:true,
  slidesToShow: 4,
  slidesToScroll: 4,
 prevArrow:"<div class='vv-slick-prev '></div>",
 nextArrow:"<div class='vv-slick-next '></div>",
  responsive: [
    {
      breakpoint: 1224,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 1100,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 800,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }	,
    {
      breakpoint: 450,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
	});
	});
	
</script>

  </body>
</html>