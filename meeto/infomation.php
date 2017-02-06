<?php     require_once('db.php'); ?>
<!DOCTYPE html><html lang="en">  
<?php	require_once('head1.php');  ?>

<style>
body header{
	background:none;
	
}
</style>
<!-- NAVBAR================================================== --> 
<script>
	$(window).scroll(function () {
		 var sc = $(window).scrollTop()
		if (sc > 40) {
			$("body.infom_page header").css("background","rgba(0,0,0,0.9)");
			$("body.infom_page header").css("position","fixed")
		} else {
			$("header").css("background","none");
		}
	});
</script>

<script>
$(window).scroll(function () {
		var sc = $(window).scrollTop()
		var divheight = $("#left_section").height();
		var footerheight = $("#footer").height();
		//var footerheight = footerheight+15;
		//alert(divheight);
		if (sc > 425) {
			//alert("top"+sc);
			$(".right_elem").removeClass("bottom_fix");
			$(".right_elem").removeAttr("style");
			$(".right_elem").addClass("fixed_price");
		} else {
			//alert(sc);
			$(".right_elem").removeClass("fixed_price");
			$(".right_elem").removeClass("bottom_fix");
			$(".right_elem").removeAttr("style");
		}
		
		if(sc > divheight-30){
			//alert("bottom"+sc);
			$(".right_elem").removeClass("fixed_price");
			$(".right_elem").addClass("bottom_fix");
			//$(".right_elem").css("bottom",footerheight+"px");
		}
	});
	
function seldate()
{
	var fromdate = document.getElementById('from_date').value;
	document.getElementById('to_date').min=fromdate;
	
	var fromdate = document.getElementById('to_date').value;
	document.getElementById('from_date').max=fromdate;
	
}
	
</script>

<body onload="hideselect();" class="infom_page" >     
<?php	require_once('header1.php');   ?>


<!-- pop up start -->		
<!-- Sing in modal -->		
<?php	require_once('loginsignup.php'); 	?>		
<!-- pop up end-->
<?php
	$seminar_detail = mysql_fetch_array(mysql_query("select * from seminar where id = '".$_REQUEST['id']."' and status='1'"));
	$seminar_city = mysql_fetch_array(mysql_query("select * from cities where id = '".$seminar_detail['cityid']."'"));
	
	$seminar_photo = mysql_query("select * from seminar_photos where seminar_id = '".$seminar_detail['id']."'");  
	$selsemitype= mysql_fetch_array(mysql_query("select * from seminar_type where id=$seminar_detail[typeid]"));
	
	$seluserdetail=mysql_fetch_array(mysql_query("select * from user_detail where uid=$seminar_detail[uid]"));
	$selsemiday=mysql_query("select * from seminar_day where seminar_id=$_REQUEST[id]");
	$fetsemiday=mysql_fetch_array($selsemiday);
	$seluser=mysql_fetch_array(mysql_query("select * from user where id=$seminar_detail[uid]"));
	$usercompany=mysql_fetch_array(mysql_query("select * from user_company where uid=$seminar_detail[uid]"));
	
	/*$purpose = explode(',',$seminar_detail['puposeid']);
	$industry= explode(',',$seminar_detail['industryid']);
	echo "<script>alert($purpose[0]);</script>";
	echo "<script>alert($industry[0]);</script>";
	print_r($purpose);
	print_r($industry);
	
	$purposeid=implode(',',array_map('intval',$purpose));
	$industryid=implode(',',array_map('intval',$industry));
	$purposeid = str_replace(",","','",$purposeid);
	$industryid = str_replace(",","','",$industryid);
    
    $selsemipurpose=mysql_query("select * from purpose where id in ('".$purposeid."')");
	$selindustry=mysql_query("select * from industry where id in ('".$industryid."')");
   */
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
                  $i++;
            ?>
        <div class="item <?php if($i==1)echo 'active'; ?>">
        <img class="img-responsive" src="img/<?php echo $sphoto['image']; ?>" style="transform:rotate(<?php echo $sphoto['rotateval']; ?>deg)" alt="First slide">
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
</div>
<!-- /.carousel -->
				
				
				
	
<div class="main_detail_div">
    <div class="main_detail">
        <div id="left_section" class="main_layout">
            <div class="section_div about_main_detail">	
                <h2 class="header-cont">basic detail</h2>
                <div class="body-cont">
                        <span class="host_prof text-center">
						   <?php
							  if($seluser['type']==2)
		                   	{
		                     ?>
	                		<img src="<?php echo $seluserdetail['photo']; ?>" class="img-responsive user center-block">
		                	<?php
		                  	}
		                 	elseif($seluserdetail['photo']=="")	
                            // if($seluserdetail['photo']=="" || !file_exists("img/".$seluserdetail['photo']))
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
                        </span>
                        <span class="host_detail text-c">
                            <h4 class="semibold-o"><?php echo $seminar_detail['title']; ?></h4>
                            <span class="opan-r font-menu"><?php echo $seminar_detail['tagline']; ?></span>
                            <ul class="nav propety-feature">
                                <li class="icon-margin">
                                     <img src="img/<?php echo $selsemitype['image']; ?>" class="list-img img-responsive">
							    <!--<i class="fa fa-home" aria-hidden="true"></i>-->
                                    <span class="opan-r"><?php echo $selsemitype['name']; ?></span>
                                </li>
                                <li class="icon-margin">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                    <span class="opan-r"><?php echo $seminar_detail['total_seat']; ?> seats</span>
                                </li>
                                <li class="icon-margin">
								   <img src="img/<?php if($usercompany['organization']=='Profit Organization') { echo "profit.png"; } else { echo "nonprofit.png"; } ?>" class="list-img img-responsive">
                                    <span class="opan-r"><?php echo $usercompany['organization']; ?></span>
                                </li>
                            </ul>
                            <div class="top-margin-20"></div>
                        </span>
                </div>
            </div>
            <div class="section_div about-listing">
                <h2 class="header-cont">About This Seminar</h2>
                <div class="body-cont">
                    <div class="about-info">
                        <p><?php echo $seminar_detail['description']; ?></p><Br>
                        <p>
                            <?php
                                
                                if($fetsemiday['from_date']==$fetsemiday['to_date'])
                                {
                                   // echo "Date : " .date("d-m-Y",strtotime($fetsemiday['from_date']));
								echo "Date : " .date("d-m-Y",$fetsemiday['from_date']/1000);
                                }
                                else
                                {
								  echo "From Date : " .date("d-m-Y",$fetsemiday['from_date']/1000)."&nbsp;&nbsp;&nbsp;";
								  echo "To Date : " .date("d-m-Y",$fetsemiday['to_date']/1000)."<br>";
                                 //echo "From Date : ".date("d-m-Y",strtotime($fetsemiday['from_date']))."&nbsp;&nbsp;&nbsp;";
                                 // echo "To Date : ".date("d-m-Y",strtotime($fetsemiday['to_date']))."<br>";
                                    
                                }
                                $selsemiday=mysql_query("select * from seminar_day where seminar_id=$_REQUEST[id]");
                                $fetsemiday=mysql_fetch_array($selsemiday);
								
                              echo "From Time : ".date("g:i a",$fetsemiday['from_date']/1000)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                              echo "To Time : ".date("g:i a",$fetsemiday['to_date']/1000)."<br>";
                            ?>
                        </p>
                    </div>
					<div class="clearfix"></div>
                </div>
            </div>
			
			<div class="section_div descri-section">
                <h2 class="header-cont">Seminar Attendees :</h2>
                <div class="body-cont Seminar-Attendees">
				     <ul class="nav right-space">
                        <?php
						$attendeesid=mysql_query("select * from seminar_purpose where seminar_id='".$_REQUEST['id']."'");
						while($selattendees=mysql_fetch_array($attendeesid))
                        { 
					        $selattendeesname=mysql_fetch_array(mysql_query("select * from purpose where id=$selattendees[attendees_id]"));
							?>
						<li>
                            <img src="img/<?php echo $selattendeesname['image']; ?>" class="list-img img-responsive">
							 &nbsp;
                            <span class="opan-r"><?php echo $selattendeesname['name']; ?></span>
                        </li>
						  <?php
						  }
						  ?>
                    </ul>
                </div>
            </div>

			<div class="section_div descri-section">
                <h2 class="header-cont">Industry Type :</h2>
                <div class="body-cont Seminar-Attendees">
				     <ul class="nav right-space">
                        <?php
						$selindustry=mysql_query("select * from seminar_industry where seminar_id='".$_REQUEST['id']."'");
						 while($industry=mysql_fetch_array($selindustry))
                         { 
					         $selindustryname=mysql_fetch_array(mysql_query("select * from industry where id=$industry[industry_id]"));
					  
							?>
						<li>
                            <img src="img/<?php echo $selindustryname['image']; ?>" class="list-img img-responsive">
							 &nbsp;
                            <span class="opan-r"><?php echo $selindustryname['name']; ?></span>
                        </li>
						  <?php
						  }
						  ?>
                    </ul>
                </div>
            </div>
			
			
            <div class="section_div descri-section">
					<h2 class="header-cont">Facilities :</h2>
				<div class="body-cont">	
                    <ul class="nav right-space">
                            <?php
                                $selfacility=mysql_query("select * from seminar_facility where seminar_id=$_REQUEST[id]");
                                while($fetseminarfaci=mysql_fetch_array($selfacility))
                                {
                                    $selfaciname=mysql_fetch_array(mysql_query("select * from facility where id=$fetseminarfaci[facility_id]"));
                            ?>
                        <li>
                            <span><!--<img src="img/icon/wifi1.png" />--><i class="fa fa-star-o" aria-hidden="true"></i> </span>
                            <label><?php echo $selfaciname['name']; ?></label>
                        </li>
                            <?php
                                }
                            ?>
                    </ul>
                    
                    <div class="descri-section">
                        <div class="row">
                                <?php
                                    $selsemiphoto=mysql_query("select * from seminar_photos where seminar_id=$_REQUEST[id]");
                                    while($fetsemiphoto=mysql_fetch_array($selsemiphoto))
                                    {
                                ?>
                            <div class="fancy-img">
                                <a class="fancybox-thumb" rel="fancybox-thumb" href="img/<?php echo $fetsemiphoto['image']; ?>" style="transform:rotate(<?php echo $fetsemiphoto['rotateval']; ?>deg)!important;"  title="Big Office - Electra City Tower">
                                    <img src="img/<?php echo $fetsemiphoto['image']; ?>" style="transform:rotate(<?php echo $fetsemiphoto['rotateval']; ?>deg)"  alt="" class="fancy-width"/>
                                </a>
                            </div>	
                                <?php
                                    }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section_div review-section">
                <h2 class="header-cont">Reviews</h2>
                <div class="body-cont">
                  <div class="col-md-12 review">
				   <div id="review">
				   <div class="table table-striped table-hover" id="dataTables-example">
				   <?php
				    $semireview=mysql_query("select r.notes,u.fname from review r,user u where u.id=r.uid and r.seminar_id=$_REQUEST[id] and r.status ='1' order by r.id desc");
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
						<div id="noreview">
							<h4>No Reviews Yet </h4>
							<p> Stay here and you could give this host their first review! </p> 
                        </div>
						
					   <?php
				   }?>	
									
                   
                   </div>
					
				  </div>
                    <textarea class="review-submit" rows="2" id="givenreview"></textarea>
					
					<div class="top-margin-20"></div>
					
					<button class="blue-button" type="button" onclick="review('<?php echo $_REQUEST['id']; ?>');" >Submit</button>
                 </div>
                </div>
            </div>
            <div class="section_div about_host">
                <h2 class="header-cont">About the Host, <?php echo $seminar_detail['hostperson_name']; ?></h2>
                <div class="body-cont">
                	<div class="col-md-3 col-sm-6 col-xs-12 text-center">
							<?php
                               if($seluser['type']==2)
                                {
                            ?>
						<img src="<?php echo $seluserdetail['photo']; ?>"class="img-responsive Host-img center-block">
							<?php
                                }
                                elseif($seluserdetail['photo']=="")			
                                //  if($seluserdetail['photo']=="" || !file_exists("img/".$seluserdetail['photo']))
                                {						
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
                    </div>
					
					
					
                    <div class="col-md-9 col-sm-6 col-xs-12 host">
                    	<div class="comp_name purple"><?php echo $usercompany['name']; echo "<br>"; ?></div>
                        <span class="green"><?php echo $usercompany['description']; echo "<br>"; ?></span>
						<span class="green"><?php echo $usercompany['organization'];echo "<br>"; ?></span>
                        <span class="green"><?php echo $seminar_detail['address'];  echo "<br>"; ?></span>
						<span class="blue"><?php echo $seminar_city['name'];  echo "<br>"; ?></span>
                        <span class="blue"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $seminar_detail['phoneno']; echo "<br>"; ?></span>
						<span class="blue"><i class="fa fa-fax" aria-hidden="true"></i> <?php echo $usercompany['faxno'];   echo "<br>"; ?></span>
						<span class="red"><?php echo $seminar_detail['contact_email']; echo "<br>"; ?></span>
						<span class="red"><?php echo $usercompany['url']; echo "<br>"; ?></span>
                    </div>
					
					<div class="clearfix"></div>
                </div>
            </div>
            
        </div>
        <div class="right_elem">
        	<div class="price_detail">
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
                        <label class="price-descri"><?php echo "Date : ".date("d-m-Y",$fetsemiday['from_date']); ?></label>		
                    </div>
                        <?php
                            }
                            else
                            {
                        ?>
                    <div class="botns-label">
                        <span class="title" style="font-size:15px;">From Date</span>
                        <label class="price-descri"><?php //echo date("d-m-Y",strtotime($fetsemiday['from_date'])); 
						echo date("d-m-Y",$fetsemiday['from_date']/1000);?></label>		
                    </div>
                    <div class="botns-label">
                        <span class="title" style="font-size:15px;">To Date</span>
                        <label class="price-descri"><?php // echo date("d-m-Y",strtotime($fetsemiday['to_date']));
                        echo date("d-m-Y",$fetsemiday['to_date']/1000);?></label>		
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
                    <div class="col-md-12 information-date">
                        <div class="col-md-12">
                            <label>From Date</label>
                            <input type="date"  id="from_date" min="<?php echo date("Y-m-d",$fetsemiday['from_date']/1000); ?>" max="<?php echo date("Y-m-d",$fetsemiday['to_date']/1000); ?>" required class="form-control" name="fromdate" onchange="seldate();">
                        </div>
                        <div class="col-md-12" style="margin-top:10px;">
                            <label>To Date</label>
                            <input type="date" id="to_date" min="<?php echo date("Y-m-d",$fetsemiday['from_date']/1000); ?>" max="<?php echo date("Y-m-d",$fetsemiday['to_date']/1000); ?>" required class="form-control" name="todate" onchange="seldate();">
                        </div>
                        <div class="col-md-12" style="margin-top:10px;">
                            <label>Total Seats</label>
                            <input type="number" id="totseat" onkeyup="checkseat('<?php echo $avaliable; ?>')" required pattern="[0-9]{1,}" placeholder="Enter Number of Ticket" title="Please Enter Numeric Value" class="form-control" name="totalseats" min="1">
                            <label style="color:red;display:none;" id="seatmsg">Sorry, Total Available Seats Is : <?php echo $avaliable; ?></label>
                        </div>
                    </div>
                    <div class="submit-link"> 
                        <button class="booking-btn" type="submit" id="booksub">Book Now</button>
                    </div>	
                </form>
					<?php
                        }
                        else
                        {
                    ?>
                <div class="error_div">Sorry, Total Available Seats Is : 0</div>
					<?php
                        }
                    ?>
            </div>
        </div> 
    </div>
    
   <!-- <div class="listing_detail_div">
    	<div class="section_div">	
            <h2 class="header-cont">Similar Listings</h2>
            <div class="body-cont">
                <div  style="width:90%;margin:auto">
                    <div class="about-carousel text-center ">
                            <?php
                                $selsimilar=mysql_query("select * from seminar where id  $_REQUEST[id] and id in (typeid=$selsemitype[id] or puposeid=$selsemipurpose[id])");
                        
                                while($fetsimilar=mysql_fetch_array($selsimilar))
                                {
                                    $selsemiphoto=mysql_query("select * from seminar_photos where seminar_id=$fetsimilar[id] limit 0,1");
                                    $fetsemiphoto=mysql_fetch_array($selsemiphoto);
                            ?>
                        <div style="margin:0 7px;border:1px solid #ddd;">
                            <a href="infomation.php?id=<?php echo $fetsimilar['id']; ?>">
                                <img src="img/<?php echo $fetsemiphoto['image']; ?>" style="height:250px;width:100%;" class="center-block" />
                            </a>
                            <h4 class="slick-f"><?php echo $fetsimilar['title']; ?></h4>
                        </div>
                            <?php
                                }
                                //echo "select * from seminar where id <> $_REQUEST[id] and (typeid=$selsemitype[id] or puposeid=$selsemipurpose[id])";
                            ?>
                    </div>
                </div>
        	</div>
        </div>
    </div>-->
</div>
<!-- footer -->	
<?php    require_once('footer1.php');	?>
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
      breakpoint: 900,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }	,
    {
      breakpoint: 650,
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




    
