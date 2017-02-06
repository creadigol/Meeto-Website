<?php
function translate($text)
{
		 
return $data = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=ja&dt=t&q=hi");
}
$entext = "hi";
$data = explode('"',translate(str_replace(" ","+",$entext))); echo $data[1];

?>