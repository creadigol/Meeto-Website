<?php
include('connection.php');
$img = mysql_query("select * from tablename order by id desc");
while($data = mysql_fetch_array($img)){
	?>
	<img src="http://www.spymasterpro.com/new_spyMobile/upload/<?php echo $data['item3']; ?>" height="200" width="200" />
	<?php
}
?>