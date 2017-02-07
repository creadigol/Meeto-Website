<?php
	include('../db.php');
	
	//FETCH ALL THE COUNTRY
	function getCountry(){
		$countryarray = array();
		$fetchcountry = mysql_query("select * from countries where name='Japan' ");
		$count = mysql_num_rows($fetchcountry);
		if($count > 0){
			$i = 0;
			while($fetchcountryrow = mysql_fetch_array($fetchcountry)){
				$countryarray[$i]['id'] = intval($fetchcountryrow['id']);
				$countryarray[$i]['sortname'] = $fetchcountryrow['sortname'];
				$countryarray[$i]['name'] = $fetchcountryrow['name'];
				
				$i++;
			}
		}else{
			$countryarray = 0;
		}	
		
		return $countryarray;
	}
	
	$fetchcountry = getCountry();
	
	if($fetchcountry > 0){
		$emp['status_code'] = 1;
		$emp['message'] = "Successfully get the Countries";	
		$emp['country_detail'] = $fetchcountry;
		$response['country_detail'] = $emp;	
	}else{
		$emp['status_code'] = 0;
		$emp['message'] = "No Data Found";	
		$response['country_detail'] = $emp;	
	}
	
echo json_encode($response);
?>