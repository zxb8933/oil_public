<?php
namespace Home\Model;
use Think\Model;

class UserModel extends Model {
	public function verfiy(){
		ob_clean();
		import('ORG.Util.lmage');
		lmage::buildlmageVerfiy();
	}
}
