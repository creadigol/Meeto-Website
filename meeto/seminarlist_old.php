 <?php   
  require_once('db.php');
  $selcity=mysql_query("select * from cities where id=$_REQUEST[id]");
  $fetcity=mysql_fetch_array($selcity);
  $locarray=array();
   $data = mysql_query("select *,p.image as image from seminar,seminar_photos as p where cityid=$_REQUEST[id] and seminar.id=p.seminar_id group by seminar.id");
	while($row = mysql_fetch_array($data)){
	$locarray[] = $row;
	}
  ?>

<!DOCTYPE html><html lang="en"> 
 <?php	require_once('head.php');   ?>
 <!-- NAVBAR================================================== --> 
 <body onload="seminarlisting('<?php echo $_REQUEST['id']; ?>')">     
 <?php	require_once('header.php');   ?>
 <!-- pop up start -->			<!-- Sing in modal -->			
 <?php					require_once('loginsignup.php'); 				?>				
 <!-- pop up end-->
 
 <!-- slide -->
	<div class="container-flude slide-border full-container">
	
		<div class="slide f-left">
			<ul>
			<li class="li-padding border-li">
					<h6>Dates</h6>
					<div class="group-control r-left margin-r">
						<input type="date" placeholder="Check in date" id="startdate" name="checkin" onchange="seminarlisting('<?php echo $_REQUEST['id']; ?>');" >
						<input type="date" placeholder="Check Out date" id="enddate" name="checkout" onchange="seminarlisting('<?php echo $_REQUEST['id']; ?>');">	
						<select class="input-medium" name="time_in">
							<option value="">Time In</option>
							<option value="0:00:00">0:00:00</option>
							<option value="1:00:00">1:00:00</option>
							<option value="2:00:00">2:00:00</option>
							<option value="3:00:00">3:00:00</option>
							<option value="4:00:00">4:00:00</option>
							<option value="5:00:00">5:00:00</option>
							<option value="6:00:00">6:00:00</option>
							<option value="7:00:00">7:00:00</option>
							<option value="8:00:00">8:00:00</option>
							<option value="9:00:00">9:00:00</option>
							<option value="10:00:00">10:00:00</option>
							<option value="11:00:00">11:00:00</option>
							<option value="12:00:00">12:00:00</option>
							<option value="13:00:00">13:00:00</option>
							<option value="14:00:00">14:00:00</option>
							<option value="15:00:00">15:00:00</option>
							<option value="16:00:00">16:00:00</option>
							<option value="17:00:00">17:00:00</option>
							<option value="18:00:00">18:00:00</option>
							<option value="19:00:00">19:00:00</option>
							<option value="20:00:00">20:00:00</option>
							<option value="21:00:00">21:00:00</option>
							<option value="22:00:00">22:00:00</option>
							<option value="23:00:00">23:00:00</option>			
					    </select>
						
						<select class="input-medium" name="time_Out">
							<option value="">Time Out</option>
							<option value="0:00:00">0:00:00</option>
							<option value="1:00:00">1:00:00</option>
							<option value="2:00:00">2:00:00</option>
							<option value="3:00:00">3:00:00</option>
							<option value="4:00:00">4:00:00</option>
							<option value="5:00:00">5:00:00</option>
							<option value="6:00:00">6:00:00</option>
							<option value="7:00:00">7:00:00</option>
							<option value="8:00:00">8:00:00</option>
							<option value="9:00:00">9:00:00</option>
							<option value="10:00:00">10:00:00</option>
							<option value="11:00:00">11:00:00</option>
							<option value="12:00:00">12:00:00</option>
							<option value="13:00:00">13:00:00</option>
							<option value="14:00:00">14:00:00</option>
							<option value="15:00:00">15:00:00</option>
							<option value="16:00:00">16:00:00</option>
							<option value="17:00:00">17:00:00</option>
							<option value="18:00:00">18:00:00</option>
							<option value="19:00:00">19:00:00</option>
							<option value="20:00:00">20:00:00</option>
							<option value="21:00:00">21:00:00</option>
							<option value="22:00:00">22:00:00</option>
							<option value="23:00:00">23:00:00</option>			
					    </select>
						
						<select class="input-medium" name="guests" id=" " >
							<option value="">Renters</option>
							<option value="1">1 Renters</option>
							<option value="2">2 Renters</option>
							<option value="3">3 Renters</option>
							<option value="4">4 Renters</option>
							<option value="5">5 Renters</option>
							<option value="6">6 Renters</option>
							<option value="7">7 Renters</option>
							<option value="8">8 Renters</option>
							<option value="9">9 Renters</option>
							<option value="10-14">10-14 Renters</option>
							<option value="15-19">15-19 Renters</option>
							<option value="20-29">20-29 Renters</option>
							<option value="30-49">30-49 Renters</option>
							<option value="50-74">50-74 Renters</option>
							<option value="75-99">75-99 Renters</option>
							<option value="100+">100+ Renters</option>
						</select>
					</div>
					<div class="bottom-margin-20">&nbsp;</div>	
				</li>
				
				<li class="li-padding border-li">
					<span class="f-left">
					<h6>Purpose</h6>
					</span>	
					<span class="l-left">
					<?php 
					 $purpose=mysql_query("select * from seminar_purpose order by id desc");
					 while($purposedetail = mysql_fetch_array($purpose))
					 { ?>
						<label>
							<input type="checkbox" class="room_type" value="<?php echo $purposedetail['id'];?>" name="purpose" id="purpose" onclick="seminarlisting('<?php echo $_REQUEST['id']; ?>');"/>
							<span class="check"><?php echo $purposedetail['name'];?></span>
						</label> 
					<?php
					}
					?>
					</span>
				</li>
				<li class="li-padding border-li text-center">
					<span class="price-r f-left">Price range</span>
					<span id="price-slider">
					  <p>
						
						<input type="text" id="amount-min" readonly style="border:0; color:#000000; font-weight:normal;">
						<input type="text" id="amount-max" readonly style="border:0; color:#000000; font-weight:normal;">
					  </p>

					  <div id="slider-range"></div>

					</span>
				</li>
				
				<li class="li-padding border-li text-center">
					<a class="blue-button"> More Filters </a>
				</li>
				
				
				<div class="li-padding border-li text-center border-n">
					<nav aria-label="Page navigation">
					  <ul class="pagination pag-nation">
						<li>
						  <a href="#" aria-label="Previous"  class="pagination-botton">
							<span aria-hidden="true">Previous &nbsp; <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></span>
						  </a>
						</li>
						<li class="active"><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li>
						  <a href="#" aria-label="Next"  class="pagination-botton">
							<span aria-hidden="true"> Next &nbsp; <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
						  </a>
						</li>
					  </ul>
					</nav>
				</div>
			</ul>
			<div class="row center-block" id="cityseminar">
			</div>
			<div class="li-padding border-li text-center border-n">
					<nav aria-label="Page navigation">
					  <ul class="pagination pag-nation">
						<li>
						  <a href="#" aria-label="Previous"  class="pagination-botton">
							<span aria-hidden="true">Previous &nbsp; <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></span>
						  </a>
						</li>
						<li class="active"><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li>
						  <a href="#" aria-label="Next"  class="pagination-botton">
							<span aria-hidden="true"> Next &nbsp; <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
						  </a>
						</li>
					  </ul>
					</nav>
			</div>
		</div>
		<div class="modal fade" id="myModal" role="dialog">					
		</div>
		<div style="position:fixed;right:0;">
			<div class="" id="semimap" style="height:610px;width:538px;position:fixed !important;right:0;">	
			</div>
		</div>
		<script type="text/javascript">
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
		
		//alert(d[1]);
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


    
