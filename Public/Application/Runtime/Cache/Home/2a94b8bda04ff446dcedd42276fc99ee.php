<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>功能选择</title>
		<link rel="stylesheet" href="/Public/Public/css/indexIndex.css" />
	</head>
	<body>
		<div class="container">
			<a href="<?php echo U('Power/index');?>">
			<div class="label">
				电源状态信息
			</div>
			</a>
			<a href="<?php echo U('Protection/index');?>">
			<div class="label">
				阴极保护信息
			</div>
			</a>
            <a href="<?php echo U('Listening/index');?>">
            <div class="label">
                测量控制台
            </div>
            </a>
			<a href="#">
			<div class="label">
				信息录入
			</div>
			</a>
		</div>
	</body>
</html>