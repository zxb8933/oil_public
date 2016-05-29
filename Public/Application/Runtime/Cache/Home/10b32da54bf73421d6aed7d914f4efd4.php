<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>电源运行状态</title>
		<link rel="stylesheet" href="/Public/Public/css/indexIndex.css" />
	</head>
	<body>
		<div class="container">
			<a href="<?php echo U('Power/powerCurrent');?>">
                <div class="label">
                    电源实时运行状态信息
                </div>
			</a>
			<a href="<?php echo U('Power/powerDaily');?>">
                <div class="label">
                    电源运行状态日汇总信息
                </div>
			</a>
			<a href="<?php echo U('Power/powerError');?>">
                <div class="label">
                    电源故障信息
                </div>
            </a>
            <a href="<?php echo U('Index/index');?>">
                <div class="label">
                    返回首页
                </div>
			</a>
        </div>
	</body>
</html>