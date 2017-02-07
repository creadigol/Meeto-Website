<nav class="navbar navbar-default top-navbar" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
			<span class="sr-only">トグルナビゲーション</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="index.php">Meeto</a>
	</div>

	<ul class="nav navbar-top-links navbar-right">
		<!-- /.dropdown -->
		<li>
						
				 <a href="../../admin/index.php" style="color:white;font-size:15px;"> ☻ English</a>

		</li>
		<li>
						
				 <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> ログアウト</a>

		</li>
		
		<!-- /.dropdown -->
	</ul>
</nav>


<!--/. NAV TOP  -->
<nav class="navbar-default navbar-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="main-menu">

			<li>
				<a class="<? if($pos = strpos($_SERVER['REQUEST_URI'], "index.php")) echo "active-menu" ?>" href="index.php"><i class="fa fa-dashboard"></i> 
ダッシュボード</a>
			</li>
			
			<li>
				<a class="<? if($pos = strpos($_SERVER['REQUEST_URI'], "user.php") or $pos = strpos($_SERVER['REQUEST_URI'], "user_detail.php")) echo "active-menu" ?>" href="user.php"><i class="fa fa-user"></i> 
ユーザー </a>
			</li>
			<li>
				<a class="<? if($pos = strpos($_SERVER['REQUEST_URI'], "seminar.php") or $pos = strpos($_SERVER['REQUEST_URI'], "seminardetails.php")) echo "active-menu" ?>" href="seminar.php"><i class="fa fa-tags"></i> セミナー </a>
			</li>
			<li>
				<a class="<? if($pos = strpos($_SERVER['REQUEST_URI'], "facility.php")) echo "active-menu" ?>" href="facility.php"><i class="fa fa-tags"></i> 
施設 </a>
			</li>
			<li>
				<a class="<? if($pos = strpos($_SERVER['REQUEST_URI'], "industry.php")) echo "active-menu" ?>" href="industry.php"><i class="fa fa-tags"></i> 産業 </a>
			</li>
			<li>
				<a class="<? if($pos = strpos($_SERVER['REQUEST_URI'], "language.php")) echo "active-menu" ?>" href="language.php"><i class="fa fa-tags"></i> 言語 </a>
			</li>
			<li>
				<a class="<? if($pos = strpos($_SERVER['REQUEST_URI'], "purpose.php")) echo "active-menu" ?>" href="purpose.php"><i class="fa fa-tags"></i> 出席者 </a>
			</li>
			<li>
				<a class="<? if($pos = strpos($_SERVER['REQUEST_URI'], "review.php")) echo "active-menu" ?>" href="review.php"><i class="fa fa-tags"></i> 
レビュー </a>
			</li>
				<li>
				<a class="<? if($pos = strpos($_SERVER['REQUEST_URI'], "place.php")) echo "active-menu" ?>" href="place.php"><i class="fa fa-tags"></i> 
場所 </a>
			</li>
			<li>
				<a class="<? if($pos = strpos($_SERVER['REQUEST_URI'], "popularcity.php")) echo "active-menu" ?>" href="popularcity.php"><i class="fa fa-tags"></i>人気の都市</a>
			</li><li>
				<a class="<? if($pos = strpos($_SERVER['REQUEST_URI'], "add_slider.php")) echo "active-menu" ?>" href="add_slider.php"><i class="fa fa-tags"></i> スライダー </a>
			</li>
		</ul>

	</div>

</nav>
<!-- /. NAV SIDE  -->