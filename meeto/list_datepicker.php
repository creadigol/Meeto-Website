<!doctype html>
<html>
<head>
<style>
select{
width::80%;
border:3px solid rgb(200, 200, 207);
height:42px;
padding:5px;
border-radius:3px;
margin:5px 10px 20px 35px;
}
input[type=text]{
width:76%;
border:3px solid rgb(200, 200, 207);
height:23px;
padding:5px;
border-radius:3px;
margin:5px 10px 20px 35px;
}
input[type=submit]{
width:80%;
border:3px solid rgb(200, 200, 207);
height:42px;
padding:5px;
border-radius:3px;
margin:10px 10px 20px 35px;
border:1px solid green;
}
label{
margin-left:35px;
font-family: 'Droid Serif', serif;
}
.container{
width:960px;
margin:50px auto;
}
.main{
float:left;
width:355px;
height:350px;
box-shadow:1px 1px 12px gray;
padding-top:30px;
}
h2{
width:370px;
text-align:center;
font-family: 'Droid Serif', serif;
}
</style>

<title>jQuery Datepicker UI Example - Demo Preview</title>
<meta name="robots" content="noindex, nofollow"/>
<!------------ Including jQuery Date UI with CSS -------------->
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<!-- jQuery Code executes on Date Format option ----->
<script src="js/script.js"></script>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
<h2>jQuery Datepicker UI Example Form</h2>
<div class="main">
<form action="" method="post">
<label>Name :</label>
<input type="text" name="sname" id="Name"/>
<label>Date Of Birth :</label>
<input type="text" name="selected_date" id="datepicker"/>
<input type="text" name="selected_date" id="datepicker1"/>
<label>Select Date Format :</label>
<select id="format">
<option value="mm/dd/yy">Default - mm/dd/yyyy</option>
<option value="dd/mm/yy">dd/mm/yyyy</option>
<option value="yy-mm-dd">ISO 8601 - yyyy-mm-dd</option>
<option value="d M, y">Short - d M, y</option>
<option value="d MM, y">Medium - d MM, y</option>
<option value="DD, d MM, yy">Full - DD, d MM, yyyy</option>
<option value="&apos;day&apos; d &apos;of&apos; MM &apos;in the year&apos; yy">With text - 'day' d 'of' MM 'in the year' yyyy</option>
</select>
<input type="submit" id="submit" value="Submit">
</form>
</div>
</div>
</body>
</html>