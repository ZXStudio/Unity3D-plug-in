<?php
//$v许愿类型,$n当前次数
function get_reward($v,$n){
	
	/*
	*99110002(魔能)
	*99110001(灵能)
	*99140006(普通空卡),99140007(良好空卡),99140008(优秀空卡),99140009(卓越空卡)
	*99130003(小医疗包),99130004(中医疗包),99130005(大医疗包)
	*/
	
	$_n=array(0,0);
	$_id='';
	switch($v){
		case 0:
			$_id = '99110002';
			switch($n){
				case 9:
					$_n[1]=100;
				break;
				case 8:
					$_n[1]=110;
					
				break;
				case 7:
					$_n[1]=120;
				break;
				case 6:
					$_n[1]=130;
				break;
				case 5:
					$_n[1]=140;
				break;
				case 4:
					$_n[1]=150;
				break;
				case 3:
					$_n[1]=160;
				break;
				case 2:
					$_n[1]=170;
				break;
				case 1:
					$_n[1]=180;
				break;
				case 0:
					$_n[1]=200;
				break;
			}
		break;
		case 1:
			$_n[0]=1;
			$_id = '99110001';
			switch($n){
				case 9:
					$_n[1]=100;
				break;
				case 8:
					$_n[1]=110;
				break;
				case 7:
					$_n[1]=120;
				break;
				case 6:
					$_n[1]=130;
				break;
				case 5:
					$_n[1]=140;
				break;
				case 4:
					$_n[1]=150;
				break;
				case 3:
					$_n[1]=160;
				break;
				case 2:
					$_n[1]=170;
				break;
				case 1:
					$_n[1]=180;
				break;
				case 0:
					$_n[1]=200;
				break;
			}
		break;
		case 2:
			switch($n){
				case 9:
					$_n[0]=10;
					$_n[1]=2;
					$_id = '99140006';
				break;
				case 8:
					$_n[0]=10;
					$_n[1]=2;
					$_id = '99140006';
				break;
				case 7:
					$_n[0]=11;
					$_n[1]=1;
					$_id = '99140007';
				break;
				case 6:
					$_n[0]=11;
					$_n[1]=2;
					$_id = '99140007';
				break;
				case 5:
					$_n[0]=11;
					$_n[1]=3;
					$_id = '99140007';
				break;
				case 4:
					$_n[0]=11;
					$_n[1]=4;
					$_id = '99140007';
				break;
				case 3:
					$_n[0]=12;
					$_n[1]=2;
					$_id = '99140008';
				break;
				case 2;
					$_n[0]=12;
					$_n[1]=3;
					$_id = '99140008';
				break;
				case 1:
					$_n[0]=12;
					$_n[1]=4;
					$_id = '99140008';
				break;
				case 0:
					$_n[0]=13;
					$_n[1]=2;
					$_id = '99140009';
				break;
			}
		break;
		case 3:
			switch($n){
				case 9:
					$_n[0]=20;
					$_n[1]=2;
					$_id = '99130003';
				break;
				case 8:
					$_n[0]=20;
					$_n[1]=3;
					$_id = '99130003';
				break;
				case 7:
					$_n[0]=20;
					$_n[1]=3;
					$_id = '99130003';
				break;
				case 6:
					$_n[0]=21;
					$_n[1]=2;
					$_id = '99130004';
				break;
				case 5:
					$_n[0]=21;
					$_n[1]=3;
					$_id = '99130004';
				break;
				case 4:
					$_n[0]=21;
					$_n[1]=3;
					$_id = '99130004';
				break;
				case 3:
					$_n[0]=22;
					$_n[1]=2;
					$_id = '99130005';
				break;
				case 2:
					$_n[0]=22;
					$_n[1]=2;
					$_id = '99130005';
				break;
				case 1:
					$_n[0]=22;
					$_n[1]=3;
					$_id = '99130005';
				break;
				case 0:
					$_n[0]=22;
					$_n[1]=3;
					$_id = '99130005';
				break;
			}
		break;
	}
	//邮件标题,邮件内容,附件数,卡牌或道具ID,道具数量,品质！
	$_text=array('','','',1,$_id,$_n[1],1);	
	return $_text;	
}
?>
