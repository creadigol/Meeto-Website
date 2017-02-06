<?php

    if(isset($_REQUEST['ss']))
    {
        $a=count($_FILES['hh']['name']);
        //echo $a;
        for($i=0;$i<$a;$i++)
        {
            echo $_FILES['hh']['name'][$i]."<br>";
        }
    }
?>
<html>
    <?php
		require_once('head1.php');
	?>
    <script>
        function setimg(id, a)
        {
    
            if (a.files && a.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#dppic' + id).attr('src', e.target.result);
                   $("#show_pic"+id).show();
                }
                reader.readAsDataURL(a.files[0]);
            }
            
        }
        var c=0;
        function addimg()
        {
            c++;
            var setdiv = '<div id="main'+c+'">';
            setdiv += '<div id="file_in'+c+'"><input type = "file" required="" name="hh[]" onchange="setimg('+c+',this);"></div>';
            setdiv += '<div id="show_pic'+c+'" style="display:none;"><img src="" width="50" height="50" id="dppic'+c+'"><font size="5" style="cursor:pointer;" onclick=remove('+c+',"rmv_img");>&nbsp;x</font>';
            setdiv += '</div><br><button type="button" onclick=remove('+c+',"rmv_div");> remove </button>';
            setdiv += '</div>';
            
            var cc=c-1;
            $("#main"+cc).after(setdiv);
        }
        function remove(rmv,a)
        {
           if(a==="rmv_img")
           {
               $("#file_in"+rmv).children().remove();
               var str='<input type="file" name="hh[]" required="" onchange="setimg('+rmv+', this);">';
               $("#file_in"+rmv).html(str);
               $('#dppic' + rmv).attr('src','');
           }else if(a=="rmv_div"){
               $("#main"+rmv).remove();
                if(c==rmv)
                {
                    c=c-1;
                }
           }
            
        }
        $(document).ready(function(){
            $("#show_pic0").hide();
        })
    </script>
    <body>
        <form method="post" enctype="multipart/form-data">
        <div id="main0">
            <div id="file_in0">
              <input type="file" required="" onchange="setimg(0, this);" name="hh[]">
            </div>
            <div id="show_pic0"><img src="" width="50" height="50" id="dppic0">
            <font size="5" style="cursor:pointer;" onclick=remove(0,"rmv_img");>&nbsp;x</font>
            <br><button type="button" onclick="addimg();">add</button></div>
        </div>
            <br>
            <button type="submit" name="ss">send</button>
            </form>
    </body>
</html>