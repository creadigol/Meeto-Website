<?php 
function sendPushNotification($to, $message, $why)
{   
	$filename = "FCM_LOG.txt";
	$myfile = fopen($filename, "a");
	$txt = "\n\n########## Date : ".date('d-m-Y H:i:s')." ##########\n";
	fwrite($myfile, $txt);
	$toGcm = "To:- ".$to."\n";
	fwrite($myfile, $toGcm);
	$whyGcm = "Why:- ".$why."\n";
	fwrite($myfile, $whyGcm);
	fclose($myfile);
		
	$fields = array(
		'to' => $to,
		'data' => $message,
	);
	
	// Set POST variables
	$url = 'https://fcm.googleapis.com/fcm/send';

	$headers = array(
		'Authorization: key=' . API_KEY_FCM,
		'Content-Type: application/json'
	);
	// Open connection
	$ch = curl_init();

	// Set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// Disabling SSL Certificate support temporarly
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

	// Execute post
	$result = curl_exec($ch);
	if ($result === FALSE) {
		die('Curl failed: ' . curl_error($ch));
	}

	// Close connection
	curl_close($ch);

	$myfile = fopen($filename, "a");
	fwrite($myfile, $result);
	fclose($myfile);
		
	return $result;
}

	require_once('header.php');
	include('config.php');
	include('condition.php');
	$p=30;
if($_REQUEST['kon']=="setstate")
{ 
?>
<option value="">-- Select State -- </option>
<?php
	$selcity=mysql_query("select * from states where country_id=$_REQUEST[id] order by name");
	while($fetcity=mysql_fetch_array($selcity))
	{
?>
		<option value="<?php echo $fetcity[0]; ?>"><?php echo $fetcity['name']; ?></option>
<?php
		
	}
}
if($_REQUEST['kon']=="setcity")
{ 
?>
<option value="">-- Select City -- </option>
<?php
	$selcity=mysql_query("select * from cities where state_id=$_REQUEST[id] order by name");
	while($fetcity=mysql_fetch_array($selcity))
	{
?>
		<option value="<?php echo $fetcity[0]; ?>"><?php echo $fetcity['name']; ?></option>
<?php
		
	}
}
?>
<?php
	if($_REQUEST['kon'] =='approvalsam')
	{
		$updatestatus=mysql_query("update `seminar` SET `approval_status`='".$_REQUEST[status]."'  WHERE `id`='".$_REQUEST['sid']."' ");
		
		$seminarData = mysql_fetch_array(mysql_query("select * from seminar where id='".$_REQUEST['sid']."'"));
		$userData = mysql_fetch_array(mysql_query("select * from user where id='".$seminarData['uid']."'"));
		
		$gcmData['sid'] = $seminarData['id'];
		$gcmData['sn'] = $seminarData['title'];
		$gcmData['st'] = $_REQUEST[status];
		$gcmData['ty'] = SEMINAR_APPROVE_DECLINE;
		
		$gcmResponse = array();
		$gcmResponse['data']['message'] = $gcmData;
		
		$ids = $userData['gcm_id'];
		sendPushNotification($ids, $gcmResponse, "SEMINAR_APPROVE_DECLINE");
	}
	
	if($_REQUEST['kon'] =='deletesam')
	{
		$deletesam=mysql_query("DELETE FROM `seminar` WHERE `id` = '".$_REQUEST[did]."' ");
		
		
	}
	
	if($_REQUEST['kon'] =='facilitystatus')
	{
		$deletesam=mysql_query("UPDATE `seminar_facility` SET status=$_REQUEST[status] WHERE `id` = $_REQUEST[id] ");
	}
	if($_REQUEST['kon'] =='attendeesstatus')
	{
		$deletesam=mysql_query("UPDATE `seminar_purpose` SET status=$_REQUEST[status] WHERE `id` = $_REQUEST[id] ");
	}
	if($_REQUEST['kon'] =='industrystatus')
	{
		$deletesam=mysql_query("UPDATE `seminar_industry` SET status=$_REQUEST[status] WHERE `id` = $_REQUEST[id] ");
	}
	
	if($_REQUEST['kon'] =='hostseminar')
	{
	?>
		<div class="row">
					<div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                              Host Seminar 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Photo</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Total Seat</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from seminar where uid='".$_REQUEST[user_id]."' ");
										while($data=mysql_fetch_array($query)){
											$detailquery = mysql_query("select * from user where id='".$_REQUEST[user_id]."' ");
											$detaildata=mysql_fetch_array($detailquery);
											$photoquery = mysql_query("select * from seminar_photos where seminar_id='".$data['id']."' ");
											$photodata=mysql_fetch_array($photoquery);
									?>
                                        <tr class="odd gradeX">
											<td>
											<?
												if(strlen($photodata["image"])>0){
											?>
												<img src="../img/<? echo $photodata['image'];?>" width="70" height="70" class="img-circle" />
											<?
												}else{
											?>		
												<img src="../img/no-photo.jpg" width="70" height="70" class="img-circle" />
											<?
												}
											?>
											</td>
                                            <td><? echo $data['title']; ?></td>
                                            <td><? echo $data['description']; ?></td>
                                            <td><? echo $data['total_seat']; ?></td>
                                            <td><span style="cursor:pointer;" onclick="deletesam('<?php echo $data['id']; ?>','<?php echo $data['uid']; ?>');" ><i class="fa fa-trash-o" aria-hidden="true"></i></span></td>
                                        </tr>
									<?
										}
									?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
		<?php
	}
?>
<?php 
	if($_REQUEST['kon'] =='state')
	{
		$querystate=mysql_query("select * from  states where country_id=$_REQUEST[cid] ");
		while($states=mysql_fetch_array($querystate))
		{
			if($states['id'] == $_REQUEST['sid']){
				echo "<option value='$states[id]' selected>$states[name]</option>";
			}else{
				echo "<option value='$states[id]' >$states[name]</option>";
			}
		}
	}
?>
<?php
if($_REQUEST['kon'] =='user')
	{
		$userquery=mysql_query("select * from user where id='".$_REQUEST[user_id]."' ");
		$data=mysql_fetch_array($userquery);
		$userdataquery=mysql_query("select * from user_detail where uid='".$data[id]."' ");
		$userdata=mysql_fetch_array($userdataquery);
		$usercompanyquery=mysql_query("select * from user_company where uid='".$data[id]."' ");
		$companydata=mysql_fetch_array($usercompanyquery);
		
?>
	<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $data['fname']." ".$data['lname']; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                    <form role="form" action="user_detail.php?user_id=<?php echo $_REQUEST[user_id]; ?>" method="POST">
										<div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" type="text" name="fname" value="<?php echo $data['fname']." ".$data['lname']; ?>">
                                            <p class="help-block error"><?php echo $errorname; ?></p>
                                        </div>
										<div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text" readonly name="email" value="<?php echo $data['email']; ?>">
                                            <p class="help-block error"><?php echo $erroremail; ?></p>
                                        </div>
										<div class="form-group">
                                            <label>Gender</label>
											<select class="form-control" name="gender" class="gender" id="gender" >
											<option value="Male" <?php if($userdata['gender']=='Male') echo "selected"; ?>>Male</option>
											<option value="Female" <?php if($userdata['gender']=='Female') echo "selected"; ?>>Female</option>
											<option value="" <?php if($userdata['gender']=='') echo "selected"; ?>>Unspecified</option>
											</select>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Date Of Birth</label>
                                            <input class="form-control" type="text" name="dob" readonly value="<?php echo $userdata['dob']; ?>">
                                            <p class="help-block"></p>
                                        </div>
										<div class="form-group">
                                            <label>Contact</label>
                                            <input class="form-control" type="text" name="contact" readonly value="<?php echo $userdata['phoneno']; ?>">
                                            <p class="help-block error"><?php echo $errorcontact; ?></p>
                                        </div>
										 
										<div class="form-group">
                                            <label>Company</label>
                                            <input class="form-control" type="text" name="company" readonly value="<?php echo $companydata['name']; ?>">
                                            <p class="help-block error"></p>
                                        </div>
										
										<div class="form-group">
                                            <label>Company Description</label>
                                            <input class="form-control" type="text" name="cdescription" value="<?php echo $companydata['description']; ?>">
                                            <p class="help-block error"></p>
                                        </div>
										</div>
										<div class="col-lg-6">
										<div class="form-group">
                                            <label>Country</label>
                                            <select class="form-control" name="country" id="country" class="country" onchange="user('<?php echo $_REQUEST['user_id']; ?>',this.value);">
											<option value="" >Select Country</option>
											<?php
													
														$querycounty=mysql_query("select * from  countries where id!='101'");
												while($country=mysql_fetch_array($querycounty))
												{
													if($_REQUEST[cscid] == $country[id])
													{
														echo "<option value='$country[id]' selected >$country[name]</option>";
														$userdata['countryid']=$country[id];
														$ctd=$country[id];
													}
													else if($country[id] == $userdata['countryid']){
														
														echo "<option value='$country[id]' selected  >$country[name]</option>";
														$ctd=$country[id];
													}else{
														?>
															<option value= <?php echo $country[id]; ?> ><?php echo $country[name]; ?></option>
														<?php
														
													}
												}
											?>
											</select>
                                            <p class="help-block"></p>
                                        </div>
										 <div class="form-group">
                                            <label>State</label>
                                            <select class="form-control" name="state" class="state" id="state" onchange="user('<?php echo $_REQUEST['user_id']; ?>','<?php echo $_REQUEST[cscid]; ?>',this.value);" >
											<?php
												$sf=0;
													if($_REQUEST[cscid]!="undefined")
													{
														$querycounty1=mysql_query("select * from  states where country_id=$_REQUEST[cscid]");
													}
													else{
														$querycounty1=mysql_query("select * from  states where country_id=$ctd");
													}
												while($country1=mysql_fetch_array($querycounty1))
												{
													if($_REQUEST[statet]==$country1[id])
													{
														echo "<option value='$country1[id]' selected >$country1[name]</option>";
														$userdata[stateid]=$country1[id];
														$ctd=$country1[id];
													}
													else if($country1[id] == $userdata[stateid]){
														echo "<option value='$country1[id]' selected >$country1[name]</option>";
														$ctd=$country1[id];
															
													}else{
														echo "<option value='$country1[id]'>$country1[name]</option>";
														
													
													}
												}
											?>
											</select>
                                            <p class="help-block"></p>
                                        </div>
										 <div class="form-group">
                                            <label>City</label>
                                            <select class="form-control" name="city" >
											<?php
												$cf=0;
												if($_REQUEST[statet]!="undefined")
													{
														$querycity=mysql_query("select * from  cities where state_id = $_REQUEST[statet]");
													}
													else{
														$querycity=mysql_query("select * from  cities where state_id=$ctd");
													}
												
												while($city=mysql_fetch_array($querycity))
												{
													
													if($city['id'] == $userdata['cityid']){
														echo "<option value='$city[id]' selected>$city[name]</option>";
													}else{
														if($_REQUEST[cscid]!="undefined" && $cf==0)
														{
															$cf=1;
															echo "<option value='$city[id]' selected>$city[name]</option>";
														}else{
															echo "<option value='$city[id]' >$city[name]</option>";
														}
														
													}
												}
												
											?>
											</select>
                                            <p class="help-block"></p>
                                        </div>
										
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input class="form-control" type="text" name="address" value="<?php echo $userdata['address']; ?>">
                                            <p class="help-block error"><?php echo $erroraddress; ?></p>
                                        </div>
										 <div class="form-group">
                                            <label>About You</label>
                                            <input class="form-control" type="text" name="about" value="<?php echo $userdata['yourself']; ?>">
                                            <p class="help-block error"><?php echo $errorabout; ?></p>
                                        </div>
										<div class="form-group">
                                            <label>Languages Known</label>
											<?php 
											$queryl=mysql_query("select * from user_language where uid='".$data[id]."' ");
											while($langname=mysql_fetch_array($queryl))
											{
												$languages[]=$langname['lid'];
											}
												$userlanguage=mysql_query("select * from `language`");
												while($lang=mysql_fetch_array($userlanguage))
												{
													if(in_array($lang['id'],$languages))
													{	
												?>
													<?php $l.= $lang['name'].", "; ?>	
														<!--<input class="control" type="checkbox" name="language[]" value="<?php echo $lang[2]; ?>" checked><?php echo $lang['name']; ?> 
													<?	//}else{ ?>
														<input class="control" type="checkbox" name="language[]" value="<?php echo $lang[2]; ?>" ><?php echo $lang['name']; ?>-->
												<?	}
												}
												?>
												 <input class="form-control" type="text" name="language[]" readonly value="<?php echo $l; ?>" >
											
												
                                            <p class="help-block error"></p>
                                        </div>
										<div class="form-group">
                                            <label>Photo</label>
                                            <?
												if(strlen($userdata["photo"])>0){
												
												if($data[type] == 2){
											?>
												<img src="<? echo $userdata['photo'];?>" width="100" height="100" class="img-square" />
											<?
												}else{
											?>
												<img src="../img/<? echo $userdata['photo'];?>" width="100" height="100" class="img-square" />
											<?
												}
												}else{
											?>		
												<img src="../img/no-photo.jpg" width="100" height="100" class="img-square" />
											<?
												}
											?>
                                        </div>
										
										</div>
										<div class="col-lg-12">
											<center>
												<input type="submit" name="btn_save" class="btn btn-primary">
												<button type="reset" class="btn btn-danger" onclick="history.go(-1);">cancel</button>
											</center>
										</div>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
<?php
	}
?>

<?php
if($_REQUEST['kon'] =='seminardetails')
	{
		$seminarquery=mysql_query("select * from seminar where id='".$_REQUEST['sid']."' ");
		$data=mysql_fetch_array($seminarquery);
		$seminardataquery=mysql_query("select * from user_detail where uid='".$data[id]."' ");
		$seminardata=mysql_fetch_array($seminardataquery);
		$usercompanyquery=mysql_query("select * from user_company where uid='".$data[id]."' ");
		$companydata=mysql_fetch_array($usercompanyquery);
		
?>
	<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $data['title']; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                    <form role="form" action="seminardetails.php?sid=<?php echo $_REQUEST['sid']; ?>" method="POST" enctype="multipart/form-data">
										<div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input class="form-control" type="text" name="title" value="<?php echo $data['title']; ?>">
                                            <p class="help-block error"><?php echo $errortitle; ?></p>
                                        </div>
										<div class="form-group">
                                            <label>Description</label>
                                            <input class="form-control" type="text" name="description" value="<?php echo $data['description']; ?>">
                                            <p class="help-block error"><?php echo $errordescription; ?></p>
                                        </div>
										<div class="form-group">
                                            <label>Host Name</label>
                                            <input class="form-control" type="text" name="hostname" value="<?php echo $data['hostperson_name']; ?>">
                                            <p class="help-block"><?php echo $errorname; ?></p>
                                        </div>
										<div class="form-group">
                                            <label>Host Email</label>
                                            <input class="form-control" type="text" name="hostemail" value="<?php echo $data['contact_email']; ?>">
                                            <p class="help-block"><?php echo $erroremail; ?></p>
                                        </div>
										<!--<div class="form-group">
                                            <label>Qualification</label>
                                            <input class="form-control" type="text" name="qualification" value="<?php echo $data['qualification']; ?>">
                                            <p class="help-block"></p>
                                        </div>-->
                                        <div class="form-group">
                                            <label>Total Seat</label>
                                            <input class="form-control" type="text" name="total_seat" value="<?php echo $data['total_seat']; ?>" readonly>
                                            <p class="help-block"></p>
                                        </div>
										<div class="form-group">
                                            <label>Booked Seat</label>
                                            <input class="form-control" type="text" name="booked_seat" value="<?php echo $data['total_booked_seat']; ?>" readonly>
                                            <p class="help-block error"><?php echo $errorcontact; ?></p>
                                        </div>
										 <div class="form-group">
                                            <label>Photo</label><br>
                                            <?
												$queryimage=mysql_query("select * from `seminar_photos` where `seminar_id` = '".$data[id]."' ");
												$image=mysql_fetch_array($queryimage);
												if(strlen($image["image"])>0){
												
											?>
												<input type="file" name="upsempic" id="id_upsempic" style="display:none;" onchange="changesempic(this);">
												<label  for="id_upsempic" style="border:1px solid black;" ><img align="center" src="../img/<? echo $image['image'];?>" width="100" height="100" class="img-square" id="id_upsempicimg" /></label>
												
											<?
												}else{
											?>		
												<img src="../img/no-photo.jpg" width="100" height="100" class="img-square" />
											<?
												}
											?>
                                        </div>
										</div>
										<div class="col-lg-6">
										 <div class="form-group">
                                            <label>Country</label>
                                            <select class="form-control" name="country" id="country" class="country" onchange="seminardetails('<?php echo $_REQUEST['sid']; ?>',this.value);">
											<?php
													
														$querycounty=mysql_query("select * from  countries where id='109'");
												
												
												while($country=mysql_fetch_array($querycounty))
												{
													if($_REQUEST[cscid] == $country[id])
													{
														echo "<option value='$country[id]' selected >$country[name]</option>";
														$data['countryid']=$country[id];
														$ctd=$country1[id];
													}
													else if($country[id] == $data['countryid']){
															
														echo "<option value='$country[id]' selected  >$country[name]</option>";
														$ctd=$country[id];
													}else{
														?>
															<option value= <?php echo $country[id]; ?> ><?php echo $country[name]; ?></option>
														<?php
														
													}
												}
											?>
											</select>
                                            <p class="help-block"></p>
                                        </div>
										 <div class="form-group">
                                            <label>State</label>
                                            <select class="form-control" name="state" class="state" id="state" onchange="seminardetails('<?php echo $_REQUEST['sid']; ?>','<?php echo $_REQUEST[cscid]; ?>',this.value);" >
											<?php
												$sf=0;
												
													if($_REQUEST[cscid]!="undefined")
													{
														$querycounty1=mysql_query("select * from  states where country_id=$_REQUEST[cscid]");
													}
													else{
														$querycounty1=mysql_query("select * from  states where country_id=$ctd");
													}
													
												while($country1=mysql_fetch_array($querycounty1))
												{
													if($_REQUEST[statet]==$country1[id])
													{
														echo "<option value='$country1[id]' selected >$country1[name]</option>";
														$data[stateid]=$country1[id];
														
														$ctd=$country1[id];
													}
													else if($country1[id] == $data[stateid]){	
														echo "<option value='$country1[id]' selected >$country1[name]</option>";
														
														$ctd=$country1[id];
															
													}else{
														echo "<option value='$country1[id]'>$country1[name]</option>";
														
													
													}
													
												}
											?>
											</select>
                                            <p class="help-block"></p>
                                        </div>
										<div class="form-group">
                                            <label>City</label>
                                            <select class="form-control" name="city" >
											<?php
												$cf=0;
												if($_REQUEST[statet]!="undefined")
													{
														$querycity=mysql_query("select * from  cities where state_id = $_REQUEST[statet]");
													}
													else{
														$querycity=mysql_query("select * from  cities where state_id=$ctd");
													}
												
												while($city=mysql_fetch_array($querycity))
												{
													
													if($city['id'] == $data['cityid']){
														echo "<option value='$city[id]' selected>$city[name]</option>";
													}else{
														if($_REQUEST[cscid]!="undefined" && $cf==0)
														{
															$cf=1;
															echo "<option value='$city[id]' selected>$city[name]</option>";
														}else{
															echo "<option value='$city[id]' >$city[name]</option>";
														}
														
													}
												}
												
											?>
											</select>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input class="form-control" type="text" name="address" value="<?php echo $data['address']; ?>">
                                            <p class="help-block error"><?php echo $erroraddress; ?></p>
                                        </div>
										 <div class="form-group">
                                            <label>Tagline</label>
                                            <input class="form-control" type="text" name="tagline" value="<?php echo $data['tagline']; ?>" readonly>
                                            <p class="help-block error"></p>
                                        </div>
										<!--<div class="form-group">
                                            <label>Languages Known</label>
											<?php 
											$queryl=mysql_query("select * from user_language where uid='".$data[id]."' ");
											while($langname=mysql_fetch_array($queryl))
											{
												$languages[]=$langname['lid'];
											}
												$userlanguage=mysql_query("select * from `language`");
												while($lang=mysql_fetch_array($userlanguage))
												{
													if(in_array($lang['id'],$languages))
													{	
												?>
													<?php echo $lang['name'].", "; ?>	
														<input class="control" type="checkbox" name="language[]" value="<?php echo $lang[2]; ?>" checked><?php echo $lang['name']; ?> 
													<?	//}else{ ?>
														<input class="control" type="checkbox" name="language[]" value="<?php echo $lang[2]; ?>" ><?php echo $lang['name']; ?>
												<?	}
												}
											?>
												
                                            <p class="help-block error"></p>
                                        </div>-->
										<div class="form-group">
                                            <label>Place</label>
											<?php 
											$typequery=mysql_query("select * from `seminar_type` where `id`= $data[typeid] ");
											$type=mysql_fetch_array($typequery);
											?>
                                            <input class="form-control" type="text" name="type" value="<?php echo $type['name']; ?>" readonly>
                                            <p class="help-block error"><?php echo $errortype; ?></p>
                                        </div>
										<!--<div class="form-group">
                                            <label>Attendees</label>
											<?php 
											$purposequery=mysql_query("select * from `seminar_purpose` where `id` = $data[puposeid] ");
											$purpose=mysql_fetch_array($purposequery);
											?>
                                            <input class="form-control" type="text" name="purpose" value="<?php echo $purpose['name']; ?>" readonly>
                                            <p class="help-block error"><?php echo $errorpurpose; ?></p>
                                        </div>-->
										<div class="form-group">
                                            <label>Contact No.</label>
                                            <input class="form-control" type="text" name="contact" value="<?php echo $data['phoneno']; ?>">
                                            <p class="help-block error"><?php echo $errorcontact; ?></p>
                                        </div>
										</div>
										<div class="col-lg-12">
											<center>
												<input type="submit" name="btn_save" class="btn btn-primary">
												<button type="reset" class="btn btn-danger" onclick="history.go(-1);">cancel</button>
											</center>
										</div>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
<?php
	}
?>

<?php
 if($_REQUEST['kon'] =='seminarfacility')
	{  
?>
	<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Seminar Facility 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `seminar_facility` where seminar_id='$_REQUEST[sid]' ");
										while($data=mysql_fetch_array($query)){
											
											$detailquery = mysql_query("select * from `facility` where id='".$data['facility_id']."' ");
											$detaildata=mysql_fetch_array($detailquery);
									?>
                                        <tr class="odd gradeX">
											
                                            <td><? echo $detaildata['name']; ?></td>
                                            <td><center><? if($data['status']=='1'){
											?>
												<i class="fa fa-thumbs-o-up" title="Active" style="color:green;cursor:pointer;" onclick="facilitystatus('0','<?php echo $data['id']; ?>','<?php echo $data['seminar_id']; ?>');"></i>
											<?
											}else{
											?>
												<i class="fa fa-thumbs-o-down" onclick="facilitystatus('1','<?php echo $data['id']; ?>','<?php echo $data['seminar_id']; ?>');" title="Inactive" style="color:red;cursor:pointer;"></i>
											<? } ?>
											</center></td>
                                        </tr>
									<?
										}
									?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
<?php
	}
 if($_REQUEST['kon'] =='attendees')
	{  
?>
	<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Seminar Attendees
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `seminar_purpose` where seminar_id='$_REQUEST[sid]' ");
										while($data=mysql_fetch_array($query)){
											
											$detailquery = mysql_query("select * from `purpose` where id='".$data['attendees_id']."' ");
											$detaildata=mysql_fetch_array($detailquery);
									?>
                                        <tr class="odd gradeX">
											
                                            <td><? echo $detaildata['name']; ?></td>
                                            <td><center><? if($data['status']=='1'){
											?>
												<i class="fa fa-thumbs-o-up" title="Active" style="color:green;cursor:pointer;" onclick="attendeesstatus('0','<?php echo $data['id']; ?>','<?php echo $data['seminar_id']; ?>');"></i>
											<?
											}else{
											?>
												<i class="fa fa-thumbs-o-down" onclick="attendeesstatus('1','<?php echo $data['id']; ?>','<?php echo $data['seminar_id']; ?>');" title="Inactive" style="color:red;cursor:pointer;"></i>
											<? } ?>
											</center></td>
                                        </tr>
									<?
										}
									?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
<?php
	}
if($_REQUEST['kon'] =='industrytype')
	{  
?>
	<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Industry Type
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `seminar_industry` where seminar_id='$_REQUEST[sid]'");
										while($data=mysql_fetch_array($query)){
											
											$detailquery = mysql_query("select * from `industry` where id='".$data['industry_id']."' ");
											$detaildata=mysql_fetch_array($detailquery);
									?>
                                        <tr class="odd gradeX">
											
                                            <td><? echo $detaildata['name']; ?></td>
                                            <td><center><? if($data['status']=='1'){
											?>
												<i class="fa fa-thumbs-o-up" title="Active" style="color:green;cursor:pointer;" onclick="industrystatus('0','<?php echo $data['id']; ?>','<?php echo $data['seminar_id']; ?>');"></i>
											<?
											}else{
											?>
												<i class="fa fa-thumbs-o-down" onclick="industrystatus('1','<?php echo $data['id']; ?>','<?php echo $data['seminar_id']; ?>');" title="Inactive" style="color:red;cursor:pointer;"></i>
											<? } ?>
											</center></td>
                                        </tr>
									<?
										}
									?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
<?php
	}
	if($_REQUEST['kon']=="admin_facility_up")
	{
			if($_REQUEST[shu]=="updatedo")
			{
				mysql_query("update facility set name='$_REQUEST[textt]' where id=$_REQUEST[id]");
			
			}
			if($_REQUEST[shu]=="delete_fac")
			{
				mysql_query("delete from facility  where id=$_REQUEST[id]");
			}
		?>
		<table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
                                            <th><center>Name</center></th>
                                            <th><center>Status</center></th>
                                           
											<th><center>update</center></th>
											<th><center>Delete</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `facility` ");
										while($data=mysql_fetch_array($query)){
									?>
                                        <tr class="odd gradeX">
										<?php
												if($_REQUEST[id]==$data[id] && $_REQUEST[shu]=="update")
												{
													?>
													<td><input type="text" style="width:100%;padding:5px;" value="<? echo $data['name'];?>" id="facility_new_text"/></td>
													<?php
												}
												else
												{
													?>
													<td><? echo $data['name']; ?></td>
													<?php
												}
										?>
                                            
                                            <td><center><? if($data['status']=='1'){
											?>
												<i class="fa fa-thumbs-o-up" title="Active" style="color:green;cursor:pointer;" onclick="facilitystatus('0','<?php echo $data['id']; ?>','<?php echo $data['seminar_id']; ?>');"></i>
											<?
											}else{
											?>
												<i class="fa fa-thumbs-o-down" onclick="facilitystatus('1','<?php echo $data['id']; ?>','<?php echo $data['seminar_id']; ?>');" title="Inactive" style="color:red;cursor:pointer;"></i>
											<? } ?>
											</center></td>
											
											
											
                                            <!--<td><center><span class="fa fa-eye" title="View Details" style="cursor:pointer;" area-hidden="true" onclick="facilitydetails('<?php echo $data['id']; ?>');"></span></center></td>-->
										<?php
												if($_REQUEST[id]==$data[id] && $_REQUEST[shu]=="update")
												{
													?>
													<td><center><span class="fa fa-check" title="Update" style="cursor:pointer;color:#13353F;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','updatedo');"></span></center></td>
													<td><center><span class="" title="Cancel" style="cursor:pointer;font-weight:bolder;color:red;" area-hidden="true" onclick="adm_facility();">X</span></center></td>
													<?php
												}
												else
												{
													?>
												<td><center><span class="fa fa-upload" title="Update" style="cursor:pointer;color:green;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','update');"></span></center></td>
												<td><center><span class="fa fa-trash-o" title="Delete" style="cursor:pointer;color:red;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','delete_fac');"></span></center></td>
													<?php
												}
										?>
										</tr>
									<?
										}
									?>
                                    </tbody>
                                </table>
		<?php
	}
?>
<?php
	
	if($_REQUEST['kon']=="admin_industry_up")
	{
			if($_REQUEST[shu]=="updatedo")
			{
				mysql_query("update industry set name='$_REQUEST[textt]' where id=$_REQUEST[id]");
			
			}
			if($_REQUEST[shu]=="delete_fac")
			{
				mysql_query("delete from industry  where id=$_REQUEST[id]");
			}
?>

<table class="table table-striped table-bordered table-hover animated jello infinte" id="">
                                    <thead>
                                        <tr>
                                            <th><center>Name</center></th>
                                        
                                            
											<th><center>update</center></th>
											<th><center>Delete</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `industry` ");
										while($data=mysql_fetch_array($query)){
									?>
                                        <tr class="odd gradeX">
										<?php
												if($_REQUEST[id]==$data[id] && $_REQUEST[shu]=="update")
												{
													?>
													<td><input type="text" style="width:100%;padding:5px;" value="<? echo $data['name'];?>" id="facility_new_text"/></td>
													<?php
												}
												else
												{
													?>
													<td><? echo $data['name']; ?></td>
													<?php
												}
										?>
                                            
                                            
											
											
											
                                            
										<?php
												if($_REQUEST[id]==$data[id] && $_REQUEST[shu]=="update")
												{
													?>
													<td><center><span class="fa fa-check" title="Update" style="cursor:pointer;color:#13353F;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','updatedo');"></span></center></td>
													<td><center><span class="" title="Cancel" style="cursor:pointer;font-weight:bolder;color:red;" area-hidden="true" onclick="adm_facility();">X</span></center></td>
													<?php
												}
												else
												{
													?>
												<td><center><span class="fa fa-upload" title="Update" style="cursor:pointer;color:green;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','update');"></span></center></td>
												<td><center><span class="fa fa-trash-o" title="Delete" style="cursor:pointer;color:red;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','delete_fac');"></span></center></td>
													<?php
												}
										?>
										</tr>
									<?
										}
									?>
                                    </tbody>
                                </table>
<?php
	}
?>
<?php
	
	if($_REQUEST['kon']=="admin_language_up")
	{
			if($_REQUEST[shu]=="updatedo")
			{
				mysql_query("update language set name='$_REQUEST[textt]' where id=$_REQUEST[id]");
			
			}
			if($_REQUEST[shu]=="delete_fac")
			{
				mysql_query("delete from language  where id=$_REQUEST[id]");
			}
		?>
		<table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
                                            <th><center>Name</center></th>
                                            <th><center>Status</center></th>
                                         
											<th><center>update</center></th>
											<th><center>Delete</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `language` ");
										while($data=mysql_fetch_array($query)){
									?>
                                        <tr class="odd gradeX">
										<?php
												if($_REQUEST[id]==$data[id] && $_REQUEST[shu]=="update")
												{
													?>
													<td><input type="text" style="width:100%;padding:5px;" value="<? echo $data['name'];?>" id="facility_new_text"/></td>
													<?php
												}
												else
												{
													?>
													<td><? echo $data['name']; ?></td>
													<?php
												}
										?>
                                            
                                            <td><center><? if($data['status']=='1'){
											?>
												<i class="fa fa-thumbs-o-up" title="Active" style="color:green;cursor:pointer;" onclick="window.location='language.php?id=<?php echo $data['id'];?>&shuup=dec'"></i>
											<?
											}else{
											?>
												<i class="fa fa-thumbs-o-down" onclick="window.location='language.php?id=<?php echo $data['id'];?>&shuup=act'" title="Inactive" style="color:red;cursor:pointer;"></i> 	
											<? } ?>
											</center></td>
											
											
											
                                            
										<?php
												if($_REQUEST[id]==$data[id] && $_REQUEST[shu]=="update")
												{
													?>
													<td><center><span class="fa fa-check" title="Update" style="cursor:pointer;color:#13353F;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','updatedo');"></span></center></td>
													<td><center><span class="" title="Cancel" style="cursor:pointer;font-weight:bolder;color:red;" area-hidden="true" onclick="adm_facility();">X</span></center></td>
													<?php
												}
												else
												{
													?>
												<td><center><span class="fa fa-upload" title="Update" style="cursor:pointer;color:green;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','update');"></span></center></td>
												<td><center><span class="fa fa-trash-o" title="Delete" style="cursor:pointer;color:red;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','delete_fac');"></span></center></td>
													<?php
												}
										?>
										</tr>
									<?
										}
									?>
                                    </tbody>
                                </table>
		<?php
	}
?>
<?php
	
	if($_REQUEST['kon']=="admin_purpose_up")
	{
			
			if($_REQUEST[shu]=="delete_fac")
			{
				mysql_query("delete from purpose  where id=$_REQUEST[id]");
			}
		?>
		<form action="purpose.php" method="post" name="fileshareform"  enctype="multipart/form-data">
		<table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
										<th><center>Image</center></th>
                                            <th><center>Name</center></th>
											
                                            <th><center>Status</center></th>
                                            
											<th><center>update</center></th>
											<th><center>Delete</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `purpose` ");
										while($data=mysql_fetch_array($query)){
									?>
                                        <tr class="odd gradeX">
										<?php
												if($_REQUEST[id]==$data[id] && $_REQUEST[shu]=="update")
												{
													?>
													<td><center><input type="file" name="filesharing" id="id_upsempic1" style="display:none;" onchange="changesempic1(this);">
												<label  for="id_upsempic1" style="border:1px solid black;border-radius:100%;" align="center"><img align="center" src="../img/<?php echo $data[image]; ?>" style="border-radius:100%;" width="70" height="70" class="img-circle" id="id_upsempicimgnew" /></label></center></td>
													<td><input type="text" name="pur_txt" style="width:100%;padding:5px;" value="<? echo $data['name'];?>" id="facility_new_text"/>
													<input type="text" name="pur_id" value="<? echo $data['id'];?>" style="display:none;" id="purposeid"/>
													<input type="text" name="pur_img" value="<? echo $data['image'];?>" style="display:none;" id="purposeid"/></td>
													<?php
												}
												else
												{
													?>
													<td ><center><img src="../img/<? echo $data['image'];?>" width="50" height="50" class="img-circle" /></center></td>
													<td><? echo $data['name']; ?></td>
													<?php
												}
										?>
                                            
                                            <td><center><? if($data['status']=='1'){
											?>
												<i class="fa fa-thumbs-o-up" title="Active" style="color:green;cursor:pointer;" onclick="window.location='purpose.php?id=<?php echo $data['id'];?>&shuup=dec'"></i>
											<?
											}else{
											?>
												<i class="fa fa-thumbs-o-down" onclick="window.location='purpose.php?id=<?php echo $data['id'];?>&shuup=act'" title="Inactive" style="color:red;cursor:pointer;"></i> 	
											<? } ?>
											</center></td>
											
											
											
                                            
										<?php
												if($_REQUEST[id]==$data[id] && $_REQUEST[shu]=="update")
												{
													?>
													<td><center><span  title="Update" style="cursor:pointer;color:#13353F;" area-hidden="true" ><button name="sub_update" type="submit" class="fa fa-check btn btn-primary"></button ></span></center></td>
													<td><center><span class="btn btn-danger" title="Cancel" style="cursor:pointer;font-weight:bolder;color:white;" area-hidden="true" onclick="adm_facility();">X</span></center></td>
													<?php
												}
												else
												{
													?>
												<td><center><span class="fa fa-upload" title="Update" style="cursor:pointer;color:green;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','update');"></span></center></td>
												<td><center><span class="fa fa-trash-o" title="Delete" style="cursor:pointer;color:red;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','delete_fac');"></span></center></td>
													<?php
												}
										?>
										</tr>
									<?
										}
									?>
                                    </tbody>
                                </table>
								</form>
		<?php
	}
	if($_REQUEST['kon']=="admin_place_up")
	{
			
			if($_REQUEST[shu]=="delete_fac")
			{
				mysql_query("delete from seminar_type  where id=$_REQUEST[id]");
			}
		?>
		<form action="place.php" method="post" name="fileshareform"  enctype="multipart/form-data">
		<table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
										<th><center>Image</center></th>
                                            <th><center>Name</center></th>
											
                                            <th><center>Status</center></th>
                                            
											<th><center>update</center></th>
											<th><center>Delete</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
										$query=mysql_query("select * from `seminar_type` ");
										while($data=mysql_fetch_array($query)){
									?>
                                        <tr class="odd gradeX">
										<?php
												if($_REQUEST[id]==$data[id] && $_REQUEST[shu]=="update")
												{
													?>
													<td><center><input type="file" name="filesharing" id="id_upsempic1" style="display:none;" onchange="changesempic1(this);">
												<label  for="id_upsempic1" style="border:1px solid black;border-radius:100%;" align="center"><img align="center" src="../img/<?php echo $data[image]; ?>" style="border-radius:100%;" width="70" height="70" class="img-circle" id="id_upsempicimgnewplace" /></label></center></td>
													<td><input type="text" name="pur_txt" style="width:100%;padding:5px;" value="<? echo $data['name'];?>" id="facility_new_text"/>
													<input type="text" name="pur_id" value="<? echo $data['id'];?>" style="display:none;" id="purposeid"/>
													<input type="text" name="pur_img" value="<? echo $data['image'];?>" style="display:none;" id="purposeid"/></td>
													<?php
												}
												else
												{
													?>
													<td ><center><img src="../img/<? echo $data['image'];?>" width="50" height="50" class="img-circle" /></center></td>
													<td><? echo $data['name']; ?></td>
													<?php
												}
										?>
                                            
                                            <td><center><? if($data['status']=='1'){
											?>
												<i class="fa fa-thumbs-o-up" title="Active" style="color:green;cursor:pointer;" onclick="window.location='place.php?id=<?php echo $data['id'];?>&shuup=dec'"></i>
											<?
											}else{
											?>
												<i class="fa fa-thumbs-o-down" onclick="window.location='place.php?id=<?php echo $data['id'];?>&shuup=act'" title="Inactive" style="color:red;cursor:pointer;"></i> 	
											<? } ?>
											</center></td>
											
											
											
                                            
										<?php
												if($_REQUEST[id]==$data[id] && $_REQUEST[shu]=="update")
												{
													?>
													<td><center><span  title="Update" style="cursor:pointer;color:#13353F;" area-hidden="true" ><button name="sub_update" type="submit" class="fa fa-check btn btn-primary"></button ></span></center></td>
													<td><center><span class="btn btn-danger" title="Cancel" style="cursor:pointer;font-weight:bolder;color:white;" area-hidden="true" onclick="adm_facility();">X</span></center></td>
													<?php
												}
												else
												{
													?>
												<td><center><span class="fa fa-upload" title="Update" style="cursor:pointer;color:green;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','update');"></span></center></td>
												<td><center><span class="fa fa-trash-o" title="Delete" style="cursor:pointer;color:red;" area-hidden="true" onclick="adm_facility('<?php echo $data[id]; ?>','delete_fac');"></span></center></td>
													<?php
												}
										?>
										</tr>
									<?
										}
									?>
                                    </tbody>
                                </table>
								</form>
		<?php
	}
?>