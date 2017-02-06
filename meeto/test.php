<?php   
  require_once('db.php');
  $selcity=mysql_query("select * from cities where id=1041");
  $fetcity=mysql_fetch_array($selcity);
  $locarray=array();
	$data = mysql_query("select * from seminar where cityid=1041");
	while($row = mysql_fetch_array($data)){
	$locarray[] = $row;
	}
  ?>
<!DOCTYPE html>
<html lang="en"> 
 <?php	require_once('head.php');   ?>
 
 <body onload="seminarlisting('<?php echo $_REQUEST['id']; ?>')">     
 <?php	
	require_once('header.php');  
				
	require_once('loginsignup.php'); 	
?>				

		
		<div id="map" style="height:300px;width:300px;"></div>
		<script type="text/javascript">
	codeAddress('<?php echo $fetcity['name']; ?>');
	function codeAddress(city) {
		alert(city);
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
		
		var map = new google.maps.Map(document.getElementById('map'), {
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
			'<h3>'+locations[i]['title']+'</h3>' +
			'<p>'+locations[i]['address']+'</p>' +        '</div>');
			  infowindow.open(map, marker);
			}
		  })(marker, i));
		}
	}
</script>

 
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


    
