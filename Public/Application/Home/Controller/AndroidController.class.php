<?php
namespace Home\Controller;

class AndroidController extends BaseController{
	function index(){
		echo $_GET['$AD'];
		//echo I('AD',0,'htmlspecialchars');
	} 
}