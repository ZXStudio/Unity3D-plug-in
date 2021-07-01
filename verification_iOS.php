<?php
require_once('Debug.php');
require_once('IP.php');
require_once('compute.php');
require_once('reward.php');
require_once('fw.php');
function generate_hash($params, $secret) {

	//检查访问者的IP是否是UnityAds服务器
	$ip = $_SERVER["REMOTE_ADDR"];
	if(!Get_IP($ip)){
		//Logs('IP不对,拒绝访问'.$ip);
		exit; 
	}else{
		//Logs('IP是对的'.$ip);
	}
	
   	ksort($params); //所有参数总是按字母顺序检查
   	$s = '';
   	foreach ($params as $key => $value) {
    	$s.= "$key=$value,";
   	}
   	$s = substr($s, 0, -1);
   	$hash = hash_hmac('md5', $s, $secret);
   	return $hash;
}

//$NN='';//测试:许愿类型字符串
$PlayID='';//玩家ID
$Att_type=0;//玩家SID号中的3位许愿类型码,0魔能,1灵能,2空卡,3医疗包
$Att_num=0;//许愿剩余次数
$hash = $_GET['hmac'];//哈希值
unset($_GET['hmac']);//销毁指定的$_GET['hmac']变量
$signature = generate_hash($_GET, 'f5b349732e5ddef8f9268aee4dd49a06'); //在这里插入您从中收到的秘密哈希密钥

Logs("官方的签名：".$hash);
Logs("我算的签名：".$signature);

//检擦UnityAds服务器发来的签名和我们自己算的是否一样
if($hash != $signature) {
	Logs('签名不匹配');
	header('HTTP/1.1 403 Forbidden'); 
	exit; 
}else{
	//判断SID是11位吗
	if(strlen($_GET['sid'])!=11){
		Logs('玩家SID位数不对:'.$_GET['sid']);
		exit; 
	}else{
		//从SID获得玩家ID
		$PlayID = substr($_GET['sid'],0,8);
		
		//提取3位
		$Att_type = (int)substr($_GET['sid'],8,11);
		Logs('许愿码未计算前：'.$Att_type);
		//判断许愿类型
		$Att_type  = get_xym($Att_type);
		if($Att_type==-1){
			Logs('SID后三位许愿码的范围不对:'.$Att_type);
			exit; 
		}else{
			switch($Att_type){
				case 0:
					$NN='魔能许愿';
				break;
				case 1:
					$NN='灵能许愿';
				break;
				case 2:
					$NN='空卡许愿';
				break;
				case 3:
					$NN='医疗许愿';
				break;
			}
			Logs('玩家许愿码正确：'.$Att_type.',许愿类型为'.$NN);
		}
	}
}

//检查Sid是否和上次是否相同,防止订单重复,Sid由玩家ID+3个随
if(check_duplicate_orders($_GET['sid'])){
	Logs('重复订单');
	header('HTTP/1.1 403 Forbidden');exit; 
}
function check_duplicate_orders($sid){
	global $PlayID;
	//获取玩家次数和上次订单号
	$ck_sid = fw('127.0.0.1:999/getad?playerid='.$PlayID.'&sid=');
	if($ck_sidl!="0"){
		$ck_sid = substr($ck_sid,0,-1);//除去&符号
		Logs('上次的SID订单是：'.$ck_sid.',长度：'.strlen($ck_sid).',本次提交的的SID订单是：'.$sid);
		if($ck_sid!=$sid){
			Logs("订单没有重复");
			return false;
		}else{
			return true;
		}
	}else{
		Logs("检查订单过程中发现玩家ID错误：".$ck_sid);
		exit; 
	}
}
//查询玩家次数:玩家的ID,玩家许愿类型(0魔能1灵能2空卡3医疗)
function check_number($PlayID,$v1){
	//global $NN;
	$vv = get_xy_txt($v1);
	Logs('许愿类型是：'.$NN.',地址127.0.0.1:999/getad?playerid='.$PlayID.$vv);
	$vv = fw('127.0.0.1:999/getad?playerid='.$PlayID.$vv);
	Logs('剩余次数是：'.$vv.'次');
	$aaa=get_n($vv);
	return $aaa[0];
}

//如果没有,那么给玩家物品并检查它是否成功。
if(!give_item_to_player($_GET['sid'])){ 
	Logs('未能将物品交给玩家');
	header('HTTP/1.1 500 Internal Server Error');exit; 
}
function give_item_to_player($id){
	global $PlayID;
	global $Att_type;
	global $Att_num;
	//global $NN;
	
	//判断剩余次数,如果有错,向前端报告
	$n = check_number($PlayID,$Att_type);
	if($n<=0){
		Logs('本该获得奖励的玩家为：'.$PlayID.',由于'.$NN.'剩余次数为0,所以退出');
		exit; 
	}else{
		$n--;//减少
		$Att_num=$n;
		Logs('获得奖励的玩家ID为:'.$PlayID.','.$NN.'剩余次数：'.$n);
	}
	
	//获取邮件信息
	$reward = get_reward($Att_type,$n);
	$reward[0]= $PlayID;
	//给玩家写入数据
	$url = mail_fw($reward);
	Logs('发送邮件给玩家,结果：'.$url);
	if($url=="1"){
		return true;
	}else{
		return false;
	}
}

//保存订单ID以进行重复检查
if(save_order_number($_GET['sid'])) { 
	Logs('订单ID保存失败,用户已授予项');
	header('HTTP/1.1 500 Internal Server Error'); exit; 
}
function save_order_number($sid){
	global $PlayID;
	global $Att_type;
	global $Att_num;
	Logs('保存SID订单,通信地址：'.'127.0.0.1:999/setad?playerid='.$PlayID.get_xy_txt($Att_type).$Att_num.'&sid='.$sid);
	$bol = fw('127.0.0.1:999/setad?playerid='.$PlayID.get_xy_txt($Att_type).$Att_num.'&sid='.$sid);	
	Logs("通信结果：".$bol);
	if($bol=="1"){
		Logs("保存完成");
		return false;
	}else{
		Logs("保存失败");
		return true;
	}
}

//一切正常,返回“1”
header('HTTP/1.1 200 OK');
Logs('任务完成');
echo "1";
?>