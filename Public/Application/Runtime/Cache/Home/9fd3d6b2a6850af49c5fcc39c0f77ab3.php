<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>测量情况监听</title>

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
<!--<div class="title">-->
    <!--阴极保护测量控制台-->
<!--</div>-->
<div id="container" class="container">
    <a href="<?php echo U('Index/index');?>"><input type="button" value="返回"></a>
    <form id="form" class="form" action="<?php echo U('Listening/index');?>" method="post">
        <?php if(is_array($ae)): $i = 0; $__LIST__ = $ae;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div id=<?php echo ($vo["onlineequip_id"]); ?> class="volist">
                <input type="checkbox" name=<?php echo ($vo["onlineequip_id"]); ?> value=<?php echo ($vo["onlineequip_phone"]); ?>>
                <span>测试点ID:</span>
                <input type="text" value=<?php echo ($vo["onlineequip_testpoint_id"]); ?> disabled>
                <span>设备编号:</span>
                <input type="text" value=<?php echo ($vo["onlineequip_no"]); ?> disabled>
                <span>通信手机号:</span>
                <input type="text" value=<?php echo ($vo["onlineequip_phone"]); ?> disabled>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <input type="submit" value="开始测量">
    </form>
    <div id="tableContainer" class="tableContainer">
        <div class="caption">测量信息</div>
        <table id="table" class="table_bordered"></table>
    </div>
</div>

<script>
    var $jt = eval(<?php echo ($jt); ?>);
    var data = [];
    var key = 0;
    for(var equip_id in $jt) {
        data[key] = $jt[equip_id];
        key++;
    }
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
                title: '序号',
                field: 'no',
                align: 'center',
                valign: 'middle'
            },
            {
                title: '设备编号',
                field: 'no',
                align: 'center',
                valign: 'middle'
            },
            {
                title: '经度',
                field: 'lng',
                align: 'center',
                valign: 'middle'
            },
            {
                title: '纬度',
                field: 'lat',
                align: 'center',
                valign: 'middle'
            },
            {
                title: '海拔',
                field: 'alt',
                align: 'center',
                valign: 'middle'
            },
            {
                title: '测量日期',
                field: 'date',
                align: 'center',
                valign: 'middle'
            },
            {
                title: '测量时间',
                field: 'time',
                align: 'center',
                valign: 'middle'
            },
            {
                title: 'VDC_ON',
                field: 'vdc_on',
                align: 'center',
                valign: 'middle'
            },
            {
                title: 'VDC_OFF',
                field: 'vdc_off',
                align: 'center',
                valign: 'middle'
            },
            {
                title: 'VAC_ON',
                field: 'vac_on',
                align: 'center',
                valign: 'middle'
            },
            {
                title: 'VAC_OFF',
                field: 'vac_off',
                align: 'center',
                valign: 'middle'
            },
            {
                title: 'GPS标志位',
                field: 'gps',
                align: 'center',
                valign: 'middle'
            },
            {
                title: '剩余电量',
                field: 'battery',
                align: 'center',
                valign: 'middle'
            },
            {
                title: 'END',
                field: 'end',
                align: 'center',
                valign: 'middle'
            }
        ],
        data: data
    });
</script>
</body>
</html>