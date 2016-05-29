<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/21
 * Time: 13:28
 */

/**
 * 判断session信息是否合法
 */
function identifyUserInfo($user_info) {
    if( !is_array($user_info) ||
        !is_numeric($user_info['tester_id']) ||
        !is_numeric($user_info['test_company_id']) ) {
        return 0;
    }
    return 1;
}

/**
 * 发生错误时清除session并返回登录页面
 */

function check0($arr) {
    foreach($arr as $key=>$value) {
        if(0==$value) {
            return false;
        }
    }
    return true;
}

function checkMobile($str) {
    if(is_numeric($str) && 11==strlen($str)) {
        return true;
    }
    else {
        return false;
    }
}

function containArr($arrList, $arr) {
    foreach($arr AS $key=>$value) {
        foreach($arrList AS $keyA=>$valueA) {
            if($value==$valueA) {
                continue;
            }
        }
    }
    return true;
}

function date2range($date) {
    $range['begin'] = 0;
    $range['end'] = 0;
    $dateArr = explode('/', $date);
    if(3==sizeof($dateArr)) {
        $range['begin'] = mktime(0, 0, 0, $dateArr[0], $dateArr[1], $dateArr[2]);
        $range['end'] = mktime(23, 59, 59, $dateArr[0], $dateArr[1], $dateArr[2]);
        return $range;
    }
    return $range;
}

function getDateRange($daterange) {
    $date['begin'] = 0;
    $date['end'] = 0;
    $dateArr = explode('-', $daterange);
    if(2==sizeof($dateArr)) {
        $dateBegin = explode('/', trim($dateArr[0]));
        $dateEnd = explode('/', trim($dateArr[1]));
        if(3==sizeof($dateBegin) && 3==sizeof($dateEnd)) {
            $date['begin'] = mktime(0, 0, 0, $dateBegin[0], $dateBegin[1], $dateBegin[2]);
            $date['end'] = mktime(23, 59, 59, $dateEnd[0], $dateEnd[1], $dateEnd[2]);
            return $date;
        }
    }
    return $date;
}

function returnToIndex($controller) {
    session(null);
    $controller->error('Your information is incorrect, please login again', U('Login/index'));
}

function sendSMS($mobile,$content)
{
    $post_data = array();
    $post_data['userid'] = 10611;
    $post_data['account'] = 'yyyan';
    $post_data['password'] = '123456';
    $post_data['content'] = $content;
    $post_data['mobile'] = $mobile;
    $post_data['sendtime'] = '0'; //不定时发送，值为0，定时发送，输入格式YYYYMMDDHHmmss的日期值
    $url='http://webservice.duanxin10086.com/enterprise/db2.0/sms.ashx?action=send';
    $o='';
    foreach ($post_data as $k=>$v)
    {
        $o.="$k=".urlencode($v).'&'; //短信内容需要用urlencode编码下
    }
    $post_data=substr($o,0,-1);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
    $result = curl_exec($ch);
    return $result;
}

function test() {
    echo 'test function';
}