<?php
//打印消息到log.txt
function Logs($txt){
	$myfile = fopen("log.txt", "a+") or die('退出');
	$txt = $txt."\r\n";
	fwrite($myfile, $txt);
	fclose($myfile);
}
?>