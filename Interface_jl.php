<?php
//require_once('Debug.php');
require_once('reward.php');
require_once('compute.php');
require_once('fw.php');

//直接发奖励,玩家ID,许愿类型
if(isset($_GET["id"]) && isset($_GET["vv"])){
	if(strlen($_GET['id'])==8)
	{
		$v='';
		switch($_GET["vv"]){
		case '0':
			$v=check_number($_GET['id'],'&v1=');
			//Logs("魔能许愿：".$_GET['id'].',&v1：'.$v);
			$v = GXX($_GET["id"],$_GET["vv"],$v);
			echo $v;
		break;
		case '1':
			$v=check_number($_GET['id'],'&v2=');
			//Logs("灵能许愿：".$_GET['id'].',&v2：'.$v);
			$v = GXX($_GET["id"],$_GET["vv"],$v);
			echo $v;
		break;
		case '2':
			$v=check_number($_GET['id'],'&v3=');
			//Logs("空卡许愿：".$_GET['id'].',&v3：'.$v);
			$v = GXX($_GET["id"],$_GET["vv"],$v);
			echo $v;
		break;
		case '3':
			$v=check_number($_GET['id'],'&v4=');
			//Logs("医疗许愿：".$_GET['id'].',&v4：'.$v);
			$v = GXX($_GET["id"],$_GET["vv"],$v);
			echo $v;
		break;
		default:
			echo 'vv_error';
		}
	}else{
		echo 'id_error';
	}
}

//玩家ID,许愿类型,剩余次数
function GXX($PlayID,$type,$v){
	switch($v){
		case 8:
			$v--;
		break;
		case 5:
			$v--;
		break;
		case 2:
			$v--;
		break;
		default:
			return 'v_error';
	}
	
	//给玩家发邮件和奖励
	$reward = get_reward($type,$v);//获得邮件文本信息
	$reward[0]= $PlayID;
	$url = mail_fw($reward);
	//Logs('给玩家发邮件,该玩家ID'.$PlayID.',许愿类型'.$type.',剩余次数'.$v.'通信结果：'.$url);
	if(!$url=='1')
	{
		return 'mail_error';
	}
	
	//保存订单
	$bol = fw('127.0.0.1:999/setad?playerid='.$PlayID.get_xy_txt($type).$v.'&sid='.$PlayID.rand(100,999));	
	//Logs("保存订单,通信结果：".$bol);
	if($bol=="1"){
		//Logs("保存完成");
		return $v;
	}else{
		//Logs("保存失败");
		return 'save_failed';
	}
}

function check_number($PlayID,$v){
	$vv='127.0.0.1:999/getad?playerid='.$PlayID.$v;
	//Logs('通信地址：'.$vv);
	$vv = fw($vv);
	//Logs('FW通信结果：'.$vv);
	$vv = get_n($vv);
	//Logs('数字提取：'.$vv);
	return $vv[0];
}
?>
