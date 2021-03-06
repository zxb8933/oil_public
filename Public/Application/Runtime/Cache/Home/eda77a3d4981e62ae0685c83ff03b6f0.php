<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>电源-故障信息</title>

        <script type="text/javascript" src="http://cdn.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
        <script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/exporting.js"></script>
        <script type="text/javascript" src="/Public/Public/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/Public/Public/js/bootstrap-table.js"></script>

        <link rel="stylesheet" href="/Public/Public/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/Public/Public/css/bootstrap-table.css"/>
        <link rel="stylesheet" href="/Public/Public/css/power.css"/>

	</head>

    <body>
		<div class="title">
			故障电源信息
		</div>
	    <div id="container" class="container">
            <a href="<?php echo U('Power/index');?>"><input type="button" value="返回"></a>
            <div id="tableContainer" class="tableContainer">
                <div class="caption">故障电源信息</div>
                <table id="table" class="table_bordered"></table>
            </div>
        </div>

        <script>
            var $jep = eval(<?php echo ($jep); ?>);
            var $table = $('#table');
            $table.bootstrapTable({
                url:"",
                dataType: "json",
                pagination: false, //分页
                singleSelect: false,
                locale: "zh-US" , //表格汉化
                search: false, //显示搜索框
                sidePagination: "client", //服务端处理分页
                //uniqueId: "power_no",
                columns: [
                    {
                        title: '电源编号',
                        field: 'power_no',
                        align: 'center',
                        valign: 'middle'
                    },
                    {
                        title: '站场编号',
                        field: 'power_site_id',
                        align: 'center',
                        valign: 'middle'
                    },
                    {
                        title: '测量设备编号',
                        field: 'power_cutoutequip_id',
                        align: 'center',
                        valign: 'middle'
                    },
                    {
                        title: '经度',
                        field: 'power_lng',
                        align: 'center',
                        valign: 'middle'
                    },
                    {
                        title: '纬度',
                        field: 'power_lat',
                        align: 'center',
                        valign: 'middle'
                    },
                    {
                        title: '海拔',
                        field: 'power_alt',
                        align: 'center',
                        valign: 'middle'
                    },
                    {
                        title: '型号',
                        field: 'power_model',
                        align: 'center',
                        valign: 'middle'
                    },
                    {
                        title: '负责人编号',
                        field: 'power_tester_id',
                        align: 'center',
                        valign: 'middle'
                    },
                    {
                        title: '维护时间',
                        field: 'date',
                        align: 'center',
                        valign: 'middle'
                    }
                ],
                data: $jep
            });
        </script>
	</body>
</html>