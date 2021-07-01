<?php
//require_once('Debug.php');
//提取数字
function get_n($v){
	$str=trim($v);
    if(empty($str)){return '';}
    $temp=array('1','2','3','4','5','6','7','8','9','0','.');
    $mumList = array();
    $result='';
    for($i=0;$i<strlen($str);$i++){
    	if(in_array($str[$i],$temp)){
			if(is_numeric($str[$i])){
            	$result.=$str[$i];
            }
            if($str[$i]=='.' && is_numeric($str[$i-1])&&is_numeric($str[$i-1])){
            	$result.=$str[$i];
            }
            if(($i+1)==strlen($str)){
            	$mumList[] = $result;
                $result = '';
            }
		}else{
        	$mumList[] = $result;
            $result = '';
		}
    }
    return $mumList;
}

//从SID号中提取3位随机数来判断许愿类型
function get_xym($Att_type){
	$v=-1;
	if($Att_type>=100 && $Att_type<=299){
		$v=0;
	}elseif($Att_type>=300 && $Att_type<=499){
		$v=1;
	}elseif($Att_type>=500 && $Att_type<=699){
		$v=2;
	}elseif($Att_type>=700 && $Att_type<=899){
		$v=3;
	}
	return $v;
}

//访问数据库
function fw($url){
    $curl = curl_init();
	curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);//如果成功返回结果,如果失败返回FALSE
    $resp = curl_exec($curl);
    curl_close($curl);
    return $resp;
}

//返回许愿字符串,输入许愿类型值
function get_xy_txt($v1){
	switch($v1)
	{
		case 0:
		$vv='&v1=';
		break;
		case 1:
		$vv='&v2=';
		break;
		case 2:
		$vv='&v3=';
		break;
		case 3:
		$vv='&v4=';
		break;
	}
	return $vv;
}

?>