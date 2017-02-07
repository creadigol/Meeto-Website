<!--<div class="top-margin-10"></div>	
	<div class="clearfix"></div>-->
<div class="container-flude top-listing-head">
    <div class="container">	
        <ul class="nav second-menu semibold-o">
            <li><a class="dashboard_menu" href="view-profile.php?id=<?php echo $_SESSION['jpmeetou']['id']; ?>">ダッシュボード</a></li>
            <li><a class="inbox_menu" href="inbox.php">受信トレイ</a></li>
            <li class="active"><a class="listing_menu" href="your-listing.php">
マイリスト</a></li>
            <li><a class="booking_menu" href="booking.php">私の予約</a></li>
            <li><a class="wishlist" href="my-wish-list.php">
マイウィッシュリスト</a></li>
            <li><a class="Editprofile_menu" href="Editprofile.php">プロフィール</a></li>
			<?php
				$fbid = mysql_fetch_array(mysql_query("select * from user where id='".$_SESSION['jpmeetou']['id']."'"));
				if($fbid['type']==2)
				{
					
				}else{
			?>
            <li><a class="account_menu" href="account.php">パスワードを変更する</a></li>
			<?php
			}
			?>

        </ul>
    </div>
</div> 

<div class="clearfix"></div>