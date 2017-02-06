<?php
	include('../db.php');
	
	//FETCH ALL THE CITY ACCORDING TO STATE ID
	function getCity($state_id){
		$cityarray = array();
		$fetchcity = mysql_query("select * from cities where state_id = '".$state_id."' ");	
		$count = mysql_num_rows($fetchcity);
		if($count > 0){
			$i = 0;
			while($fetchcityrow = mysql_fetch_array($fetchcity)){
				$cityarray[$i]['id'] = intval($fetchcityrow['id']);
				$cityarray[$i]['name'] = $fetchcityrow['name'];
				
				$i++;
			}
		}else{
			$cityarray = 0;
		}	
		
		return $cityarray;	
	}
	
	$state_id = $_POST['state_id'];
	
	if(isset($_POST['state_id']) && isset($_POST['state_id']) != ''){
		$fetchcity = getCity($state_id);
	
		if($fetchcity > 0){
			$emp['status_code'] = 1;
			$emp['message'] = "Successfully get the Cities";	
			$emp['city_detail'] = $fetchcity;
			$response['city_detail'] = $emp;	
		}else{
			$emp['status_code'] = 0;
			$emp['message'] = "No Data Found";	
			$response['city_detail'] = $emp;	
		}
	}else{
		$emp['status_code'] = 0;
		$emp['message'] = "Missing Parameters";	
		$response['city_detail'] = $emp;
	}
echo json_encode($response);
?>