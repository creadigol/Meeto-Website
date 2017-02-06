<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


	public function __construct() {
		
		parent::__construct();
		//$this->load->library(array('session'));
		//$this->load->helper(array('url'));
		$this->load->model('User_model');	
	}
	
	public function index() {
		
	}
	
	public function register()
	{	
		$fname=$this->input->post('fname');
		$lname=$this->input->post('lname');
		$email=$this->input->post('email');
		$password=$this->input->post('password');
		$type=$this->input->post('type');
		
		if($type=="FACEBOOK")
		{
			$id="";
			$fb_id=$this->input->post('fb_id');
			if( empty($fname) || empty($email) || empty($fb_id))
			{
				$res['status_code']=0;
				$res['message']="Parameter missing";
			}
			else
			{
				$fb_id=$this->db->query("select count(*) as count from user where fb_id = '".$fb_id."' ");
				$fb_id=$fb_id->result();
				if($fb_id[0]->{'count'}>0)
				{
					$res['status_code']=4;
					$res['message']="FB Acount Already Exist";	
				}
				else
				{
					if($this->User_model->create_users($id,$fname,$lname,$email,$password,$type))
					{
						$query=$this->db->query("select * from user where email='".$email."' ");
						foreach($query->result() as $row)
						{ 
							$res1['id']=$row->id;
							$res1['fname']=$row->fname;
							$res1['lname']=$row->lname;
							$res1['email']=$row->email;
							$res1['type']=$row->type;
							$value=$res1;
						}
						$res['status_code']=1;
						$res['message']="Registration successful";
						$res['user']=$value;
					}
					else
					{
						$res['status_code']=0;
						$res['message']="Registration not successfully";
					}
				}
			}
		}
		else if($type=="LOCAL")
		{
			$id="";
			if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password) && !empty($type))
			{
				$selemail=$this->db->query("select count(*) as count from user where email = '".$email."' ");
				$fetemail=$selemail->result();
				if($fetemail[0]->{'count'}>0)
				{
					$res['status_code']=4;
					$res['message']="Email Already Exist";	
				}
				else
				{
					if($this->User_model->create_users($id,$fname,$lname,$email,$password,$type))
					{
						$query=$this->db->query("select * from user where email='".$email."' ");
						foreach($query->result() as $row)
						{ 
							$res1['id']=$row->id;
							$res1['fname']=$row->fname;
							$res1['lname']=$row->lname;
							$res1['email']=$row->email;
							$res1['type']=$row->type;
							$value=$res1;
						}
						$res['status_code']=1;
						$res['message']="Registration successful";
						$res['user']=$value;
					}
					else
					{
						$res['status_code']=3;
						$res['message']="Registration not successfully";
					}
				}
			}
			else
			{
				$res['status_code']=0;
				$res['message']="Parameter missing";
			}
			
		}
		echo json_encode($res);
	}
	
	public function login()
	{
		$type=$this->input->post('type');
		if(!empty($type))
		{
			if($type=="LOCAL")
			{
				$email=$this->input->post('email');
				$password=$this->input->post('password');
				if(empty($email) || empty($password))
				{
					$res['status_code']=0;
					$res['message']="Email or Password Parameter missing..";
				}
				else
				{
					if($data = $this->User_model->get_localuser($email,$password))
					{
						foreach($data as $value)
						{
							$uid = $value->id;
							$data1['uid'] = $value->id;
							$data1['fname'] = $value->fname;
							$data1['lname'] = $value->lname;
							$data1['email'] = $value->email;
							$data1['email_verify'] = $value->email_verify;
							
							$query = $this->db->query("select * from user_detail where uid='".$uid."' ");
							if($result = $query->result())
							{
								$data1['gender'] = $result[0]->{'gender'};
								$data1['dob'] = $result[0]->{'dob'};
								$data1['phoneno'] = $result[0]->{'phoneno'};
								$data1['address'] = $result[0]->{'address'};
								$data1['yourself'] = $result[0]->{'yourself'};
								$data1['photo'] = "http://creadigol.biz/meeto/img/".$result[0]->{'photo'};
							}
							else
							{
								$data1['gender'] = "";
								$data1['dob'] = "";
								$data1['phoneno'] = "";
								$data1['address'] = "";
								$data1['yourself'] = "";
								$data1['photo'] = "";
							}
							
							$query = $this->db->query("select * from user_company where uid='".$uid."' ");
							if($result = $query->result())
							{
								$data1['company_name'] = $result[0]->{'name'};
								$data1['company_description'] = $result[0]->{'description'};
								
								$query1 = $this->db->query("select * from timezone where id='".$result[0]->{'timezoneid'}."' ");
								if($result1 = $query1->result())
								{
									$data1['timezone'] = $result1[0]->{'name'};
								}
								else
								{
									$data1['timezone'] = "";
								}
							}
							else
							{
								$data1['company_name'] = "";
								$data1['company_description'] = "";
								$data1['timezone'] = "";
							}
							
							$query = $this->db->query("select * from user_language where uid='".$uid."' ");
							if($result = $query->result())
							{
								$i=0;
								foreach($result as $val)
								{
									$query1 = $this->db->query("select * from language where id='".$val->lid."' ");
									
									if($result1 = $query1->result())
									{
										$data1['language']['language_name_'.$i] = $result1[0]->{'name'};
									}
									else
									{
										$data1['language'] = "";
									}
									$i++;
								}
							}
							else
							{
								$data1['language'] = "";
							}
						}
						$res['status_code']=1;
						$res['message']="Login Successfully With LOCAL..";
						$res['user']=$data1;
					}
					else
					{
						$res['status_code']=0;
						$res['message']="Invalid Email or Password";
					}
				}
			}
			
			else if($type=="FACEBOOK")
			{
				$fb_id=$this->input->post('fb_id');
					if(!empty($fb_id) && $data=$this->User_model->get_users($fb_id))
					{
						foreach($data as $value)
						{
							$uid = $value->id;
							$data1['uid'] = $value->id;
							$data1['fname'] = $value->fname;
							$data1['lname'] = $value->lname;
							$data1['email'] = $value->email;
							$data1['email_verify'] = $value->email_verify;
							
							$query = $this->db->query("select * from user_detail where uid='".$uid."' ");
							if($result = $query->result())
							{
								$data1['gender'] = $result[0]->{'gender'};
								$data1['dob'] = $result[0]->{'dob'};
								$data1['phoneno'] = $result[0]->{'phoneno'};
								$data1['address'] = $result[0]->{'address'};
								$data1['yourself'] = $result[0]->{'yourself'};
								$data1['photo'] = "http://creadigol.biz/meeto/img/".$result[0]->{'photo'};
							}
							else
							{
								$data1['gender'] = "";
								$data1['dob'] = "";
								$data1['phoneno'] = "";
								$data1['address'] = "";
								$data1['yourself'] = "";
								$data1['photo'] = "";
							}
							
							$query = $this->db->query("select * from user_company where uid='".$uid."' ");
							if($result = $query->result())
							{
								$data1['company_name'] = $result[0]->{'name'};
								$data1['company_description'] = $result[0]->{'description'};
								
								$query1 = $this->db->query("select * from timezone where id='".$result[0]->{'timezoneid'}."' ");
								if($result1 = $query1->result())
								{
									$data1['timezone'] = $result1[0]->{'name'};
								}
								else
								{
									$data1['timezone'] = "";
								}
							}
							else
							{
								$data1['company_name'] = "";
								$data1['company_description'] = "";
								$data1['timezone'] = "";
							}
							
							$query = $this->db->query("select * from user_language where uid='".$uid."' ");
							if($result = $query->result())
							{
								$i=0;
								foreach($result as $val)
								{
									$query1 = $this->db->query("select * from language where id='".$val->lid."' ");
									
									if($result1 = $query1->result())
									{
										$data1['language']['language_name_'.$i] = $result1[0]->{'name'};
									}
									else
									{
										$data1['language'] = "";
									}
									$i++;
								}
							}
							else
							{
								$data1['language'] = "";
							}
						}
						$res['status_code']=1;
						$res['message']="Login Successfully With FACEBOOK..";
						$res['user']=$data1;
					}
					else
					{
						$res['status_code']=2;
						$res['message']="facebook id missing";
					}
			}
			else
			{
				$res['status_code']=0;
				$res['message']="Type Parameter Invalid..";
			}
		}		
		else
		{
			$res['status_code']=0;
			$res['message']="Type Parameter missing..";
		}
		echo json_encode($res);  
	}

	public function changepass()
	{
		$id=$this->input->post('id');
		$password=$this->input->post('password');
		$newpassword=$this->input->post('newpassword');
		if(empty($id) || empty($password) || empty($newpassword))
		{
			$res['status_code']=0;
			$res['message']="Parameter Missing";
		}
		else
		{
			$query=$this->db->query("select count(*) as c from user where id='".$id."' and password='".md5($password)."' ");
			$result=$query->result();
			if($result[0]->{'c'}==0)
			{
				$res['status_code']=0;
				$res['message']="Id or Password Doesn't match";
			}
			else
			{
				if($this->User_model->changepass($id,$password,$newpassword))
				{
					$res['status_code']=1;
					$res['message']="Password Change Successfully";
				}
				else
				{
					$res['status_code']=0;
					$res['message']="Password Not Changed Successfully";
				}
			}
		}
		echo json_encode($res);
	}
	
	public function forgotpass()
	{
		$email=$this->input->post('email');
		if(empty($email))
		{
			$res['status_code']=0;
			$res['message']="Parameter Missing";
		}
		else
		{
			$query=$this->db->query("select count(*) as c from user where email='".$email."' ");
			$result=$query->result();
			if($result[0]->{'c'}==0)
			{
				$res['status_code']=0;
				$res['message']="email does not exist";
			}
			else
			{
				function generatePassword($length = 8) {
					$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					$count = mb_strlen($chars);
					for ($i = 0, $result = ''; $i < $length; $i++) {
						$index = rand(0, $count - 1);
						$result .= mb_substr($chars, $index, 1);
					}
					return $result;
				}
				
				$newpassword = generatePassword();
				
				if($this->User_model->sendmail($email,$newpassword))
				{
					$res['status_code']=1;
					$res['message']="Send Mail Check Your Mail..";
				}
				else
				{
					$res['status_code']=0;
					$res['message']="Something Problem.";
				}
			}
		}
		echo json_encode($res);
	}
	
	public function home(){
		$id = $this->input->post('id');
		if(!empty($id))
		{
			$data = $this->User_model->home($id);
		}
		else
		{
			
		}
		echo json_encode($res);
	}
	
	public function searchseminar()
	{
		$city = $this->input->post('city');
		$type = $this->input->post('type');
		$facility = $this->input->post('facility');
		$purpose = $this->input->post('purpose');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$from_time = $this->input->post('from_time');
		$to_time = $this->input->post('to_time');
		$seat = $this->input->post('seat');
		$seminartype = $this->input->post('seminartype');
		
		$data = $this->User_model->searchseminar($type,$city,$facility,$from_date,$to_date,$from_time,$to_time,$purpose,$seat,$seminartype);
		if(empty($data))
		{
			$res['status_code']=0;
			$res['message']='NO RECORD FOUND';
		}
		else
		{
			$i=0;
			foreach($data as $key => $value){
				$res1[$i]['id']=$value->id;
				$res1[$i]['uid']=$value->uid;
				$res1[$i]['title']=$value->title;
				$res1[$i]['tagline']=$value->tagline;
				$res1[$i]['description']=$value->description;
				$res1[$i]['total_seat']=$value->total_seat;
				$res1[$i]['total_booked_seat']=$value->total_booked_seat;
				
				$i++;
			}
			$res['status_code']=1;
			$res['message']='Seminar List';
			$res['seminar_detail']=$res1;
		}
		echo json_encode($res);
	}
	
	public function userprofile()
	{
		$type = $this->input->post('type');
		$uid = $this->input->post('user_id');
		
		if($type=="VIEW")
		{
			if(!empty($uid))
			{
				if($data = $this->User_model->userprofile($uid,$type))
				{
					foreach($data as $value)
					{
						$data1['uid'] = $value->id;
						$data1['fname'] = $value->fname;
						$data1['lname'] = $value->lname;
						$data1['email'] = $value->email;
						
						$query = $this->db->query("select * from user_detail where uid='".$uid."' ");
						if($result = $query->result())
						{
							$data1['gender'] = $result[0]->{'gender'};
							$data1['dob'] = $result[0]->{'dob'};
							$data1['phoneno'] = $result[0]->{'phoneno'};
							$data1['address'] = $result[0]->{'address'};
							$data1['yourself'] = $result[0]->{'yourself'};
							$data1['countryid'] = $result[0]->{'countryid'};
							$data1['stateid'] = $result[0]->{'stateid'};
							$data1['cityid'] = $result[0]->{'cityid'};
							$data1['photo'] = "http://creadigol.biz/meeto/img/".$result[0]->{'photo'};
						}
						else
						{
							$data1['gender'] = "";
							$data1['dob'] = "";
							$data1['phoneno'] = "";
							$data1['address'] = "";
							$data1['yourself'] = "";
							$data1['countryid'] = "";
							$data1['stateid'] = "";
							$data1['cityid'] = "";
							$data1['photo'] = "";
						}
						
						$query = $this->db->query("select * from user_company where uid='".$uid."' ");
						if($result = $query->result())
						{
							$data1['company_name'] = $result[0]->{'name'};
							$data1['company_description'] = $result[0]->{'description'};
							
							$query1 = $this->db->query("select * from timezone where id='".$result[0]->{'timezoneid'}."' ");
							if($result1 = $query1->result())
							{
								$data1['timezone'] = $result1[0]->{'name'};
								$data1['organization'] = $result1[0]->{'organization'};
								$data1['faxno'] = $result1[0]->{'faxno'};
								$data1['url'] = $result1[0]->{'url'};
							}
							else
							{
								$data1['timezone'] = "";
								$data1['organization'] = "";
								$data1['faxno'] = "";
								$data1['url'] = "";
							}
						}
						else
						{
							$data1['company_name'] = "";
							$data1['company_description'] = "";
							$data1['timezone'] = "";
						}
						
						$query = $this->db->query("select * from user_language where uid='".$uid."' ");
						if($result = $query->result())
						{
							$i=0;
							foreach($result as $val)
							{
								$query1 = $this->db->query("select * from language where id='".$val->lid."' ");
								
								if($result1 = $query1->result())
								{
									$data1['language']['language_name_'.$i] = $result1[0]->{'name'};
								}
								else
								{
									$data1['language'] = "";
								}
								$i++;
							}
						}
						else
						{
							$data1['language'] = "";
						}
					}
					
					$res['status_code']=1;
					$res['message']='Seminar List';
					$res['user_detail']=$data1;
				}
				else
				{
					$res['status_code']=0;
					$res['message']='Record Not Found.';
				}
			}
			else
			{
				$res['status_code']=0;
				$res['message']='Invalid UID';
			}
		}
		if($type=="EDIT")
		{
			if(!empty($uid))
			{
				if($data = $this->User_model->userprofile($uid,$type))
				{
					$res['status_code']=1;
					$res['message']='User Detail Updated Successfully.';
				}
				else
				{
					$res['status_code']=0;
					$res['message']='Record Not Found.';
				}
			}
			else
			{
				$res['status_code']=0;
				$res['message']='Invalid UID';
			}
		}
		echo json_encode($res);
	}
	
	public function userlisting()
	{
		$uid = $this->input->post('user_id');
		if(!empty($uid))
		{
			if($data = $this->User_model->userlisting($uid))
			{
				$i=0;
				foreach($data as $value)
				{
					$data1[$i]['seminar_id'] = $value->id;
					$data1[$i]['title'] = $value->title;
					$data1[$i]['tagline'] = $value->tagline;
					$data1[$i]['description'] = $value->description;
					
					$query = $this->db->query("select * from seminar_photos where seminar_id='".$value->id."' ");
					if($result = $query->result())
					{
						$data1[$i]['photo'] = "http://creadigol.biz/meeto/img/".$result[0]->{'image'};
					}
					else
					{
						$data1[$i]['photo'] = "";
					}
					$i++;
				}
				
				$res['status_code']=1;
				$res['message']='Seminar List';
				$res['seminar_detail']=$data1;
			}
			else
			{
				$res['status_code']=0;
				$res['message']='Record Not Found.';
			}
		}
		else
		{
			$res['status_code']=0;
			$res['message']='Invalid UID';
		}
		echo json_encode($res);
	}
	
	public function userbooking()
	{
		$uid = $this->input->post('user_id');
		if(!empty($uid))
		{
			if($data = $this->User_model->userbooking($uid))
			{
				$i=0;
				foreach($data as $value)
				{
					$data1[$i]['seminar_id'] = $value->seminar_id;
					$data1[$i]['booking_id'] = $value->id;
					$data1[$i]['uid'] = $value->uid;
					$data1[$i]['from_date'] = $value->from_date;
					$data1[$i]['status'] = $value->approval_status;
					
					$query = $this->db->query("select * from user where id='".$value->uid."' ");
					if($result = $query->result())
					{
						$data1[$i]['host_name'] = $result[0]->{'fname'}." ".$result[0]->{'lname'};
					}
					else
					{
						$data1[$i]['photo'] = "";
					}
					
					$query = $this->db->query("select * from seminar_photos where seminar_id='".$value->seminar_id."' ");
					if($result = $query->result())
					{
						$data1[$i]['photo'] = "http://creadigol.biz/meeto/img/".$result[0]->{'image'};
					}
					else
					{
						$data1[$i]['photo'] = "";
					}
					
					$query = $this->db->query("select * from seminar where id='".$value->seminar_id."' ");
					if($result = $query->result())
					{
						$data1[$i]['title'] = $result[0]->{'title'};
					}
					else
					{
						$data1[$i]['title'] = "";
					}
					$i++;
				}
				
				$res['status_code']=1;
				$res['message']='Seminar List';
				$res['booked_seminar_detail']=$data1;
			}
			else
			{
				$res['status_code']=0;
				$res['message']='Record Not Found.';
			}
		}
		else
		{
			$res['status_code']=0;
			$res['message']='Invalid UID';
		}
		echo json_encode($res);
	}
	
	public function userwishlist()
	{
		$uid = $this->input->post('user_id');
		if(!empty($uid))
		{
			if($data = $this->User_model->userwishlist($uid))
			{
				$i=0;
				foreach($data as $value)
				{
					$data1[$i]['seminar_id'] = $value->seminar_id;
					$data1[$i]['wishlist_id'] = $value->id;
					$data1[$i]['uid'] = $value->uid;
					$data1[$i]['date'] = date("d-m-Y",$value->created_date/1000);
					
					$query = $this->db->query("select * from seminar where id='".$value->seminar_id."' ");
					if($result = $query->result())
					{
						$data1[$i]['title'] = $result[0]->{'title'};
					}
					else
					{
						$data1[$i]['title'] = "";
					}
					
					$query = $this->db->query("select * from seminar_photos where seminar_id='".$value->seminar_id."' ");
					if($result = $query->result())
					{
						$data1[$i]['photo'] = "http://creadigol.biz/meeto/img/".$result[0]->{'image'};
					}
					else
					{
						$data1[$i]['photo'] = "";
					}
					$i++;
				}
				
				$res['status_code']=1;
				$res['message']='Seminar List';
				$res['wishlist_seminar_detail']=$data1;
			}
			else
			{
				$res['status_code']=0;
				$res['message']='Seminar Not Found in Your Wishlist.';
			}
		}
		else
		{
			$res['status_code']=0;
			$res['message']='Invalid UID';
		}
		echo json_encode($res);
	}
	
	public function deletewishlist()
	{
		$uid = $this->input->post('user_id');
		$seminar_id = $this->input->post('seminar_id');
				
		$uidquery=$this->db->query("select * from user where id = '".$uid."' ");
		$uidresult=$uidquery->result();
		
		$seminarquery=$this->db->query("select * from seminar where id = '".$seminar_id."' ");
		$seminarresult=$seminarquery->result();
		
		$query=$this->db->query("select * from wishlist where uid = '".$uid."' and seminar_id = '".$seminar_id."' ");
		$result=$query->result();
		
		if(!empty($uidresult))
		{
			if(!empty($seminarresult))
			{
				if(!empty($result))
				{
					$data = $this->User_model->deletewishlist($uid,$seminar_id);
					
					$res['status_code']=1;
					$res['message']='Wishlist Deleted Successfully.';
				}
				else
				{
					$res['status_code']=0;
					$res['message']='Wishlist Not Found.';
				}
			}
			else
			{
				$res['status_code']=0;
				$res['message']='Seminar Not Found.';
			}
		}
		else
		{
			$res['status_code']=0;
			$res['message']='User Not Found.';
		}
		
		echo json_encode($res);
	}
	
	public function deletebooking()
	{
		$uid = $this->input->post('user_id');
		$seminar_id = $this->input->post('seminar_id');
				
		$uidquery=$this->db->query("select * from user where id = '".$uid."' ");
		$uidresult=$uidquery->result();
		
		$seminarquery=$this->db->query("select * from seminar where id = '".$seminar_id."' ");
		$seminarresult=$seminarquery->result();
		
		$query=$this->db->query("select * from seminar_booking where uid = '".$uid."' and seminar_id = '".$seminar_id."' ");
		$result=$query->result();
		
		if(!empty($uidresult))
		{
			if(!empty($seminarresult))
			{
				if(!empty($result))
				{
					$data = $this->User_model->deletebooking($uid,$seminar_id);
					
					$res['status_code']=1;
					$res['message']='Seminar Booking Deleted Successfully.';
				}
				else
				{
					$res['status_code']=0;
					$res['message']='Seminar Booking Not Found.';
				}
			}
			else
			{
				$res['status_code']=0;
				$res['message']='Seminar Not Found.';
			}
		}
		else
		{
			$res['status_code']=0;
			$res['message']='User Not Found.';
		}
		
		echo json_encode($res);
	}
	
	public function deleteseminar()
	{
		$uid = $this->input->post('user_id');
		$seminar_id = $this->input->post('seminar_id');
				
		$uidquery=$this->db->query("select * from user where id = '".$uid."' ");
		$uidresult=$uidquery->result();
		
		$seminarquery=$this->db->query("select * from seminar where id = '".$seminar_id."' ");
		$seminarresult=$seminarquery->result();
		
		$query=$this->db->query("select * from seminar where uid = '".$uid."' and id = '".$seminar_id."' ");
		$result=$query->result();
		
		if(!empty($uidresult))
		{
			if(!empty($seminarresult))
			{
				if(!empty($result))
				{
					$data = $this->User_model->deleteseminar($uid,$seminar_id);
					
					$res['status_code']=1;
					$res['message']='Seminar Deleted Successfully.';
				}
				else
				{
					$res['status_code']=0;
					$res['message']='Seminar Not Found.';
				}
			}
			else
			{
				$res['status_code']=0;
				$res['message']='Seminar Not Found.';
			}
		}
		else
		{
			$res['status_code']=0;
			$res['message']='User Not Found.';
		}
		
		echo json_encode($res);
	}
	
	public function notification()
	{
		$uid = $this->input->post('user_id');
		$synctime = $this->input->post('synctime');
		if($data = $this->User_model->notification($uid,$synctime))
		{
			$res['status_code']=1;
			$res['message']='Notification.';
			$res['notification_detail']=$data;
		}
		else
		{
			$res['status_code']=0;
			$res['message']='Notification Not Found.';
		}
		
		echo json_encode($res);
	}
	
	public function verifyemail()
	{
		$uid = $this->input->post('user_id');
		$email = $this->input->post('email');
		
		$query = $this->db->query("select * from user where id='".$uid."' and email='".$email."' ");
		
		if($result=$query->result())
		{
			$key= md5($email);
			$url = "http://www.creadigol.biz/meeto/Verification.php?uid=".$uid."&key=".$key;
			$subject = "Email Verification";
			$to = $email;
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$message  = '<html>';	
			$message .= '<body>';
			$message .= '<h2>To activate your account please click on Activate buttton</h2>';
			$message .= '<table>';
			$message .= '<tr>';
			$message .= '<td align="center" width="300" height="40" bgcolor="#000091" style="border-radius:5px;color:#ffffff;display:block"><a href='.trim($url).' style="color:#ffffff;font-size:16px;font-weight:bold;font-family:Helvetica,Arial,sans-serif;text-decoration:none;line-height:40px;width:100%;display:inline-block">Activate Your Account</a></td>';
			$message .= '</tr>';
			$message .= '</table>';
			$message .= '</div>';
			$message .= '</body>';
			$message .= '</html>';
			$sentmail = mail($to,$subject,$message,$headers);
			
			if($sentmail)
			{
				$res['status_code']=1;
				$res['message']='A confirmation email has been sent to "'.$email.'" Please click on the Activate Button to Activate your account!';
			}
			else
			{
				$res['status_code']=0;
				$res['message']='Mail Not Sent.';
			}
		}
		else
		{
			$res['status_code']=0;
			$res['message']='User ID or E-mail not match.';
		}
		echo json_encode($res);
	}
	
	public function setgcm()
	{
		$uid = $this->input->post('user_id');
		$gcm_id = $this->input->post('gcm_id');
		
		if($data = $this->User_model->setgcm($uid,$gcm_id))
		{
			$res['status_code']=1;
			$res['message']='GCM ID set Successfully.';
		}
		else
		{
			$res['status_code']=0;
			$res['message']='GCM ID not set.';
		}
		echo json_encode($res);
	}
	
	public function loginwithfb()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$fb_id = $this->input->post('fb_id');
		
		if(!empty($fb_id) && !empty($name) && $data=$this->User_model->loginwithfb($name,$email,$fb_id))
		{
			foreach($data as $value)
			{
				$uid = $value->id;
				$data1['uid'] = $value->id;
				$data1['fname'] = $value->fname;
				$data1['lname'] = $value->lname;
				$data1['email'] = $value->email;
				$data1['email_verify'] = $value->email_verify;
				
				$query = $this->db->query("select * from user_detail where uid='".$uid."' ");
				if($result = $query->result())
				{
					$data1['gender'] = $result[0]->{'gender'};
					$data1['dob'] = $result[0]->{'dob'};
					$data1['phoneno'] = $result[0]->{'phoneno'};
					$data1['address'] = $result[0]->{'address'};
					$data1['yourself'] = $result[0]->{'yourself'};
					$data1['photo'] = "http://creadigol.biz/meeto/img/".$result[0]->{'photo'};
				}
				else
				{
					$data1['gender'] = "";
					$data1['dob'] = "";
					$data1['phoneno'] = "";
					$data1['address'] = "";
					$data1['yourself'] = "";
					$data1['photo'] = "";
				}
				
				$query = $this->db->query("select * from user_company where uid='".$uid."' ");
				if($result = $query->result())
				{
					$data1['company_name'] = $result[0]->{'name'};
					$data1['company_description'] = $result[0]->{'description'};
					
					$query1 = $this->db->query("select * from timezone where id='".$result[0]->{'timezoneid'}."' ");
					if($result1 = $query1->result())
					{
						$data1['timezone'] = $result1[0]->{'name'};
					}
					else
					{
						$data1['timezone'] = "";
					}
				}
				else
				{
					$data1['company_name'] = "";
					$data1['company_description'] = "";
					$data1['timezone'] = "";
				}
				
				$query = $this->db->query("select * from user_language where uid='".$uid."' ");
				if($result = $query->result())
				{
					$i=0;
					foreach($result as $val)
					{
						$query1 = $this->db->query("select * from language where id='".$val->lid."' ");
						
						if($result1 = $query1->result())
						{
							$data1['language']['language_name_'.$i] = $result1[0]->{'name'};
						}
						else
						{
							$data1['language'] = "";
						}
						$i++;
					}
				}
				else
				{
					$data1['language'] = "";
				}
			}
			$res['status_code']=1;
			$res['message']="Login Successfully With FACEBOOK..";
			$res['user']=$data1;
		}
		else
		{
			$res['status_code']=0;
			$res['message']="facebook id or name missing";
		}
		
		echo json_encode($res);
	}
	
	
}