<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class User2 extends CI_Controller {


	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('User2_model');	
	}
	
	
	public function index() {
	echo "Welcome to Cashtag";
	}
	public function login()
	{
		$type=$this->input->post('type');
		if(!empty($type))
		{
			if($type=="LOCAL")
			{
				$name=$this->input->post('name');
				$email=$this->input->post('email');
				$mobile=$this->input->post('mobile');
				$password=$this->input->post('password');
				if((empty($email) || empty($mobile)) && (empty($password)))
				{
					$res['status_code']=0;
					$res['message']="Parameter missing..";
				}
				else
				{
					$resultlocal=$this->User2_model->get_localuser($email,$mobile,$password);
					if(empty($resultlocal))
					{
						$res['status_code']=3;
						if(empty($mobile))
						{
							$selcat=$this->db->query("select count(*) as count from ct_user where email like '$email'");
							$result2=$selcat->result();
							if($result2[0]->{'count'}==0)
							{
								$res['message']="Email id does not exist";
							}
							else
							{
								$res['message']="Your login detail does not match";
							}
							
						}
						elseif(empty($email))
						{
							$selcat=$this->db->query("select count(*) as count from ct_user where mobile like '$mobile'");
							$result2=$selcat->result();
							if($result2[0]->{'count'}==0)
							{
								$res['message']="Mobile number does not exist";
							}
							else
							{
								$res['message']="Your login detail does not match";
							}
						}
						
					}
					else
					{
						if($resultlocal[0]->{'status'}==0)
						{
						$res['status_code']=1;
						$res['message']="User login successfully..";
						$i=0;
						
						foreach($resultlocal as $data1 => $data)
						{ 
							$res1['name']=$data->name;
							$res1['mobile']=$data->mobile;
							$res1['email']=$data->email;
							$res1['userid']=$data->id;
							$res1['dob']=$data->dob;
							$res1['password']=$data->password;
							$res1['user_image']=$data->user_image;
							if($data->location_id==0)
							{
								$res1['locationid']=$data->city_id;
								$selcity=$this->db->query("select * from ct_city where id=$data->city_id");
								//echo "select * from ct_city where id=$data->city_id"; 
								$fetcity=$selcity->result();
								//print_r($fetcity);
								if(empty($fetcity))
								{
									$res1['locationname']="";
									$res1['locationtype']="";
								}
								else
								{
									$res1['locationname']=$fetcity[0]->{'name'};
									$res1['locationtype']="city";
								}
							}
							else
							{
								$res1['locationid']=$data->location_id;
								$sellocation=$this->db->query("select * from ct_location where id=$data->location_id");
								$fetlocation=$sellocation->result();
								$res1['locationname']=$fetlocation[0]->{'name'};
								$res1['locationtype']="location";
							}
							$lid=$data->location_id;
							$res1['type']="LOCAL";
							$res1['totaltag']=$data->total_tag;
							$res1['pendingtag']=$data->pending_tag;
							$res1['type']="LOCAL";
							$value=$res1;
							$i++;
						} 
						$res['user']=$value;
						}
						else
						{
							$res['status_code']=0;
							$res['message']="Your account is suspended please contact info@cashtag.co.in";
						}
					}
				}
		}
		else
		{
			if($type=="FACEBOOK")
			{
				$fbid=$this->input->post('fb_id');
				$fbemail=$this->input->post('fb_email');
				$fbname=$this->input->post('fb_name');
				$fbpic=$this->input->post('fb_pic');
				if(!empty($fbid))
				{
				$resultfacebook=$this->User2_model->get_users($fbid,'FACEBOOK');
				if(empty($resultfacebook))
				{
					$res['status_code']=2;
					$res['message']="Give more details";
					$res['type']="FACEBOOK";
					//$id=$this->User2_model->create_users('FACEBOOK',$fbid,$fbemail,$fbname,$fbpic);
					//$res['userid']=$id;
				}
				else
				{
					if($resultfacebook[0]->{'status'}==0)
					{
					$res['status_code']=1;
					$res['message']="User login successfully..";
					$i=0;
					foreach($resultfacebook as $data1 => $data)
					{ 
						$res1['name']=$data->name;
						$res1['mobile']=$data->mobile;
						$res1['email']=$data->email;
						$res1['userid']=$data->id;
						$res1['user_image']=$data->user_image;
						$res1['locationid']=$data->location_id;
						$lid=$data->location_id;
						$sellocation=$this->db->query("select * from ct_location where id=$lid");
						$fetlocation=$sellocation->result();
						if($data->location_id==0)
							{
								$res1['locationid']=$data->city_id;
								$selcity=$this->db->query("select * from ct_city where id=$data->city_id");
								//echo "select * from ct_city where id=$data->city_id"; 
								$fetcity=$selcity->result();
								//print_r($fetcity);
								if(empty($fetcity))
								{
									$res1['locationname']="";
									$res1['locationtype']="";
								}
								else
								{
									$res1['locationname']=$fetcity[0]->{'name'};
									$res1['locationtype']="city";
								}
							}
							else
							{
								$res1['locationid']=$data->location_id;
								$sellocation=$this->db->query("select * from ct_location where id=$data->location_id");
								$fetlocation=$sellocation->result();
								$res1['locationname']=$fetlocation[0]->{'name'};
								$res1['locationtype']="location";
							}
							$lid=$data->location_id;
							$res1['totaltag']=$data->total_tag;
							$res1['pendingtag']=$data->pending_tag;
						$res1['type']="FACEBOOK";
						$value=$res1;
						$i++;
					} 
					$res['user']=$value;
					}
					
					else
					{
						$res['status_code']=0;
						$res['message']="Your account is suspended please contact info@cashtag.co.in";
					}
				}
				}
				else
				{
					$res['status_code']=0;
					$res['message']="facebook id missing";
				}
			}
			elseif($type=="GOOGLE")
			{
				$glid=$this->input->post('gl_id');
				$glemail=$this->input->post('gl_email');
				$glname=$this->input->post('gl_name');
				$glpic=$this->input->post('gl_pic');
				if(!empty($glid))
				{	
					$resultgoogle=$this->User2_model->get_users($glid,'GOOGLE');
					if(empty($resultgoogle))
					{
						$res['status_code']=2;
						$res['message']="Give more details";
						$res['type']="GOOGLE";
						//$id=$this->User2_model->create_users('GOOGLE',$glid,$glemail,$glname,$glpic);
						//$res['userid']=$id;
					}
					else
					{
						if($resultgoogle[0]->{'status'}==0)
						{
						$res['status_code']=1;
						$res['message']="User login successfully..";
						$i=0;
						foreach($resultgoogle as $data1 => $data)
						{ 
							$res1['name']=$data->name;
							$res1['mobile']=$data->mobile;
							$res1['email']=$data->email;
							$res1['user_id']=$data->id;
							$res1['user_image']=$data->user_image;
							$res1['locationid']=$data->location_id;
							$lid=$data->location_id;
							$sellocation=$this->db->query("select * from ct_location where id=$lid");
							$fetlocation=$sellocation->result();
							if(empty($fetlocation))
							{
								$res1['locationname']=NULL;
							}
							else
							{
								$res1['locationname']=$fetlocation[0]->{'name'};
							}
							$res1['cityid']=$data->city_id;
							$cid=$data->city_id;
							$selcity=$this->db->query("select * from ct_city where id=$cid");
							$fetcity=$selcity->result();
							if(empty($fetcity))
							{
								$res1['cityname']=NULL;
							}
							else
							{
								$res1['cityname']=$fetcity[0]->{'name'};
							}
							$res1['totaltag']=$data->total_tag;
							$res1['pendingtag']=$data->pending_tag;
							$res1['type']="GOOGLE";
							$value=$res1;
							$i++;
						} 
						$res['user']=$value;
						}
						else
						{
							$res['status_code']=0;
							$res['message']="Your account is suspended please contact info@cashtag.co.in";
						}
					}
					
				}
				else
				{
					$res['status_code']=0;
					$res['message']="Google id missing";
				}
			}
			else
			{
				$res['status_code']=0;
				$res['message']="Type invalid";
			}
		}
		}
		else
		{
			$res['status_code']=0;
			$res['message']="Parameter missing..";
		}
		echo json_encode($res);  
	}
	
	public function register()
	{	
		$username=$this->input->post('name');
		$email=$this->input->post('email');
		$mobile=$this->input->post('mobile');
		$userimage=$this->input->post('user_image');
		$type=$this->input->post('type');
		if($type=="FACEBOOK" || $type=="GOOGLE")
		{
			$id=$this->input->post('id');
			if( empty($username) || empty($email) || empty($mobile) || empty($id))
			{
				$res['status_code']=2;
				$res['message']="Parameter missing";
			}
			else
			{
				
				if($this->User2_model->create_users($id,$username,$email,$mobile,$type,$userimage))
				{
					if($type=="FACEBOOK")
					{
						$selall=$this->db->query("select * from ct_user where fb_id='$id'");
					}
					elseif($type=="GOOGLE")
					{
						$selall=$this->db->query("select * from ct_user where google_id='$id'");
					}
					$result=$selall->result();
					$i=0;
					foreach($result as $data1 => $data)
					{ 
						$res1['name']=$data->name;
						$res1['mobile']=$data->mobile;
						$res1['email']=$data->email;
						$res1['password']=$data->password;
						$res1['userid']=$data->id;
						$res1['type']=$type;
						$res1['totaltag']=$data->total_tag;
						$res1['pendingtag']=$data->pending_tag;
						$value=$res1;
						$i++;
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
			$password=$this->input->post('password');
			$id="";	
			if(!empty($password))
			{
				$selmobile=$this->db->query("select count(*) as count from ct_user where mobile like '$mobile' and flag=2");
				$fetmobile=$selmobile->result();
				if($fetmobile[0]->{'count'}!=0)
				{
					$res['status_code']=4;
					$res['message']="Mobile number already exist";	
				}
				else
				{
					$selcat=$this->db->query("select count(*) as count from ct_user where email like '$email'");
					$re=$selcat->result();
					if($re[0]->{'count'} > 0)
					{
						$res['status_code']=4;
						$res['message']="Email id already exist";
					}
					else
					{
						if($this->User2_model->create_users($id,$username,$email,$mobile,$type,$userimage))
						{
							$selall=$this->db->query("select * from ct_user where mobile='$mobile'");
							$result=$selall->result();
							$i=0;
							foreach($result as $data1 => $data)
							{ 
								$res1['name']=$data->name;
								$res1['mobile']=$data->mobile;
								$res1['email']=$data->email;
								$res1['password']=$data->password;
								$res1['userid']=$data->id;
								$res1['type']=$type;
								$res1['totaltag']=$data->total_tag;
								$res1['pendingtag']=$data->pending_tag;
								$value=$res1;
								$i++;
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
			}
			else
			{
				$res['status_code']=2;
				$res['message']="Parameter missing";
			}
			
		}
		echo json_encode($res);
	}
	
	public function forgotpass()
	{
		$mobile=$this->input->post('mobile');
		if(empty($mobile))
		{
			$res['status_code']=0;
			$res['message']="Parameter Missing";
		}
		else
		{
			$selmer=$this->db->query("select count(*) as c from ct_user where mobile='$mobile' and flag=2");
			$fetmer=$selmer->result();
			if($fetmer[0]->{'c'}==0)
			{
				$res['status_code']=0;
				$res['message']="Mobile number does not exist";
			}
			else
			{
				$otp=rand(100000, 999999);
				if($this->User2_model->sendSms($mobile,$otp))
				{
					$res['status_code']=1;
					$res['message']="SMS request is initiated! You will be receiving OTP shortly.";
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
	public function verifyotp()
	{
		$mobile=$this->input->post('mobile');
		$otp=$this->input->post('otp');
		if(empty($mobile) || empty($otp))
		{
			$res['status_code']=0;
			$res['message']="Parameter Missing";
		}
		else
		{
			$selmer=$this->db->query("select count(*) as c from ct_user where mobile='$mobile' and flag=2");
			$fetmer=$selmer->result();
			if($fetmer[0]->{'c'}==0)
			{
				$res['status_code']=0;
				$res['message']="Mobile number does not exist";
			}
			else
			{
				$selmer2=$this->db->query("select * from ct_user where mobile='$mobile' and forgotkey='$otp' and flag=2");
				$fetmer2=$selmer2->result();
				if(empty($fetmer2))
				{
					$res['status_code']=0;
					$res['message']="User Verify Unsuccessfull";
				}
				else
				{
					$res['status_code']=1;
					$res['message']="User Verified Successfully";
				}
			}
		}
		echo json_encode($res);
	}
	public function changepass()
	{
		$mobile=$this->input->post('mobile');
		$pass=$this->input->post('password');
		if(empty($mobile) || empty($pass))
		{
			$res['status_code']=0;
			$res['message']="Parameter Missing";
		}
		else
		{
			$selmer=$this->db->query("select count(*) as c from ct_user where mobile='$mobile' and flag=2");
			$fetmer=$selmer->result();
			if($fetmer[0]->{'c'}==0)
			{
				$res['status_code']=0;
				$res['message']="Mobile number does not exist";
			}
			else
			{

				if($this->User2_model->changepass($mobile,$pass))
				{
					$res['status_code']=1;
					$res['message']="Password Change Successfully";
					
				}
				else
				{
					$res['status_code']=0;
					$res['message']="Password Change Unsuccessfull";
				}
			}
		}
		echo json_encode($res);
	}
	/*public function forgotpass()
	{
		$eid=$this->input->post('email');
		if(empty($eid))
		{
			$res['status_code']=0;
			$res['message']="Parameter Missing";
		}
		else
		{
			$selmer=$this->db->query("select count(*) as c from ct_user where email='$eid' ");
			$fetmer=$selmer->result();
			if($fetmer[0]->{'c'}==0)
			{
				$res['status_code']=0;
				$res['message']="Email id does not exist";
			}
			else
			{
				$res['status_code']=1;
				$res['message']="You have receive mail in your email";
				$selmer=$this->db->query("select * from ct_user where email='$eid' ");
				$fetmer=$selmer->result();
				$uid=$fetmer[0]->{'id'};
				$key=$fetmer[0]->{'id'}."/".md5(uniqid(rand(), true)) . md5(uniqid(rand(), true));
				$data = array(
					'forgotkey'=>$key,
				);
				$message="";
				$this->db->set($data);  
				$this->db->where("id",$uid);
				$this->db->update("ct_user", $data);
				$subject="Forgot YOur Password";
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$message .= '<body>';
				$message .= '<p>You have recevie this 64 bit generate key for password : '.$key.'<br>Please click on reset button to change your password</p>';
				$message .= '<a href="http://creadigol.biz/cashtag/mainadmin/forgotpass.php?key='.$key.'" style="padding:10px 10px 20px 10px;background:red;color:#fff;text-decoration:none;">Reset Password</a>';
				$message .= '</body>';
				$mail = mail($eid,$subject,$message,$headers);
			}
		}
		echo json_encode($res);
	}*/
	public function response(){
		
	}

}