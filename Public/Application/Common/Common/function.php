<?php
function check_verfiy($code, $id='') {
	$verfiy = new \Think\Verify();
	//echo $code;
	return $verfiy->check($code, $id);
}