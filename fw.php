<?php
//require_once('Debug.php');

function mail_fw($reward){
	$reward[1] = '������ͽ���';
	$reward[2] = '���������,��л����֧��,�ۻ��ۿ������������ӽ�����';
	$url='127.0.0.1:999/sendmail?playerid='.$reward[0].'&title='.$reward[1].'&content='.$reward[2].'&attachcnt='.$reward[3].'&atta_typeid='.$reward[4].'&atta_num='.$reward[5].'&atta_quality='.$reward[6];
	//Logs('mailing address:'.$url);
    //header���͸�ʽ
    $headers = array("","",);
    //��ʼ��
    $curl = curl_init();
    //����url·��
    curl_setopt($curl, CURLOPT_URL, $url);
    //�� curl_exec()��ȡ����Ϣ���ļ�������ʽ���أ�������ֱ�������
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ;
    //������ CURLOPT_RETURNTRANSFER ʱ�򽫻�ȡ���ݷ���
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true) ;
    //���ͷ��Ϣ
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //CURLINFO_HEADER_OUTѡ������õ�����ͷ��Ϣ
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    //����֤SSL
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    //ִ��
    $data = curl_exec($curl);
    //�ر�����
    curl_close($curl);
    //��������
    return $data;
}

?>