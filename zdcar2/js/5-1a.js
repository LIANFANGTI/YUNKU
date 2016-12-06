// JavaScript Document
ShowChart()
function ShowChart(){
	var myChart = echarts.init(document.getElementById('Charts1'));
	var Sdate=document.getElementById("StartDate").value
	var Edate=document.getElementById("EndDate").value
	//alert("开始时间:"+Sdate+"\n结束时间:"+Edate)
	$.post("ajax.php",{cp:1001,Sdate:Sdate,Edate:Edate,atype:"chart"},function(data,aaa){
			SetDate(eval(cut(data,"[json]","[/json]")),cut(data,"[date]","[/date]"),cut(data,"[CompanyName]","[/CompanyName]"))
			myChart.setOption(option);
	    }
	);
}

function SetDate(JsonData,DateQujian,CompanyName){
		var billdate=[],billct=[],byye= [];
		for(i=0;i<JsonData.length;i++){
			billdate[i]=JsonData[i]["date1"];
			billct[i]=JsonData[i]["ct"];
			byye[i]=JsonData[i]["yye"];
		}
		 option = {
				title:{  //标题
						text:CompanyName+DateQujian+'营业额统计图',    //主标题
						//subtext:'副标题'  //副标题
				      },
				tooltip : {    //鼠标移上去的时候显示的数字
				      show:1, //控制显示或隐藏
					  trigger: 'axis',  //item 显示当前  axis 显示所有
					  triggerOn:'mousemove' //触发事件   click 单击时触发
						 },
								toolbox: {  //工具栏
									show : 1,
									feature : {
									mark : {show:1},
									dataView : {
												 show: true,
												 readOnly: 0,//只读（文本框是否可编辑）
											   },
									magicType: {show: true,  type: ['line', 'bar', 'stack', 'tiled']},//Type 四个属性 分别为  折线图  柱形图 堆叠模式 平铺模式
									restore : {show: true}, //配置项还原
									saveAsImage : {show: true} //保存为图片
									}
								},
							calculable :true,
							legend: {
								show:true,  //图例显示
								zlevel:12,  //Z_INDEX属性
								data:['营业额','订单数'], //看不懂！！！！！！！！！！！！！！！！！！！！！
								itemGap:5 //两个图例之间的距离
								
							},
							grid: { //直角坐标系
								top: '15%',  //上边距
								left: '1%', //左边距
								right: '10%',//右边距
								containLabel: true //坐标区域是否包含该标签
							},
							xAxis: [  //X轴数据
								{
									type : 'category',   //数据类型 数值轴：value  类目轴category  时间轴time  对数轴log
									data : billdate   //数据源
								}
							], 
							yAxis: [  //Y轴数据
								 {
									type : 'value', //数值类型
									name : '营业额',
									axisLabel: {
										formatter: function (a) {
											a = +a;
											return isFinite(a)
												? echarts.format.addCommas(+a / 1)
												: '';
										}
									}
								}
							],
							dataZoom: [
								{
									show: true,   
									start: 0,
									end: 100,
									handleSize: 10
								},
								{
									type: 'inside',
									start: 50,
									end: 100
								},
								{
									show: true,
									yAxisIndex: 0,
									filterMode: 'empty',
									width: 12,
									height: '70%',
									handleSize: 8,
									showDataShadow: true,
									left: '93%'
								}
							],
							series : [
								{
									name: '营业额',
									type: 'line',
									data: byye,
									//smooth:true
									
								}
							],
							color:[
								'#ff8ed0','#19abff'
							]
						};
	
}

