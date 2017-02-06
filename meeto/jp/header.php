<div class="navbar-wrapper nevbar-position">
      <div class="container header-container">
        <nav class="navbar navbar-inverse navbar-static-top toggal-back menu-h">
          <div class="container">
            <div class="navbar-header header-nev">
				<div class="left">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">
トグルナビゲーション</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand menu-h navbar-logo" href="index.php">
あなたのロゴ</a>
				</div>
				<div class="browse menu-h" data-target="dropdown-menu" data-toggle="dropdown" >
ブラウズ<span class="caret"></span>
				</div>	
				
				  <div class="dropdown-menu sing-menu brawose-menu">
					<a class="dropdown-item f-left sing-menu" href="#">
人気のあります</a>
					<a class="dropdown-item f-left sing-menu" href="#">
私のほしい物リスト</a>
				  </div>
				
				
				
				<div class="nav-input-box search-left">
				<input type="text" class="nav-input" placeholder="
あなたのワークスペースを選択してください。" />
				</div>
				
            </div>
			
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav text-center font-menu">
				<?php
				if(isset($_SESSION['jpmeetou']['id']))
				{
				?>
                <li>
					<a style="float:left; padding:10px 15px; background:none;">
						<?php
						$img="img/".$_SESSION['jpmeetou']['profileimage'];
							if($_SESSION['jpmeetou']['type']==2)
							{ 
							?>
							<img src="<?php echo $_SESSION['jpmeetou']['user_picture'] ?>" class="img img-responsive" style="text-align:center;border-radius:50%;width:40px;height:40px;"/>
       						<?php
							}
							elseif($_SESSION['jpmeetou']['profileimage']=="" || !file_exists($img))
							{
						?>
							<img src="../img/profile.png" class="img img-responsive" style="text-align:center;border-radius:50%;width:40px;height:40px; " />
						<?php
							}
							else
							{
						?>
							<img src="../img/<?php echo $_SESSION['jpmeetou']['profileimage']; ?>" class="img img-responsive" style="text-align:center;border-radius:50%;width:40px;height:40px;"/>
						<?php
							}
						?>
					</a>
					<a  class="l-height" href="#" data-target="dropdown-menu" data-toggle="dropdown" style="text-transform:capitalize; float:left !important; padding:10px 15px; color:#000 !important; background:none;">
						こんにちは <?php $marutra = explode('"',translate(str_replace(" ","+",$_SESSION['jpmeetou']['fname']))); echo $marutra[1]."   "; ?>   <i class="fa fa-caret-down"></i>
					</a>
					
						  <div class="dropdown-menu sing-menu">
							<a class="dropdown-item f-left sing-menu" href="view-profile.php?id=<?php echo $_SESSION['jpmeetou']['id'];?>">
ダッシュボード</a>
							<a class="dropdown-item f-left sing-menu" href="your-listing.php">
あなたの掲載</a>
							<a class="dropdown-item f-left sing-menu" href="your-listing.php">
ご予約</a>
							<a class="dropdown-item f-left sing-menu" href="booking.php">
ご予約</a>
							<a class="dropdown-item f-left sing-menu" href="my-wish-list.php">
欲しい物のリスト</a>
							<a class="dropdown-item f-left sing-menu" href="Editprofile.php">
プロファイル編集</a>
							<a class="dropdown-item f-left sing-menu" href="account.php">アカウント</a>
							<a class="dropdown-item f-left sing-menu" href="logout.php">
ログアウト</a>
						  </div>
						  
				</li>
				<li>
					<a href="inbox.php" class="header-nev" style="font-size:25px;color:#000;"><i class="fa fa-envelope"></i></a>
				</li>
                <li><a href="list_space.php" class="blue-button list-button"> 
あなたのスペースを一覧表示</a></li>
					<?php
				}
				else
				{
					?>
					 <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm">
サインアップ</a></li>
                <li><a id="some-id" href="#logindiv" data-toggle="modal" data-target=".bc-example-modal-sm">ログイン</a></li>
                <li><a href="how-work.php">
使い方</a></li>
                <li><a href="list_space.php" class="blue-button"> あなたのスペースを一覧表示</a></li>
					<?php
				}
				?>
               
				
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>  