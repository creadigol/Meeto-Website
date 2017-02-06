<?php

function translate($text)
{
	return $data = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=hi&dt=t&q=gohil");
}
$entext = "vishal ";
$data1 = explode('"',translate(str_replace(" ","+",$entext))); echo $data1[1];
print_r($data1);
?>