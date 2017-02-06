<?php 
	include('gcm.php');
				 ?>
<?php 
if(isset($_POST['submit']))
{
	// Payload data you want to send to Android device(s)
	// (it will be accessible via intent extras)    
	$data = array(
		'title'		=> 'HR Managment',
		'isBackground' 	=> 'false',
		'flag'		=> '1',
		'data'	=> '{
					  "chat_room_id": 1,
					  "messages": {
						"message_id": 27,
						"message": "Hi",
						"created_at": "2016-06-21 23:43:22"
					  },
					  "user": {
						"user_id": 6,
						"name": "zahid",
						"email": "zahid@gmail.com",
						"gcm_registration_id": "cbl9H6aMk78:APA91bGNPiWGMhhnqWKDbjqPpBy_b1LvPOkfKWhhlr3GoXpk_z0pA_HLka-FlaUkJkQZtKUbzTTRfE2cnYkBQfh0F305q_mSFTwg073-qvmgsfZnaBv-7VCuYv7qekQ9dnJ-6V50vY6Q",
						"created_at": "2016-06-20 22:22:08"
					  }
					}'
	);

	// The recipient registration tokens for this notification
	// https://developer.android.com/google/gcm/   
	
	$ids = array($_POST['gcmid']);
		

	// Send push notification via Google Cloud Messaging
	sendPushNotification($data, $ids);
}
?>

<form action="" method="post">
  <table>
    <tr>
      <td>GCMID</td>
      <td><input type="text" name="gcmid" size="100"/></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="submit" value="submit" /></td>
    </tr>
  </table>
</form>
</body></html>