<div class="navbar-wrapper nevbar-position">
      <div class="container header-container">
        <nav class="navbar navbar-inverse navbar-static-top toggal-back menu-h">
          <div class="container">
            <div class="navbar-header header-nev">
				<div class="left">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand menu-h navbar-logo" href="index.php">Your LOGO</a>
				</div>
				<div class="browse menu-h" data-target="dropdown-menu" data-toggle="dropdown" >Browse<span class="caret"></span>
				</div>	
				
				  <div class="dropdown-menu sing-menu brawose-menu">
					<a class="dropdown-item f-left sing-menu" href="#">popular</a>
					<a class="dropdown-item f-left sing-menu" href="#">My Wish Lists</a>
				  </div>
				
				
				
				<div class="nav-input-box search-left">
				<input type="text" class="nav-input" placeholder="Pick Your Workspace." />
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
							<img src="img/profile.png" class="img img-responsive" style="text-align:center;border-radius:50%;width:40px;height:40px; " />
						<?php
							}
							else
							{
						?>
							<img src="img/<?php echo $_SESSION['jpmeetou']['profileimage']; ?>" class="img img-responsive" style="text-align:center;border-radius:50%;width:40px;height:40px;"/>
						<?php
							}
						?>
					</a>
					<a  class="l-height" href="#" data-target="dropdown-menu" data-toggle="dropdown" style="text-transform:capitalize; float:left !important; padding:10px 15px; color:#000 !important; background:none;">
						Hi <?php echo $_SESSION['jpmeetou']['fname']."   "; ?>   <i class="fa fa-caret-down"></i>
					</a>
					
						  <div class="dropdown-menu sing-menu">
							<a class="dropdown-item f-left sing-menu" href="view-profile.php?id=<?php echo $_SESSION['jpmeetou']['id'];?>">Dashboard</a>
							<a class="dropdown-item f-left sing-menu" href="your-listing.php">Your Listings</a>
							<a class="dropdown-item f-left sing-menu" href="your-listing.php">Your Reservation</a>
							<a class="dropdown-item f-left sing-menu" href="booking.php">Your Bookings</a>
							<a class="dropdown-item f-left sing-menu" href="my-wish-list.php">Wish List</a>
							<a class="dropdown-item f-left sing-menu" href="Editprofile.php">Edit Profile</a>
							<a class="dropdown-item f-left sing-menu" href="account.php">Account</a>
							<a class="dropdown-item f-left sing-menu" href="logout.php">Log Out</a>
						  </div>
						  
				</li>
				<li>
					<a href="inbox.php" class="header-nev" style="font-size:25px;color:#000;"><i class="fa fa-envelope"></i></a>
				</li>
                <li><a href="list_space.php" class="blue-button list-button"> List Your Seminar</a></li>
					<?php
				}
				else
				{
					?>
					 <li><a class="link-btn h-track main_signup">Sign Up</a><!-- data-toggle="modal" data-target=".bs-example-modal-sm"--></li>
                <li><a id="some-id" href="#logindiv" class="link-btn h-track main_login">Login</a><!-- data-toggle="modal" data-target=".bc-example-modal-sm"--></li>
                <li><a href="how-work.php">How It Works</a></li>
                <li><a href="list_space.php" class="blue-button"> List Your Seminar</a></li>
					<?php
				}
				?>
               
				
              </ul>
            </div>
          </div>
        </nav>

      </div>
    </div>  