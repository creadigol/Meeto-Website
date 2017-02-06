<?php
	include('../db.php');
	
	//FETCH ALL THE STATE ACCORDING TO COUNTRY ID
	function getState($country_id){
		$statearray = array();
		$fetchstate = mysql_query("select * from states where country_id = '".$country_id."' ");	
		$count = mysql_num_rows($fetchstate);
		if($count > 0){
			$i = 0;
			while($fetchstaterow = mysql_fetch_array($fetchstate)){
				$statearray[$i]['id'] = intval($fetchstaterow['id']);
				$statearray[$i]['name'] = $fetchstaterow['name'];
				
				$i++;
			}
		}else{
			$statearray = 0;
		}	
		
		return $statearray;
	}
	
	$country_id = $_POST['country_id'];
	
	if(isset($_POST['country_id']) && isset($_POST['country_id']) != ''){
		$fetchstate = getState($country_id);
	
		if($fetchstate > 0){
			$emp['status_code'] = 1;
			$emp['message'] = "Successfully get the States";	
			$emp['state_detail'] = $fetchstate;
			$response['state_detail'] = $emp;	
		}else{
			$emp['status_code'] = 0;
			$emp['message'] = "No Data Found";	
			$response['state_detail'] = $emp;	
		}
	}else{
		$emp['status_code'] = 0;
		$emp['message'] = "Missing Parameters";	
		$response['state_detail'] = $emp;
	}
echo json_encode($response);
?>