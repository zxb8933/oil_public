<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>电源-实时</title>

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
			电源实时状态信息
		</div>
	    <div id="container" class="container">
            <div>
                <form id="form1" class="form" name="form1" method="post" action="<?php echo U('Power/powerCurrent');?>">
                    <span>电源编号:</span>
                    <select id="power" name="power" class="input"></select><label for="power"></label>
                    <input type="submit" value="查询">
                    <span><a href="<?php echo U('Power/index');?>"><input type="button" value="返回"></a></span>
                </form>
            </div>

            <div id="chartV" class="chart"></div>
            <div id="chartA" class="chart"></div>
            <div id="tableContainer" class="tableContainer">
                <div class="caption">电源实时测量数据</div>
                <table id="table" class="table_bordered"></table>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var $jlp = <?php echo ($jlp); ?>;
                var i;
                for(i=0; i<$jlp.length; i++) {
                    document.form1.power.options[i] = new Option($jlp[i], $jlp[i]);
                }
                document.form1.power.options[0].selected = true;

                var $jcp = eval(<?php echo ($jcp); ?>);
                var vdc = [];
                var idc = [];
                var vdc_r = [];
                var idc_r = [];
                var time = $jcp[0]['test_time']*1000;
                alert(time);
                for(var i=0; i<$jcp.length; i++) {
                    vdc.push($jcp[i]['vdc']);
                    idc.push($jcp[i]['idc']);
                    vdc_r.push($jcp[i]['vdc_r']);
                    idc_r.push($jcp[i]['idc_r']);
                }

                $('#table').bootstrapTable({
                    url: "",
                    dataType: "json",
                    pagination: false, //分页
                    singleSelect: false,
                    locale: "zh-US", //表格汉化
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
                            field: 'site_no',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '输出电压(V)',
                            field: 'vdc',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '输出电流(mA)',
                            field: 'idc',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '标准电压(V)',
                            field: 'vdc_r',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '标准电流(mA)',
                            field: 'idc_r',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '测量时间',
                            field: 'time',
                            align: 'center',
                            valign: 'middle'
                        }
                    ],
                    data: $jcp
                });

                $('#chartV').highcharts({
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: '电源电压折线图',
                        x: -20 //center
                    },
                     xAxis: {
                        type: 'datetime',
                        dateTimeLabelFormats: {
                            second: '%H:%M:%S'
                        }
                    },
                    yAxis: [
                        {
                            title: {
                                text: '电压(V)'
                            }
                        }
                    ],
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    tooltip: {
                        valueSuffix: 'V'
                    },
                    series: [{
                        name: '额定电压',
                        data: eval("[" + vdc_r + "]"),
                        pointStart: time,
                        pointInterval: 10 * 60 * 1000 // one day
                    }, {
                        name: '输出电压',
                        data: eval("[" + vdc + "]"),
                        pointStart: time,
                        pointInterval: 10 * 60 * 1000 // one day
                    }
                    ]
                });
                $('#chartA').highcharts({
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: '电源电流折线图',
                        x: -20 //center
                    },
                    xAxis: {
                        type: 'datetime',
                        dateTimeLabelFormats: {
                            second: '%H:%M:%S'
                        }
                    },
                    yAxis: [
                        {
                            title: {
                                text: '电流(mA)'
                            }
                        }
                    ],
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    tooltip: {
                        valueSuffix: 'mA'
                    },
                    series: [{
                        name: '额定电流',
                        //data: [1.0000,1.0000],
                        data: eval("[" + idc_r + "]"),
                        pointStart: time,
                        pointInterval: 10 * 60 * 1000 // one day
                    }, {
                        name: '输出电流',
                        //data: [2.3459,1.1720],
                        data: eval("[" + idc + "]"),
                        pointStart: time,
                        pointInterval: 10 * 60 * 1000 // one day
                    }
                    ]
                });
            });

        </script>
	</body>
</html>