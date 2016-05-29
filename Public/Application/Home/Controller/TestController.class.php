<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/17
 * Time: 21:02
 */

namespace Home\Controller;
use Think\Controller;


class TestController extends BaseController {
    protected $a = ['name'=>'zhangsan', 'age'=>13];
    public function index() {
//        $fileName = "D:\\2016\\wamp\\www\\oil\\ProtectionData\\test.txt";
//        echo $fileName;
//        $fp = fopen($fileName,'a');
//        for($i = 0; $i<10; $i++) {
//            $data = 'test'.$i."\n";
//            fwrite($fp,$data);
//        }
//        fclose($fp);
//
//        $fp2 = fopen($fileName,'r');
//        $arr = [];
//        for($i = 0; $i<10; $i++) {
//            $arr[$i] = fgets($fp2);
//        }
//        fclose($fp2);
//
//        dump($arr);
//        $data = '!11';
//        $dataR = substr($data,1);
//        dump($dataR);
//        $mobile = '15129265430';
//        $content = '石油巡线系统验证码：171058';
//        $res = sendSMS($mobile,$content);
//        dump($res);
//        $date =  '2015.01.12';
//        $fileName = "D:\\2016\\wamp\\www\\oil\\ProtectionData\\".$date.".txt";
//        $lines = file($fileName,FILE_IGNORE_NEW_LINES);
//        $date =  date('G:i:s', time()+60);
//        dump($lines);
        //dump(chr(0x21));
//        $pdo = new PDO("mysql:host=localhost;dbname=oilsystem","root","root");
//        $value['id'] = 10;
//        $value['text'] = '123';
//        $sql = 'insert into oil_test values('.$value.')';
//        $rs = $pdo -> query($sql);
//        dump($rs);
        $arr1 = ['1','2','3'];
        $arr2 = ['3'];
        $res = array_intersect($arr1,$arr2);
        dump($res);
    }

    public function insertToTest() {
        $test['text'] = 'M方法测试';
        $res = M('test')->add($test);
        dump($res);
    }
    public function model() {
    	$user = D('user');
    	var_dump($user->create());
    }
}