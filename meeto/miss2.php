<?php
require_once('db.php'); 
 if($_REQUEST['kon']=="seachcity")
 {?>

	 <ul class="city-submit">
	  <?php
	  $name=$_REQUEST['city'];  
      $cities=mysql_query("select * from cities where name like '%$name%'  and id in (select cityid from seminar)");  
	  
      $citiesjp=mysql_query("select * from cities where jp_name like '%$name%'  and id in (select cityid from seminar)"); 
	  
	  if(mysql_num_rows($cities)>0)
	  {
		 while($city = mysql_fetch_array($cities))
	     {
	    ?>
		<a href="seminarlist.php?id=<?php echo $city['id']; ?>">
		   <li onClick="$('#citysuggetion').hide();"><?php echo $city['jp_name']." ".$city['name']; ?></li>
	    </a>
        <?php
	     } 
	  }
	  else if(mysql_num_rows($citiesjp)>0)
	  {
		  while($city = mysql_fetch_array($citiesjp))
	     {
	    ?>
		<a href="seminarlist.php?id=<?php echo $city['id']; ?>">
		   <li onClick="$('#citysuggetion').hide();"><?php echo $city['jp_name']." ".$city['name']; ?></li>
	    </a>
        <?php
	     } 
	  }
	  else
	  { ?>  
        <a>
		   <li>Cities Not Found</li>
	    </a>
	 <?
	 }
	 ?> 
	  
      
    </ul>
<?php
 }
 if($_REQUEST['kon']=="cityname")
 {
	$name=$_REQUEST['city'];
    $cities12=mysql_query("select id from cities where name='".$name."' and  id in (select cityid from seminar)");
	$jpcities12=mysql_query("select id from cities where jp_name='".$name."' and  id in (select cityid from seminar)");
	
	 if(mysql_num_rows($cities12)>0)
	 {
		 $cities=mysql_fetch_array($cities12);
	 	  if($cities)
	      {
	      echo "<script>window.location.href='seminarlist.php?id=$cities[id]'</script>";
	      }
	      else
	      {
	      ?>  
	     <ul class="city-submit">
          <a>
		  <li>Cities Not Found</li>
	      </a>
	    </ul>
	     <?
	      } 
	 }
	 elseif(mysql_num_rows($jpcities12)>0)
	 {
		 $cities1=mysql_fetch_array($jpcities12);
	 	  if($cities1)
	      {
	       echo "<script>window.location.href='seminarlist.php?id=$cities1[id]'</script>";
	      }
	      else
	      {
	      ?>  
	     <ul class="city-submit">
           <a>
		    <li>Cities Not Found</li>
	       </a>
	    </ul>
	     <?
	      }  
	 }
 }
 ?>