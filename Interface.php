<?php
require_once('compute.php');

if(isset($_GET["id_all"])){
	if(strlen($_GET['id_all'])==8)
	{
		echo check_number_all($_GET['id_all']);
	}else{
		echo 'id_error';
	}
}

function check_number_all($PlayID){
	$vv = fw('127.0.0.1:999/getad?playerid='.$PlayID.'&v1=&v2=&v3=&v4=');
	return $vv;
}

?>