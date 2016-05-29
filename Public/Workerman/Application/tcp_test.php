<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 15:09
 */
use Workerman\Worker;
require_once '../Autoloader.php';

// 创建一个Worker监听2347端口，不使用任何应用层协议
$tcp_worker = new Worker("tcp://0.0.0.0:2347");
//static $res = ' : ';
// 启动4个进程对外提供服务
$tcp_worker->count = 4;

// 当客户端发来数据时
$tcp_worker->onMessage = function($connection, $data)
{
    if(substr_count($data,',')>=5) {
        echo $data;
        //$data = '"151,108.1096,34.4792,401.4589,2015.01.12,13:47:05.100,vdc_on,vdc_off,vac_on,vac_off,YES,90%,END1';
        $dataArr = explode(',',$data);
        $test_no = date('Ymd',time());

        $dateArr = explode('.', $dataArr[4]);
        $timeTempArr = explode('.', $dataArr[5]);
        $timeArr = explode(':',$timeTempArr[0]);

        $insertValue[2] = $value['no'] = $test_no;
        $insertValue[3] = $value['no_set'] = substr($dataArr[sizeof($dataArr)-1],-1);
        $insertValue[4] = $value['time'] = mktime($timeArr[0], $timeArr[1], $timeArr[2], $dateArr[1], $dateArr[2], $dateArr[0]);
        $insertValue[5] = $value['equipe_id'] = substr($dataArr[0],1);
        $insertValue[7] = $value['lng'] = $dataArr[1];
        $insertValue[8] = $value['lat'] = $dataArr[2];
        $insertValue[9] = $value['alt'] = $dataArr[3];
        $insertValue[14] = $value['battery'] = substr($dataArr[sizeof($dataArr)-2],0,strlen('END1')-1);
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
            $pdo = new PDO("mysql:host=localhost;dbname=oilsystem","root","root");
            $para = "null".",'".$insertValue[2]."',"."$insertValue[3]".",".$insertValue[4].",".$insertValue[5].
                ",".$insertValue[6].",'".$insertValue[7]."',"."'".$insertValue[8]."',".$insertValue[9].
                ",".$insertValue[10].",".$insertValue[11].",".$insertValue[12].",".$insertValue[13].",".$insertValue[14];
            $sql = "INSERT INTO oil_protectiondata VALUES (".$para.")";
            //echo $para;die;
            $rs = $pdo -> query($sql);
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

        $fp = fopen($fileName,'a');
        $time = time();
        $content = $data.",".$time."\n";
        fwrite($fp,$content);
        fclose($fp);
        //var_dump($res);
        $connection->send($res);
    }
    else {
        echo 'can not handle '.$data;
    }

};

// 运行worker
Worker::runAll();