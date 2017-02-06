<?

$ipAddress=$_SERVER['REMOTE_ADDR'];
echo $_SERVER['REMOTE_ADDR'];
$macAddr=false;

#run the external command, break output into lines
echo $arp=`arp -a $ipAddress`;
$lines=explode("\n", $arp);

#look for the output line describing our IP address
foreach($lines as $line)
{
   $cols=preg_split('/\s+/', trim($line));
   if ($cols[0]==$ipAddress)
   {
       echo $macAddr=$cols[1];
   }
}
?>