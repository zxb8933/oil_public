<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/18
 * Time: 10:03
 */

namespace Home\Controller;
use Think\Controller;

class ProtectionController extends BaseController {

    protected $userInfo = [];
    protected $company = 0;
    protected $lineRes = [];
    protected $sublineRes = [];

    function _initialize() {
        $this->userInfo = session('userInfo');
        $company = $this->userInfo['tester_company_id'];
        $this->company = $company;
        $this->lineRes = M('line')->select();
        $sublineRes = [];
        if(is_numeric($company) && 0!= $company) {
            foreach($this->lineRes AS $key=>$value) {
                $getSublineSql = 'CALL getSublineFromLinePROC('.$company.','.$value['line_id'].')';
                $sublineRes[$value['line_id']] = M()->query($getSublineSql);
            }
            $this->sublineRes = $sublineRes;
        }
    }

    function index() {
        //echo 'The information of cathodic protection will be here';
        $this->display();
    }

    function protectionCollection() {
        //按月汇总，查protectionmon
        $lineList = $this->lineRes;
        //dump($lineList);
        $lineListJson = json_encode($lineList);
        $this->assign('jll', $lineListJson);
        //$sublineList = $this->sublineRes;
        $line = I('line', 0, 'htmlspecialchars');
//        $line = 1;
        $date = I('date', 0, 'htmlspecialchars');
        //dump($date);
        $range = [];
        if(0!=$date) {
            $range = date2range($date);
        }
        //dump($range);
        $range['begin'] = 1459238043;
        $range['end'] = 1459338043;
        $company = $this->company;
        if(is_numeric($line) && !empty($range)) {

            $getCollSql = 'CALL getProtCollPROC('.$company.','.$line.','.$range['begin'].','.$range['end'].')';
            $collRes = M()->query($getCollSql);
            $collJson = json_encode($collRes);

            $over_sum = 0;
            $low_sum = 0;
            $right_sum = 0;
            $point_sum = 0;
            foreach($collRes AS $key=>$value) {
                $over_sum += $value['over_num'];
                $low_sum += $value['low_num'];
                $right_sum += $value['right_num'];
                $point_sum += $value['point_num'];
            }
            $over_rate = 100*$over_sum/$point_sum;
            $low_rate = 100*$low_sum/$point_sum;
            $right_rate = 100*$right_sum/$point_sum;
            $nodate_rate = 100-$over_rate-$low_rate-$right_rate;
            $percentage['过保护'] = floatval(sprintf('%.2f', $over_rate));
            $percentage['欠保护'] = floatval(sprintf('%.2f', $low_rate));
            $percentage['正常保护'] = floatval(sprintf('%.2f', $right_rate));
            $percentage['无数据'] = floatval(sprintf('%.2f', $nodate_rate));
            //dump($percentage);
            $percentageJson = json_encode($percentage);

            $this->assign('jc', $collJson);
            $this->assign('jp', $percentageJson);
        }

//        dump($sublineRes);

        $this->display();
    }

    function protectionCollectionOld() {
        //按月汇总，查protectionmon
        $lineList = $this->lineRes;
        $lineListJson = json_encode($lineList);
        $this->assign('jll', $lineListJson);
        //$sublineList = $this->sublineRes;
        $line = I('line', 0, 'htmlspecialchars');
        $month = I('month', 0, 'htmlspecialchars');
        $company = $this->company;
        if(is_numeric($line) && is_numeric($month)) {
            $beginTime = mktime(0,0,0,$month+1,1,date('Y'));
            $endTime = mktime(0,0,0,$month+2,1,date('Y'));

            $getCollSql = 'CALL getProtCollPROC('.$company.','.$line.','.$beginTime.','.$endTime.')';
            $collRes = M()->query($getCollSql);
            $collJson = json_encode($collRes);

            $over_sum = 0;
            $low_sum = 0;
            $right_sum = 0;
            $point_sum = 0;
            foreach($collRes AS $key=>$value) {
                $over_sum += $value['over_num'];
                $low_sum += $value['low_num'];
                $right_sum += $value['right_num'];
                $point_sum += $value['point_num'];
            }
            $over_rate = 100*$over_sum/$point_sum;
            $low_rate = 100*$low_sum/$point_sum;
            $right_rate = 100*$right_sum/$point_sum;
            $nodate_rate = 100-$over_rate-$low_rate-$right_rate;
            $percentage['过保护'] = floatval(sprintf('%.2f', $over_rate));
            $percentage['欠保护'] = floatval(sprintf('%.2f', $low_rate));
            $percentage['正常保护'] = floatval(sprintf('%.2f', $right_rate));
            $percentage['无数据'] = floatval(sprintf('%.2f', $nodate_rate));
            $percentageJson = json_encode($percentage);

            $this->assign('jc', $collJson);
            $this->assign('jp', $percentageJson);
        }

//        dump($sublineRes);

        $this->display();
    }

    function protectionChart() {
        //按天汇总，直接查test表
        $lineList = $this->lineRes;
        $lineListJson = json_encode($lineList);
        $this->assign('jll', $lineListJson);
        $sublineList = $this->sublineRes;
        //dump($this->sublineRes);
        $sublineListJson = json_encode($sublineList);
        $this->assign('jls', $sublineListJson);

        $subline = I('subline', 0, 'htmlspecialchars');
        $date = I('date', 0, 'htmlspecialchars');
//        dump($date);
        $range = [];
        if(0!=$date) {
            $range = date2range($date);
        }

        if(is_numeric($subline) && !empty($range)) {
            $getSubSql = 'CALL getSublineProtPROC('.$subline.','.$range['begin'].','.$range['end'].')';
            $sublineProtRes = M()->query($getSubSql);
            foreach($sublineProtRes AS $key=>$value) {
                $sublineProtRes[$key]['label'] = $key+1;
                $sublineProtRes[$key]['date'] = date('Y-m-d H:i:s',$value['time']);
                if($value['state']==0) {
                    $sublineProtRes[$key]['state'] = '正常保护';
                }
                elseif($value['state'>0]) {
                    $sublineProtRes[$key]['state'] = '欠保护';
                }
                else {
                    $sublineProtRes[$key]['state'] = '过保护';
                }
            }
            $sublineProtJson = json_encode($sublineProtRes);
            $this->assign('jms',$sublineProtJson);
        }

        $this->display();
    }

    function protectionChartOld() {
        //按月汇总，查protectionmon表
        $lineList = $this->lineRes;
        $lineListJson = json_encode($lineList);
        $this->assign('jll', $lineListJson);
        $sublineList = $this->sublineRes;
        //dump($this->sublineRes);
        $sublineListJson = json_encode($sublineList);
        $this->assign('jls', $sublineListJson);

        $subline = I('subline', 0, 'htmlspecialchars');
        $month = I('month', 0, 'htmlspecialchars');
        $beginTime = mktime(0,0,0,$month+1,1,date('Y'));
        $endTime = mktime(0,0,0,$month+2,1,date('Y'));

        if(is_numeric($subline) && is_numeric($month)) {
            $getSubSql = 'CALL getSublineMonPROC('.$subline.','.$beginTime.','.$endTime.')';
            $sublineMonRes = M()->query($getSubSql);
            foreach($sublineMonRes AS $key=>$value) {
                $sublineMonRes[$key]['label'] = $key+1;
                $sublineMonRes[$key]['date'] = date('Y-m-d H:i:s',$value['time']);
                if($value['state']==0) {
                    $sublineMonRes[$key]['state'] = '正常保护';
                }
                elseif($value['state'>0]) {
                    $sublineMonRes[$key]['state'] = '欠保护';
                }
                else {
                    $sublineMonRes[$key]['state'] = '过保护';
                }
            }
            $sublineMonJson = json_encode($sublineMonRes);
            $this->assign('jms',$sublineMonJson);
        }

        $this->display();
    }

    function  protectionOnPoints() {
        $lineList = $this->lineRes;
        $lineListJson = json_encode($lineList);
        $this->assign('jll', $lineListJson);
        $sublineList = $this->sublineRes;
        //dump($this->sublineRes);
        $sublineListJson = json_encode($sublineList);
        $this->assign('jls', $sublineListJson);
        $pointList = [];
        foreach($sublineList AS $key=>$value) {
            foreach($value AS $kkey=>$vvalue) {
                $condition['testpoint_subline_id'] = $vvalue['subline_id'];
                $pointList[$vvalue['subline_id']] = M('testpoint')->where($condition)->select();
            }

        }
        $pointListJson = json_encode($pointList);
        $this->assign('jlp', $pointListJson);

//        $point = 1;
//        $beginTime = 3;
//        $endTime = 1459251643;
        $point = I('point', 0, 'htmlspecialchars');
        $daterange = I('daterange', 0, 'htmlspecialchars');
        $date = getDateRange($daterange);

        if( is_numeric($point) && 0!=$point
            && is_numeric($date['begin']) && 0!=$date['begin']
            && is_numeric($date['end']) && 0!=$date['end'] )
        {
            //$getPointDataSql = 'CALL getPointDataPROC('.$point.','.$beginTime.','.$endTime.')';
            $getPointDataSql = 'CALL getPointDataPROC('.$point.','.$date['begin'].','.$date['end'].')';
            $pointData = M()->query($getPointDataSql);
            foreach($pointData AS $key=>$value) {
                $pointData[$key]['date'] = date('Y-m-d G:i:s', $value['time']);
                $pointData[$key]['label'] = $key+1;
            }

            $pointTestJson = json_encode($pointData);
            //dump($pointTestJson);
            $this->assign('jtp', $pointTestJson);
        }

        $this->display();
    }

    function protectionError() {


        $this->display();
    }


}