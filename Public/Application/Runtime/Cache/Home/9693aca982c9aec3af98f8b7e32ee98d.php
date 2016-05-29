<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>阴极保护状态</title>
		<link rel="stylesheet" href="/Public/Public/css/indexIndex.css" />
	</head>
	<body>
		<div class="container">
			<a href="<?php echo U('Protection/protectionCollection');?>">
                <div class="label">
                    管道保护率
                </div>
			</a>
			<a href="<?php echo U('Protection/protectionChart');?>">
                <div class="label">
                    阴极保护区段数据汇总
                </div>
			</a>
			<a href="<?php echo U('Protection/protectionOnPoints');?>">
                <div class="label">
                    测试点历史数据
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