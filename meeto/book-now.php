<?php 

require_once('db.php'); 

require_once('condition.php');

   $micro = round(microtime(true) * 1000);

if(isset($_REQUEST['subbtn'])) 
{	
$iddd=$_SESSION['jpmeetou']['id'];
        $fromday = $_REQUEST['fromdate'];
	    $from_day =strtotime($fromday) * 1000;
        $today = $_REQUEST['todate'];
	    $to_day =strtotime($today) * 1000;

$inbooking=mysql_query("insert into seminar_booking (seminar_id,uid,booking_no,book_seat,from_date,to_date,approval_status,created_date,modified_date,message) values ($_REQUEST[id],$iddd,'$_REQUEST[bookingno]','$_REQUEST[totalseats]','".$from_day."','".$to_day."','pending','$micro','$micro','$_REQUEST[message]')");
$bookid=mysql_insert_id();
	
$fetseminar=mysql_fetch_array(mysql_query("select * from seminar where id=$_REQUEST[id]"));

$totalseats=$_REQUEST['totalseats'] + $fetseminar['total_booked_seat'];
$upsemi=mysql_query("update seminar set total_booked_seat=$totalseats where id=$_REQUEST[id]");

$ticketdetail=mysql_fetch_array(mysql_query("select * from seminar_booking where id=$bookid"));
$userdetail=mysql_fetch_array(mysql_query("select * from user where id=$iddd"));
$hostuser=mysql_fetch_array(mysql_query("select * from user where id='".$fetseminar['uid']."'"));

            $email= $hostuser['email'];
            $to = $email;
			$subject = "Seminar Ticket Booked";
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: <creadigol.in@gmail.com>' . "\r\n";
			
			$message  = '<html>';	
			$message .= '<body>';
			$message .= '<h2>User Information Of Book Your Seminar</h2>';
			$message .= '<table>';
			$message .= '<tr>';
			$message .= '<td>Seminar Title : '.$fetseminar['title'].'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td>User name : '.$userdetail['fname'].' '.$userdetail['lname'].'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td> Total Booked Seats: '.$ticketdetail['book_seat'].'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td> From date : '.date("Y-m-d",$ticketdetail['from_date']/1000).'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td> To date : '.date("Y-m-d",$ticketdetail['to_date']/1000).'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td> Booking No : '.$ticketdetail['booking_no'].'</td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td> Message : '.$ticketdetail['message'].'</td>';
			$message .= '</tr>';
			$message .= '</table>';
			$message .= '</div>';
			$message .= '</body>';
			$message .= '</html>';
			
			$sentmail = mail($to,$subject,$message,$headers);
			/* if($sentmail)
			{
			echo "<script>alert('send mail');</script>";	
			}
			else
			{
			echo "<script>alert('not send mail');</script>";			
			} */

echo "<script>location.href='booking.php'</script>";



}	 

$row = mysql_fetch_array(mysql_query("select * from user where id = '".$_SESSION['jpmeetou']['id']."'")); 

$rowuserdetail= mysql_fetch_array(mysql_query("select * from user_detail where uid = '".$_SESSION['jpmeetou']['id']."'")); 

$rowusercompany=mysql_fetch_array(mysql_query("select * from user_company where uid = '".$_SESSION['jpmeetou']['id']."'")); 

$selseminar=mysql_query("select * from seminar where id=$_REQUEST[id]");$fetseminar=mysql_fetch_array($selseminar);$selsemiphoto=mysql_query("select * from seminar_photos where seminar_id=$_REQUEST[id] limit 0,1");
$fetsemiphoto=mysql_fetch_array($selsemiphoto);$selsemitype= mysql_fetch_array(mysql_query("select * from seminar_type where id=$fetseminar[typeid]"));
//$selsemipurpose= mysql_fetch_array(mysql_query("select * from purpose where id=$fetseminar[puposeid]"));

?>

<!DOCTYPE html>

<html lang="en">  

<?php	require_once('head1.php'); ?>

	<!-- NAVBAR================================================== -->

<script>
$(window).scroll(function () {
		var sc = $(window).scrollTop()
		var divheight = $("#left_section").height();
		var footerheight = $("#footer").height();
		var footerheight = footerheight+15;
		//alert(divheight);
		if (sc > 195) {
			//alert("top"+sc);
			$(".map_div").removeClass("bottom_fix");
			$(".map_div").removeAttr("style");
			$(".map_div").addClass("fixed_map");
		} else {
			//alert(sc);
			$(".map_div").removeClass("fixed_map");
			$(".map_div").removeClass("bottom_fix");
			$(".map_div").removeAttr("style");
		}
		
		if(sc > divheight-425){
			//alert("bottom"+sc);
			$(".map_div").removeClass("fixed_map");
			$(".map_div").addClass("bottom_fix");
			$(".map_div").css("bottom",footerheight+"px");
		}
	});
</script>
<body class="city-select-on" onload="hideselect();" style="width:100%; position:absolute;">   

<?php	require_once('header1.php');   ?>

	<!-- pop up start -->

    <div class="container-flude full-container container-background">	
        <div class="container">
        <div class="top-margin-20">&nbsp;</div>						
        <div class="row">
            <form method="post" action="" enctype="multipart/form-data">				
                <div class="col-md-8 col-md-offset-2 Location-row">	
                    <div class="row hedding-row row-border">				
                        <div class="col-md-12 now-booking-head booking-option">
                            <span class="semibold-o">1. Overview of your Booking</span>
					
                            <a href="infomation.php?id=<?php echo $_REQUEST['id']; ?>" class="r-left text-right blue-button back-button">Back to offer</a>
						 <div class="clearfix"></div>	
                        </div>
                        
                        <div class="row your-booking">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="row">
                                        <img src="img/<?php echo $fetsemiphoto['image']; ?>" class="img-responsive slider-width center-block booking-icon">
                                    </div>
                                </div>	
                                <div class="col-md-6 review">
                                    <h4 class="semibold-o headding-boredr"><?php echo $fetseminar['title']; ?></h4>
                                    <ul class="nav checkin-details-left cheks-status">
                                        <li>
                                            <label>From Date :</label><input type="text" name="fromdate" hidden value="<?php echo $_REQUEST['fromdate']; ?>" />
                                            <span><?php echo $_REQUEST['fromdate']; ?></span>
                                        </li>
                                        <li>
                                            <label>To Date :</label><input type="text" name="todate" hidden value="<?php echo $_REQUEST['todate']; ?>" />											
                                            <span><?php echo $_REQUEST['todate']; ?></span>
                                        </li>
                                        <li>
                                            <label>Total Seats :</label><input type="text" name="totalseats" hidden value="<?php echo $_REQUEST['totalseats']; ?>" />
                                            <span><?php echo $_REQUEST['totalseats']; ?></span>
                                        </li>
                                    </ul>
                                    <ul class="nav checkin-details-left cheks-status">
                                        <li>
                                            <label>Place:</label>
                                            <span> <?php echo $selsemitype['name']; ?></span>
                                        </li>
                                       <!-- <li>
                                            <label>Purpose :</label>
                                            <span><?php// echo $selsemipurpose['name']; ?></span>
                                        </li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>	
                        <div class="clearfix"></div>
                    </div>
                <div class="top-margin-30">&nbsp;</div>						
                    <div class="row hedding-row row-border">				
                        <div class="col-md-12 now-booking-head booking-option">
                            <span class="semibold-o">2. Personal Information</span>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row your-booking">
                            <div class="col-md-12">
                                <div class="col-md-12 review Personal-Info">
                                        <ul class="nav login-list-cont reservation">
                                            <li>
                                                <span>Booking No</span>												
                                                <?php 
                                                    $char1=chr(rand(65,90));
                                                    $char2=chr(rand(65,90));
                                                    $no=rand(0000000,9999999);
                                                    $uniq=$char1.$char2.$no	
                                                ?>
                                                <input type="text" readonly name="bookingno" value="<?php echo $uniq; ?>" />
                                            </li>
                                            <li>
                                                <span>Message</span>
                                                <textarea name="message" id="message" value="" style="width:300px;" placeholder="Message your host.." rows="5"></textarea>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <div class="clearfix"></div>
                    <div class="top-margin-20">&nbsp;</div>
                        <div class="row text-center">
                            <div class="col-md-4 col-md-offset-4">								
                            <?php 								?>
        
                                <button type="submit" name="subbtn" class="blue-button center-block book-now-button">Book Now</button>
                            </div>	
                        </div>
                </div>			
            </form>				
        </div>
        </div>
        <div class="top-margin-10">&nbsp;</div>
    </div>
<?php require_once('footer1.php'); ?>

<!-- footer END-->

    <!-- Bootstrap core JavaScript

    ================================================== -->

    <!-- Placed at the end of the document so the pages load faster -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
</body>