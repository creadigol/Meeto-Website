<?php    
 require_once('db.php'); 
        require_once('condition.php');
?>

<!DOCTYPE html><html lang="en">  
<?php	require_once('head.php');  ?>
<!-- NAVBAR================================================== --> 
 
<script>
  function wishlist(did)
  {
	  if(did=="")
	  {
		  $.ajax({
		  url: "miss.php?kon=wishlist&did="+did,		 
		  type: "POST",
		  success: function(data)
		  {
			   $("#wishlist").html(data);
		  } 
		  });
	  }
	  else
	  {
	    if(confirm("Are you sure you want to delete ?"))
		{
		    $.ajax({
			  url: "miss.php?kon=wishlist&did="+did,		 
			  type: "POST",
			  success: function(data)
			  {
				   $("#wishlist").html(data);
			  } 
			});
		}
	  }
  }
</script>
<body onload="wishlist('');">     
  <?php	
    require_once('header.php');   
  ?>
  <?php	require_once('usermenu.php');   ?>
<!-- pop up start -->		
	<!-- Sing in modal -->		
		<?php				
		  require_once('loginsignup.php'); 		
		?>		
		<!-- pop up end-->

<div class="container-flude full-container">
	<div class="container">	
	    <div id="wishlist">
		</div>
	</div>
</div> 

<!-- footer -->	<?php    require_once('footer.php');	?>
	
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
</html>




    
