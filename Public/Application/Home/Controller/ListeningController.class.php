<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/17
 * Time: 8:37
 */

namespace Home\Controller;
use Think\Controller;
define('PT_DETAILS',13);
//require_once '../../../Workerman/Autoloader.php';

class ListeningController extends BaseController{
    protected $sentArr = [];
    function index() {
        $userInfo = session('userInfo');
        $company = $userInfo['tester_company_id'];
        $equipArr = [];
        if(is_numeric($company) && 0!=$company) {
            $condition['onlineequip_company_id'] = $company;
            $equipArr = M('onlineequip')->where($condition)->select();
            //$equipJson = json_encode($equipArr);
            $this->assign('ae', $equipArr);
            //$this->assign('je', $equipJson);
            //dump($equipJson);
        }
        //dump($equipArr);
        $testArr = [];
        foreach($equipArr AS $key=>$value) {
            $testArr[$key] = I($equipArr[$key]['onlineequip_id'],0);
        }
        foreach($testArr AS $key=>$value) {
            if(0==$value || !checkMobile($value)) {
                unset($testArr[$key]);
            }
        }
        //dump($testArr);
        //dump($this->sentArr);die;
        $date = date('Y.m.d');
        $time = date('G:i:s', time()+60);
        $duplication = array_intersect($this->sentArr,$testArr);
        //dump($duplication);
        if(sizeof($testArr)>0 && empty($duplication)) {
            //dump($testArr);
            $mobile = implode(',', $testArr);
            $content = 'SET_TEST:27,8000,4000,'.$date.','.$time.',4000,00:01:05#';
            //群发短信，未通
            sendSMS($mobile, $content);
            $this->sentArr = array_merge($this->sentArr,$testArr);
            echo 'sent';
        }
        $fileName = "D:\\2016\\wamp\\www\\oil\\ProtectionData\\".$company."\\".$date.".txt";
        //dump($fileName);
        $lines = file($fileName,FILE_IGNORE_NEW_LINES);
        //dump($lines);
        $result['pointNum'] = sizeof($testArr);
        $result['correct'] = 0;
        $result['error'] = 0;
        $testRes = [];
        foreach($lines AS $key=>$value) {
            $res = explode(',',$value);
            if(PT_DETAILS==sizeof($res)) {
                $equip_condition['onlineequip_no'] = substr($res[0],1);
                $equipRes = M('onlineequip')->where($equip_condition)->find();
                if($equipRes!=null) {
                    $id = $equipRes['onlineequip_id'];
                    $testRes[$id]['no'] = substr($res[0],1);
                    $testRes[$id]['lng'] = $res[1];
                    $testRes[$id]['lat'] = $res[2];
                    $testRes[$id]['alt'] = $res[3];
                    $testRes[$id]['date'] = $res[4];
                    $testRes[$id]['time'] = $res[5];
                    $testRes[$id]['vdc_on'] = $res[6];
                    $testRes[$id]['vdc_off'] = $res[7];
                    $testRes[$id]['vac_on'] = $res[8];
                    $testRes[$id]['vac_off'] = $res[9];
                    $testRes[$id]['gps'] = $res[10];
                    $testRes[$id]['battery'] = $res[11];
                    $testRes[$id]['end'] = $res[12];
                    $result['correct'] ++;
                }
            }
            else {
                $result['error'] ++;
            }
        }
        $resultJson = json_encode($result);
        $this->assign('jr',$resultJson);
        $testJson = json_encode($testRes);
        $this->assign('jt',$testJson);
        //dump($testRes);
        //dump($result);
        $this->display();
    }

}