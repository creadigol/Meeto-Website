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
		$this->load->helper(array('form', 'url'));
	}
	
	public function index() {
		
	}
	
	public function home()
	{
		$lang=$this->input->post('lang');
		$uid = $this->input->post('user_id');
		$sync_time = $this->input->post('sync_time');
		
		$data = $this->Seminar_model->home();
		$i=0;
		foreach($data as $val1){
			$res1[$i]['cityid']=$val1->id;
			$res1[$i]['cityname']=$val1->name;
			if($lang=='ja'){
				$res1[$i]['cityname']=$val1->jp_name;
			}
			if(empty($val1->city_img)){
				$res1[$i]['cityimage']="";
			}else{
				$res1[$i]['cityimage']="http://www.meeto.jp/img/".$val1->city_img;
			}
			$i++;
		}
		
		$sliders = $this->db->query("select * from sliders where status=1");
		$sliders = $sliders->result();
		$query = $this->db->query("SELECT count(*) as c FROM `user` where id='".$uid."' ");
		$result = $query->result();
		if($uid!="" && $result[0]->{'c'}>0)
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
		if($lang=='ja')
			$res_message = '人気都市一覧';
		else
			$res_message = 'Popular City List';
		$res['message']=$res_message;
		$res['List']=$res1;
		$res['Slider']="http://www.meeto.jp/img/".$sliders[0]->{'name'};
		$res['notification_count']=$notification_count;
		$res['email_verify']=$email_verify;
		echo json_encode($res);
	}
	
	public function searchseminar()
	{
		$lang=$this->input->post('lang');
		$user_id = $this->input->post('user_id');
		$data = $this->Seminar_model->searchseminar();
		if(empty($data))
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'レコードが見つかりませんありません';
			else
				$res_message = 'No Seminars Found ...!';
			$res['message']=$res_message;
		}
		else
		{
			$i=0;
			foreach($data as $key => $value){
				$res1[$i]['seminar_id']=$value->id;
				$res1[$i]['uid']=$value->uid;
				$res1[$i]['title']=$value->title;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$value->title)));
					$res1[$i]['title'] = $marutra[1];
				} */
				/*$res1[$i]['tagline']=$value->tagline;
				$res1[$i]['description']=$value->description;
				$res1[$i]['total_seat']=$value->total_seat;
				$res1[$i]['total_booked_seat']=$value->total_booked_seat;
				$res1[$i]['qualification']=$value->qualification;*/
				$res1[$i]['address']=$value->address;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$value->address)));
					$res1[$i]['address'] = $marutra[1];
				} */
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
				$query = $this->db->query("select * from seminar_photos where seminar_id = '".$value->id."' order by id ");
				if($query->result()){
					foreach($query->result() as $key => $val){
						$res1[$i]['seminar_image']="http://www.meeto.jp/img/".$val->image;
					}
				}else{
					$res1[$i]['seminar_image']="";
				}
				
				$query = $this->db->query("select * from user_detail where uid = '".$value->uid."' ");
				if($query->result()){
					foreach($query->result() as $key => $val){
						$res1[$i]['host_image']="http://www.meeto.jp/img/".$val->photo;
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
			if($lang=='ja')
				$res_message = 'セミナー一覧';
			else
				$res_message = 'Seminar List';
			$res['message']=$res_message;
			$res['seminar_list']=$res1;
		}
		echo json_encode($res);
	}
	
	public function addseminar()
	{
		$lang=$this->input->post('lang');
		$uid=$this->input->post('user_id');
		if(isset($uid) && !empty($uid))
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
					//$data['seminar']['qualification'] = $row->qualification;
				}
				$query=$this->db->query("select * from seminar_day where seminar_id='".$data['seminar']['id']."' ");
				foreach($query->result() as $row){
					$data['seminar_day']['id'] = $row->id;
					$data['seminar_day']['from_date'] = $row->from_date;
					$data['seminar_day']['to_date'] = $row->to_date;
					$data['seminar_day']['from_time'] = $row->from_date;
					$data['seminar_day']['to_time'] = $row->to_date;
				}
				
				$seminaredit=$this->input->post('seminaredit');
				if(!$seminaredit)
				{
					$res['status_code']=1;
					if($lang=='ja')
						$res_message = 'セミナーを追加しました。';
					else
						$res_message = 'Your Seminar Succesfully Added.';
					$res['message']=$res_message;
					$res['seminar_detail']=$data;
				}
				else
				{
					$res['status_code']=1;
					if($lang=='ja')
						$res_message = 'セミナーが成功裏に更新されました。';
					else
						$res_message = 'Your Seminar Updated Succesfully.';
					$res['message']=$res_message;
					$res['seminar_detail']=$data;
				}
			}
			else
			{
				$seminaredit=$this->input->post('seminaredit');
				if(!$seminaredit)
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = 'セミナー後で試してみてくださいまたはあなたの詳細を確認してください追加されていません';
					else
						$res_message = 'Seminar Not Added Try Later or Check Your Detail';
					$res['message']=$res_message;
				}
				else
				{
					$res['status_code']=0;
					if($lang=='ja')
						$res_message = 'セミナー後で試してみてくださいまたはあなたの詳細を確認してください追加されていません';
					else
						$res_message = 'Seminar Not Updated Try Later or Check Your Detail';
					$res['message']=$res_message;
				}
			}
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'セミナー後で試してみてくださいまたはあなたの詳細を確認してください追加されていません';
			else
				$res_message = 'User ID missing.';
			$res['message']=$res_message;
		}
		echo json_encode($res);
	}
	
	public function seminardetail()
	{
		$lang=$this->input->post('lang');
		$seminar_id=$this->input->post('seminar_id');
		$uid=$this->input->post('user_id');
		if($data = $this->Seminar_model->seminardetail($seminar_id))
		{
			foreach($data as $val)
			{
				$data1['seminar_id']=$val->id;
				$data1['seminar_name']=$val->title;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$val->title)));
					$data1['seminar_name'] = $marutra[1];
				} */
				$data1['tagline']=$val->tagline;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$val->tagline)));
					$data1['tagline'] = $marutra[1];
				} */
				$data1['qualification']=$val->qualification;
				$data1['zipcode']=$val->zipcode;
				$data1['contact_email']=$val->contact_email;
				$data1['contact_no']=$val->phoneno;
				//$puposeid=$val->puposeid;
				$typeid=$val->typeid;
				$data1['lat']=$val->lat;
				$data1['lng']=$val->lng;
				$data1['countryid']=$val->countryid;
				$data1['stateid']=$val->stateid;
				$data1['cityid']=$val->cityid;
				$data1['seminar_adress']=$val->address;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$val->address)));
					$data1['seminar_adress'] = $marutra[1];
				} */
				$data1['seminar_host_name']=$val->hostperson_name;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$val->hostperson_name)));
					$data1['seminar_host_name'] = $marutra[1];
				} */
				$data1['seminar_description']=$val->description;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$val->description)));
					$data1['seminar_description'] = $marutra[1];
				} */
				$data1['seminar_total_seat']=$val->total_seat;
				$data1['available_seat']=($val->total_seat)-($val->total_booked_seat);
				
				
				if($val->uid==$uid)
				{
					$data1['admin']="true";
				}
				else
				{
					$data1['admin']="false";
				}
				$query = $this->db->query("select * from seminar_day where seminar_id='".$val->id."' ");
				if($result = $query->result())
				{
					$data1['from_date']=$result[0]->{'from_date'};
					$data1['to_date']=$result[0]->{'to_date'};
					$data1['from_time']=$result[0]->{'from_date'};
					$data1['to_time']=$result[0]->{'to_date'};
				}
				else
				{
					$data1['from_date']="";
					$data1['to_date']="";
					$data1['from_time']="";
					$data1['to_time']="";
				}
				
				$review=array();
				$query = $this->db->query("select * from review where seminar_id='".$val->id."' and status=1 ");
				if($result = $query->result())
				{
					$i=0;
					foreach($result as $value)
					{
						$review[$i]['review']=$value->notes;
						/* if($lang=='ja'){
							$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$value->notes)));
							$review[$i]['review'] = $marutra[1];
						} */
						$usrnam = $this->db->query("select * from user where id='".$value->uid."' ");
						$usrnam = $usrnam->result();
						$review[$i]['user_name']=trim($usrnam[0]->fname)." ".trim($usrnam[0]->lname);
						/* if($lang=='ja'){
							$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$review[$i]['user_name'])));
							$review[$i]['user_name'] = $marutra[1];
						} */
						$i++;
					}
				}
				
				$query = $this->db->query("select * from user_detail where uid='".$val->uid."' ");
				if($result = $query->result())
				{
					$data1['seminar_host_description']=$result[0]->{'yourself'};
					/* if($lang=='ja'){
						$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$result[0]->{'yourself'})));
						$data1['seminar_host_description'] = $marutra[1];
					} */
					$data1['seminar_host_pic']="http://www.meeto.jp/img/".$result[0]->{'photo'};
					
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
					if($lang=='ja')
						$data1['seminar_type']=$result[0]->{'name_jp'};
					else
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
				$seminar_pic[$i]['seminar_pic']="http://www.meeto.jp/img/".$value->image;
				//$data1['seminar_pic']['seminar_pic_'.$i]="http://www.meeto.jp/img/".$value->image;
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
					if($lang=='ja')
						$seminar_facility[$i]['seminar_facility']=$result1[0]->{'name_jp'};
					else
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
				if($lang=='ja')
					$seminar_purpose[$i]['seminar_purpose']=$result1[0]->{'name_jp'};
				else
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
					if($lang=='ja')
						$seminar_industry[$i]['seminar_industry']=$result1[0]->{'name_jp'};
					else
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
			
			
			$query = $this->db->query("select * from seminar where status=1 and approval_status='approved' and typeid='".$typeid."' and id not in ('".$seminar_id."')");
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
						$data2[$h]['seminar_host_pic']="http://www.meeto.jp/img/".$result[0]->{'photo'};
					}*/
					
					$query = $this->db->query("select * from seminar_photos where seminar_id='".$val->id."' ");
					if($result = $query->result())
					{
						$data2[$h]['seminar_pic']="http://www.meeto.jp/img/".$result[0]->{'image'};
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
			if($lang=='ja')
				$res_message = 'セミナーの詳細';
			else
				$res_message = 'Seminar Detail';
			$res['message']=$res_message;
			$res['seminar_detail']=$data1;
			$res['seminar_pic']=$seminar_pic;
			$res['seminar_facility']=$seminar_facility;
			$res['seminar_purpose']=$seminar_purpose;
			$res['seminar_industry']=$seminar_industry;
			$res['review']=$review;
			$res['similar_seminar_detail']=$data2;
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'セミナーが見つかりません';
			else
				$res_message = 'No Seminars Found ...!';
			$res['message']=$res_message;
			$res['seminar_detail']="";
		}
		
		echo json_encode($res);
	}
	
	public function ownseminardetail()
	{
		$lang=$this->input->post('lang');
		$seminar_id=$this->input->post('seminar_id');
		$uid=$this->input->post('user_id');
		if($data = $this->Seminar_model->ownseminardetail($seminar_id))
		{
			foreach($data as $val)
			{
				$data1['seminar_id']=$val->id;
				$data1['seminar_name']=$val->title;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$val->title)));
					$data1['seminar_name'] = $marutra[1];
				} */
				$data1['tagline']=$val->tagline;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$val->tagline)));
					$data1['tagline'] = $marutra[1];
				} */
				$data1['qualification']=$val->qualification;
				$data1['zipcode']=$val->zipcode;
				$data1['contact_email']=$val->contact_email;
				$data1['contact_no']=$val->phoneno;
				//$puposeid=$val->puposeid;
				$typeid=$val->typeid;
				$data1['countryid']=$val->countryid;
				$data1['stateid']=$val->stateid;
				$data1['cityid']=$val->cityid;
				$data1['seminar_adress']=$val->address;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$val->address)));
					$data1['seminar_adress'] = $marutra[1];
				} */
				$data1['seminar_host_name']=$val->hostperson_name;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$val->hostperson_name)));
					$data1['seminar_host_name'] = $marutra[1];
				} */
				$data1['seminar_description']=$val->description;
				/* if($lang=='ja'){
					$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$val->description)));
					$data1['seminar_description'] = $marutra[1];
				} */
				$data1['seminar_total_seat']=$val->total_seat;
				$data1['available_seat']=($val->total_seat)-($val->total_booked_seat);
				
				if($val->uid==$uid)
				{
					$data1['admin']="true";
				}
				else
				{
					$data1['admin']="false";
				}
				$query = $this->db->query("select * from seminar_day where seminar_id='".$val->id."' ");
				if($result = $query->result())
				{
					$data1['from_date']=$result[0]->{'from_date'};
					$data1['to_date']=$result[0]->{'to_date'};
					//$data1['from_time']=date("g:i a",$result[0]->{'from_date'}/1000);
					//$data1['to_time']=date("g:i a",$result[0]->{'to_time'}/1000);
				}
				else
				{
					$data1['from_date']="";
					$data1['to_date']="";
					$data1['from_time']="";
					$data1['to_time']="";
				}
				
				$review=array();
				$query = $this->db->query("select * from review where seminar_id='".$val->id."' and status=1 ");
				if($result = $query->result())
				{
					$i=0;
					foreach($result as $value)
					{
						$review[$i]['review']=$value->notes;
						/* if($lang=='ja'){
							$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$val->notes)));
							$review[$i]['review'] = $marutra[1];
						} */
						$usrnam = $this->db->query("select * from user where id='".$value->uid."' ");
						$usrnam = $usrnam->result();
						$review[$i]['user_name']=trim($usrnam[0]->fname)." ".trim($usrnam[0]->lname);
						/* if($lang=='ja'){
							$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$review[$i]['user_name'])));
							$review[$i]['user_name'] = $marutra[1];
						} */
						$i++;
					}
				}
				
				$query = $this->db->query("select * from user_detail where uid='".$val->uid."' ");
				if($result = $query->result())
				{
					$data1['seminar_host_description']=$result[0]->{'yourself'};
					/* if($lang=='ja'){
						$marutra = explode('"',$this->Seminar_model->translate(str_replace(" ","+",$result[0]->{'yourself'})));
						$data1['seminar_host_description'] = $marutra[1];
					} */
					$data1['seminar_host_pic']="http://www.meeto.jp/img/".$result[0]->{'photo'};
					
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
					if($lang=='ja')
						$data1['seminar_type']=$result[0]->{'id'};
					else
						$data1['seminar_type']=$result[0]->{'id'};
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
				$seminar_pic[$i]['seminar_pic']="http://www.meeto.jp/img/".$value->image;
				//$data1['seminar_pic']['seminar_pic_'.$i]="http://www.meeto.jp/img/".$value->image;
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
					if($lang=='ja')
						$seminar_facility[$i]['seminar_facility']=$result1[0]->{'id'};
					else
						$seminar_facility[$i]['seminar_facility']=$result1[0]->{'id'};
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
				if($lang=='ja')
					$seminar_purpose[$i]['seminar_purpose']=$result1[0]->{'id'};
				else
					$seminar_purpose[$i]['seminar_purpose']=$result1[0]->{'id'};
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
					if($lang=='ja')
						$seminar_industry[$i]['seminar_industry']=$result1[0]->{'id'};
					else
						$seminar_industry[$i]['seminar_industry']=$result1[0]->{'id'};
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
						$data2[$h]['seminar_host_pic']="http://www.meeto.jp/img/".$result[0]->{'photo'};
					}*/
					
					$query = $this->db->query("select * from seminar_photos where seminar_id='".$val->id."' ");
					if($result = $query->result())
					{
						$data2[$h]['seminar_pic']="http://www.meeto.jp/img/".$result[0]->{'image'};
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
			if($lang=='ja')
				$res_message = 'セミナーの詳細';
			else
				$res_message = 'Seminar Detail';
			$res['message']=$res_message;
			$res['seminar_detail']=$data1;
			$res['seminar_pic']=$seminar_pic;
			$res['seminar_facility']=$seminar_facility;
			$res['seminar_purpose']=$seminar_purpose;
			$res['seminar_industry']=$seminar_industry;
			$res['review']=$review;
			$res['similar_seminar_detail']=$data2;
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'セミナーが見つかりません';
			else
				$res_message = 'No Seminars Found ...!';
			$res['message']=$res_message;
			$res['seminar_detail']="";
		}
		
		echo json_encode($res);
	}

	public function seminarbooking()
	{
		$lang=$this->input->post('lang');
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
				$seminar_data = $this->db->query("select * from seminar where id='".$seminar_id."' ");
				$seminar_data = $seminar_data->result();
				
				$user_data = $this->db->query("select * from user where id='".$uid."' ");
				$user_data = $user_data->result();
				
				$ticketdetail = $this->db->query("select * from seminar_booking where uid='".$uid."' and seminar_id='".$seminar_id."' ");
				$ticketdetail = $ticketdetail->result();
				
				$subject = "Seminar Ticket Booked";
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From:meeto.japan@gmail.com';
				
				$message  = '<html>';	
				$message .= '<body>';
				$message .= '<h2>User Information Of Book Your Seminar</h2>';
				$message .= '<table>';
				$message .= '<tr>';
				$message .= '<td>Seminar Title : '.$seminar_data[0]->{'title'}.'</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td>User name : '.$user_data[0]->{'fname'}.' '.$user_data[0]->{'lname'}.'</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td> Total Booked Seats: '.$ticketdetail[0]->{'book_seat'}.'</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td> From date : '.date("Y-m-d",$ticketdetail[0]->{'from_date'}/1000).'</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td> To date : '.date("Y-m-d",$ticketdetail[0]->{'to_date'}/1000).'</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td> Booking No : '.$ticketdetail[0]->{'booking_no'}.'</td>';
				$message .= '</tr>';
				$message .= '<tr>';
				$message .= '<td> Message : '.$ticketdetail[0]->{'message'}.'</td>';
				$message .= '</tr>';
				$message .= '</table>';
				$message .= '</div>';
				$message .= '</body>';
				$message .= '</html>';
				
				
				$host_data = $this->db->query("select * from user where id in (select uid from seminar where id='".$seminar_id."')");
				$host_data = $host_data->result();
				
				$sentmail = mail($host_data[0]->{'email'},$subject,$message,$headers);
				
				$gcmData['sid'] = $seminar_data[0]->{'id'};
				$gcmData['bid'] = $ticketdetail[0]->{'id'};
				$gcmData['sn'] = $seminar_data[0]->{'title'};
				$gcmData['un'] = $user_data[0]->{'fname'};
				$gcmData['ty'] = SEMINAR_BOOKING;
				
				$data = array(
					'title'		=> 'Meeto',
					//'isBackground' 	=> 'false',
					//'flag'		=> '1',
					'data'	=> $gcmData
				);
								
				$ids = array( $user_data[0]->{'gcm_id'} );
				$this->Seminar_model->sendPushNotification($data, $ids);
		
				$res['status_code']=1;
				if($lang=='ja')
					$res_message = '正常に予約';
				else
					$res_message = 'Booking Successfully';
				$res['message']=$res_message;
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'れていない正常に予約';
				else
					$res_message = 'Booking Not Successfully';
				$res['message']=$res_message;
			}
		}
		else
		{	
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'ユーザIDまたは無効なセミナーID';
			else
				$res_message = 'User ID OR Seminar ID not valid';
			$res['message']=$res_message;
		}
		
		echo json_encode($res);
	}
	
	public function addtowishlist()
	{
		$lang=$this->input->post('lang');
		$seminar_id=$this->input->post('seminar_id');
		$uid=$this->input->post('user_id');
		
		if($this->Seminar_model->addtowishlist($seminar_id,$uid))
		{
			$res['status_code']=1;
			if($lang=='ja')
				$res_message = '成功しましたウィッシュリストに追加';
			else
				$res_message = 'Added To Wishlist Successfully';
			$res['message']=$res_message;
		}
		else
		{
			$wishlist = $this->db->query("select * from wishlist where seminar_id='".$seminar_id."' and uid='".$uid."' ");
			$wishlist_r = $wishlist->result();
			if(!empty($wishlist_r))
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'すでにウィッシュリストで';
				else
					$res_message = 'Already in Wishlist';
				$res['message']=$res_message;
			}
			else
			{
				$res['status_code']=0;
				if($lang=='ja')
					$res_message = 'ユーザーIDまたは有効でないセミナーID';
				else
					$res_message = 'User ID or Seminar ID Not Valid';
				$res['message']=$res_message;
			}				
		}
		echo json_encode($res);
	}
	
	public function searchseminarstring()
	{
		$lang=$this->input->post('lang');
		$i=0;
		$search = $this->input->post('search');
		
		$query = $this->db->query("select * from seminar where approval_status='approved' and status=1 and title like '%".$search."%' ");
		foreach($query->result() as $key => $value){
			$res1[$i]['name']=$value->title;
			$res1[$i]['type']="seminar";
			$res1[$i]['id']=$value->id;
			$i++;
		}
		
		$query = $this->db->query("select * from cities where (name like '%".$search."%' or jp_name like '%".$search."%') and id in (select distinct cityid from seminar where approval_status='approved' and status=1) ");
		foreach($query->result() as $key => $val){
			$res1[$i]['name']=$val->name;
			$res1[$i]['type']="city";
			$res1[$i]['id']=$val->id;
			$i++;
		}
		if(empty($res1))
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'セミナー一覧';
			else
				$res_message = 'Seminar List';
			$res['message']=$res_message;
			$res['seminar_list']="";
		}
		else
		{
			$res['status_code']=1;
			if($lang=='ja')
				$res_message = 'セミナー一覧';
			else
				$res_message = 'Seminar List';
			$res['message']=$res_message;
			$res['seminar_list']=$res1;
		}	
		echo json_encode($res);
	}
	
	public function seminarbookinglist()
	{
		$lang=$this->input->post('lang');
		$seminar_id = $this->input->post('seminar_id');
		$uid = $this->input->post('user_id');
		
		if($data = $this->Seminar_model->seminarbookinglist($seminar_id,$uid))
		{
			$i=0;
			foreach($data as $val)
			{
				$query = $this->db->query("select * from user where id = '".$val->uid."' ");
				foreach($query->result() as $key => $value)
				{
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
							$res1[$i]['user_pic']="http://www.meeto.jp/img/".$value->photo;
						}
					}
				}
				$query = $this->db->query("select * from seminar where id = '".$val->seminar_id."' ");
				foreach($query->result() as $key => $value)
				{
					$res1[$i]['seminar_name']=$value->title;
					$res1[$i]['seminar_id']=$value->id;
				}
				$res1[$i]['book_seat'] = $val->book_seat;
				$res1[$i]['booking_no'] = $val->booking_no;
				$res1[$i]['status']=$val->approval_status;
				$res1[$i]['booking_date']=date("Y-m-d H:i:s a",$val->created_date/1000);		
				$i++;
			}
			
			$res['status_code']=1;
			if($lang=='ja')
				$res_message = 'セミナー予約ユーザーリスト';
			else
				$res_message = 'Seminar Booking User List';
			$res['message']=$res_message;
			$res['data']=$res1;
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = '何もデータが見つかりませんでした';
			else
				$res_message = 'No Data Found';
			$res['message']=$res_message;
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
		$lang=$this->input->post('lang');
		$seminar_id = $this->input->post('seminar_id');
		$uid = $this->input->post('user_id');
		$approval_status = $this->input->post('approval_status');
		$booking_no = $this->input->post('booking_no');
		
		if($this->Seminar_model->acceptdeclineseminar($seminar_id,$uid,$approval_status,$booking_no))
		{
			$seminar_data = $this->db->query("select * from seminar where id='".$seminar_id."' ");
			$seminar_data = $seminar_data->result();
			
			$user_data = $this->db->query("select * from user where id='".$uid."' ");
			$user_data = $user_data->result();
				
			$ticketdetail = $this->db->query("select * from seminar_booking where uid='".$uid."' and seminar_id='".$seminar_id."' ");
			$ticketdetail = $ticketdetail->result();
				
			$subject = "Seminar Booking Ticket";
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From:meeto.japan@gmail.com';
			
			$message  = '<html>';	
			$message .= '<body>';
			$message .= '<h2>Your Seminar Booking is '.$approval_status.'</h2>';
			$message .= '<table>';
			
			$message .= '<tr>';
			$message .= '<td>Seminar Title : '.$seminar_data[0]->{'title'}.'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td>Your Booked Seats : '.$ticketdetail[0]->{'book_seat'}.'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td> From date : '.date("Y-m-d",$ticketdetail[0]->{'from_date'}/1000).'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td> To date : '.date("Y-m-d",$ticketdetail[0]->{'to_date'}/1000).'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td>Your Ticket No : '.$ticketdetail[0]->{'booking_no'}.'</td>';
			$message .= '</tr>';
			$message .= '</table>';
			$message .= '</div>';
			$message .= '</body>';
			$message .= '</html>';
			
			$sentmail = mail($user_data[0]->{'email'},$subject,$message,$headers);
			
			$gcmData['sid'] = $seminar_data[0]->{'id'};
			$gcmData['bid'] = $ticketdetail[0]->{'id'};
			$gcmData['st'] = $approval_status;
			$gcmData['sn'] = $seminar_data[0]->{'title'};
			$gcmData['ty'] = SEMINAR_BOOKING_APPROVE_DECLINE;
			
			$data = array(
				'title'		=> 'Meeto',
				//'isBackground' 	=> 'false',
				//'flag'		=> '1',
				'data'	=> $gcmData
			);
				
			$ids = array( $user_data[0]->{'gcm_id'} );
			$this->Seminar_model->sendPushNotification($data, $ids);
				
			$res['status_code']=1;
			if($lang=='ja')
				$res_message = 'ご予約';
			else
				$res_message = 'Your Booking '.ucfirst($approval_status);
			$res['message']=$res_message;
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = '承認既に設定されているか、ユーザーIDと有効でないセミナーID';
			else
				$res_message = 'Approval Already Set OR User ID and Seminar ID Not Valid';
			$res['message']=$res_message;
		}
		echo json_encode($res);
	}
	
	public function booking_ticket_download()
	{
		$lang=$this->input->post('lang');
		$seminar_id = $this->input->post('seminar_id');
		$uid = $this->input->post('user_id');
		$booking_id = $this->input->post('booking_id');
		
		if($data = $this->Seminar_model->booking_ticket_download($seminar_id,$uid,$booking_id))
		{
			//$file = file_get_contents("http://www.meeto.jp/tcpdf/examples/print_pdf.php?bkid=".$data[0]->id."&sem_id=".$data[0]->seminar_id);
			//file_put_contents("pdf/".$data[0]->id .".pdf",$file);
			
			//load the download helper
			//$this->load->helper('download');
			//Get the file from whatever the user uploaded (NOTE: Users needs to upload first), @See http://localhost/CI/index.php/upload
			//$pdf = file_get_contents("http://www.meeto.jp/tcpdf/examples/print_pdf.php?bkid=".$data[0]->id."&sem_id=".$data[0]->seminar_id);
			//Read the file's contents
			//$name = "pdf/".$data[0]->id .".pdf";

			//use this function to force the session/browser to download the file uploaded by the user 
			//force_download($name, $pdf);
			
			//$url  = "http://www.meeto.jp/tcpdf/examples/print_pdf.php?bkid=".$data[0]->id."&sem_id=".$data[0]->seminar_id;
			//$path = "pdf/".$data[0]->id .".pdf";

			//$ch = curl_init($url);
			//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch, CURLOPT_REFERER, "http://www.meeto.jp/tcpdf/examples/print_pdf.php?bkid=".$data[0]->id."&sem_id=".$data[0]->seminar_id);

			//$data = curl_exec($ch);

			//curl_close($ch);

			//$result = file_put_contents($path, $data);

				//if(!$result){
			//			echo "error";
			//	}else{
			//			echo "success";
			//	}
			
			
			$res['status_code']=1;
			if($lang=='ja')
				$res_message = 'ご予約のチケット';
			else
				$res_message = 'Your Booking Ticket';
			$res['message']=$res_message;
			$res['pdf_url']= "http://www.meeto.jp/tcpdf/examples/print_pdf.php?bkid=".$data[0]->id."&sem_id=".$data[0]->seminar_id;
		}
		else
		{
			$res['status_code']=0;
			if($lang=='ja')
				$res_message = 'あなたの予約状況は、保留中またはないと判定されました';
			else
				$res_message = 'Your Booking Status is Pending OR Not Found';
			$res['message']=$res_message;
		}
		echo json_encode($res);
	}
	
	
}