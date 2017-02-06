<?php
function data($zip)
{
	$geocode=file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=395006&sensor=true");
	$output= json_decode($geocode);
	
	echo "<br>".$output->results[0]->address_components[0]->types[0];
	echo " = ".$output->results[0]->address_components[0]->{'long_name'};
	
	echo "<br>".$output->results[0]->address_components[1]->types[0];
	echo " = ".$output->results[0]->address_components[1]->{'long_name'};
	
	echo "<br>".$output->results[0]->address_components[3]->types[0];
	echo " = ".$output->results[0]->address_components[3]->{'long_name'};
	
	
	
	echo "<br>".$output->results[0]->{'formatted_address'};
	
}

echo data(395001);
?>