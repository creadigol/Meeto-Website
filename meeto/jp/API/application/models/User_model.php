<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function create_users($id,$fname,$lname,$email,$password,$type)
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
		return $result = $query->result();
	}

	public function get_users($id)
	{
		$query=$this->db->query("select * from user where fb_id like '".$id."' ");
		return $result=$query->result();
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
	
	public function home($id)
	{
		
	}

	public function searchseminar($type,$city,$facility,$from_date,$to_date,$from_time,$to_time,$purpose,$seat,$seminartype)
	{
		if($type=='NOFILTER'){
			$query = $this->db->query("select * from seminar where cityid in (select id from cities where name like '%$city%' ) ");
		}
		else
		{
			$query = $this->db->query("select * from seminar where cityid in (select id from cities where name like '%$city%') and (id in (select seminar_id from seminar_facility where facility_id in ('$facility')) or puposeid in ('$purpose') or typeid in ('$seminartype') or id in (select seminar_id from seminar_day where from_date BETWEEN '$from_date' and '$to_date')) ");
			echo "select * from seminar where cityid in (select id from cities where name like '%$city%') and (id in (select seminar_id from seminar_facility where facility_id in ('$facility')) or puposeid in ('$purpose') or typeid in ('$seminartype') or id in (select seminar_id from seminar_day where from_date BETWEEN '$from_date' and '$to_date')) ";
		}
		
		return $result=$query->result();
		
	}
	
	public function userprofile($uid,$type)
	{
		if($type=="VIEW")
		{
			$query = $this->db->query("select * from user where id='".$uid."' ");
			return $result=$query->result();
		}
		if($type=="EDIT")
		{
			$query = $this->db->query("select * from user where id='".$uid."' ");
			if($result = $query->result())
			{
				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				/*if(empty($fname))
					$fname=$result[0]->fname;
				if(empty($fname))
					$fname=$result[0]->lname;*/
				$gender = $this->input->post('gender');
				$dob = $this->input->post('dob');
				$phoneno = $this->input->post('phoneno');
				$address = $this->input->post('address');
				$yourself = $this->input->post('yourself');
				$countryid = $this->input->post('countryid');
				$stateid = $this->input->post('stateid');
				$cityid = $this->input->post('cityid');
				$company_name = $this->input->post('company_name');
				$company_description = $this->input->post('company_description');
				$timezone = $this->input->post('timezone');
				$organization = $this->input->post('organization');
				$faxno = $this->input->post('faxno');
				$url = $this->input->post('url');
				$language = $this->input->post('language');
				
				$data = array(
					'fname'=>$fname,
					'lname'=>$lname,
				);
				$this->db->set($data);  
				$this->db->where("id", $uid);
				$user = $this->db->update("user", $data);
				
				$query = $this->db->query("select * from user_detail where uid='".$uid."' ");
				if($result = $query->result())
				{
					/*if(empty($gender))
						$fname=$result[0]->gender;
					if(empty($dob))
						$fname=$result[0]->dob;
					if(empty($phoneno))
						$fname=$result[0]->phoneno;
					if(empty($address))
						$fname=$result[0]->address;
					if(empty($yourself))
						$fname=$result[0]->yourself;*/
					$data = array(
						'gender'=>$gender,
						'dob'=>$dob,
						'phoneno'=>$phoneno,
						'address'=>$address,
						'yourself'=>$yourself,
						'countryid'=>$countryid,
						'stateid'=>$stateid,
						'cityid'=>$cityid,
					);
					$this->db->set($data);  
					$this->db->where("uid", $uid);
					$user_detail = $this->db->update("user_detail", $data);
				}
				else
				{
					$data = array(
						'uid'=>$uid,
						'gender'=>$gender,
						'dob'=>$dob,
						'phoneno'=>$phoneno,
						'address'=>$address,
						'yourself'=>$yourself,
						'countryid'=>$countryid,
						'stateid'=>$stateid,
						'cityid'=>$cityid,
					);
					$user_detail = $this->db->insert('user_detail', $data);
				}
				
				/*if(!empty($_FILES['photo']['name']))
				{
					$photo = time()."_".$_FILES['photo']['name'];
					$path = "../img/";
					$fpath = $path.$photo;
					move_uploaded_file($_FILES['photo']['tmp_name'],$fpath);
					
					$data = array(
						'photo'=>$photo,
					);
					$this->db->set($data);  
					$this->db->where("uid", $uid);
					$user_detail = $this->db->update("user_detail", $data);
				}*/
				
				if($photo = $this->input->post('photo'))
				{
					$image = base64_decode($photo);
					$name = time()."profileimg.jpeg";
					$path = "../img/".$name;
					$success = file_put_contents($path, $image);
					
					$data = array(
						'photo'=>$name,
					);
					$this->db->set($data);  
					$this->db->where("uid", $uid);
					$user_detail = $this->db->update("user_detail", $data);
				}
				
				$query = $this->db->query("select * from user_company where uid='".$uid."' ");
				if($result = $query->result())
				{
					/*if(empty($company_name))
						$fname=$result[0]->name;
					if(empty($company_description))
						$fname=$result[0]->description;
					if(empty($timezone))
						$fname=$result[0]->timezoneid;*/
					$data = array(
						'name'=>$company_name,
						'description'=>$company_description,
						'timezoneid'=>$timezone,
						'organization'=>$organization,
						'faxno'=>$faxno,
						'url'=>$url,
					);
					$this->db->set($data);  
					$this->db->where("uid", $uid);
					$user_detail = $this->db->update("user_company", $data);
				}
				else
				{
					$data = array(
						'uid'=>$uid,
						'name'=>$company_name,
						'description'=>$company_description,
						'timezoneid'=>$timezone,
						'organization'=>$organization,
						'faxno'=>$faxno,
						'url'=>$url,
					);
					$user_detail = $this->db->insert('user_company', $data);
				}
				
				if(!empty($language))
				{
					$language = explode(',',$language);
					$this->db->where('uid', $uid);
					$this->db->delete('user_language');
					$langcount = count($language);
					$i=1;
					foreach($language as $val)
					{
						$i++;
						$data = array(
							'uid'=>$uid,
							'lid'=>$val,
						);
						$user_detail = $this->db->insert('user_language', $data);
						if($i>=$langcount)
							break;
					}
				}
				else
				{
					$this->db->where('uid', $uid);
					$this->db->delete('user_language');
				}
				
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function userlisting($uid)
	{
		$query = $this->db->query("select * from seminar where uid='".$uid."' ");
		
		return $result=$query->result();
	}
	
	public function userbooking($uid)
	{
		$query = $this->db->query("select * from seminar_booking where uid='".$uid."' ");
		
		return $result=$query->result();
	}
	
	public function userwishlist($uid)
	{
		$query = $this->db->query("select * from wishlist where uid='".$uid."' ");
		
		return $result=$query->result();
	}
	
	public function deletewishlist($uid,$seminar_id)
	{
		$this->db->where('uid', $uid);
		$this->db->where('seminar_id', $seminar_id);
		return $this->db->delete('wishlist');
	}
	
	public function deletebooking($uid,$seminar_id)
	{
		$this->db->where('uid', $uid);
		$this->db->where('seminar_id', $seminar_id);
		return $this->db->delete('seminar_booking');
	}
	
	public function deleteseminar($uid,$seminar_id)
	{
		$this->db->where('uid', $uid);
		$this->db->where('id', $seminar_id);
		return $this->db->delete('seminar');
	}
	
	public function notification($uid,$synctime)
	{
		$query = $this->db->query("select * from notification where uid='".$uid."' and created_date >= '".$synctime."' ");
		return $result=$query->result();
	}
	
	public function verifyemail($uid,$email)
	{
		$query = $this->db->query("select * from notification where uid='".$uid."' and created_date >= '".$synctime."' ");
		return $result=$query->result();
	}
	
	public function setgcm($uid,$gcm_id)
	{
		$data = array(
			'gcm_id'=>$gcm_id,
		);
		$this->db->set($data);  
		$this->db->where("id", $uid);
		return $this->db->update("user", $data);
	}
	
	
	public function loginwithfb($name,$email,$fb_id)
	{
		$query=$this->db->query("select * from user where fb_id = '".$fb_id."' ");
		if($result=$query->result())
		{
			return $result=$query->result();
		}
		else
		{
			$fb_id=$this->input->post('fb_id');
			$data = array(
			'fname' => $name,
			'lname' => '',
			'email' => $email,
			'password' => "",
			'type'=> 2,
			'fb_id'=> $fb_id,
			'email_verify' => 0,
			'status' => 1,
			'created_date'=>(int)round(microtime(true)*1000),
			'modified_date'=>(int)round(microtime(true)*1000),
			);
			$this->db->insert('user', $data);
			
			$query=$this->db->query("select * from user where fb_id = '".$fb_id."' ");
			return $result=$query->result();
		}
	}
	
	
}