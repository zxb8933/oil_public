<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/6
 * Time: 21:06
 */

namespace Home\Controller;
use Think\Controller;

class Setting extends BaseController {
    function _initialize() {
        //判断权限，获取相应list
    }

    function index() {
        $this->display();
    }

    private function setLine() {
        //line trigger: no update;
        $condition['line_id'] = I('lineId', 0, 'htmlspecialchars');
        $data['line_name'] = I('lineName', 0, 'htmlspecialchars');
        $line = M('line');
        if(check0($condition) && check0($data)) {
            $line->where($condition)->setField($data);
        }
        elseif(!check0($condition) && check0($data)) {
            $line->add($data);
        }
        else {
            //错误提示
        }
    }

    private function setCompany() {
        //company trigger: no update;
        $condition['company_id'] = I('companyId', 0, 'htmlspecialchars');
        $data['companyNo'] = I('companyNo', 0, 'htmlspecialchars');
        $data['companyName'] = I('companyName', 0, 'htmlspecialchars');
        $data['company_parent_id'] = I('company_parent_id', 0, 'htmlspecialchars');
        $company = M('company');
        if(check0($condition) && check0($data)) {
            $company->where($condition)->setField($data);
        }
        elseif(!check0($condition) && check0($data)) {
            $company->add($data);
        }
        else {
            //错误提示
        }
    }

    private function setTester() {
        //tester trigger:
        //on delete -> (power,testpoint)=>set(tester_id=0);
        //on create -> (company)=>check(company_id);
        //on update -> (company)=>check(company_id);
        $condition['tester_id'] = I('tester_id', 0, 'htmlspecialchars');
        $data['tester_no'] = I('tester_no', 0, 'htmlspecialchars');
        $data['tester_realname'] = I('tester_realname', 0, 'htmlspecialchars');
        $data['tester_sex'] = I('tester_sex', 0, 'htmlspecialchars');
        $data['tester_birth'] = I('tester_birth', 0, 'htmlspecialchars');
        $data['tester_phone'] = I('tester_phone', 0, 'htmlspecialchars');
        $data['tester_email'] = I('tester_email', 0, 'htmlspecialchars');
        $data['tester_company_id'] = I('tester_company_id', 0, 'htmlspecialchars');
        $data['tester_permission'] = I('tester_permission', 0, 'htmlspecialchars');
        $tester = M('tester');
        if(check0($condition) && check0($data)) {
            $update['tester_company_id'] = $data['tester_company_id'];
            $update['tester_permission'] = $data['tester_permission'];
            $tester->where($condition)->setField($update);
        }
        elseif(!check0($condition) && check0($data)) {
            $data['tester_insert_date'] = time();
            $tester->add($data);
        }
        else {
            //错误提示
        }
    }

    private function setSite() {
        //site trigger:
        //on delete -> (power,testpoint)=>set(site_id=0);
        //on create -> (company,line)=>check(company_id,line_id);
        //on update -> (company,line)=>check(company_id,line_id);
        $condition['site_id'] = I('site_id', 0, 'htmlspecialchars');
        $data['site_id'] = I('site_id', 0, 'htmlspecialchars');
        $data['site_name'] = I('site_name', 0, 'htmlspecialchars');
        $data['site_line_id'] = I('site_line_id', 0, 'htmlspecialchars');
        $data['site_lng'] = I('site_lng', 0, 'htmlspecialchars');
        $data['site_lat'] = I('site_lat', 0, 'htmlspecialchars');
        $data['site_alt'] = I('site_alt', 0, 'htmlspecialchars');
        $data['site_company_id'] = I('site_company_id', 0, 'htmlspecialchars');
        $site = M('site');
        if(check0($condition) && check0($data)) {
            $site->where($condition)->setField($data);
        }
        elseif(!check0($condition) && check0($data)) {
            $site->add($data);
        }
        else {
            //错误提示
        }
    }

    private function setPower() {
        //power trigger:
        //on delete -> (cutout)=>set(power_id=0);
        //on create -> (site,tester)=>check(site_id,tester_id);
        //on update -> (site,tester)=>check(site_id,tester_id);
        $condition['power_id'] = I('power_id', 0, 'htmlspecialchars');
        $data['power_no'] = I('power_no', 0, 'htmlspecialchars');
        $data['power_site_id'] = I('power_site_id', 0, 'htmlspecialchars');
        $data['power_lng'] = I('power_lng', 0, 'htmlspecialchars');
        $data['power_lat'] = I('power_lat', 0, 'htmlspecialchars');
        $data['power_alt'] = I('power_alt', 0, 'htmlspecialchars');
        $data['power_model'] = I('power_model', 0, 'htmlspecialchars');
        $data['power_tester_id'] = I('power_tester_id', 0, 'htmlspecialchars');
        $data['power_vdc_rated'] = I('power_vdc_rated', 0, 'htmlspecialchars');
        $data['power_idc_rated'] = I('power_idc_rated', 0, 'htmlspecialchars');
        $power = M('power');
        if(check0($condition) && check0($data)) {
            $power->where($condition)->setField($data);
        }
        elseif(!check0($condition) && check0($data)) {
            $power->add($data);
        }
        else {
            //错误提示
        }
    }
}