 <?php   
  require_once('db.php');
  $selcity=mysql_query("select * from cities where id=$_REQUEST[id]");
  $fetcity=mysql_fetch_array($selcity);
  $locarray=array();
   $data = mysql_query("select *,p.image as image from seminar,seminar_photos as p where cityid=$_REQUEST[id] and approval_status='approved' and seminar.id=p.seminar_id group by seminar.id");
	while($row = mysql_fetch_array($data))
	{
	$locarray[] = $row;
	}
  ?>
<!DOCTYPE html><html lang="en"> 
 <?php	require_once('head1.php');   ?>
 
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnWG6DJ5dpqNjBC1CZI8xdS3L769lQHuc&callback=initMap" type="text/javascript"></script>
<script>
$(window).scroll(function () {
		var sc = $(window).scrollTop()
		var divheight = $("#left_section").height();
		var footerheight = $("#footer").height();
		var footerheight = footerheight+15;
		//alert(divheight);
		if (sc > 195) {
			//alert("top"+sc);
			$(".map_div").removeClass("bottom_fix");
			$(".map_div").removeAttr("style");
			$(".map_div").addClass("fixed_map");
		} else {
			//alert(sc);
			$(".map_div").removeClass("fixed_map");
			$(".map_div").removeClass("bottom_fix");
			$(".map_div").removeAttr("style");
		}
		
		if(sc > divheight-425){
			//alert("bottom"+sc);
			$(".map_div").removeClass("fixed_map");
			$(".map_div").addClass("bottom_fix");
			$(".map_div").css("bottom",footerheight+"px");
		}
	});
</script>

<!-- NAVBAR================================================== --> 
 <body  class="city-select-on" onload="hideselect(); seminarlisting('<?php echo $_REQUEST['id']; ?>');" style="width:100%; position:absolute;">
    
 <?php	require_once('header1.php');   ?>
 <!-- pop up start -->			<!-- Sing in modal -->			
 <?php	require_once('loginsignup.php');	?>				
 <!-- pop up end-->
 
 <!-- slide -->
 
 <div class="clearfix"></div>
	<div class="container-flude slide-border full-container">
    	<!--<div style="height:10px; top:85px;position:fixed;background-color:#fff;z-index:1;width:100%;"></div>-->
		<div class="filter_bar_div">
        	<div class="container">
            	<div class="col-xs-12 col-sm-5 col-md-5">
                	<div class="filt">
                    	<h5 style="margin-bottom:15px;"><center>日付</center></h5>
                        <div class="group-control" style="margin-bottom:5px;">
                        	<center>
                                から&nbsp;
                                <input type="date" placeholder="Check in date" id="startdate" name="checkin" onchange="seminarlisting('<?php echo $_REQUEST['id']; ?>');" class="date" >
                                &nbsp; 
に&nbsp;
                                <input type="date" placeholder="Check Out date" id="enddate" name="checkout" onchange="seminarlisting('<?php echo $_REQUEST['id']; ?>');" class="date">	
                            </center>
                        </div>
                    </div>
					<div class="bottom-margin-20">&nbsp;</div>
                </div>
				
				
				
                <div class="col-xs-12 col-sm-7 col-md-7 seminar-Attendees-box">
                	<div class="filt">
                    	<h5><center>セミナー参加者</center></h5>
                        <div class="group-control">
                        	<div class="Seminar-Attendees">
								<?php 
					           $purpose=mysql_query("select * from purpose order by id asc");
					           while($purposedetail = mysql_fetch_array($purpose))
					            { ?>
						      <label>
							  <input type="checkbox" class="room_type" value="<?php echo $purposedetail['id'];?>" name="purpose" id="purpose" onclick="seminarlisting('<?php echo $_REQUEST['id']; ?>');"/>
							 <span class="check"><?php  $marutra = explode('"',translate(str_replace(" ","+",$purposedetail['name']))); echo $marutra[1];?></span>
							  </label> 
				        	<?php
					        }
					       ?>
                            </div>
                        </div>
                    </div>
					<div class="bottom-margin-20">&nbsp;</div>
                </div>
			
			
			
				<div class="col-xs-12 col-sm-10 col-md-10">
                	<div class="filt">
                    	<h5><center>産業タイプ</center></h5>
                        <div class="group-control">
                        	<div class="Seminar-Attendees industry-type">
								<?php 
					           $industry=mysql_query("select * from industry order by id asc");
					           while($industrydetail = mysql_fetch_array($industry))
					            { ?>
						      <label>
							  <input type="checkbox" class="room_type" value="<?php echo $industrydetail['id'];?>" name="industry" id="industry" onclick="seminarlisting('<?php echo $_REQUEST['id']; ?>');"/>
							 <span class="check"><?php  $marutra = explode('"',translate(str_replace(" ","+",$industrydetail['name']))); echo $marutra[1];?></span>
							  </label> 
				        	<?php
					        }
					       ?>
                            </div>
                        </div>
                    </div>
				<div class="bottom-margin-20"></div>		
                </div>

				<div class="col-xs-12 col-sm-2 col-md-2 seminar-Attendees-box">
                	<div class="filt">
                    	<h5><center>
セミナー・プレイス</center></h5>
                        <div class="group-control">
                        	<div class="Seminar-Attendees seminar-place">
								<?php 
					           $semitype=mysql_query("select * from seminar_type order by id asc");
					           while($semitypedetail = mysql_fetch_array($semitype))
					            { ?>
						      <label>
							  <input type="checkbox" class="room_type" value="<?php echo $semitypedetail['id'];?>" name="semitype" id="semitype" onclick="seminarlisting('<?php echo $_REQUEST['id']; ?>');"/>
							 <span class="check"><?php  $marutra = explode('"',translate(str_replace(" ","+",$semitypedetail['name']))); echo $marutra[1];?></span>
							  </label> 
				        	<?php
					        }
					       ?>
                            </div>
                        </div>
                    </div>
				<div class="bottom-margin-20">&nbsp;</div>						
                </div>
            </div>
        </div>
        <div class="row" style="margin:0;"><!--height:650px;-->
            <div id="left_section" class="f-left col-xs-12 col-sm-6 col-md-7" style="overflow-y:auto;margin:10px 0 15px;">
                <div class="row center-block" style="min-height:500px;" id="cityseminar">
                </div>
            </div>
            
            <div class="modal fade" id="myModal" role="dialog"></div>
            
            <div  class="col-xs-12 col-sm-6 col-md-5 map_div" style="height:550px;margin-top:10px;">
                <div class="row center-block" style="height:100%;padding-right:15px;">
                    <div class="col-xs-12" style="padding:0;height:100%;position:relative;border:1px solid rgba(0,0,0,0.1);">
                        <div class="" id="semimap" style="height:100%;width:100%;position:absolute;right:0;">	
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<script type="text/javascript">
	//codeAddress('<?php $marutra = explode('"',translate(str_replace(" ","+",$fetcity['name']))); echo $marutra[1];?>');
	codeAddress('<?php echo $fetcity['name']; ?>');
	function codeAddress(city) {
		geocoder = new google.maps.Geocoder();
		var address = city;
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				//alert("Latitude: "+results[0].geometry.location.lat());
				//alert("Longitude: "+results[0].geometry.location.lng());
				//document.getElementById("lat").value=results[0].geometry.location.lat();
				//document.getElementById("lng").value=results[0].geometry.location.lng();
				var lat = results[0].geometry.location.lat();
				var lng = results[0].geometry.location.lng();
				init(lat,lng);
			} 
			else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}
	function init(lat,lng){
		
		var locations = <? echo json_encode($locarray); ?>;
		
		//alert(locations);
		//alert(locations.length);
		/*var locations = [
		  ['HaPo\'el HaMizrahi B', 32.0827912,34.8179502],
		  ['Rabin Medical Center', 32.0748641,34.8045606],
		  ['Giv\'at Shmuel', 32.0839787,34.7764766],
		  ['Ganei Tikva', 32.0612576,34.8666507],
		  ['Kiryat Ono', 32.0584508,34.8391313]
		];*/
		
		var map = new google.maps.Map(document.getElementById('semimap'), {
		  zoom: 12,
		  center: new google.maps.LatLng(lat, lng),
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		var infowindow = new google.maps.InfoWindow();

		var marker, i;

		for (i = 0; i < locations.length; i++) {
				//alert(locations[i]['lat']);
				//alert(locations[i]['lng']);
		  marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']),
			map: map
		  });
		  marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');

		  google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
			  infowindow.setContent('<div class="info_content">' +
			 
			'<p><img src=img/'+locations[i]['image']+' style="width:300px;height:200px;"/></p>' +
			'<a href=infomation.php?id='+locations[i]['seminar_id']+'>' +
			'<h4>'+locations[i]['title']+'</h4></a>' +
			'<p>'+locations[i]['address']+'</p>' +     
			'</div>');
			  infowindow.open(map, marker);
			}
		  })(marker, i));
		}
	}
</script>
	</div>
 
 <!-- slide END -->
	
 <?php	require_once('footer1.php');   ?>

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
	
	<!-- price-slider -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 
      <script type="text/javascript" src="price_range.js"></script>
	  <script src="js/index.js"></script>
	  <script>
				$(function() {
			$( "#slider-range" ).slider({
			  range: true,
			  min: 0,
			  max: 1000,
			  values: [ 0, 450 ],
			  animate:true,
			  step:5,
			  slide: function( event, ui ) {
				$( "#amount-min" ).val( "min : " + ui.values[ 0 ] + "$");
				$( "#amount-max" ).val( "max : " + ui.values[ 1 ] + "$");
			  }
			});

			$( "#amount-min" ).val("min : " + $( "#slider-range" ).slider( "values", 0 ) + "$");
			$( "#amount-max" ).val( "max : " + $( "#slider-range" ).slider( "values", 1 ) + "$");
		  });
	  </script>
	
	
  </body>
</html>


    
