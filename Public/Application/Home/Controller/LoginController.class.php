<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/19
 * Time: 9:25
 */

namespace Home\Controller;
use Think\Controller;
use Think\Crypt\Driver\Think;

class LoginController extends BaseController {
    function index() {
    	
       // echo 'Welcome to oil';
        $this->display();
    }

    function login() {
    	$code = I('post.code');
    	if(!check_verfiy($code)){
    		$this->error("亲，验证码输错了哦！",$this->site_url,5);
    	}
        $condition['tester_no'] = I('no', 0, 'htmlspecialchars');
        $condition['tester_password'] = I('psw', 0, 'htmlspecialchars');

        $tester = M('tester');
       // $tester=M('user');
        $testerRes = $tester->where($condition)->select();
        if(1==count($testerRes) && 0!=$testerRes[0]['tester_permission']) {
            session(null);
            session('userInfo', $testerRes[0]);
            $this->success('login successfully!', U('Index/index'));
        }
        else {
            $this->error('can not find your information');
        }
    }

    function logout() {
        session(null);
        $this->success('logout successfully', U('Login/index'));
    }
   function verfiy(){
   	$config = array(
   			'fontSize' => 18,
   			'length' => 4,
   			'useNoise' => false,
   			'codeSet'=>'0123456789',
   	);
   	$verfiy = new \Think\Verify($config);
   	$verfiy->entry();
   }
    function test(){
    	$code = I('get.code');
    	var_dump(check_verfiy($code));
    }
}