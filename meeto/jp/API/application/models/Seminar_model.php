<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seminar_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	/*public function create_users($id,$fname,$lname,$email,$password,$type)
	{
		if($type=="FACEBOOK")
		{
			$fb_id=$this->input->post('fb_id');
			$data = array(
			'fname' => $fname,
			'lname' => $lname,
			'email' => $email,
			'password' => "",
			'type'=> 2,
			'fb_id'=> $fb_id,
			'email_verify' => 0,
			'status' => 1,
			'created_date'=>(int)round(microtime(true)*1000),
			'modified_date'=>(int)round(microtime(true)*1000),
			);
			return $this->db->insert('user', $data);
			//$insert_id = $this->db->result->insert_id();
		}
		elseif($type=="LOCAL")
		{
			$data = array(
			'fname' => $fname,
			'lname' => $lname,
			'email' => $email,
			'password' => md5($password), 
			'type'=> 1,
			'fb_id'=>"",
			'email_verify'=>0,
			'status'=>1,
			'created_date'=>(int)round(microtime(true)*1000),
			'modified_date'=>(int)round(microtime(true)*1000),
			);
			return $this->db->insert('user', $data);
			//$insert_id = $this->db->result->insert_id();
		}
	}

	public function get_localuser($email,$password)
	{
		$query = $this->db->query("select * from user where email = '".$email."' and password = '".md5($password)."' ");
		$result = $query->result();
		
		return $result;
	}

	public function get_users($id)
	{
		$query=$this->db->query("select * from user where fb_id like '".$id."' ");
		
		$result=$query->result();
		return $result;
	}
	
	public function changepass($id, $password, $newpassword) 
	{
		$data = array(
			'password'=>md5($newpassword),
		);
		$this->db->set($data);  
		$this->db->where("id", $id);
		return $this->db->update("user", $data);
	}

	public function sendmail($email, $newpassword) 
	{
		mail($email,"New Password For MEETTO","Your New Password For MEETTO Login Authenticatiuon..\nNEW PASSWORD :- ".$newpassword);
		
		$data = array(
			'password'=>md5($newpassword),
		);
		
		$this->db->set($data);  
		$this->db->where("email", $email);
		return $this->db->update("user", $data);
	}
	*/
	public function home()
	{
		$query = $this->db->query("SELECT *,count(cityid) as numofsemi FROM `seminar` group by cityid order by numofsemi desc");
		return $query->result();
	}

	public function searchseminar()
	{
		$city = $this->input->post('city');
		$type = $this->input->post('type');
		$facility = $this->input->post('facility');
		$purpose = $this->input->post('purpose');
		$industry = $this->input->post('industry');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$from_time = $this->input->post('from_time');
		$to_time = $this->input->post('to_time');
		$seat = $this->input->post('seat');
		$seminartype = $this->input->post('seminartype');
		
		if($type=='NOFILTER')
		{
			$query = $this->db->query("select * from seminar where cityid in (select id from cities where name like '%".$city."%' ) or title like '%".$city."%' or tagline like '%".$city."%' or description like '%".$city."%' ");
		}
		if($type=='CITY')
		{
			$query = $this->db->query("select * from seminar where cityid = '".$city."' ");
		}
		if($type=='FILTER')
		{
			if(empty($city))
			{
				$query = $this->db->query("select * from seminar where typeid in ('$seminartype') or (id in (select seminar_id from seminar_facility where facility_id in ('$facility')) or id in (select seminar_id from seminar_day where from_date BETWEEN '$from_date' and '$to_date') or id in (select seminar_id from seminar_purpose where attendees_id in ('$purpose') ) or id in (select seminar_id from seminar_industry where industry_id in ('$industry') )) ");
			}
			else
			{
				$query = $this->db->query("select * from seminar where cityid in (select id from cities where name like '%$city%') or typeid in ('$seminartype') or (id in (select seminar_id from seminar_facility where facility_id in ('$facility')) or id in (select seminar_id from seminar_day where from_date BETWEEN '$from_date' and '$to_date') or id in (select seminar_id from seminar_purpose where attendees_id in ('$purpose') ) or id in (select seminar_id from seminar_industry where industry_id in ('$industry') )) ");
			}
		}
		
		return $result=$query->result();
		
	}
	
	public function addseminar()
	{
		//INSERT INTO SEMINAR
		$uid=$this->input->post('user_id');
		$title=$this->input->post('title');
		$tagline=$this->input->post('tagline');
		$description=$this->input->post('description');
		$total_seat=$this->input->post('total_seat');
		//$total_booked_seat=$this->input->post('total_booked_seat');
		$qualification=$this->input->post('qualification');
		$address=$this->input->post('address');
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
		
		$data_seminar = array(
		'uid' => $uid,
		'title' => $title,
		'tagline' => $tagline,
		'description' => $description,
		'total_seat' => $total_seat,
		'total_booked_seat' => 0,
		'qualification' => $qualification,
		'address' => $address,
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
			$from_time=$this->input->post('from_time');
			$to_time=$this->input->post('to_time');
			
			$data_day = array(
				'seminar_id' => $seminar_id,
				'from_date' => $from_date,
				'to_date' => $to_date,
				'from_time' => $from_time,
				'to_time' => $to_time,
			);
			
			$this->db->insert('seminar_day', $data_day);
			
			//INSERT INTO SEMINAR_FACILITY
			$facility_id=$this->input->post('facility_id');
			
			if(!empty($facility_id))
			{
				$facility_id = explode(',',$facility_id);
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
				$photo = $this->input->post('photo_'.$i);
				$image = base64_decode($photo);
				//$name = time().$i."seminarimg.jpeg";
				$name = "semiimage".time().$i.".jpeg";
				$path = "../img/".$name;
				$success = file_put_contents($path, $image);
				
				$data_photos = array(
					'seminar_id' => $seminar_id,
					'image' => $name,
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
		else
		{
			return false;
		}
	}
	
	public function seminardetail($seminar_id)
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
		return $this->db->insert_id();
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
	
	public function acceptdeclineseminar($seminar_id,$uid,$approval_status)
	{
		$seminar = $this->db->query("select * from seminar_booking where seminar_id='".$seminar_id."' and uid='".$uid."' and approval_status='pending' ");
		if($seminar->result())
		{			
			$data = array(
				'approval_status'=>$approval_status,
				'modified_date'=>round(microtime(true)*1000),
			);
			$this->db->set($data);
			$this->db->where('seminar_id',$seminar_id);
			$this->db->where('uid',$uid);
			return $this->db->update('seminar_booking',$data);
		}
		else
		{
			return false;
		}
	}
	
	
}