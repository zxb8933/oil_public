<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>电源-日汇总</title>

		<script type="text/javascript" src="http://cdn.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
        <script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/exporting.js"></script>
        <script type="text/javascript" src="/Public/Public/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/Public/Public/js/bootstrap-table.js"></script>
        <link rel="stylesheet" href="/Public/Public/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/Public/Public/css/bootstrap-table.css"/>
        <link rel="stylesheet" href="/Public/Public/css/power.css"/>

        <script type="text/javascript" src="/Public/Public/dateRangePicker/jquery.js"></script>
        <script type="text/javascript" src="/Public/Public/dateRangePicker/moment.js"></script>
        <script type="text/javascript" src="/Public/Public/dateRangePicker/daterangepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="/Public/Public/dateRangePicker/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="/Public/Public/dateRangePicker/daterangepicker-bs3.css" />
	</head>

    <body>
		<div class="title">
			电源状态信息日汇总
		</div>

	    <div id="container" class="container">
            <!--时间选择-->
            <div>
                <form id="form1" class="form" name="form1" method="post" action="<?php echo U('Power/powerDaily');?>">
                    <span>选择日期:</span><input id="daterange" name="daterange">
                    <span>电源编号:</span>
                    <select id="power" name="power" class="input"></select><label for="power"></label>
                    <input type="submit" value="查询">
                    <span><a href="<?php echo U('Power/index');?>"><input type="button" value="返回"></a></span>
                </form>
            </div>
            <!--时间选择-->

            <div id="chartV" class="chart"></div>
            <div id="chartA" class="chart"></div>
            <div id="tableContainer" class="tableContainer">
                <div class="caption">电源日汇总测量信息</div>
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

                $('input[name="daterange"]').daterangepicker();

                var $jdp = eval(<?php echo ($jdp); ?>);
                var vdc_max = [];
                var vdc_min = [];
                var vdc_avg = [];
                var idc_max = [];
                var idc_min = [];
                var idc_avg = [];
                var vdc_r = [];
                var idc_r = [];
                var time = $jdp[0]['test_date']*1000;
                //alert(time);
                for(var i=0; i<$jdp.length; i++) {
                    vdc_max.push($jdp[i]['vdc_max']);
                    vdc_min.push($jdp[i]['vdc_min']);
                    vdc_avg.push($jdp[i]['vdc_avg']);
                    idc_max.push($jdp[i]['idc_max']);
                    idc_min.push($jdp[i]['idc_min']);
                    idc_avg.push($jdp[i]['idc_avg']);
                    vdc_r.push($jdp[i]['vdc_r']);
                    idc_r.push($jdp[i]['idc_r']);
                }

                $('#table').bootstrapTable({
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
                            field: 'site_no',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '测量编号',
                            field: 'test_no',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '最大输出电压(V)',
                            field: 'vdc_max',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '最小输出电压(V)',
                            field: 'vdc_min',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '平均输出电压(V)',
                            field: 'vdc_avg',
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
                            title: '最大输出电流(mA)',
                            field: 'idc_max',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '最小输出电压(mA)',
                            field: 'idc_min',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '平均输出电流(mA)',
                            field: 'idc_avg',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '标准电流(V)',
                            field: 'idc_r',
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            title: '日期',
                            field: 'date',
                            align: 'center',
                            valign: 'middle'
                        }
                    ],
                    data: $jdp
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
                                data: eval("["+vdc_r+"]"),
//                                pointStart: Date.UTC(2010, 0, 1),
                                pointStart: time,
                                pointInterval: 24 * 3600 * 1000 // one day
                            }, {
                                name: '最大输出电压',
                                data: eval("["+vdc_max+"]"),
//                                pointStart: Date.UTC(2010, 0, 1),
                            pointStart: time,
                                pointInterval: 24 * 3600 * 1000 // one day
                            }, {
                                name: '最小输出电压',
                                data: eval("["+vdc_min+"]"),
//                                pointStart: Date.UTC(2010, 0, 1),
                            pointStart: time,
                                pointInterval: 24 * 3600 * 1000 // one day
                            }, {
                                name: '平均输出电压',
                                data: eval("["+vdc_avg+"]"),
//                                pointStart: Date.UTC(2010, 0, 1),
                            pointStart: time,
                                pointInterval: 24 * 3600 * 1000 // one day
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
                                data: eval("["+idc_r+"]"),
                                pointStart: time,
                                pointInterval: 24 * 3600 * 1000 // one day
                            }, {
                                name: '最大输出电流',
                                data: eval("["+idc_max+"]"),
                                pointStart: time,
                                pointInterval: 24 * 3600 * 1000 // one day
                            }, {
                                name: '最小输出电流',
                                data: eval("["+idc_min+"]"),
                                pointStart: time,
                                pointInterval: 24 * 3600 * 1000 // one day
                            }, {
                                name: '平均输出电流',
                                data: eval("["+idc_avg+"]"),
                                pointStart: time,
                                pointInterval: 24 * 3600 * 1000 // one day
                            }
                        ]
                    });
            });
        </script>
	</body>
</html>