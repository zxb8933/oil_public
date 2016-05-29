<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/18
 * Time: 10:34
 */
//$pdo = new PDO("mysql:host=localhost;dbname=oilsystem","root","root");
//$value['id'] = 10;
//$value['text'] = '123';
//$sql = 'insert into oil_test values('.$value.')';
//$rs = $pdo -> query($sql);
//dump($rs);
//$str = substr('END1',0,strlen('END1')-1);
//var_dump($str);
//var_dump(strlen('END1'));

$data = '"151,108.1096,34.4792,401.4589,2015.01.12,13:47:05.100,10,1,5,0.5,YES,90%,END1';
var_dump($data);
$dataArr = explode(',',$data);
$test_no = date('Ymd',time());

$dateTempArr = explode('.', $dataArr[4]);
$timeTempArr = explode('.', $dataArr[5]);
$timeArr = explode(':',$timeTempArr[0]);

$insertValue[2] = $value['no'] = $test_no;
$insertValue[3] = $value['no_set'] = substr($dataArr[sizeof($dataArr)-1],-1);
$insertValue[4] = $value['time'] = mktime($timeArr[0], $timeArr[1], $timeArr[2], $dateTempArr[1], $dateTempArr[2], $dateTempArr[0]);
$insertValue[5] = $value['equipe_id'] = substr($dataArr[0],1);
$insertValue[7] = $value['lng'] = $dataArr[1];
$insertValue[8] = $value['lat'] = $dataArr[2];
$insertValue[9] = $value['alt'] = $dataArr[3];
$insertValue[14] = $value['battery'] = substr($dataArr[sizeof($dataArr)-2],0,strlen('END1')-2);
//8

$fileName = '';
if('"'==substr($dataArr[0],0,1) || '!'==substr($dataArr[0],0,1)) {
    $insertValue[6] = $value['type'] = 2;
    if('"'==substr($dataArr[0],0,1)) {
        $insertValue[6] = $value['type'] = 1;
    }
    $insertValue[11] = $value['vdc_on'] = $dataArr[6];
    $insertValue[10] = $value['vdc_off'] = $dataArr[7];
    $insertValue[13] = $value['vac_on'] = $dataArr[8];
    $insertValue[12] = $value['vac_off'] = $dataArr[9];
    //13
//    $pdo = new PDO("mysql:host=localhost;dbname=oilsystem","root","root");
//    $s = "INSERT INTO oil_test VALUES("."null".","."'".$data."'".")";
//    var_dump($s);
//    $r = $pdo -> query($s);var_dump($r);die;
//    var_dump($insertValue);
//    ('protectiondata_id','protectiondata_no','protectiondata_no_set',
//            'protectiondata_time','protectiondata_equip_id','protectiondata_equip_type','protectiondata_lng',
//            'protectiondata_lat','protectiondata_alt','protectiondata_vdc_off','protectiondata_vdc_on',
//            'protectiondata_vac_off','protectiondata_vac_on','protectiondata_battery')
    $pdo = new PDO("mysql:host=localhost;dbname=oilsystem","root","root");
    $para = "null".",'".$insertValue[2]."',"."$insertValue[3]".",".$insertValue[4].",".$insertValue[5].
        ",".$insertValue[6].",'".$insertValue[7]."',"."'".$insertValue[8]."',".$insertValue[9].
        ",".$insertValue[10].",".$insertValue[11].",".$insertValue[12].",".$insertValue[13].",".$insertValue[14];
    $sql = "INSERT INTO oil_protectiondata VALUES (".$para.")";
    //echo $para;die;
    $rs = $pdo -> query($sql);
    var_dump($rs);
    echo 'success';die;
    $fileName = "D:\\2016\\wamp\\www\\oil\\ProtectionData\\".$test_no.".txt";
    $res = 'receive successfully';
}
elseif(' '==substr($dataArr[0],0,1)) {
    $value['vdc'] = $dataArr[6];
    $value['idc'] = $dataArr[7];
    $fileName = "D:\\2016\\wamp\\www\\oil\\PowerData\\".$test_no.".txt";
    $res = 'receive successfully';
}
else {
    $res = 'error data';
    //var_dump($res);
    $connection->send($res);
    return;
}