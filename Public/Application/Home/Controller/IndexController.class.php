<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index() {
        $userNickname = session('userInfo')['tester_nickname'];
      //  echo $userNickname;
        $this->display();
    }

    public function map() {
        $info = session('userInfo');
        //dump($info);
        $condition['testpoint_tester_id'] = session('userInfo')['tester_id'];
        $points = M('testpoint')->where($condition)->select();
        //dump($points);
        $pointsRes = [];
        foreach($points as $key=>$value) {
            $pointsRes[$key]['position'] = [$value['testpoint_lng'], $value['testpoint_lat']];
        }
        $pointsJson = json_encode($pointsRes);
        //dump($pointsJson);
        $this->assign('jp', $pointsJson);

        $this->display();
    }

    public function map2() {
        $info = session('userInfo');
        //dump($info);
        $conditionPoints['testpoint_tester_id'] = session('userInfo')['tester_id'];
        $points = M('testpoint')->where($conditionPoints)->select();
        //dump($points);
        $pointsRes = [];
        foreach($points as $key=>$value) {
            $pointsRes[$key] = [$value['testpoint_lng'], $value['testpoint_lat']];
        }
        $pointsJson = json_encode($pointsRes);
        //dump($pointsJson);
        $this->assign('jp', $pointsJson);



        $this->display();
    }
    
}