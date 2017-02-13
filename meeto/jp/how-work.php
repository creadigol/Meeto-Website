<?php   require_once('db.php'); ?>
<!DOCTYPE html><html lang="en">  
<?php	require_once('head1.php');   ?>
<!-- NAVBAR================================================== --> 
 <body>      
 <?php	require_once('header1.php');   ?>
 <!-- pop up start -->		
 <!-- Sing in modal -->		
 <?php			
 require_once('loginsignup.php'); 	
 ?>				 <!-- pop up end-->
 <!-- img -->
	<div class="container content_text">
			
				<h1><?php echo HOW_IT_WORK;?></h1>
					
				<img src="img/how-work.jpg" class="img-responsive center-block" />
				<div class="bottom-margin-20">&nbsp;</div>
	</div>
 <!-- img END -->
	
<!-- footer -->	
	<?php    
	require_once('footer1.php');
	?>	
	<!-- footer END -->	
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
</html>
