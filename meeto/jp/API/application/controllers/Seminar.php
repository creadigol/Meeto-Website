<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class Seminar extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->library(array('session'));
		//$this->load->helper(array('url'));
		$this->load->model('Seminar_model');	
	}
	
	public function index() {
		
	}
	
	/*public function register()
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
					if($this->Seminar_model->create_users($id,$fname,$lname,$email,$password,$type))
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
					if($this->Seminar_model->create_users($id,$fname,$lname,$email,$password,$type))
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
					$data = $this->Seminar_model->get_localuser($email,$password);
					if(!empty($data))
					{
						$query = $this->db->query("select * from user where email = '".$email."' and password = '".md5($password)."' ");
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
						$res['message']="Login Successfully..";
						$res['user']=$value;
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
					if(!empty($fb_id))
					{
						$resultfacebook=$this->Seminar_model->get_users($fb_id);
						if(empty($resultfacebook))
						{
							$res['status_code']=2;
							$res['message']="Give more details";
							$res['type']="FACEBOOK";
						}
						else
						{
							if($resultfacebook[0]->{'status'}==1)
							{
								$res['status_code']=1;
								$res['message']="User login successfully..";
								
								$res1['id']=$resultfacebook[0]->{'id'};
								$res1['fname']=$resultfacebook[0]->{'fname'};
								$res1['lname']=$resultfacebook[0]->{'lname'};
								$res1['email']=$resultfacebook[0]->{'email'};
								$res1['type']=$resultfacebook[0]->{'type'};
								
								$value=$res1;
								$res['user']=$value;
							}
						
							else
							{
								$res['status_code']=0;
								$res['message']="Your account is suspended.";
							}
						}
					}
					else
					{
						$res['status_code']=0;
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
				if($this->Seminar_model->changepass($id,$password,$newpassword))
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
				
				if($this->Seminar_model->sendmail($email,$newpassword))
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
	}*/
	
	public function home()
	{
		$uid = $this->input->post('user_id');
		$sync_time = $this->input->post('sync_time');
		
		$data = $this->Seminar_model->home();
		$i=0;
		foreach($data as $val){
			$res1[$i]['cityid']=$val->cityid;
			$query = $this->db->query("SELECT * FROM `cities` where id='".$res1[$i]['cityid']."' ");
			foreach($query->result() as $val1){
				$res1[$i]['cityname']=$val1->name;
			}
			$res1[$i]['cityimage']='';
			$i++;
		}
		
		if($uid!="")
		{
			$query = $this->db->query("SELECT * FROM `user` where id='".$uid."' ");
			foreach($query->result() as $val){
				$email_verify=$val->email_verify;
			}
			$query = $this->db->query("SELECT *,count(id) as numofnoti FROM `notification` where uid='".$uid."' and created_date > '".$sync_time."' ");
			foreach($query->result() as $val){
				$notification_count=$val->numofnoti;
			}
		}
		else
		{
			$email_verify="";
			$notification_count="";
		}
		$res['status_code']=1;
		$res['message']="Popular City List.";
		$res['List']=$res1;
		$res['notification_count']=$notification_count;
		$res['email_verify']=$email_verify;
		echo json_encode($res);
	}
	
	public function searchseminar()
	{
		$user_id = $this->input->post('user_id');
		$data = $this->Seminar_model->searchseminar();
		if(empty($data))
		{
			$res['status_code']=0;
			$res['message']='NO RECORD FOUND';
		}
		else
		{
			$i=0;
			foreach($data as $key => $value){
				$res1[$i]['seminar_id']=$value->id;
				$res1[$i]['uid']=$value->uid;
				$res1[$i]['title']=$value->title;
				/*$res1[$i]['tagline']=$value->tagline;
				$res1[$i]['description']=$value->description;
				$res1[$i]['total_seat']=$value->total_seat;
				$res1[$i]['total_booked_seat']=$value->total_booked_seat;
				$res1[$i]['qualification']=$value->qualification;*/
				$res1[$i]['address']=$value->address;
				/*$res1[$i]['lat']=$value->lat;
				$res1[$i]['lng']=$value->lng;
				$res1[$i]['typeid']=$value->typeid;
				$res1[$i]['countryid']=$value->countryid;
				$res1[$i]['stateid']=$value->stateid;
				$res1[$i]['cityid']=$value->cityid;
				$res1[$i]['zipcode']=$value->zipcode;
				$res1[$i]['phoneno']=$value->phoneno;
				$res1[$i]['hostperson_name']=$value->hostperson_name;
				$res1[$i]['contact_email']=$value->contact_email;
				$res1[$i]['puposeid']=$value->puposeid;
				$res1[$i]['status']=$value->status;
				$res1[$i]['approval_status']=$value->approval_status;
				$res1[$i]['created_date']=date("Y-m-d H:i:s a",$value->created_date/1000);
				$res1[$i]['modified_date']=date("Y-m-d H:i:s a",$value->modified_date/1000);*/
				$query = $this->db->query("select * from seminar_photos where seminar_id = '".$value->id."' ");
				if($query->result()){
					foreach($query->result() as $key => $val){
						$res1[$i]['seminar_image']="http://creadigol.biz/meeto/img/".$val->image;
					}
				}else{
					$res1[$i]['seminar_image']="";
				}
				
				$query = $this->db->query("select * from user_detail where uid = '".$value->uid."' ");
				if($query->result()){
					foreach($query->result() as $key => $val){
						$res1[$i]['host_image']="http://creadigol.biz/meeto/img/".$val->photo;
					}
				}else{
					$res1[$i]['host_image']="";
				}
				
				$query = $this->db->query("select * from wishlist where uid = '".$user_id."' and seminar_id = '".$value->id."' ");
				if($query->result()){
					foreach($query->result() as $key => $val){
						$res1[$i]['wishlist']="true";
					}
				}else{
					$res1[$i]['wishlist']="false";
				}
				
				$i++;
			}
			$res['status_code']=1;
			$res['message']='Seminar List';
			$res['seminar_list']=$res1;
		}
		echo json_encode($res);
	}
	
	public function addseminar()
	{
		if($data1 = $this->Seminar_model->addseminar())
		{
			foreach($data1 as $row){
				$data['seminar']['id'] = $row->id;
				$data['seminar']['uid'] = $row->uid;
				$data['seminar']['title'] = $row->title;
				$data['seminar']['tagline'] = $row->tagline;
				$data['seminar']['description'] = $row->description;
				$data['seminar']['total_seat'] = $row->total_seat;
				$data['seminar']['total_booked_seat'] = $row->total_booked_seat;
				$data['seminar']['qualification'] = $row->qualification;
			}
			$query=$this->db->query("select * from seminar_day where seminar_id='".$data['seminar']['id']."' ");
			foreach($query->result() as $row){
				$data['seminar_day']['id'] = $row->id;
				$data['seminar_day']['from_date'] = $row->from_date;
				$data['seminar_day']['to_date'] = $row->to_date;
				$data['seminar_day']['from_time'] = $row->from_time;
				$data['seminar_day']['to_time'] = $row->to_time;
			}
			$res['status_code']=1;
			$res['message']='Seminar Added.';
			$res['seminar_detail']=$data;
		}
		else
		{
			$res['status_code']=1;
			$res['message']='Seminar Not Added Try Later or Check Your Detail..';
			$res['seminar_detail']=$data;
		}
		
		echo json_encode($res);
	}
	
	public function seminardetail()
	{
		$seminar_id=$this->input->post('seminar_id');
		$uid=$this->input->post('user_id');
		if($data = $this->Seminar_model->seminardetail($seminar_id))
		{
			foreach($data as $val)
			{
				$data1['seminar_id']=$val->id;
				$data1['seminar_name']=$val->title;
				//$puposeid=$val->puposeid;
				$typeid=$val->typeid;
				$data1['seminar_adress']=$val->address;
				$data1['seminar_host_name']=$val->hostperson_name;
				$data1['seminar_description']=$val->description;
				$data1['seminar_total_seat']=$val->total_seat;
				
				$query = $this->db->query("select * from seminar_day where seminar_id='".$val->id."' ");
				if($result = $query->result())
				{
					$data1['from_date']=$result[0]->{'from_date'};
					$data1['to_date']=$result[0]->{'to_date'};
					$data1['from_time']=$result[0]->{'from_time'};
					$data1['to_time']=$result[0]->{'to_time'};
				}
				else
				{
					$data1['from_date']="";
					$data1['to_date']="";
					$data1['from_time']="";
					$data1['to_time']="";
				}
				
				$query = $this->db->query("select * from user_detail where uid='".$val->uid."' ");
				if($result = $query->result())
				{
					$data1['seminar_host_description']=$result[0]->{'yourself'};
					$data1['seminar_host_pic']="http://creadigol.biz/meeto/img/".$result[0]->{'photo'};
					
					$chkimg = $this->db->query("select * from user where id='".$val->uid."' ");
					if($chkimg = $chkimg->result())
					{
						if($chkimg[0]->{'type'}==2)
						{
							$data1['seminar_host_pic']=$result[0]->{'photo'};
						}
					}
				}
				else
				{
					$data1['seminar_host_description']="";
					$data1['seminar_host_pic']="";
				}
				
				$query = $this->db->query("select * from user_company where uid='".$val->uid."' ");
				if($result = $query->result())
				{
					$data1['comapny_name']=$result[0]->{'name'};
					$data1['comapny_description']=$result[0]->{'description'};
					$data1['organization']=$result[0]->{'organization'};
				}
				else
				{
					$data1['comapny_name']="";
					$data1['comapny_description']="";
					$data1['organization']="";
				}
				
				/*$query = $this->db->query("select * from seminar_purpose where id='".$val->puposeid."' ");
				$result = $query->result();
				$data1['seminar_purpose']=$result[0]->{'name'};*/
				
				$query = $this->db->query("select * from seminar_type where id='".$val->typeid."' ");
				if($result = $query->result())
				{					
					$data1['seminar_type']=$result[0]->{'name'};
				}
				else
				{
					$data1['seminar_type']="";
				}
				
				$query = $this->db->query("select * from seminar_booking where seminar_id='".$val->id."' and uid='".$uid."' ");
				if($result = $query->result())
				{
					$data1['book']="true";
				}
				else
				{
					$data1['book']="false";
				}
				
			}
			
			$query = $this->db->query("select * from seminar_photos where seminar_id='".$val->id."' ");
			$result = $query->result();
			$i=0;
			$seminar_pic=array();
			foreach($result as $value)
			{
				$seminar_pic[$i]['seminar_pic']="http://creadigol.biz/meeto/img/".$value->image;
				//$data1['seminar_pic']['seminar_pic_'.$i]="http://creadigol.biz/meeto/img/".$value->image;
				$i++;
			}
			$data3['seminar_pic']=$seminar_pic;
			
			$query = $this->db->query("select * from seminar_facility where seminar_id='".$val->id."' ");
			$result = $query->result();
			$i=0;
			$seminar_facility=array();
			foreach($result as $value)
			{
				$query = $this->db->query("select * from facility where id='".$value->facility_id."' ");
				if($result1 = $query->result())
				{
					$seminar_facility[$i]['seminar_facility']=$result1[0]->{'name'};
				}
				else
				{
					$seminar_facility[$i]['seminar_facility']="";
				}
				
				//$data1['seminar_facility']['seminar_facility_'.$i]=$result1[0]->{'name'};
				$i++;
			}
			$data4['seminar_facility']=$seminar_facility;
			
			$query = $this->db->query("select * from seminar_purpose where seminar_id='".$val->id."' ");
			$result = $query->result();
			$i=0;
			$seminar_purpose=array();
			foreach($result as $value)
			{
				$query = $this->db->query("select * from purpose where id='".$value->attendees_id."' ");
				$result1 = $query->result();
				$seminar_purpose[$i]['seminar_purpose']=$result1[0]->{'name'};
				//$data1['seminar_purpose']['seminar_facility_'.$i]=$result1[0]->{'name'};
				$i++;
			}
			$data5['seminar_purpose']=$seminar_purpose;
			
			$query = $this->db->query("select * from seminar_industry where seminar_id='".$val->id."' ");
			$result = $query->result();
			$i=0;
			$seminar_industry=array();
			foreach($result as $value)
			{
				$query = $this->db->query("select * from industry where id='".$value->industry_id."' ");
				if($result1 = $query->result())
				{
					$seminar_industry[$i]['seminar_industry']=$result1[0]->{'name'};
				}
				else
				{
					$seminar_industry[$i]['seminar_industry']="";
				}
				
				//$data1['seminar_industry']['seminar_facility_'.$i]=$result1[0]->{'name'};
				$i++;
			}
			$data6['seminar_industry']=$seminar_industry;
			
			
			$query = $this->db->query("select * from seminar where typeid='".$typeid."' and id not in ('".$seminar_id."')");
			if($data = $query->result())
			{
				$h=0;
				foreach($data as $val)
				{
					$data2[$h]['seminar_id']=$val->id;
					$data2[$h]['seminar_name']=$val->title;
					/*$puposeid=$val->puposeid;
					$typeid=$val->typeid;
					$data2[$h]['seminar_adress']=$val->address;
					$data2[$h]['seminar_host_name']=$val->hostperson_name;
					$data2[$h]['seminar_description']=$val->description;
					$data2[$h]['seminar_total_seat']=$val->total_seat;
					
					$query = $this->db->query("select * from user_detail where uid='".$val->uid."' ");
					if($result = $query->result()){
						$data2[$h]['seminar_host_description']=$result[0]->{'yourself'};
						$data2[$h]['seminar_host_pic']="http://creadigol.biz/meeto/img/".$result[0]->{'photo'};
					}*/
					
					$query = $this->db->query("select * from seminar_photos where seminar_id='".$val->id."' ");
					if($result = $query->result())
					{
						$data2[$h]['seminar_pic']="http://creadigol.biz/meeto/img/".$result[0]->{'image'};
					}
					else
					{
						$data2[$h]['seminar_pic']="";
					}
					
					/*
					$query = $this->db->query("select * from seminar_facility where seminar_id='".$val->id."' ");
					$result = $query->result();
					$i=0;
					foreach($result as $value)
					{
						$query = $this->db->query("select * from facility where id='".$value->facility_id."' ");
						$result1 = $query->result();
						$data2[$h]['seminar_facility']['seminar_facility_'.$i]=$result1[0]->{'name'};
						$i++;
					}
					
					$query = $this->db->query("select * from seminar_purpose where id='".$val->puposeid."' ");
					$result = $query->result();
					$data2[$h]['seminar_purpose']=$result[0]->{'name'};
					
					$query = $this->db->query("select * from seminar_type where id='".$val->typeid."' ");
					$result = $query->result();
					$data2[$h]['seminar_type']=$result[0]->{'name'};*/
					$h++;
				}
			}
			else
			{
				$data2="";
			}
			
			$res['status_code']=1;
			$res['message']='Seminar Detail.';
			$res['seminar_detail']=$data1;
			$res['seminar_pic']=$seminar_pic;
			$res['seminar_facility']=$seminar_facility;
			$res['seminar_purpose']=$seminar_purpose;
			$res['seminar_industry']=$seminar_industry;
			$res['similar_seminar_detail']=$data2;
		}
		else
		{
			$res['status_code']=0;
			$res['message']='Seminar Not Found.';
			$res['seminar_detail']="";
		}
		
		echo json_encode($res);
	}

	public function seminarbooking()
	{
		$seminar_id=$this->input->post('seminar_id');
		$uid=$this->input->post('user_id');
		$booking_no=$this->input->post('booking_no');
		$book_seat=$this->input->post('book_seat');
		$from_date=$this->input->post('from_date');
		$to_date=$this->input->post('to_date');
		//$approval_status=$this->input->post('approval_status');
		$message=$this->input->post('message');
		
		$seminar = $this->db->query("select id from seminar where id='".$seminar_id."' ");
		$seminar = $seminar->result();
		$user = $this->db->query("select id from user where id='".$uid."' ");
		$user = $user->result();
		
		if(!empty($seminar) && !empty($user))
		{
			if($this->Seminar_model->seminarbooking($seminar_id,$uid,$booking_no,$book_seat,$from_date,$to_date,$message))
			{
				$res['status_code']=1;
				$res['message']='Booking Successfully.';
			}
			else
			{
				$res['status_code']=0;
				$res['message']='Booking Not Successfully.';
			}
		}
		else
		{	
			$res['status_code']=0;
			$res['message']='User ID OR Seminar ID not valid.';
		}
		
		echo json_encode($res);
	}
	
	public function addtowishlist()
	{
		$seminar_id=$this->input->post('seminar_id');
		$uid=$this->input->post('user_id');
		
		if($this->Seminar_model->addtowishlist($seminar_id,$uid))
		{
			$res['status_code']=1;
			$res['message']='Added To Wishlist Successfully.';
		}
		else
		{
			$wishlist = $this->db->query("select * from wishlist where seminar_id='".$seminar_id."' and uid='".$uid."' ");
			$wishlist_r = $wishlist->result();
			if(!empty($wishlist_r))
			{
				$res['status_code']=0;
				$res['message']='Already in Wishlist.';	
			}
			else
			{
				$res['status_code']=0;
				$res['message']='User ID or Seminar ID Not Valid';
			}				
		}
		echo json_encode($res);
	}
	
	public function searchseminarstring()
	{
		$i=0;
		$search = $this->input->post('search');
		
		$query = $this->db->query("select * from seminar where title like '%".$search."%' ");
		foreach($query->result() as $key => $value){
			$res1[$i]['name']=$value->title;
			$res1[$i]['type']="seminar";
			$res1[$i]['id']=$value->id;
			$i++;
		}
		
		$query = $this->db->query("select * from cities where name like '%".$search."%' and id in (select distinct cityid from seminar) ");
		foreach($query->result() as $key => $val){
			$res1[$i]['name']=$val->name;
			$res1[$i]['type']="city";
			$res1[$i]['id']=$val->id;
			$i++;
		}
		if(empty($res1))
		{
			$res['status_code']=0;
			$res['message']='Seminar List';
			$res['seminar_list']="";
		}
		else
		{
			$res['status_code']=1;
			$res['message']='Seminar List';
			$res['seminar_list']=$res1;
		}	
		echo json_encode($res);
	}
	
	public function seminarbookinglist()
	{
		$seminar_id = $this->input->post('seminar_id');
		$uid = $this->input->post('user_id');
		
		if($data = $this->Seminar_model->seminarbookinglist($seminar_id,$uid))
		{
			$i=0;
			foreach($data as $val)
			{
				$query = $this->db->query("select * from user where id = '".$val->uid."' ");
				foreach($query->result() as $key => $value){
					$res1[$i]['user_id']=$value->id;
					$res1[$i]['name']=trim($value->fname)." ".trim($value->lname);
					$res1[$i]['email']=$value->email;
					
					if($value->type==2)
					{
						$query = $this->db->query("select * from user_detail where uid = '".$val->uid."' ");
						foreach($query->result() as $key => $value){
							$res1[$i]['user_pic']=$value->photo;
						}
					}
					else if($value->type==1)
					{
						$query = $this->db->query("select * from user_detail where uid = '".$val->uid."' ");
						foreach($query->result() as $key => $value){
							$res1[$i]['user_pic']="http://creadigol.biz/meeto/img/".$value->photo;
						}
					}
				}
				$res1[$i]['book_seat'] = $val->book_seat;				
				$i++;
			}
			
			$res['status_code']=1;
			$res['message']='Seminar Booking User List.';
			$res['data']=$res1;
		}
		else
		{
			$res['status_code']=0;
			$res['message']='No Data Found.';
		}
		/*$i=0;
		$search = $this->input->post('search');
		
		$query = $this->db->query("select * from seminar where title like '%".$search."%' ");
		foreach($query->result() as $key => $value){
			$res1[$i]['name']=$value->title;
			$res1[$i]['type']="seminar";
			$res1[$i]['id']=$value->id;
			$i++;
		}
		
		$query = $this->db->query("select * from cities where name like '%".$search."%' and id in (select distinct cityid from seminar) ");
		foreach($query->result() as $key => $val){
			$res1[$i]['name']=$val->name;
			$res1[$i]['type']="city";
			$res1[$i]['id']=$val->id;
			$i++;
		}
		if(empty($res1))
		{
			$res['status_code']=0;
			$res['message']='Seminar List';
			$res['seminar_list']="";
		}
		else
		{
			$res['status_code']=1;
			$res['message']='Seminar List';
			$res['seminar_list']=$res1;
		}	*/
		
		echo json_encode($res);
	}
	
	public function acceptdeclineseminar()
	{
		$seminar_id = $this->input->post('seminar_id');
		$uid = $this->input->post('user_id');
		$approval_status = $this->input->post('approval_status');
		
		if($this->Seminar_model->acceptdeclineseminar($seminar_id,$uid,$approval_status))
		{
			$res['status_code']=1;
			$res['message']="Your Booking ".ucfirst($approval_status).".";
		}
		else
		{
			$res['status_code']=0;
			$res['message']="Approval Already Set OR User ID and Seminar ID Not Valid..";
		}
		echo json_encode($res);
	}
	
	
}