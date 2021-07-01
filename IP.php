<?php
function Get_IP($ip){
	$arrStr = explode('.',$ip);
	
	if($arrStr[0]==185){
		if($arrStr[1]==33){
			if($arrStr[2]==96){
				return true;
			}
		}elseif($arrStr[1]==98){
			if($arrStr[2]==36){
				return true;
			}
		}
	}elseif($arrStr[0]==35){	
		switch ($arrStr[1])
		{
			case 235:
  				if($arrStr[2]==16){
					return true;
				}
  			break;  
			case 227:
  				if($arrStr[2]==129){
					return true;
				}
 			break;
			case 234:
  				if($arrStr[2]==176){
					return true;
				}
 			break;
			case 192:
  				if($arrStr[2]==193){
					return true;
				}
 			break;
			case 205:
 				if($arrStr[2]==0){
					return true;
				}
 			break;
		}
	}
	return false;
}
?>