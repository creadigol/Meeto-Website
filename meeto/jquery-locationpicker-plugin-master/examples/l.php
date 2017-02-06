<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Bootstrap stuff -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
   
    <!-- -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Location picker -->
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
    <script src="../dist/locationpicker.jquery.min.js"></script>
    <title>Location</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
   <form role="form" method="get" enctype="multipart/form-data">
<div class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-1 control-label">Location:</label>

                <div class="col-sm-5"><input type="text" class="form-control" id="us2-address"/></div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label">Radius:</label>

                <div class="col-sm-2"><input type="text" class="form-control" id="us2-radius"/></div>
            </div>
            <div id="us2" style="width: 550px; height: 400px;"></div>
            <div class="clearfix">&nbsp;</div>
            <div class="m-t-small">
                <label class="p-r-small col-sm-1 control-label">Lat.:</label>

                <div class="col-sm-1"><input type="text" class="form-control" name="lat" style="width: 110px" id="us2-lat"/></div>
                <label class="p-r-small col-sm-1 control-label">Long.:</label>

                <div class="col-sm-1"><input type="text" class="form-control" name="long"  style="width: 110px" id="us2-lon"/></div>
                 <label class="p-r-small col-sm-1 control-label"> <a href="../../addplace.php?lat='".$_GET['lat']."'&long=long">Back</a>.:</label>
            </div>
            <div class="clearfix"></div>
        </div></form>
        <script>$('#us2').locationpicker({
            location: {latitude: 46.15242437752303, longitude: 2.7470703125},
            radius: 300,
            inputBinding: {
                latitudeInput: $('#us2-lat'),
                longitudeInput: $('#us2-lon'),
                radiusInput: $('#us2-radius'),
                locationNameInput: $('#us2-address')
            },
            enableAutocomplete: true
        });</script>
        
        </html>