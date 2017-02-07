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
		$lang=$this->input->post('lang');
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
				if($lang=='ja')
					$res_message = 'パラメータ不足しています';
				else
					$res_message = 'Parameter missing';
				$res['message']=$res_message;
			}
			else
			{
				$fb_id=$this->db->query("select count(*) as count from user where fb_id = '".$fb_id."' ");
				$fb_id=$fb_id->result();
				if($fb_id[0]->{'count'}>0)
				{
					$res['status_code']=4;
					if($lang=='ja')
						$res_message = 'Facebookのアカウントがすでに存在しています';
					else
						$res_message = 'Facebook Acount Already Exist';
					$res['message']=$res_message;	
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
						if($lang=='ja')
							$res_message = '登録に成功';
						else
							$res_message = 'Registration successful';
						$res['message']=$res_message;
						$res['user']=$value;
					}
					else
					{
						$res['status_code']=0;
						if($lang=='ja')
							$res_message = '成功していない登録';
						else
							$res_message = 'Registration not successfully';
						$res['message']=$res_message;
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
					if($lang=='ja')
						$res_message = 'メールすでに存在しています';
					else
						$res_message = 'Email Already Exist';
					$res['message']=$res_message;
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
						
						$key= md5($email);
						$url = "http://www.meeto.jp/Verification.php?uid=".$row->id."&key=".$key;
						$subject = "Email Verification";
						$to = $email;
						$headers = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From:meeto.japan@gmail.com';
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
						
						$res['status_code']=1;
						if($lang=='ja')
							$res_message = '登録に成功';
						else
							$res_message = 'Registration successful';
						$res['message']=$res_message;
						$res['user']=$value;
					}
					else
					{
						$res['status_code']=3;
						if($lang=='ja')
							$res_message = '成功していない登録';
						else
							$res_message = 'Registration not successfully';
						$res['message']=$res_message;
					}
				}
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'パラメータ不足しています';
				else
					$res_message = 'Parameter missing';
				$res['message']=$res_message;
			}
			
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'パラメータが存在しないタイプ';
			else
				$res_message = 'Type Parameter missing';
			$res['message']=$res_message;
		}
		echo json_encode($res);
	}
	
	public function login()
	{
		$lang=$this->input->post('lang');
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
					if($lang=='ja')
						$res_message = 'メールやパスワードのパラメータが欠落します..';
					else
						$res_message = 'Email or Password Parameter missing..';
					$res['message']=$res_message;
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
								$data1['photo'] = "http://www.meeto.jp/img/".$result[0]->{'photo'};
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
								$data1['organization'] = $result[0]->{'organization'};
								$data1['fax_number'] = $result[0]->{'faxno'};
								$data1['url'] = $result[0]->{'url'};
								
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
								$data1['organization'] = "";
								$data1['fax_number'] = "";
								$data1['url'] = "";
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
						if($lang=='ja')
							$res_message = 'ローカルで正常にログイン';
						else
							$res_message = 'Login Successfully With Local';
						$res['message']=$res_message;
						$res['user']=$data1;
					}
					else
					{
						$res['status_code']=0;
						if($lang=='ja')
							$res_message = '無効なメールアドレスまたはパスワード';
						else
							$res_message = 'Invalid Email or Password';
						$res['message']=$res_message;
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
							
							$query = $this->db->query("update user_detail set photo='".$this->input->post('photo')."' where uid='".$uid."' ");
							$query = $this->db->query("select * from user_detail where uid='".$uid."' ");
							if($result = $query->result())
							{
								$data1['gender'] = $result[0]->{'gender'};
								$data1['dob'] = $result[0]->{'dob'};
								$data1['phoneno'] = $result[0]->{'phoneno'};
								$data1['address'] = $result[0]->{'address'};
								$data1['yourself'] = $result[0]->{'yourself'};
								$data1['photo'] = $result[0]->{'photo'};
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
								$data1['organization'] = $result[0]->{'organization'};
								$data1['fax_number'] = $result[0]->{'faxno'};
								$data1['url'] = $result[0]->{'url'};
								
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
								$data1['organization'] = "";
								$data1['fax_number'] = "";
								$data1['url'] = "";
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
						if($lang=='ja')
							$res_message = 'Facebookので正常にログイン';
						else
							$res_message = 'Login Successfully With Facebook';
						$res['message']=$res_message;
						$res['user']=$data1;
					}
					else
					{
						$fname=$this->input->post('fname');
						$lname=$this->input->post('lname');
						$email=$this->input->post('email');
						$photo=$this->input->post('photo');
						
						$query = $this->db->query("select * from user where email='".$email."' ");
						if($result = $query->result() && !empty($email))
						{
							$res['status_code']=2;
							if($lang=='ja')
								$res_message = '別のアカウントで添付されたこのメールをもう一度お試しください。';
							else
								$res_message = 'This Email id attached with other account.';
							$res['message']=$res_message;
						}
						else						
						{
							$id="";
							$password="";
							$fb_id=$this->input->post('fb_id');
							
							if($this->User_model->create_users($id,$fname,$lname,$email,$password,$type))
							{
								$query=$this->db->query("select * from user where fb_id like '".$fb_id."' ");
								foreach($query->result() as $row)
								{ 
									$data = array(
									'uid' => $row->id,
									'photo' => $photo,
									);
									$this->db->insert('user_detail', $data);	
									
									$res1['uid']=$row->id;
									$res1['fb_id']=$row->fb_id;
									$res1['fname']=$row->fname;
									$res1['lname']=$row->lname;
									$res1['email']=$row->email;
									$res1['photo']=$photo;
									$res1['type']=$row->type;
									$value=$res1;
								}
								
								$key= md5($email);
								$url = "http://www.meeto.jp/Verification.php?uid=".$row->id."&key=".$key;
								$subject = "Email Verification";
								$to = $email;
								$headers = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								$headers .= 'From:meeto.japan@gmail.com';
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
								
								$res['status_code']=1;
								if($lang=='ja')
									$res_message = '登録に成功';
								else
									$res_message = 'Registration successful';
								$res['message']=$res_message;
								$res['user']=$value;
							}
							else
							{
								$res['status_code']=0;
								if($lang=='ja')
									$res_message = '成功していない登録';
								else
									$res_message = 'Registration not successfully';
								$res['message']=$res_message;
							}
						}
					}
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'パラメータ無効を入力';
				else
					$res_message = 'Type Parameter Invalid';
				$res['message']=$res_message;
			}
		}		
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'パラメータが存在しないタイプ';
			else
				$res_message = 'Type Parameter missing';
			$res['message']=$res_message;
		}
		echo json_encode($res);  
	}

	public function changepass()
	{
		$lang=$this->input->post('lang');
		$id=$this->input->post('id');
		$password=$this->input->post('password');
		$newpassword=$this->input->post('newpassword');
		if(empty($id) || empty($password) || empty($newpassword))
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'パラメータ不足しています';
			else
				$res_message = 'Parameter missing';
			$res['message']=$res_message;
		}
		else
		{
			$query=$this->db->query("select count(*) as c from user where id='".$id."' and password='".md5($password)."' ");
			$result=$query->result();
			
			if($result[0]->{'c'}==0)
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'IDまたはパスワードが一致しません';
				else
					$res_message = 'Old Password Does not match';
				$res['message']=$res_message;
			}
			else
			{
				if($this->User_model->changepass($id,$password,$newpassword))
				{
					$res['status_code']=1;
					if($lang=='ja')
						$res_message = 'パスワードは正常に変更されました';
					else
						$res_message = 'Password Change Successfully';
					$res['message']=$res_message;
				}
				else
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = 'パスワードが正常に変更されていません';
					else
						$res_message = 'Password Not Changed Successfully';
					$res['message']=$res_message;
				}
			}
		}
		echo json_encode($res);
	}
	
	public function forgotpass()
	{
		$lang=$this->input->post('lang');
		$email=$this->input->post('email');
		if(empty($email))
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'パラメータ不足しています';
			else
				$res_message = 'Parameter missing';
			$res['message']=$res_message;
		}
		else
		{
			$query=$this->db->query("select count(*) as c from user where email='".$email."' and type='1' ");
			$result=$query->result();
			if($result[0]->{'c'}==0)
			{
				$query=$this->db->query("select count(*) as c from user where email='".$email."' and type='2' ");
				$result=$query->result();
				if($result[0]->{'c'}==0)
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = '電子メールは存在しません。';
					else
						$res_message = 'email does not exist';
					$res['message']=$res_message;	
				}
				else
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = '電子メールは存在しません。';
					else
						$res_message = 'This Email ID Attach with facebook account.';
					$res['message']=$res_message;
				}
			}
			else
			{
				$query1 = $this->db->query("select * from user where email='".$email."' and type ='1'");
				$result1=$query1->result();
				$uid=$result1[0]->{'id'};
				
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
				
				if($this->User_model->sendmail($email,$newpassword,$uid))
				{
					
					$res['status_code']=1;
					if($lang=='ja')
						$res_message = 'あなたの登録したメールで送信されたメールあなたのメールをチェックしてください';
					else
						$res_message = 'Mail Sent on Your Registered Email Please Check Your Email';
					$res['message']=$res_message;
					
					
				}
				else
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = '何か問題';
					else
						$res_message = 'Something Problem';
					$res['message']=$res_message;
				}
			}
		}
		echo json_encode($res);
	}
	
	public function userprofile()
	{
		$lang=$this->input->post('lang');
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
						$data1['email_verify'] = $value->email_verify;
						
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
							if($value->type=='2')
							{
								$data1['photo'] = $result[0]->{'photo'};
							}
							else
							{
								$data1['photo'] = "http://www.meeto.jp/img/".$result[0]->{'photo'};
							}
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
							$data1['organization'] = $result[0]->{'organization'};
							$data1['faxno'] = $result[0]->{'faxno'};
							$data1['url'] = $result[0]->{'url'};
							
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
							$data1['organization'] = "";
							$data1['faxno'] = "";
							$data1['url'] = "";
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
									$datal[$i]['language'] = $result1[0]->{'name'};
								}
								else
								{
									$datal['language'] = "";
								}
								$i++;
							}
							$data1['language'] = $datal;
							
						}
						else
						{
							$data1['language'] = "";
						}
					}
					
					$res['status_code']=1;
					if($lang=='ja')
						$res_message = 'ユーザーの詳細';
					else
						$res_message = 'User Detail';
					$res['message']=$res_message;
					$res['user_detail']=$data1;
				}
				else
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = 'レコードが見つかりません。';
					else
						$res_message = 'Record Not Found.';
					$res['message']=$res_message;
				}
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = '無効なUID';
				else
					$res_message = 'Invalid UID';
				$res['message']=$res_message;
			}
			echo json_encode($res);
		}
		else if($type=="EDIT")
		{
			if(!empty($uid))
			{
				$email = $this->input->post('email');
				$query = $this->db->query("select * from user where email='".$email."' and id!='".$uid."' ");
				if($result = $query->result())
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = '別のアカウントで添付されたこのメールをもう一度お試しください。';
					else
						$res_message = 'This Email Attched With Another Accound Please Try Another.';
					$res['message']=$res_message;
				}
				else
				{
					if($data = $this->User_model->userprofile($uid,$type))
					{
						$res['status_code']=1;
						if($lang=='ja')
							$res_message = 'ユーザーの詳細が正常に更新されました。';
						else
							$res_message = 'User Detail Updated Successfully.';
						$res['message']=$res_message;
					}
					else
					{
						$res['status_code']=0;
						if($lang=='ja')
							$res_message = 'レコードが見つかりません。';
						else
							$res_message = 'Record Not Found.';
						$res['message']=$res_message;
					}

				}
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = '無効なUID';
				else
					$res_message = 'Invalid UID';
				$res['message']=$res_message;
			}
			echo json_encode($res);
		}
		else
		{
			$res['status_code']=3;
			if($lang=='ja')
				$res_message = 'タイプパラメータがありません';
			else
				$res_message = 'Missing Type Parameter';
			$res['message']=$res_message;
			
			echo json_encode($res);
		}
	}
	
	public function userlisting()
	{
		$lang=$this->input->post('lang');
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
						$data1[$i]['photo'] = "http://www.meeto.jp/img/".$result[0]->{'image'};
					}
					else
					{
						$data1[$i]['photo'] = "";
					}
					$i++;
				}
				
				$res['status_code']=1;
				if($lang=='ja')
					$res_message = 'セミナー一覧';
				else
					$res_message = 'Seminar List';
				$res['message']=$res_message;
				$res['seminar_detail']=$data1;
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = '録音が見つかりません';
				else
					$res_message = 'Record Not Found';
				$res['message']=$res_message;
			}
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = '無効なユーザーID';
			else
				$res_message = 'Invalid User Id';
			$res['message']=$res_message;
		}
		echo json_encode($res);
	}
	
	public function userbooking()
	{
		$lang=$this->input->post('lang');
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
					$data1[$i]['to_date'] = $value->to_date;
					$data1[$i]['status'] = $value->approval_status;
					$data1[$i]['booking_no'] = $value->booking_no;
					$data1[$i]['book_seat'] = $value->book_seat;
					$data1[$i]['created_date'] = $value->created_date;
					$data1[$i]['message'] = $value->message;
					
					$query = $this->db->query("select * from seminar where id='".$value->seminar_id."' ");
					if($result = $query->result())
					{
						$data1[$i]['host_name'] = $result[0]->{'hostperson_name'};
					}
					else
					{
						$data1[$i]['host_name'] = "";
					}
					
					$query = $this->db->query("select * from seminar_photos where seminar_id='".$value->seminar_id."' ");
					if($result = $query->result())
					{
						$data1[$i]['photo'] = "http://www.meeto.jp/img/".$result[0]->{'image'};
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
				if($lang=='ja')
					$res_message = 'セミナー一覧';
				else
					$res_message = 'Seminar List';
				$res['message']=$res_message;
				$res['booked_seminar_detail']=$data1;
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = '録音が見つかりません';
				else
					$res_message = 'Record Not Found';
				$res['message']=$res_message;
			}
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = '無効なユーザーID';
			else
				$res_message = 'Invalid User Id';
			$res['message']=$res_message;
		}
		echo json_encode($res);
	}
	
	public function userwishlist()
	{
		$lang=$this->input->post('lang');
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
						$data1[$i]['total_seat'] = $result[0]->{'total_seat'};
						$data1[$i]['total_booked_seat'] = $result[0]->{'total_booked_seat'};
					}
					else
					{
						$data1[$i]['title'] = "";
						$data1[$i]['total_seat'] = "";
						$data1[$i]['total_booked_seat'] = "";
					}
					
					$query = $this->db->query("select * from seminar_photos where seminar_id='".$value->seminar_id."' order by id ");
					if($result = $query->result())
					{
						$data1[$i]['photo'] = "http://www.meeto.jp/img/".$result[0]->{'image'};
					}
					else
					{
						$data1[$i]['photo'] = "";
					}
					$i++;
				}
				
				$res['status_code']=1;
				if($lang=='ja')
					$res_message = 'セミナー一覧';
				else
					$res_message = 'Seminar List';
				$res['message']=$res_message;
				$res['wishlist_seminar_detail']=$data1;
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'セミナーは、あなたのウィッシュリストに見つかりません';
				else
					$res_message = 'Seminar Not Found in Your Wishlist';
				$res['message']=$res_message;
			}
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = '無効なユーザーID';
			else
				$res_message = 'Invalid User Id';
			$res['message']=$res_message;
		}
		echo json_encode($res);
	}
	
	public function deletewishlist()
	{
		$lang=$this->input->post('lang');
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
					if($lang=='ja')
						$res_message = '正常にリスト削除済みウィッシュ';
					else
						$res_message = 'Wishlist Deleted Successfully';
					$res['message']=$res_message;
				}
				else
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = 'ウィッシュリストが見つかりません';
					else
						$res_message = 'Wishlist Not Found';
					$res['message']=$res_message;
				}
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'セミナーが見つかりません';
				else
					$res_message = 'Seminar Not Found';
				$res['message']=$res_message;
			}
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'ユーザーが見つかりません';
			else
				$res_message = 'User Not Found';
			$res['message']=$res_message;
		}
		
		echo json_encode($res);
	}
	
	public function deletebooking()
	{
		$lang=$this->input->post('lang');
		$uid = $this->input->post('user_id');
		$seminar_id = $this->input->post('seminar_id');
		$booking_id = $this->input->post('booking_id');
				
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
					$seat = $seminarresult[0]->{'total_booked_seat'}+$result[0]->{'book_seat'};
					$query=$this->db->query("update seminar set total_booked_seat='".$seat."' where id='".$seminar_id."'");
					
					$data = $this->User_model->deletebooking($uid,$seminar_id,$booking_id);
					
					$gcmData['sid'] = $seminarresult[0]->{'id'};
					$gcmData['bid'] = $result[0]->{'id'};
					$gcmData['sn'] = $seminarresult[0]->{'title'};
					$gcmData['un'] = $uidresult[0]->{'fname'};
					$gcmData['ty'] = SEMINAR_CANCEL;
					
					$gcmData1 = array(
						'title'		=> 'Meeto',
						//'isBackground' 	=> 'false',
						//'flag'		=> '1',
						'data'	=> $gcmData
					);
						
					$ids = array( $user_data[0]->{'gcm_id'} );
					$this->User_model->sendPushNotification($gcmData1, $ids);
			
					$res['status_code']=1;
					if($lang=='ja')
						$res_message = 'セミナーの予約削除されたに成功しました';
					else
						$res_message = 'Seminar Booking Deleted Successfully';
					$res['message']=$res_message;
				}
				else
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = 'セミナーの予約が見つかりません';
					else
						$res_message = 'Seminar Booking Not Found';
					$res['message']=$res_message;
				}
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'セミナーが見つかりません';
				else
					$res_message = 'Seminar Not Found';
				$res['message']=$res_message;
			}
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'ユーザーが見つかりません';
			else
				$res_message = 'User Not Found';
			$res['message']=$res_message;
		}
		
		echo json_encode($res);
	}
	
	public function deleteseminar()
	{
		$lang=$this->input->post('lang');
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
					if($lang=='ja')
						$res_message = 'セミナー削除されたに成功しました';
					else
						$res_message = 'Seminar Deleted Successfully';
					$res['message']=$res_message;
				}
				else
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = 'セミナーが見つかりません';
					else
						$res_message = 'Seminar Not Found';
					$res['message']=$res_message;
				}
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'セミナーが見つかりません';
				else
					$res_message = 'Seminar Not Found';
				$res['message']=$res_message;
			}
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'ユーザーが見つかりません';
			else
				$res_message = 'User Not Found';
			$res['message']=$res_message;
		}
		
		echo json_encode($res);
	}
	
	public function notification()
	{
		$lang=$this->input->post('lang');
		$uid = $this->input->post('user_id');
		$synctime = $this->input->post('synctime');
		if($data = $this->User_model->notification($uid,$synctime))
		{
			$res['status_code']=1;
			if($lang=='ja')
				$res_message = 'お知らせ';
			else
				$res_message = 'Notification';
			$res['message']=$res_message;
			$res['notification_detail']=$data;
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = '通知が見つかりません';
			else
				$res_message = 'Notification Not Found';
			$res['message']=$res_message;
		}
		
		echo json_encode($res);
	}
	
	public function verifyemail()
	{
		$lang=$this->input->post('lang');
		$uid = $this->input->post('user_id');
		$email = $this->input->post('email');
		
		$query = $this->db->query("select * from user where id='".$uid."' and email='".$email."' ");
		
		if($result=$query->result())
		{
			$key= md5($email);
			$url = "http://www.meeto.jp/Verification_app.php?uid=".$uid."&key=".$key;
			$subject = "Email Verification";
			$to = $email;
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From:meeto.japan@gmail.com';
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
				if($lang=='ja')
					$res_message = '確認メールが "'.$email.'" に送信されたアカウントをアクティブにするためにActivateボタンをクリックしてください';
				else
					$res_message = 'A confirmation email has been sent to "'.$email.'" Please click on the Activate Button to Activate your account';
				$res['message']=$res_message;
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'メール送信されません';
				else
					$res_message = 'Mail Not Sent';
				$res['message']=$res_message;
			}
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'ユーザーIDまたはメールが一致しません';
			else
				$res_message = 'User ID or E-mail not match';
			$res['message']=$res_message;
		}
		echo json_encode($res);
	}
	
	public function setgcm()
	{
		$lang=$this->input->post('lang');
		$uid = $this->input->post('user_id');
		$gcm_id = $this->input->post('gcm_id');
		
		if($data = $this->User_model->setgcm($uid,$gcm_id))
		{
			$res['status_code']=1;
			if($lang=='ja')
				$res_message = 'GCM IDが正常に設定されました';
			else
				$res_message = 'GCM ID set Successfully';
			$res['message']=$res_message;
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'GCM IDが設定されていません';
			else
				$res_message = 'GCM ID not set';
			$res['message']=$res_message;
		}
		echo json_encode($res);
	}
	
	public function loginwithfb()
	{
		$lang=$this->input->post('lang');
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
					$data1['photo'] = "http://www.meeto.jp/img/".$result[0]->{'photo'};
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
			if($lang=='ja')
				$res_message = 'Facebookので正常にログイン';
			else
				$res_message = 'Login Successfully With Facebook';
			$res['message']=$res_message;
			$res['user']=$data1;
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'FacebookのIDまたは名前を欠落しています';
			else
				$res_message = 'facebook id or name missing';
			$res['message']=$res_message;
		}
		
		echo json_encode($res);
	}
	
	public function user_review()
	{
		$lang=$this->input->post('lang');
		$uid = $this->input->post('user_id');
		$seminar_id = $this->input->post('seminar_id');
		$review = $this->input->post('review');
		
		$query = $this->db->query("select * from review where uid='".$uid."' and seminar_id='".$seminar_id."' ");
		if($query->result())
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'あなたはすでにこのセミナーのためのあなたのレビューを与えました';
			else
				$res_message = 'You already Gave Your Review For This Seminar';
			$res['message']=$res_message;
		}
		else
		{
			if(!empty($uid) && !empty($seminar_id) && !empty($review) )
			{
				if($data=$this->User_model->user_review($uid,$seminar_id,$review))
				{
					$res['status_code']=1;
					if($lang=='ja')
						$res_message = 'レビューは正常に追加します';
					else
						$res_message = 'Review Added Successfully';
					$res['message']=$res_message;
				}
				else
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = '確認追加されていません';
					else
						$res_message = 'Review Not Added';
					$res['message']=$res_message;
				}
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'パラメータ不足しています';
				else
					$res_message = 'Parameter missing';
				$res['message']=$res_message;
			}
		}
		echo json_encode($res);
	}

	public function user_review_detail()
	{
		$lang=$this->input->post('lang');
		$uid = $this->input->post('user_id');
		
		if(!empty($uid))
		{
			if($data=$this->User_model->user_review_detail($uid))
			{
				$i=0;
				foreach($data as $value)
				{
					if($value->uid==$uid)
					{
						$data1[$i]['type']="your_review";
					}
					else
					{
						$data1[$i]['type']="user_review";
					}
					
					$query1 = $this->db->query("select * from user where id='".$value->uid."' ");
					if($result1 = $query1->result())
					{
						$data1[$i]['user_name'] = trim($result1[0]->{'fname'})." ".trim($result1[0]->{'lname'});
					}
					else
					{
						$data1[$i]['user_name'] = "";
					}
					
					$query1 = $this->db->query("select * from seminar where id='".$value->seminar_id."' ");
					if($result1 = $query1->result())
					{
						$data1[$i]['seminar_name'] = $result1[0]->{'title'};
					}
					else
					{
						$data1[$i]['seminar_name'] = "";
					}
					
					$query1 = $this->db->query("select * from seminar_photos where seminar_id='".$value->seminar_id."' ");
					if($result1 = $query1->result())
					{
						$data1[$i]['seminar_pic'] = "http://www.meeto.jp/img/".$result1[0]->{'image'};
					}
					else
					{
						$data1[$i]['seminar_pic'] = "";
					}
					
					$data1[$i]['review']=$value->notes;
					$data1[$i]['review_id']=$value->id;
					$data1[$i]['user_id']=$value->uid;
					$data1[$i]['seminar_id']=$value->seminar_id;
					$i++;
				}
				$res['status_code']=1;
				if($lang=='ja')
					$res_message = 'レビューは正常に追加します';
				else
					$res_message = 'Review Added Successfully';
				$res['message']=$res_message;
				$res['review']=$data1;
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = '確認が見つかりません';
				else
					$res_message = 'Review Not Found';
				$res['message']=$res_message;
			}
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'パラメータ不足しています';
			else
				$res_message = 'Parameter missing';
			$res['message']=$res_message;
		}
		
		echo json_encode($res);
	}
	
	public function table_data()
	{
		$lang=$this->input->post('lang');
		if($lang=="en")
		{
			$query="";$result="";$data="";
			$query = $this->db->query("select * from language where status = 1 ");
			$result = $query->result();
			if(!empty($result))
			{
				$i=0;
				foreach($query->result() as $result)
				{
					$data[$i]['id'] = $result->id;
					$data[$i]['name'] = $result->name;
					$i++;
				}
				$res['language']=$data;
			}
			
			$query="";$result="";$data="";
			$query = $this->db->query("select * from seminar_type where status = 1 ");
			$result = $query->result();
			if(!empty($result))
			{
				$i=0;
				foreach($query->result() as $result)
				{
					$data[$i]['id'] = $result->id;
					$data[$i]['name'] = $result->name;
					$i++;
				}
				$res['seminar_type']=$data;
			}
			
			$query="";$result="";$data="";
			$query = $this->db->query("select * from facility where status = 1 ");
			$result = $query->result();
			if(!empty($result))
			{
				$i=0;
				foreach($query->result() as $result)
				{
					$data[$i]['id'] = $result->id;
					$data[$i]['name'] = $result->name;
					$i++;
				}
				$res['facility']=$data;
			}
			
			$query="";$result="";$data="";
			$query = $this->db->query("select * from industry where status = 1 ");
			$result = $query->result();
			if(!empty($result))
			{
				$i=0;
				foreach($query->result() as $result)
				{
					$data[$i]['id'] = $result->id;
					$data[$i]['name'] = $result->name;
					$i++;
				}
				$res['industry']=$data;
			}
			
			$query="";$result="";$data="";
			$query = $this->db->query("select * from purpose where status = 1 ");
			$result = $query->result();
			if(!empty($result))
			{
				$i=0;
				foreach($query->result() as $result)
				{
					$data[$i]['id'] = $result->id;
					$data[$i]['name'] = $result->name;
					$i++;
				}
				$res['purpose']=$data;
			}
		}
		else if($lang=="ja")
		{
			$query="";$result="";$data="";
			$query = $this->db->query("select * from language where status = 1 ");
			$result = $query->result();
			if(!empty($result))
			{
				$i=0;
				foreach($query->result() as $result)
				{
					$data[$i]['id'] = $result->id;
					$data[$i]['name'] = $result->name;
					$i++;
				}
				$res['language']=$data;
			}
			
			$query="";$result="";$data="";
			$query = $this->db->query("select * from seminar_type where status = 1 ");
			$result = $query->result();
			if(!empty($result))
			{
				$i=0;
				foreach($query->result() as $result)
				{
					$data[$i]['id'] = $result->id;
					$data[$i]['name'] = $result->name_jp;
					$i++;
				}
				$res['seminar_type']=$data;
			}
			
			$query="";$result="";$data="";
			$query = $this->db->query("select * from facility where status = 1 ");
			$result = $query->result();
			if(!empty($result))
			{
				$i=0;
				foreach($query->result() as $result)
				{
					$data[$i]['id'] = $result->id;
					$data[$i]['name'] = $result->name_jp;
					$i++;
				}
				$res['facility']=$data;
			}
			
			$query="";$result="";$data="";
			$query = $this->db->query("select * from industry where status = 1 ");
			$result = $query->result();
			if(!empty($result))
			{
				$i=0;
				foreach($query->result() as $result)
				{
					$data[$i]['id'] = $result->id;
					$data[$i]['name'] = $result->name_jp;
					$i++;
				}
				$res['industry']=$data;
			}
			
			$query="";$result="";$data="";
			$query = $this->db->query("select * from purpose where status = 1 ");
			$result = $query->result();
			if(!empty($result))
			{
				$i=0;
				foreach($query->result() as $result)
				{
					$data[$i]['id'] = $result->id;
					$data[$i]['name'] = $result->name_jp;
					$i++;
				}
				$res['purpose']=$data;
			}
		}
		else
		{
			$res['error']="invalid language.";
		}
		
		echo json_encode($res);
	}
	
	
}