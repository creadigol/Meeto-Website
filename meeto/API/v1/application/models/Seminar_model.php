<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seminar_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function translate($text)
	{
		if(preg_match('/^[a-zA-Z+0-9-,?\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]*$/',$text))
		{
			return $data = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=ja&dt=t&q=$text");
		}
		else
		{
			return '[[["'.$text;
		}
	}

	public function home()
	{
		$query = $this->db->query("select * from cities where status ='1' ");
		return $query->result();
	}

	public function searchseminar()
	{
		$city = $this->input->post('city');
		$type = $this->input->post('type');
		//$facility = $this->input->post('facility');
		$purpose = $this->input->post('purpose');
		$industry = $this->input->post('industry');
		$from_date = strtotime($this->input->post('from_date'))*1000;
		$to_date = (strtotime($this->input->post('to_date'))*1000)+86399;
		$from_time = $this->input->post('from_time');
		$to_time = $this->input->post('to_time');
		$seat = $this->input->post('seat');
		$seminartype = $this->input->post('seminartype');
		
		if($type=='NOFILTER')
		{
			$query = $this->db->query("select * from seminar where approval_status='approved' and status=1 and cityid in (select id from cities where name like '%".$city."%' ) or title like '%".$city."%' or tagline like '%".$city."%' or description like '%".$city."%' ");
		}
		if($type=='CITY')
		{
			$query = $this->db->query("select * from seminar where approval_status='approved' and status=1 and cityid = '".$city."' ");
		}
		if($type=='FILTER')
		{
			if(empty($city))
			{
				$filter="";
				if(!empty($seminartype))
				{
					$seminartype = rtrim($seminartype, ",");
					$seminartype = str_replace(",","','",$seminartype);
					$filter .= "typeid in ('$seminartype') or ";
				}
				/* if(!empty($facility))
				{
					$facility = rtrim($facility, ",");
					$facility = str_replace(",","','",$facility);
					$filter .= "id in (select seminar_id from seminar_facility where facility_id in ('$facility')) or ";
				} */
				if(!empty($from_date) && $to_date>86399)
				{
					$filter .= "id in (select seminar_id from seminar_day where from_date BETWEEN '$from_date' and '$to_date') or ";
				}
				if(!empty($purpose))
				{
					$purpose = rtrim($purpose, ",");
					$purpose = str_replace(",","','",$purpose);
					$filter .= "id in (select seminar_id from seminar_purpose where attendees_id in ('$purpose') ) or ";
				}
				if(!empty($industry))
				{
					$industry = rtrim($industry, ",");
					$industry = str_replace(",","','",$industry);
					$filter .= "id in (select seminar_id from seminar_industry where industry_id in ('$industry') or ";
				}
				if(!empty($filter))
				{
					$filter = rtrim($filter, " or ");
					$query = $this->db->query("select * from seminar where approval_status='approved' and status=1 and ($filter) ");
				}
				else
				{
					$query = $this->db->query("select * from seminar where approval_status='approved' and status=1 ");
				}
			}
			else
			{
				$filter="";
				if(!empty($seminartype))
				{
					$seminartype = rtrim($seminartype, ",");
					$seminartype = str_replace(",","','",$seminartype);
					$filter .= "typeid in ('$seminartype') or ";
				}
				/* if(!empty($facility))
				{
					$facility = rtrim($facility, ",");
					$facility = str_replace(",","','",$facility);
					$filter .= "id in (select seminar_id from seminar_facility where facility_id in ('$facility')) or ";
				} */
				if(!empty($from_date) && $to_date>86399)
				{
					$filter .= "id in (select seminar_id from seminar_day where (from_date BETWEEN '$from_date' and '$to_date') OR (to_date BETWEEN '$from_date' and '$to_date') OR (from_date <= '$from_date' AND to_date >= '$to_date') ) or ";
				}
				if(!empty($purpose))
				{
					$purpose = rtrim($purpose, ",");
					$purpose = str_replace(",","','",$purpose);
					$filter .= "id in (select seminar_id from seminar_purpose where attendees_id in ('$purpose') ) or ";
				}
				if(!empty($industry))
				{
					$industry = rtrim($industry, ",");
					$industry = str_replace(",","','",$industry);
					$filter .= "id in (select seminar_id from seminar_industry where industry_id in ('$industry') ) or ";
				}
				if(!empty($filter))
				{
					$filter = rtrim($filter, "or ");
					//echo $filter;
					//echo "select * from seminar where approval_status='approved' and status=1 and cityid in (select id from cities where name like '%$city%') and ($filter) ";
					$query = $this->db->query("select * from seminar where approval_status='approved' and status=1 and cityid in (select id from cities where name like '%$city%') and ($filter) ");
				}
				else
				{
					$query = $this->db->query("select * from seminar where approval_status='approved' and status=1 and cityid in (select id from cities where name like '%$city%')");
				}
			}
		}
		
		return $result=$query->result();
		
	}
	
	public function addseminar()
	{
		$seminaredit=$this->input->post('seminaredit');
		if(!$seminaredit)
		{
			//INSERT INTO SEMINAR
			$uid=$this->input->post('user_id');
			$title=$this->input->post('title');
			$tagline=$this->input->post('tagline');
			$description=$this->input->post('description');
			$total_seat=$this->input->post('total_seat');
			//$total_booked_seat=$this->input->post('total_booked_seat');
			//$qualification=$this->input->post('qualification');
			$address=$this->input->post('address');
			$latitude=$this->input->post('latitude');
			$longitude=$this->input->post('longitude');
			$typeid=$this->input->post('typeid');
			$countryid=$this->input->post('countryid');
			$stateid=$this->input->post('stateid');
			$cityid=$this->input->post('cityid');
			$zipcode=$this->input->post('zipcode');
			$phoneno=$this->input->post('phoneno');
			$hostperson_name=$this->input->post('hostperson_name');
			$contact_email=$this->input->post('contact_email');
			$status=1;
			$approval_status='pending';
			
			/* function getLatLong($address)
			{
				if(!empty($address)){
					//Formatted address
					$formattedAddr = str_replace(' ','+',$address);
					//Send request and receive json data by address
					$geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
					$output = json_decode($geocodeFromAddr);
					//Get latitude and longitute from json data
					if(!empty($output->results[0]->geometry->location->lat) || !empty($output->results[0]->geometry->location->lng)){
						$data['latitude']  = $output->results[0]->geometry->location->lat; 
						$data['longitude'] = $output->results[0]->geometry->location->lng;
						
						if(!empty($data)){
							return $data;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					return false;   
				}
			}
			
			$latLong = getLatLong($address);
			if(empty($latLong['latitude']) || empty($latLong['longitude'])){
				return false;
			}
			$latitude = $latLong['latitude'];
			$longitude = $latLong['longitude']; */

			$data_seminar = array(
			'uid' => $uid,
			'title' => $title,
			'tagline' => $tagline,
			'description' => $description,
			'total_seat' => $total_seat,
			'total_booked_seat' => 0,
			'qualification' => '',
			'address' => $address,
			'lat' => $latitude,
			'lng' => $longitude,
			'typeid' => $typeid,
			'countryid' => $countryid,
			'stateid' => $stateid,
			'cityid' => $cityid,
			'zipcode' => $zipcode,
			'phoneno' => $phoneno,
			'hostperson_name' => $hostperson_name,
			'contact_email' => $contact_email,
			'status' => 1,
			'approval_status' => 'pending',
			'created_date'=>round(microtime(true)*1000),
			'modified_date'=>round(microtime(true)*1000),
			);
			
			$this->db->insert('seminar', $data_seminar);
			$seminar_id = $this->db->insert_id();
			
			if(!empty($seminar_id) && $seminar_id!=0)
			{
				//INSERT INTO SEMINAR_DAY
				$from_date=$this->input->post('from_date');
				$to_date=$this->input->post('to_date');
				//$from_time=$this->input->post('from_time');
				//$to_time=$this->input->post('to_time');
				
				$data_day = array(
					'seminar_id' => $seminar_id,
					'from_date' => $from_date,
					'to_date' => $to_date,
					//'from_time' => $from_time,
					//'to_time' => $to_time,
				);
				
				$this->db->insert('seminar_day', $data_day);
				
				//INSERT INTO SEMINAR_FACILITY
				$facility_id=$this->input->post('facility_id');
				
				if(!empty($facility_id))
				{
					$facility_id = explode(',',$facility_id);
					$facility_id = array_unique($facility_id);
					$facility_id_count = count($facility_id);
					$i=1;
					foreach($facility_id as $val)
					{
						$i++;
						$data_facility = array(
							'seminar_id' => $seminar_id,
							'facility_id' => $val,
							'status' => 1 ,
						);
						
						$this->db->insert('seminar_facility', $data_facility);
						
						if($i>=$facility_id_count)
							break;
					}
				}
				
				//INSERT INTO SEMINAR_PURPOSE
				$purpose_id=$this->input->post('purpose_id');
				
				if(!empty($purpose_id))
				{
					$purpose_id = explode(',',$purpose_id);
					$purpose_id = array_unique($purpose_id);
					$purpose_id_count = count($purpose_id);
					$i=1;
					foreach($purpose_id as $val)
					{
						$i++;
						$data_purpose = array(
							'seminar_id' => $seminar_id,
							'attendees_id' => $val,
							'status' => 1 ,
						);
						
						$this->db->insert('seminar_purpose', $data_purpose);
						
						if($i>=$purpose_id_count)
							break;
					}
				}
				
				//INSERT INTO SEMINAR_INDUSTRY
				$industry_id=$this->input->post('industry_id');
				
				if(!empty($industry_id))
				{
					$industry_id = explode(',',$industry_id);
					$industry_id = array_unique($industry_id);
					$industry_id_count = count($industry_id);
					$i=1;
					foreach($industry_id as $val)
					{
						$i++;
						$data_industry = array(
							'seminar_id' => $seminar_id,
							'industry_id' => $val,
							'status' => 1 ,
						);
						
						$this->db->insert('seminar_industry', $data_industry);
						
						if($i>=$industry_id_count)
							break;
					}
				}
				
				//INSERT INTO SEMINAR_PHOTOS
				$photo_count=$this->input->post('photo_count');
				for($i=1;$i<=$photo_count;$i++)
				{
					/* $rotateval=$this->input->post('rotateval_'.$i);
					$photo = $this->input->post('photo_'.$i);
					$image = base64_decode($photo);
					//$name = time().$i."seminarimg.jpeg";
					$name = "semiimage".time().$i.".jpeg";
					$path = "../img/".$name;
					$success = file_put_contents($path, $image);
					
					$data_photos = array(
						'seminar_id' => $seminar_id,
						'image' => $name,
						'rotateval' => $rotateval,
					);
					$this->db->insert('seminar_photos', $data_photos); */
					
					$rotateval=$this->input->post('rotateval_'.$i);
					//$photo = time()."_".$_FILES['photo_'.$i]['name'];
					$photo = "semiimage".time().$i.".jpeg";
					$path = "../img/";
					$fpath = $path.$photo;
					move_uploaded_file($_FILES['photo_'.$i]['tmp_name'],$fpath);
					
					$data_photos = array(
						'seminar_id' => $seminar_id,
						'image' => $photo,
						'rotateval' => $rotateval,
					);
					
					$this->db->insert('seminar_photos', $data_photos);
				}
				
				$query = $this->db->query("select * from seminar where id='".$seminar_id."' ");
				return $query->result();
			}
			else
			{
				return false;
			}
		}
		else
		{
			//UPDATE INTO SEMINAR
			$seminar_id=$this->input->post('seminar_id');
			$uid=$this->input->post('user_id');
			$title=$this->input->post('title');
			$tagline=$this->input->post('tagline');
			$description=$this->input->post('description');
			$total_seat=$this->input->post('total_seat');
			//$total_booked_seat=$this->input->post('total_booked_seat');
			//$qualification=$this->input->post('qualification');
			$address=$this->input->post('address');
			$latitude=$this->input->post('latitude');
			$longitude=$this->input->post('longitude');
			$typeid=$this->input->post('typeid');
			$countryid=$this->input->post('countryid');
			$stateid=$this->input->post('stateid');
			$cityid=$this->input->post('cityid');
			$zipcode=$this->input->post('zipcode');
			$phoneno=$this->input->post('phoneno');
			$hostperson_name=$this->input->post('hostperson_name');
			$contact_email=$this->input->post('contact_email');
			//$status=$this->input->post('status');
			//$approval_status=$this->input->post('approval_status');
			
			/* function getLatLong($address)
			{
				if(!empty($address)){
					//Formatted address
					$formattedAddr = str_replace(' ','+',$address);
					//Send request and receive json data by address
					$geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
					$output = json_decode($geocodeFromAddr);
					//Get latitude and longitute from json data
					$data['latitude']  = $output->results[0]->geometry->location->lat; 
					$data['longitude'] = $output->results[0]->geometry->location->lng;
					//Return latitude and longitude of the given address
					if(!empty($data)){
						return $data;
					}else{
						return false;
					}
				}else{
					return false;   
				}
			}
			
			$latLong = getLatLong($address);
			$latitude = $latLong['latitude'];
			$longitude = $latLong['longitude']; */

			$data_seminar = array(
			'title' => $title,
			'tagline' => $tagline,
			'description' => $description,
			'total_seat' => $total_seat,
			//'qualification' => $qualification,
			'address' => $address,
			'lat' => $latitude,
			'lng' => $longitude,
			'typeid' => $typeid,
			'countryid' => $countryid,
			'stateid' => $stateid,
			'cityid' => $cityid,
			'zipcode' => $zipcode,
			'phoneno' => $phoneno,
			'hostperson_name' => $hostperson_name,
			'contact_email' => $contact_email,
			'modified_date'=>round(microtime(true)*1000),
			);
			
			$this->db->set($data_seminar);
			$this->db->where('id',$seminar_id);
			$this->db->update('seminar', $data_seminar);
			
			//UPDATE INTO SEMINAR_DAY			
			$from_date=$this->input->post('from_date');
			$to_date=$this->input->post('to_date');
			//$from_time=$this->input->post('from_time');
			//$to_time=$this->input->post('to_time');
			
			$data_day = array(
				'seminar_id' => $seminar_id,
				'from_date' => $from_date,
				'to_date' => $to_date,
				//'from_time' => $from_time,
				//'to_time' => $to_time,
			);
			
			$this->db->set($data_day);
			$this->db->where('seminar_id',$seminar_id);
			$this->db->update('seminar_day', $data_day);
			
			//UPDATE INTO SEMINAR_FACILITY
			$this->db->where('seminar_id', $seminar_id);
			$this->db->delete('seminar_facility');
			
			$facility_id=$this->input->post('facility_id');
			
			if(!empty($facility_id))
			{
				$facility_id = explode(',',$facility_id);
				$facility_id = array_unique($facility_id);
				$facility_id_count = count($facility_id);
				$i=1;
				foreach($facility_id as $val)
				{
					$i++;
					$data_facility = array(
						'seminar_id' => $seminar_id,
						'facility_id' => $val,
						'status' => 1 ,
					);
					
					$this->db->insert('seminar_facility', $data_facility);
					
					if($i>=$facility_id_count)
						break;
				}
			}
			
			//UPDATE INTO SEMINAR_PURPOSE
			$this->db->where('seminar_id', $seminar_id);
			$this->db->delete('seminar_purpose');
			
			$purpose_id=$this->input->post('purpose_id');
			
			if(!empty($purpose_id))
			{
				$purpose_id = explode(',',$purpose_id);
				$purpose_id = array_unique($purpose_id);
				$purpose_id_count = count($purpose_id);
				$i=1;
				foreach($purpose_id as $val)
				{
					$i++;
					$data_purpose = array(
						'seminar_id' => $seminar_id,
						'attendees_id' => $val,
						'status' => 1 ,
					);
					
					$this->db->insert('seminar_purpose', $data_purpose);
					
					if($i>=$purpose_id_count)
						break;
				}
			}
			
			//UPDATE INTO SEMINAR_INDUSTRY
			$this->db->where('seminar_id', $seminar_id);
			$this->db->delete('seminar_industry');
			
			$industry_id=$this->input->post('industry_id');
			
			if(!empty($industry_id))
			{
				$industry_id = explode(',',$industry_id);
				$industry_id = array_unique($industry_id);
				$industry_id_count = count($industry_id);
				$i=1;
				foreach($industry_id as $val)
				{
					$i++;
					$data_industry = array(
						'seminar_id' => $seminar_id,
						'industry_id' => $val,
						'status' => 1 ,
					);
					
					$this->db->insert('seminar_industry', $data_industry);
					
					if($i>=$industry_id_count)
						break;
				}
			}
			
			//UPDATE INTO SEMINAR_PHOTOS
			//$this->db->where('seminar_id', $seminar_id);
			//$this->db->delete('seminar_photos');
			$deleteImage=$this->input->post('deleteImage');
			if(!empty($deleteImage))
			{
				$deleteImageExpload = explode(",",$deleteImage);
				foreach($deleteImageExpload as $deleteImageExploadFE){
					$deleteImageExploadUnlink = explode("/img/",$deleteImageExploadFE);
					$this->db->where('seminar_id', $seminar_id);
					$this->db->where('image', $deleteImageExploadUnlink[1]);
					$this->db->delete('seminar_photos');
				}
			}
			
			$photo_count=$this->input->post('photo_count');
			for($i=1;$i<=$photo_count;$i++)
			{
				/* $rotateval=$this->input->post('rotateval_'.$i);
				$photo = $this->input->post('photo_'.$i);
				$image = base64_decode($photo);
				//$name = time().$i."seminarimg.jpeg";
				$name = "semiimage".time().$i.".jpeg";
				$path = "../img/".$name;
				$success = file_put_contents($path, $image);
				
				$data_photos = array(
					'seminar_id' => $seminar_id,
					'image' => $name,
					'rotateval' => $rotateval,
				);
				$this->db->insert('seminar_photos', $data_photos); */
				
				$rotateval=$this->input->post('rotateval_'.$i);
				//$photo = time()."_".$_FILES['photo_'.$i]['name'];
				$photo = "semiimage".time().$i.".jpeg";
				$path = "../img/";
				$fpath = $path.$photo;
				move_uploaded_file($_FILES['photo_'.$i]['tmp_name'],$fpath);
				
				$data_photos = array(
					'seminar_id' => $seminar_id,
					'image' => $photo,
					'rotateval' => $rotateval,
				);
				
				$this->db->insert('seminar_photos', $data_photos);
				/*$photo = time()."_".$_FILES['photo_'.$i.'']['name'];
				$photo = "semiimage".time().$i.".jpeg";
				$path = "../img/";
				$fpath = $path.$photo;
				move_uploaded_file($_FILES['photo_'.$i.'']['tmp_name'],$fpath);
				
				$data_photos = array(
				'seminar_id' => $seminar_id,
				'image' => $photo,
				);
				
				$this->db->insert('seminar_photos', $data_photos);*/
			}
			
			$query = $this->db->query("select * from seminar where id='".$seminar_id."' ");
			return $query->result();
			
		}
	}
	
	public function seminardetail($seminar_id)
	{
		$query = $this->db->query("select * from seminar where status=1 and approval_status='approved' and id='".$seminar_id."' ");
		return $query->result();
	}

	public function ownseminardetail($seminar_id)
	{
		$query = $this->db->query("select * from seminar where id='".$seminar_id."' ");
		return $query->result();
	}

	public function seminarbooking($seminar_id,$uid,$booking_no,$book_seat,$from_date,$to_date,$message)
	{
		$data_seminar = array(
		'seminar_id' => $seminar_id,
		'uid' => $uid,
		'booking_no' => $booking_no,
		'book_seat' => $book_seat,
		'from_date' => $from_date,
		'to_date' => $to_date,
		'approval_status' => 'pending',
		'message' => $message,
		'created_date'=>round(microtime(true)*1000),
		'modified_date'=>round(microtime(true)*1000),
		);
		
		$this->db->insert('seminar_booking', $data_seminar);
		$this->db->insert_id();
		
		$seminar = $this->db->query("select * from seminar where id='".$seminar_id."' ");
		$seminar_r = $seminar->result();
		
		$data = array(
			'total_booked_seat'=>($seminar_r[0]->{'total_booked_seat'}+$book_seat),
		);
		$this->db->set($data);
		$this->db->where('id',$seminar_id);
		return $this->db->update('seminar',$data);
	}
	
	public function addtowishlist($seminar_id,$uid)
	{
		$user = $this->db->query("select * from user where id='".$uid."' ");
		$user_r = $user->result();
		$seminar = $this->db->query("select * from seminar where id='".$seminar_id."' ");
		$seminar_r = $seminar->result();
		
		$wishlist = $this->db->query("select * from wishlist where seminar_id='".$seminar_id."' and uid='".$uid."' ");
		$wishlist_r = $wishlist->result();
		if(!empty($user_r) && !empty($seminar_r) && empty($wishlist_r))
		{
			$wishlist = array(
			'seminar_id' => $seminar_id,
			'uid' => $uid,
			'status' => 1,
			'created_date'=>round(microtime(true)*1000),
			'modified_date'=>round(microtime(true)*1000),
			);
			
			return $this->db->insert('wishlist', $wishlist);
		}
		else
		{
			return false;
		}
	}
	
	public function searchseminarstring()
	{
		return true;
	}
	
	public function seminarbookinglist($seminar_id,$uid)
	{
		$seminar = $this->db->query("select * from seminar_booking where seminar_id='".$seminar_id."' ");
		//echo "select * from seminar_booking where seminar_id='".$seminar_id."' ";
		return $seminar->result();
	}
	
	public function acceptdeclineseminar($seminar_id,$uid,$approval_status,$booking_no)
	{
		$seminar = $this->db->query("select * from seminar_booking where seminar_id='".$seminar_id."' and uid='".$uid."' and booking_no='".$booking_no."' and approval_status='pending' ");
		if($seminar_day = $seminar->result())
		{
			if($approval_status=="declined"){
				$seminar = $this->db->query("select * from seminar where id='".$seminar_id."' ");
				$seminar_r = $seminar->result();
				
				$data = array(
					'total_booked_seat'=>($seminar_r[0]->{'total_booked_seat'}-$seminar_day[0]->{'book_seat'}),
				);
				$this->db->set($data);
				$this->db->where('id',$seminar_id);
				$this->db->update('seminar',$data);
				$data="";
			}
			$data = array(
				'approval_status'=>$approval_status,
				'modified_date'=>round(microtime(true)*1000),
			);
			$this->db->set($data);
			$this->db->where('seminar_id',$seminar_id);
			$this->db->where('uid',$uid);
			$this->db->where('booking_no',$booking_no);
			return $this->db->update('seminar_booking',$data);
		}
		else
		{
			return false;
		}
	}
	
	public function booking_ticket_download($seminar_id,$uid,$booking_id)
	{
		$seminar = $this->db->query("select * from seminar_booking where seminar_id='".$seminar_id."' and uid='".$uid."' and id='".$booking_id."' and approval_status='accepted' ");
		if($seminar->result())
		{			
			return $seminar->result();
		}
		else
		{
			return false;
		}
	}
	
	
}