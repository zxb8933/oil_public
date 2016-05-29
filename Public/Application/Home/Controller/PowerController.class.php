<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/18
 * Time: 9:42
 */

namespace Home\Controller;
use Think\Controller;

class PowerController extends BaseController {

    protected $userInfo = [];
    protected $powerList = '';
    protected $powerId = 0;
    protected $company = 0;

    function _initialize() {
        $this->userInfo = session('userInfo');
        $company = $this->userInfo['tester_company_id'];
        if(is_numeric($company) && 0!=$company) {
            $getPowerSql = 'SELECT getPowerListFunc('.$company.') AS list';
            $powerListRes = M()->query($getPowerSql);
            $this->powerList = $powerListRes[0]['list'];
        }
        else {
            echo 'error';
        }
    }

    private function setPowerId() {
        $powerId = I('form1', 0, 'htmlspecialchars');
        if(is_int($powerId)) {
            $this->powerId = $powerId;
        }
        else{
            returnToIndex($this);
        }
    }

    function index() {
        $statement =  "The information of power will be here";
        $this->assign('statement', $statement);

        $this->assign('userInfo', $this->userInfo);
        $this->display();
    }

    function currentQuery() {
        $powerId = 1;//I('power', 0, 'htmlspecialchars');
        $powerCurrentRes = [];
        if(is_numeric($powerId) && 0!=$powerId) {
            $getPowerCurrentSql = 'call getPowerCurrentPROC('.$powerId.')';
            $powerCurrentRes = M()->query($getPowerCurrentSql);
            foreach($powerCurrentRes as $key=>$value) {
                $powerCurrentRes[$key]['test_time'] = date(DATE_ATOM,$value['test_time']);
            }
            //dump($powerCurrentRes);
        }
        $powerCurrentJson = json_encode($powerCurrentRes);
        $this->ajaxReturn($powerCurrentJson);
    }

    function powerCurrent() {
        $powerListArr = explode(',',$this->powerList);
        $powerListJson = json_encode($powerListArr);
        $this->assign('jlp', $powerListJson);
        $powerId = I('power', 0, 'htmlspecialchars');
        $powerCurrentRes = [];
        if(is_numeric($powerId) && 0!=$powerId) {
            $getPowerCurrentSql = 'call getPowerCurrentPROC('.$powerId.')';
            $powerCurrentRes = M()->query($getPowerCurrentSql);
            foreach($powerCurrentRes as $key=>$value) {
                $powerCurrentRes[$key]['time'] = date('Y-m-d H:i:s',$value['test_time']);
            }
        }
        $powerCurrentJson = json_encode($powerCurrentRes);
        $this->assign('jcp', $powerCurrentJson);
        $this->display();

    }

    function powerDaily() {
        $powerListArr = explode(',',$this->powerList);
        $powerListJson = json_encode($powerListArr);
        $this->assign('jlp', $powerListJson);
        $powerId = I('power', 0, 'htmlspecialchars');
        $daterange = I('daterange', 0, 'htmlspecialchars');
        $date = getDateRange($daterange);
        $powerDailyRes = [];
        if( is_numeric($powerId) && 0!=$powerId
            && is_numeric($date['begin']) && 0!=$date['begin']
            && is_numeric($date['end']) && 0!=$date['end'] )
        {
            $paraStr = $powerId.','.$date['begin'].','.$date['end'];
            $getPowerDailySql = 'call getPowerDailyPROC('.$paraStr.')';
            $powerDailyRes = M()->query($getPowerDailySql);
            foreach($powerDailyRes as $key=>$value) {
                $powerDailyRes[$key]['date'] = date('Y-m-d',$value['test_date']);
            }
        }
        $powerDailyJson = json_encode($powerDailyRes);
        //dump($powerDailyRes);
        $this->assign('jdp', $powerDailyJson);

        $this->display();
    }

    function powerError() {
        $condition = "FIND_IN_SET(power_id,'".$this->powerList."')"." AND power_state = 0";
        $powerErrorRes = M('power') -> where($condition)->select();
        foreach($powerErrorRes as $key=>$value) {
            $powerErrorRes[$key]['date'] = date('Y-m-d H:i:s',$value['power_maintaindate']);
        }
        $powerErrorJson = json_encode($powerErrorRes);
        $this->assign('jep', $powerErrorJson);
        $this->display();
    }

}