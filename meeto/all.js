$(document).ready(function() {
	$.pageURL = $(location). attr("href");
	if(urlcheck($.pageURL))
		 $('#some-id').trigger('click');
});
function urlcheck(a)
{
	return a.includes("for=login");
}
function showlogin()
{
	location.href="index.php?for=login"
}
function showlisting(uid,did,approvalstatus)
{
	if(did=="")
	{
		$.ajax({
			url: "miss.php?kon=listseminar&uid="+uid+"&did="+did+"&status="+approvalstatus, 
			type: "POST",
			success: function(data)
			{ 
				$("#listseminar").html(data);
			}
		}); 
	}
	else
	{
		if(confirm("Are You Sure You Want To Delete  ?"))
		{
			$.ajax({
				url: "miss.php?kon=listseminar&uid="+uid+"&did="+did+"&status="+approvalstatus, 
				type: "POST",
				success: function(data)
				{ 
					$("#listseminar").html(data);
				}
			}); 

		}
	}
}
function viewlisting(sid)
{
		$.ajax({
			url: "miss.php?kon=viewlisting&sid="+sid, 
			type: "POST",
			success: function(data)
			{ 
				$("#viewlisting").html(data);
			}
		}); 
}
function seminarlisting(cityid)
{
    var startdate = document.getElementById('startdate').value;
	var enddate  =   document.getElementById('enddate').value;
	
	
	var arr = [];
     $.each($('input[name="purpose"]:checked'), function() {
       var value = $(this).val()
       arr.push(value)
       })
	   
	var industry = [];
     $.each($('input[name="industry"]:checked'), function() {
       var value = $(this).val()
       industry.push(value)
       })
	
	var semitype = [];
     $.each($('input[name="semitype"]:checked'), function() {
       var value = $(this).val()
       semitype.push(value)
       })
	
	
      
	$.ajax({
			url: "miss.php?kon=cityseminarlist&cityid="+cityid+"&startdate="+startdate+"&enddate="+enddate+"&purposeid="+arr+"&industryid="+industry+"&semitype="+semitype, 
			type: "POST",
			success: function(data)
			{ 
				$("#cityseminar").html(data);
			}
		}); 	
}
function setstate(cid)
{
	//alert(cid);
	$.ajax({

		url: "miss.php?kon=setstate&id="+cid, 
		type: "POST",
		success: function(data)
		{
			//alert(data);
			$("#allstate").html(data);
		}
	}); 
}
function setcity(cid)
{
	//alert(cid);
	$.ajax({

		url: "miss.php?kon=setcity&id="+cid, 
		type: "POST",
		success: function(data)
		{
			//alert(data);
			$("#allcity").html(data);
		}
	}); 
}
function changeimg(input)
{
	 if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#profileimg')
				.attr('src', e.target.result)
		};

		reader.readAsDataURL(input.files[0]);
	}
	$("#profileimg").show();
}
function showcontinue(s)
{
	if(s.length>0)
	{
		$('#continue').css({'pointer-events':'all'});
	}
	else
	{
		$('#continue').css({'pointer-events':'none'});
	} 
}
function checkvalid()
{
	
	if($(".semitype").is(":checked"))
	{
		$("#typevalidation").hide();
		if($(".semipurpose").is(":checked"))
		{
			$("#purposevalidation").hide();
			if($(".semipurpose1").is(":checked"))
			{
			  $("#Industry").hide();
			  /*var s = $('#seats').val();
			  if(s.length>0)
			    {*/
				$('#secondscreen').show();$('#firstscreen').show();$('#firstscreenhead').show();
				$('#Pricing').show();
				$("#continue").hide();
				$("#seatvalidation").hide();
		      /*}
			 else
			  {
				$("#seatvalidation").show();
			  } */
			}
			else
			{
				$("#Industry").show();
			}
		}
		else
		{
			$("#purposevalidation").show();
		}
	}
	else
	{
		$("#typevalidation").show();
	}
}
function semivalidation()
{ 
  
	/*
	if (document.getElementById('hostname').value==""
                 || document.getElementById('contactemail').value==""
				 ||  document.getElementById('contactno').value=="")
    {
		$("#valfalse").show();
		$("#valtrue").hide();
	}
	else
	{
		$("#valtrue").show();
		$("#valfalse").hide();
	}
	*/
	
	if (document.getElementById('semifromdate').value==""
                 || document.getElementById('semitodate').value==""
				 ||  document.getElementById('fromtime').value=="" 
				 ||  document.getElementById('totime').value=="")
    {
		$("#dayfalse").show();
		$("#daytrue").hide();
	}
	else
	{
		$("#daytrue").show();
		$("#dayfalse").hide();
	}
	
	if (document.getElementById('title').value==""
                 || document.getElementById('tagline').value==""
				 ||  document.getElementById('description').value=="")
    {
		$("#Overviewfalse").show();
		$("#Overviewtrue").hide();
	}
	else
	{
		$("#Overviewtrue").show();
		$("#Overviewfalse").hide();
	}
	
	/*
	if (document.getElementById('jsimgid0').value=="")
    {
		$("#Photosfalse").show();
		$("#Photostrue").hide();
	}
	else
	{
		$("#Photostrue").show();
		$("#Photosfalse").hide();
	}
	*/
	
	if (document.getElementById('country').value==""
                 || document.getElementById('pac-input').value==""
				 || document.getElementById('allstate').value==""
				 ||  document.getElementById('allcity').value=="" 
				 ||  document.getElementById('streetaddress').value==""
				 ||  document.getElementById('zipcode').value=="")
    {
		$("#Locationfalse").show();
		$("#Locationtrue").hide();
	}
	else
	{
		$("#Locationtrue").show();
		$("#Locationfalse").hide();
	}
    
	
}
function showwishlist(id)
{
	$.ajax({
		url: "miss.php?kon=setwishlist&id="+id, 
		type: "POST",
		success: function(data)
		{
			$("#myModal").html(data);
		}
	}); 
}
function addtowishlist(id)
{

	var note=document.getElementById('wishnotes').value;
	$.ajax({
		url: "miss.php?kon=addwishlist&id="+id+"&note="+note, 
		type: "POST",
		success: function(data)
		{
			location.href='my-wish-list.php';
		}
	}); 
}
function checkseat(available)
{
	var total=parseInt(document.getElementById('totseat').value);
	if(total > available)
	{
		$("#seatmsg").show();
		$("#booksub").hide();
	}
	else
	{
		$("#seatmsg").hide();
		$("#booksub").show();
	}
}
function seminarstatus(bookid,semistatus)
{
	$.ajax({
		url: "miss.php?kon=seminarstatus&bid="+bookid+"&status="+semistatus, 
		type: "POST",
		success: function(data)
		{
		  window.location.href="inbox.php";
		}
	}); 

}
function booked(bid)
{
 $.ajax({
		url: "miss.php?kon=booked&btid="+bid, 
		type: "POST",
		success: function(data)
		{ 
			$("#bookedtiket1").html(data);	
		}
		}); 
 
}
function review(sid)
{
	var notes=document.getElementById('givenreview').value;
	if(document.getElementById('givenreview').value=="")
	{
		
	}
	else
	{
	  document.getElementById('givenreview').value = "";
       $.ajax({
		url: "miss.php?kon=review&notes="+notes+"&sid="+sid, 
		type: "POST",
		success: function(data)
		{ 
	   $("#review").html(data);		
		}
		}); 
	}
	
 
}
 