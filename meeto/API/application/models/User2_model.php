<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User2_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}

	public function get_users($id,$type)
	{
		if($type=="FACEBOOK")
		{
			$q=$this->db->query("select * from ct_user where fb_id like '$id'");
		}
		elseif($type=="GOOGLE")
		{
			$q=$this->db->query("select * from ct_user where google_id like '$id'");
		}
		else
		{
			$q=$this->db->query("select * from ct_user where mobile like '$id'");
		}
		$r=$q->result();
		return $r;
	}
	public function get_localuser($email,$mobile,$password)
	{
			if(empty($email))
			{
				$q=$this->db->query("select * from ct_user where mobile like '$mobile' and password like '$password'");
			}
			else
			{
				$q=$this->db->query("select * from ct_user where email like '$email' and password like '$password'");
			}
			$r=$q->result();
			return $r;
	}
	public function create_users($id,$username,$email,$mobile,$type,$fbpic)
	{
		$dt=date("Y-m-d"); 
		if($fbpic==NULL)
		{
			$fbpic="";
		}
		if($type=="FACEBOOK")
		{
			$dt=date('Y-m-d');
			$dt2=round(microtime($dt)*1000);
			$data = array(
			'name' => $username,
			'email' => $email,
			'mobile' => $mobile,
			'user_image' => $fbpic, 
			'fb_id' => $id,
			'dob'=>"",
			'type'=>2,
			'total_tag'=>0,
			'pending_tag'=>0,
			'flag'=>2,
			'created_at'=>$dt2,
			'modified_at'=>$dt2,
			);
			return $this->db->insert('ct_user', $data);
			//return $this->db->insert_id();
		}
		elseif($type=="GOOGLE")
		{
			$dt=date('Y-m-d');
			$dt2=round(microtime($dt)*1000);
			$data = array(
			'name' => $username,
			'email' => $email,
			'mobile' => $mobile,
			'user_image' => $fbpic, 
			'dob'=>"",
			'google_id' => $id,
			'type'=>3,
			'total_tag'=>0,
			'pending_tag'=>0,
			'flag'=>2,
			'created_at'=>$dt2,
			'modified_at'=>$dt2,
			);
			return $this->db->insert('ct_user', $data);
		}
		elseif($type=="LOCAL")
		{
			$dt=date('Y-m-d');
			$dt2=round(microtime($dt)*1000);
			$password=$this->input->post('password');
			$data = array(
			'name' => $username,
			'email' => $email,
			'mobile' => $mobile,
			'user_image' => $fbpic, 
			'password'=> $password,
			'dob'=>"",
			'type'=>1,
			'total_tag'=>0,
			'pending_tag'=>0,
			'flag'=>2, 
			'created_at'=>$dt2,
			'modified_at'=>$dt2,
			);
			return $this->db->insert('ct_user', $data);
		}
	}
	
	
	public function sendSms($mobile, $otp) 
	{
		//echo $mobile;
		$data = array(
			'forgotkey'=>$otp,
		);
			 
			$this->db->set($data);  
			$this->db->where("mobile", $mobile);
			$this->db->where("flag", '2');
			$this->db->update("ct_user", $data);	
			$otp_prefix = ':';
			$message = "Hello! Welcome to CashTag. Your OTP is $otp_prefix '$otp'";
			$response_type = 'json';

			//Define route 
			$route = "4";
			
			//Prepare you post parameters
			$postData = array(
				'uname' => USERNAME,
				'pass' => PASSWORD,
				'send' => SENDERID,
				'dest' => '91'.$mobile,
				'msg' => $message
			);
			$base_url = "http://api.infoskysolution.com/SendSMS/sendmsg.php";
			$ch = curl_init(); 
			 
			curl_setopt($ch, CURLOPT_URL,$base_url);  
			curl_setopt($ch, CURLOPT_POST, 1);  
			curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			$server_output = curl_exec ($ch); 
			//echo $ch; 
			curl_close ($ch);
			return true;
	}
	
	public function changepass($mobile, $pass) 
	{
		//echo $mobile;
		$data = array(
			'password'=>$pass,
		);
		$this->db->set($data);  
		$this->db->where("mobile", $mobile);
		$this->db->where("flag", '2');
		return $this->db->update("ct_user", $data);
	}

	public function get_user_mobile($mobile)
	{
			$query = $this->db->query("select * from ct_user where mobile = '".$mobile."'");
		    $userarray=$query->result();
			return $userarray;
	}
		
	public function login_user_mobile($mobile,$password){
		
		$this->db->select('*');		
		$this->db->from('ct_user');
		$this->db->where('mobile', $mobile);
		$this->db->where('password', $password);
		return $this->db->get()->row();
		
	}
	
	public function count_user_mobile($mobile,$password){
		
		$this->db->select('*');
		$this->db->from('ct_user');
		$this->db->where('mobile',$mobile);
		$this->db->where('password', $password);
		return $this->db->get()->num_rows();
	}
	public function login_userarray_mobile($mobile,$password)
	{
		$query = $this->db->query("select * from ct_user where mobile = '".$mobile."' and password = '".$password."'");
		$userarray=$query->result();
		return $userarray;
	}
	
	public function login_user_email($email,$password){
		
		$this->db->select('*');		
		$this->db->from('ct_user');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		return $this->db->get()->row();	
	}
	
	public function count_userdata_email($email,$password){
		
		$this->db->select('*');
		$this->db->from('ct_user');
		$this->db->where('email',$email);
		$this->db->where('password', $password);
		return $this->db->get()->num_rows();
	}
	
	public function login_userarray_email($email,$password)
	{
		$query = $this->db->query("select * from ct_user where email = '".$email."' and password = '".$password."' and status = '1'");
		$userarray=$query->result();
		return $userarray;
	}
	
	public function select_user_password($old_pass,$user_id)
	{
		$this->db->select('*');		
		$this->db->from('ct_user');
		$this->db->where('password', $old_pass);
		$this->db->where('id', $user_id);
		return $this->db->get()->row();	
		
	}
	
	public function count_user_password($old_pass,$user_id)
	{
		$this->db->select('*');
		$this->db->from('ct_user');
		$this->db->where('password', $old_pass);
		$this->db->where('id', $user_id);
		return $this->db->get()->num_rows();
		
	}
	
	public function select_userid_password($old_pass,$user_id)
	{
		$this->db->select('*');		
		$this->db->from('ct_user');
		$this->db->where('password', $old_pass);
		$this->db->where('id', $user_id);
		return $this->db->get()->row('id');
	}
	
	public function update_user_password($new_pass,$old_pass,$rowid)
	{
		$data = array(
			'password'   => $new_pass,
		);
			 
			$this->db->set($data); 
			$this->db->where("password", $old_pass);
			$this->db->where("id", $rowid); 
			$this->db->update("ct_user", $data);
	}
	
	public function select_user_id($user_id)
	{
		$query = $this->db->query("select * from ct_user where id = '".$user_id."'");
		$userarray=$query->result();
		return $userarray;
	}
	
	public function select_user_userid($user_id)
	{
		$this->db->select('*');		
		$this->db->from('ct_user');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();	
	}
	
	public function select_userarray_userid($user_id)
	{
		$query = $this->db->query("select * from ct_user where id = '".$user_id."'");
		$userarray=$query->result();
		return $userarray;
	}
	
	public function count_user_userid($user_id)
	{
		$this->db->select('*');
		$this->db->from('ct_user');
		$this->db->where('id', $user_id);
		return $this->db->get()->num_rows();
		
	}
	
	public function fetch_email($email,$user_id)
	{
		$this->db->select('email');		
		$this->db->from('ct_user');
		$this->db->where('email', $email);
		$this->db->where('id', $user_id);
		return $this->db->get()->row();
	}
	
	public function fetch_emailarray($email,$user_id)
	{
		$query = $this->db->query("select email from ct_user where email = '".$email."' and id !=".$user_id."");
		$userarray=$query->result();
		return $userarray;
	}
	
	public function count_email($email,$user_id)
	{
		$this->db->select('email');		
		$this->db->from('ct_user');
		$this->db->where('email', $email);
		$this->db->where('id !=', $user_id);
		return $this->db->get()->num_rows();
		
	}
	
	public function user_update($uname,$email,$dob,$modified_at,$mobile,$user_id,$image)
	{
		
		
			$data = array(
			'name'=>$uname,
			'email'=>$email,
			'mobile'=>$mobile,
			'dob'=>$dob,
			'user_image'=>$image,
			'modified_at' => $modified_at,
		);
			 
			$this->db->set($data);  
			$this->db->where("id", $user_id);
			return $this->db->update("ct_user", $data);	
	}
}