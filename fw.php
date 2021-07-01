<?php
//require_once('Debug.php');

function mail_fw($reward){
	$reward[1] = '看广告送奖励';
	$reward[2] = '敬爱的玩家,感谢您的支持,累积观看广告可以逐渐增加奖励。';
	$url='127.0.0.1:999/sendmail?playerid='.$reward[0].'&title='.$reward[1].'&content='.$reward[2].'&attachcnt='.$reward[3].'&atta_typeid='.$reward[4].'&atta_num='.$reward[5].'&atta_quality='.$reward[6];
	//Logs('mailing address:'.$url);
    //header传送格式
    $headers = array("","",);
    //初始化
    $curl = curl_init();
    //设置url路径
    curl_setopt($curl, CURLOPT_URL, $url);
    //将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ;
    //在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true) ;
    //添加头信息
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //CURLINFO_HEADER_OUT选项可以拿到请求头信息
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    //不验证SSL
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    //执行
    $data = curl_exec($curl);
    //关闭连接
    curl_close($curl);
    //返回数据
    return $data;
}

?>