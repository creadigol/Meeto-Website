
<?php     require_once('db.php'); ?>
<!DOCTYPE html><html lang="en">  
<?php	require_once('head1.php');   ?>
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
	$seminar_detail = mysql_fetch_array(mysql_query("select * from seminar where id = '".$_REQUEST['id']."' and status='1' "));
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
        <img class="img-responsive" src="../img/<?php echo $sphoto['image']; ?>" style="transform:rotate(<?php echo $sphoto['rotateval']; ?>deg)"  alt="First slide">
        </div>
			<?php  
                }
            ?>
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    	<span class="sr-only">前</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    	<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    	<span class="sr-only">次</span>
    </a>
</div>
<!-- /.carousel -->
				
				
				
	
<div class="main_detail_div">
    <div class="main_detail">
        <div id="left_section" class="main_layout">
            <div class="section_div about_main_detail">	
                <h2 class="header-cont">基本的な詳細</h2>
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
                            <img src="../img/profile.png" class="img-responsive user center-block"/>			
                             <?php					
                             }		
                             else					
                            {						
                                ?>							
                            <img src="../img/<?php echo $seluserdetail['photo']; ?>" class="img-responsive user center-block">			
                                <?php						
                                    }					
                                ?>
                            <div class="top-margin-20">
                                <span class="semibold-o user-text"><?php $marutra = explode('"',translate(str_replace(" ","+",$seminar_detail['hostperson_name']))); echo $marutra[1] ; ?></span>
                            </div>
                        </span>
                        <span class="host_detail text-c">
                            <h4 class="semibold-o"><?php 
$data = explode('"',translate(str_replace(" ","+",$seminar_detail['title']))); echo $data[1]; ?></h4>
                            <span class="opan-r font-menu"><?php $data = explode('"',translate(str_replace(" ","+",$seminar_detail['tagline']))); echo $data[1]; ?></span>
                            <ul class="nav propety-feature">
                                <li class="icon-margin">
                                     <img src="../img/<?php echo $selsemitype['image']; ?>" class="list-img img-responsive">
							    <!--<i class="fa fa-home" aria-hidden="true"></i>-->
                                    <span class="opan-r"><?php $data = explode('"',translate(str_replace(" ","+",$selsemitype['name']))); echo $data[1]; ?></span>
                                </li>
                                <li class="icon-margin">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                    <span class="opan-r"><?php $data = explode('"',translate(str_replace(" ","+",$seminar_detail['total_seat']))); echo $data[1] ; ?> 席</span>
                                </li>
                                <li class="icon-margin">
								   <img src="../img/<?php if($usercompany['organization']=='Profit Organization') { echo "profit.png"; } else { echo "nonprofit.png"; } ?>" class="list-img img-responsive">
                                    <span class="opan-r"><?php $data = explode('"',translate(str_replace(" ","+",$usercompany['organization']))); echo $data[1] ; ?></span>
                                </li>
                            </ul>
                            <div class="top-margin-20"></div>
                        </span>
                </div>
            </div>
            <div class="section_div about-listing">
                <h2 class="header-cont">このセミナーについて</h2>
                <div class="body-cont">
                    <div class="about-info">
                        <p><?php $data = explode('"',translate(str_replace(" ","+",$seminar_detail['description']))); echo $data[1] ; ?></p><Br>
                        <p>
                            <?php
                                
                                if($fetsemiday['from_date']==$fetsemiday['to_date'])
                                {
									echo "日付 : " .date("d-m-Y",$fetsemiday['from_date']);
                                   // echo "日付 : " .date("d-m-Y",strtotime($fetsemiday['from_date']));
                                }
                                else
                                {
									 echo "日から : " .date("d-m-Y",$fetsemiday['from_date']/1000)."&nbsp;&nbsp;&nbsp;";
								    echo "現在まで : " .date("d-m-Y",$fetsemiday['to_date']/1000)."<br>";
                                   // echo "日から: ".date("d-m-Y",strtotime($fetsemiday['from_date']))."&nbsp;&nbsp;&nbsp;";
                                   // echo "現在まで : ".date("d-m-Y",strtotime($fetsemiday['to_date']))."<br>";
                                    
                                }
                                $selsemiday=mysql_query("select * from seminar_day where seminar_id=$_REQUEST[id]");
                                $fetsemiday=mysql_fetch_array($selsemiday);
								
								 echo "時から : ".date("g:i a",$fetsemiday['from_date']/1000)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                               echo "時間に : ".date("g:i a",$fetsemiday['to_date']/1000)."<br>";
                              //  echo "時から : ".$fetsemiday['from_time']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                               // echo "時間に : ".$fetsemiday['to_time']."<br>";
                            ?>
                        </p>
                    </div>
					<div class="clearfix"></div>
                </div>
            </div>
			
			<div class="section_div descri-section">
                <h2 class="header-cont">セミナー参加者:</h2>
                <div class="body-cont Seminar-Attendees">
				     <ul class="nav right-space">
                        <?php
						$attendeesid=mysql_query("select * from seminar_purpose where seminar_id='".$_REQUEST['id']."'");
						while($selattendees=mysql_fetch_array($attendeesid))
                        { 
					        $selattendeesname=mysql_fetch_array(mysql_query("select * from purpose where id=$selattendees[attendees_id]"));
							?>
						<li>
                            <img src="../img/<?php echo $selattendeesname['image']; ?>" class="list-img img-responsive">
							 &nbsp;
                            <span class="opan-r"><?php $data = explode('"',translate(str_replace(" ","+",$selattendeesname['name']))); echo $data[1] ; ?></span>
                        </li>
						  <?php
						  }
						  ?>
                    </ul>
                </div>
            </div>

			<div class="section_div descri-section">
                <h2 class="header-cont">産業タイプ :</h2>
                <div class="body-cont Seminar-Attendees">
				     <ul class="nav right-space">
                        <?php
						$selindustry=mysql_query("select * from seminar_industry where seminar_id='".$_REQUEST['id']."'");
						 while($industry=mysql_fetch_array($selindustry))
                         { 
					         $selindustryname=mysql_fetch_array(mysql_query("select * from industry where id=$industry[industry_id]"));
					  
							?>
						<li>
                            <img src="../img/<?php echo $selindustryname['image']; ?>" class="list-img img-responsive">
							 &nbsp;
                            <span class="opan-r"><?php $data = explode('"',translate(str_replace(" ","+",$selindustryname['name']))); echo $data[1] ; ?></span>
                        </li>
						  <?php
						  }
						  ?>
                    </ul>
                </div>
            </div>
			
			
            <div class="section_div descri-section">
					<h2 class="header-cont">ファシリティ :</h2>
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
                            <label><?php $data = explode('"',translate(str_replace(" ","+",$selfaciname['name']))); echo $data[1] ; ?></label>
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
                                <a class="fancybox-thumb" rel="fancybox-thumb" href="../img/<?php echo $fetsemiphoto['image']; ?>" style="transform:rotate(<?php echo $fetsemiphoto['rotateval']; ?>deg)" title="Big Office - Electra City Tower">
                                    <img src="../img/<?php echo $fetsemiphoto['image']; ?>" style="transform:rotate(<?php echo $fetsemiphoto['rotateval']; ?>deg)"  alt="" class="fancy-width"/>
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
                <h2 class="header-cont">
レビュー</h2>
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
											<label>											
												<?php $marutra = explode('"',translate(str_replace(" ","+",$fetreview['fname']))); echo $marutra[1] ; ?>
											</label>
                                            <p>
												<i class="fa fa-star" aria-hidden="true"></i>
												<?$marutra = explode('"',translate(str_replace(" ","+",$fetreview['notes']))); echo $marutra[1] ;?>
											</p>
                                        </tr>
									<?php
						             }  
								  }	 
				   else
				   {
					   ?>
						 <div id="noreview">
							<h4>まだレビューはありません </h4>
							<p>ここに滞在し、あなたは、このホストに彼らの最初のレビューを与えることができます！ </p> 
                         </div>
						 
					   <?php
				   }?>	
									
                                   
                                </div>
					
				  </div>
                    <textarea class="review-submit" rows="2" id="givenreview"></textarea>
					
					<div class="top-margin-20"></div>
					
					<button class="blue-button" type="button" onclick="review('<?php echo $_REQUEST['id']; ?>');" >提出します</button>
                 </div>
                </div>
            </div>
            <div class="section_div about_host">
                <h2 class="header-cont">ホストについて、 <?php $marutra = explode('"',translate(str_replace(" ","+",$seminar_detail['hostperson_name']))); echo $marutra[1]; ?></h2>
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
                       	<img src="../img/profile.png" class="img-responsive Host-img center-block"/>			
							<?php					
								}		
								else					
								{						
                            ?>							
                        <img src="../img/<?php echo $seluserdetail['photo']; ?>" class="img-responsive Host-img center-block"/>			
                            <?php						
                                }					
                            ?>
                    </div>
					
                    <div class="col-md-9 col-sm-6 col-xs-12 host">
                    	<div class="comp_name purple"><?php $data = explode('"',translate(str_replace(" ","+",$usercompany['name']))); echo $data[1] ; echo "<br>"; ?></div>
                        <span class="green"><?php $data = explode('"',translate(str_replace(" ","+",$usercompany['description']))); echo $data[1] ; echo "<br>"; ?></span>
						<span class="green"><?php $data = explode('"',translate(str_replace(" ","+",$usercompany['organization']))); echo $data[1] ;echo "<br>"; ?></span>
                        <span class="green"><?php $marudata = explode('"',translate(str_replace(" ","+",$seminar_detail['address']))); echo $marudata[1] ;  echo "<br>"; ?></span>
						<span class="blue"><?php $data = explode('"',translate(str_replace(" ","+",$seminar_city['name']))); echo $data[1] ;  echo "<br>"; ?></span>
                        <span class="blue"><i class="fa fa-phone" aria-hidden="true"></i> <?php $data = explode('"',translate(str_replace(" ","+",$seminar_detail['phoneno']))); echo $data[1] ; echo "<br>"; ?></span>
						<span class="blue"><i class="fa fa-fax" aria-hidden="true"></i> <?php $data = explode('"',translate(str_replace(" ","+",$usercompany['faxno']))); echo $data[1] ;   echo "<br>"; ?></span>
						<span class="red"><?php $data = explode('"',translate(str_replace(" ","+",$seminar_detail['contact_email']))); echo $data[1] ; echo "<br>"; ?></span>
						<span class="red"><?php 	$data = explode('"',translate(str_replace(" ","+",$usercompany['url']))); echo $data[1] ; echo "<br>"; ?></span>
                    </div>
					
					<div class="clearfix"></div>
                </div>
            </div>
            
        </div>
        <div class="right_elem">
        	<div class="price_detail">
                <div class="top-title">
                    <div class="botns-label">
                            <span class="title" style="font-size:15px;">総席</span>
                            <label class="price-descri"><?php $marutra = explode('"',translate(str_replace(" ","+",$seminar_detail['total_seat']))); echo $marutra[1] ; ?></label>		
                    </div>
                    <div class="botns-label">
                            <span class="title" style="font-size:15px;">利用可能な総席</span>
                            <label class="price-descri"><?php $avaliable=$seminar_detail['total_seat'] - $seminar_detail['total_booked_seat']; $marutra = explode('"',translate(str_replace(" ","+",$avaliable))); echo $marutra[1];  ?></label>		
                    </div>
                        <?php
                            if($fetsemiday['from_date']==$fetsemiday['to_date'])
                            {
                        ?>
                    <div class="botns-label">
                        <span class="title" style="font-size:15px;">日付</span>
                        <label class="price-descri"><?php echo "日付 : ".date("d-m-Y",$fetsemiday['from_date']); ?></label>		
                    </div>
                        <?php
                            }
                            else
                            {
                        ?>
                    <div class="botns-label">
                        <span class="title" style="font-size:15px;">日から</span>
                        <label class="price-descri"><?php echo date("d-m-Y",$fetsemiday['from_date']/1000); ?></label>		
                    </div>
                    <div class="botns-label">
                        <span class="title" style="font-size:15px;">現在まで</span>
                        <label class="price-descri"><?php echo date("d-m-Y",$fetsemiday['to_date']/1000); ?></label>		
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
                            <label>日から</label>
                            <input type="date"  id="from_date" min="<?php echo date("Y-m-d",$fetsemiday['from_date']/1000); ?>" max="<?php echo date("Y-m-d",$fetsemiday['to_date']/1000); ?>" required class="form-control" name="fromdate" onchange="seldate();">
                        </div>
                        <div class="col-md-12" style="margin-top:10px;">
                            <label>現在まで</label>
                            <input type="date" id="to_date" min="<?php echo date("Y-m-d",$fetsemiday['from_date']/1000); ?>" max="<?php echo date("Y-m-d",$fetsemiday['to_date']/1000); ?>" required class="form-control" name="todate" onchange="seldate();">
                        </div>
                        <div class="col-md-12" style="margin-top:10px;">
                            <label>総席</label>
                            <input type="number" id="totseat" onkeyup="checkseat('<?php echo $avaliable; ?>')" required pattern="[0-9]{1,}" placeholder="チケットの数を入力してください"
							title="数値を入力してください" class="form-control" name="totalseats" min="1">
                            <label style="color:red;display:none;" id="seatmsg">申し訳ありませんが、利用可能な総席です : <?php $marutra = explode('"',translate(str_replace(" ","+",$avaliable))); echo $marutra[1] ; ?></label>
                        </div>
                    </div>
                    <div class="submit-link"> 
                        <button class="booking-btn" type="submit" id="booksub">今予約する</button>
                    </div>	
                </form>
					<?php
                        }
                        else
                        {
                    ?>
                <div class="error_div">申し訳ありませんが、利用可能な総席です：0</div>
					<?php
                        }
                    ?>
            </div>
        </div> 
    </div>
    
   <!-- <div class="listing_detail_div">
    	<div class="section_div">	
            <h2 class="header-cont">
同様の掲載</h2>
            <div class="body-cont">
                <div  style="width:90%;margin:auto">
                    <div class="about-carousel text-center ">
                            <?php
                                $selsimilar=mysql_query("select * from seminar where id <> $_REQUEST[id] and (typeid=$selsemitype[id] or puposeid=$selsemipurpose[id])");
                        
                                while($fetsimilar=mysql_fetch_array($selsimilar))
                                {
                                    $selsemiphoto=mysql_query("select * from seminar_photos where seminar_id=$fetsimilar[id] limit 0,1");
                                    $fetsemiphoto=mysql_fetch_array($selsemiphoto);
                            ?>
                        <div style="margin:0 7px;border:1px solid #ddd;">
                            <a href="infomation.php?id=<?php echo $fetsimilar['id']; ?>">
                                <img src="../img/<?php echo $fetsemiphoto['image']; ?>" style="height:250px;width:100%;" class="center-block" />
                            </a>
                            <h4 class="slick-f"><?php $marutra = explode('"',translate(str_replace(" ","+",$fetsimilar['title']))); echo $marutra[1] ; ?></h4>
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




    
