//Get the context of the canvas element we want to select
function lineChart() {

        var ctx = document.getElementById("yyeqs").getContext("2d") //对象初始化
		var col={}
		col= ["2014-10", "2014-11", "2014-12", "2015-1", "2015-2", "2015-4"]
		/*数据赋值*/
        var data = {
            labels:col,
            datasets: [{
                label: "",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(0,102,51,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#339933",
                pointHighlightFill: "#339933",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [1.27, 1.30, 1.30, 1.41, 1.04, 1.29]
            },{
                label: "数据2",
                fillColor: "rgba(100,220,220,0.2)",
                strokeColor: "rgba(100,102,51,1)",
                pointColor: "rgba(100,220,220,1)",
                pointStrokeColor: "#339933",
                pointHighlightFill: "#339933",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [5, 8, 2, 1, 6, 3]
            }],
        };

        var salesVolumeChart = new Chart(ctx).Line(data, {
            bezierCurveTension: 0.4,  /*线条样式控制 0是折线 0.4是曲线*/
            bezierCurve: false, 	  /*关闭或开启曲线*/
            tooltipTemplate: "<%if (label){%><%=label%> 销量：<%}%><%= value %>万辆", /*折线顶点文字提示*/
            //自定义背景小方格、y轴每个格子的单位、起始坐标
            scaleOverride: true,
            scaleSteps: 10,     /*Y轴总单元数*/
            scaleStepWidth: 0.5, /*Y轴步长*/
            scaleStartValue: 1 /*Y轴起点*/
        });
    }



    function barChart() {
        var ctx = document.getElementById("myChart2").getContext("2d")
        var data = {
            labels: ["2014-10", "2014-11", "2014-12", "2015-1", "2015-2", "2015-3"], //X轴刻度
            datasets: [{
                label: "",  
                fillColor: "rgba(153,204,153,0.5)",/*条子背景色*/
                strokeColor: "rgba(0,102,51,1)",/*边框色*/
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#338033",
                pointHighlightFill: "#338033",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [1.27, 1.30, 1.30, 1.41, 1.04, 1.29]  //对应值

            }]

        };
		/*样式控制*/
        var salesVolumeChart = new Chart(ctx).Bar(data, {
            tooltipTemplate: "<%if (label){%><%=label%> 销量：<%}%><%= value %>万辆"// 点击的小提示
        });

    }
	/*雷达图*/
    function RadarChart() {
        var ctx = document.getElementById("myChart3").getContext("2d")
		var data = {
			labels : ["数据1","数据2","数据3","数据4","数据5","数据6","数据7"],
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : [65,59,90,81,56,55,40]
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : [28,48,40,19,96,27,100]
				}
			]
		 }
		/*样式控制*/
        var salesVolumeChart = new Chart(ctx).Radar(data, {
			scaleOverlay : false,
			scaleOverride : false,
			scaleSteps : null,
			scaleStepWidth : null,
			scaleStartValue : null,
			scaleShowLine : true,
			scaleLineColor : "rgba(0,0,0,.1)",
			scaleLineWidth : 1,
			scaleShowLabels : false,
			scaleLabel : "<%=value%>",
			scaleFontFamily : "'Arial'",
			scaleFontSize : 12,
			scaleFontStyle : "normal",
			scaleFontColor : "#666",
			scaleShowLabelBackdrop : true,
			scaleBackdropColor : "rgba(255,255,255,0.75)",
			scaleBackdropPaddingY : 2,	
			scaleBackdropPaddingX : 2,
			angleShowLineOut : true,
			angleLineColor : "rgba(0,0,0,.1)",
			angleLineWidth : 1,	
			pointLabelFontFamily : "'Arial'",
			pointLabelFontStyle : "normal",
			pointLabelFontSize : 12,
			pointLabelFontColor : "#666",
			pointDot : true,
			pointDotRadius : 3,
			pointDotStrokeWidth : 1,
			datasetStroke : true,
			datasetStrokeWidth : 2,
			datasetFill : true,
			animation : true,
			animationSteps : 60,
			animationEasing : "easeOutQuart",
			onAnimationComplete : null,
			tooltipTemplate: "<%if (label){%><%=label%> 销量：<%}%><%= value %>万辆"// 点击的小提示
        });

    }
	/*饼图*/	
    function PieChart() {
        var ctx = document.getElementById("myChart4").getContext("2d")	
		var data = [
			{value: 30,color:"#F38630"},
			{value : 50,color : "#E0E4CC"},
			{value : 100,color : "#69D2E7"}			
		]	
		
		var salesVolumeChart = new Chart(ctx).Pie(data, {
			segmentShowStroke : true,
			segmentStrokeColor : "#fff",
			segmentStrokeWidth : 2,
			animation : true,
			animationSteps : 100,
			animationEasing : "easeOutBounce",
			animateRotate : true,
			animateScale : false,
			onAnimationComplete : null
		})	
}

	/*环形图*/	
    function HuanChart() {
        var ctx = document.getElementById("myChart5").getContext("2d")	
		var data = [
		
			{value: 30,color:"#F38630"},
			{value : 50,color : "#E0E4CC"},
			{value : 100,color : "#69D2E7"}			
		]	
		
		var salesVolumeChart = new Chart(ctx).Doughnut(data, {
			segmentShowStroke : true,
			segmentStrokeColor : "#fff",
			segmentStrokeWidth : 2,
			percentageInnerCutout : 50,
			animation : true,
			animationSteps : 100,
			animationEasing : "easeOutBounce",
			animateScale : false,
			onAnimationComplete : null,
			tooltipTemplate: "<%if (label){%><%=label%> 销量：<%}%><%= value %>万辆"// 点击的小提示
		})	
}












    //↓ 启动时动画效果
    setTimeout(function() {lineChart();barChart();RadarChart();PieChart();HuanChart()}, 0)
	/*手机端优化代码 ↓*/
    if (/Mobile/i.test(navigator.userAgent)) {
        Chart.defaults.global.animationSteps = Chart.defaults.global.animationSteps / 6
        Chart.defaults.global.animationEasing = "linear"
    }
