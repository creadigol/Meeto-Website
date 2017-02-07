
<script>
function hideselect()
{
	$("body.city-select-on").css("overflow","auto");
		$(".city-select").css("position","absolute");
		$(".city-select").css("top","-315px");
		$("body").removeClass("city-select-on");
		$("header .header-group.header-main").css("top","0px");
		$(".city-toggle").css("top","335px");
	
}
$(document).ready(function(e) {
	
    $(".close-city-selection,.city-link,.displaycitylist").click(function(){
		//$("body.city-select-on .city-select-overlay").css("display","none");
		//$(".city-select").css("display","none");
		//$("body.city-select-on .city-toggle:before").css("display","none");
		$("body.city-select-on").css("overflow","auto");
		$(".city-select").css("position","absolute");
		$(".city-select").css("top","-315px");
		$("body").removeClass("city-select-on");
		//$("header .header-group").css("top","335px");
		$("header .header-group.header-main").css("top","0px");
		$(".city-toggle").css("top","335px");
	});
	
	$(".city-toggle").click(function(){
		$("body").addClass("city-select-on");
		$("body.city-select-on").css("overflow","hidden");
		$(".city-select").css("position","relative");
		$(".city-select").css("top","0");
		$("header .header-group").css("top","0");
		$(".city-toggle").css("top","0");
	});
	$(".Select-placeholder").click(function(){
		$(".search-city-container .is-searchable").addClass("is-focused");
		$(".search-city-container .is-searchable").addClass("is-open");
	});
});
</script>
<?php
$seluserdetail=mysql_query("select * from user_detail where uid='".$_SESSION['jpmeetou']['id']."'");
$fetuserdetail=mysql_fetch_array($seluserdetail);
$fetuser=mysql_fetch_array(mysql_query("select * from user where id='".$_SESSION['jpmeetou']['id']."'"));
$_SESSION['jpmeetou']['profileimage']=$fetuserdetail['photo'];
$_SESSION['jpmeetou']['fname']=$fetuser['fname'];
?>

<!--<script async="" src="https://sb.scorecardresearch.com/beacon.js"></script>
<script type="text/javascript" async="" src="https://housing-rm.housingcdn.com/tmgr/main.min.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="backbone/requirejs/css" src="https://assets-0.housingcdn.com/website/javascripts/backbone/requirejs/css-0306cb5fc4bb215d1abed50eebaf2abf.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="shared/react/containers/SearchOverlay/SearchOverlay" src="https://assets-0.housingcdn.com/website/javascripts/shared/react/containers/SearchOverlay/SearchOverlay-05fea460356c860fb5161a6feb9c82a8.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="shared/react/containers/homePage/homePage" src="https://assets-0.housingcdn.com/website/javascripts/shared/react/containers/homePage/homePage-731d46ee7dee99fe5ec59816540c7947.js"></script>-->
<!-------------------------------Script End------------------------->
<title>Meeto</title>
</head>

<style>
header {transform: translate3d(0,0px,0); height:84px;}
</style>


<body class="buy-service-home-page home-page locality-selection-page city-select-on" data-device-type='' onLoad="hideselect();">
	<div id="header">
    	<header class="" data-reactroot="" data-react-checksum="2097816972" >
            
            <div class="header-group header-main">
                <div class="header-item header-logo">
                	<a class="housing-logo" title="Real Estate | Buy/Sell Propety | Housing.com" href="index.php" style="margin-top:5px;"></a>
                </div>
            </div>
			
            <div class="header-group header-right pull-right" style="margin-top:15px;">
					<?php
						if(isset($_SESSION['jpmeetou']['id']))
						{
                    ?>
                <div class="header-item app-btn-elem">
				
					<a style="float:left;margin-right:15px; background:none;margin-top:4px;" class="how-work">
							<?php
                                $img="../img/".$_SESSION['jpmeetou']['profileimage'];
                                if($_SESSION['jpmeetou']['type']==2)
                                { 
                            ?>
					      	<a href="view-profile.php?id=<?php echo $_SESSION['jpmeetou']['id']; ?>"><img src="<?php echo $_SESSION['jpmeetou']['user_picture'];?>" class="img img-responsive menu-img-name" style="text-align:center;border-radius:50%;width:40px;height:40px;"/></a>
							<?php
                                }
                                elseif($_SESSION['jpmeetou']['profileimage']=="" || !file_exists($img))
                                {
                            ?>
						<a href="view-profile.php?id=<?php echo $_SESSION['jpmeetou']['id']; ?>"><img src="../img/profile.png" class="img img-responsive menu-img-name" style="text-align:center;border-radius:50%;width:40px;height:40px; " /></a>
							<?php
                                }
                                else
                                {
                            ?>
				        <a href="view-profile.php?id=<?php echo $_SESSION['jpmeetou']['id']; ?>"><img src="../img/<?php echo $_SESSION['jpmeetou']['profileimage']; ?>" class="img img-responsive menu-img-name" style="text-align:center;border-radius:50%;width:40px;height:40px;"/></a>
							<?php
                                }
                            ?>
					</a>
					<a  class="l-height user-size" href="#" data-target="dropdown-menu" data-toggle="dropdown" style="text-transform:capitalize; float:left !important; color:#fff !important; background:none;margin-right:15px;line-height:44px;">
						
こんにちは <?php $marutra = explode('"',translate(str_replace(" ","+",$_SESSION['jpmeetou']['fname']))); echo $marutra[1]."   "; ?>   <i class="fa fa-caret-down"></i>
					</a>
					
                    <div class="dropdown-menu sing-menu">
                        <a class="dropdown-item f-left sing-menu" href="view-profile.php?id=<?php echo $_SESSION['jpmeetou']['id'];?>">ダッシュボード</a>
                        <a class="dropdown-item f-left sing-menu" href="your-listing.php">あなたの掲載</a>
                       <!-- <a class="dropdown-item f-left sing-menu" href="your-listing.php">Your Reservation</a>-->
                        <a class="dropdown-item f-left sing-menu" href="booking.php">
私の予約</a>
                        <a class="dropdown-item f-left sing-menu" href="my-wish-list.php">
欲しい物のリスト</a>
                        <a class="dropdown-item f-left sing-menu" href="Editprofile.php">
プロファイル編集</a>
                        <a class="dropdown-item f-left sing-menu" href="account.php">
アカウント</a>
                        <a class="dropdown-item f-left sing-menu" href="logout.php">ログアウト</a>
                    </div>
				</div>
				<div class="header-item app-btn-elem how-work">
					<a href="inbox.php" class="header-nev" style="font-size:23px;color:#fff;"><i class="fa fa-envelope" style="line-height:44px;"></i></a>
				</div>
				
				<div class="header-item dropdown shortlist-content header-item-shortlist">
					<a href="my-wish-list.php">
					<!--<div class="dropdown-toggle" data-toggle="dropdown">-->
                    	 <i class="icon-shortlist-circle shortlist"></i>
                    <!--</div>-->
					</a>
                	<div class="shortlist-dropdown-container"></div>
                </div>
				
					<?php
                        }
                        else
                        { 
                    ?>
                <div class="header-item app-btn-elem">
                    <a href="#" class="link-btn h-track" data-toggle="modal" data-target=".bs-example-modal-sm">
サインアップ</a>
                </div>
            	
            	<div class="header-item header-item-blog">
                    <a id="some-id" class="link-btn h-track" href="#logindiv" data-toggle="modal" data-target=".bc-example-modal-sm">
ログイン</a>
                </div>
                
            	<!--<div class="header-item dropdown shortlist-content header-item-shortlist">
                    <div class="dropdown-toggle" data-toggle="dropdown">
                    	<i class="icon-shortlist-circle shortlist "></i>
                    </div>
                	<div class="shortlist-dropdown-container"></div>
                </div>-->
                
                <div class="header-item login-content dropdown"></div>
                <div class="header-item login-btn disabled how-work">
                    <a class="link-btn" href="how-work.php">使い方</a>
                </div>
				  <?php 
                     } 
                  ?>
                <div class="header-item btn-display" style="margin-top:15px;">
                    <a href="list_space.php" class="blue-button">あなたのセミナーを一覧表示する</a>
                </div>
             
            </div>
           
            <div class="city-toggle up-menu btn-display">
                <!-- react-text: 46 -->日本<!-- /react-text -->
                <i class="icon-arrow-down"></i>
            </div>
            <div class="header-item header-nearby-filter"></div>
            <div class="header-search">
            	<div class="tag-container header-search-input"></div>
            	<i class="icon-search"></i>
            </div>
        </header>
				<div class="header-item roundbtn-display" style="margin-top:15px;">
                    <a href="list_space.php" class="blue-button">あなたのセミナーを一覧表示する</a>
                </div>		
    </div>
</body>
</html>