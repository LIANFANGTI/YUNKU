
0.// JavaScript Document
CompanyID=document.getElementById("cp").value;

function Search(){
	S=document.getElementById("StartDate").value
	E=document.getElementById("EndDate").value
	//alert(S)
	ShowChart(S,E);
}
function ShowMonthChart(){
	Sdate=new Date(getCurrentMonthFirst());
	Edate=new Date(getCurrentMonthLast());
	S=format(Sdate);
	E=format(Edate);
	ShowChart(S,E);
}
//格式化日期
function format(date){
	return date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate()
}
//获取当前月最后一天
function getCurrentMonthLast(){
 var date=new Date();
 var currentMonth=date.getMonth();
 var nextMonth=++currentMonth;
 var nextMonthFirstDay=new Date(date.getFullYear(),nextMonth,1);
 var oneDay=1000*60*60*24;
 return new Date(nextMonthFirstDay-oneDay);
}
//获取当前月第一天
function getCurrentMonthFirst(){
 var date=new Date();
 date.setDate(1);
 return date;
}
function D_1(D){
	if(D!=""){
	A=D.split("-")
	return A[0]+"-"+A[1]+"-"+(Number(A[2])-1);
	}else{
		return ""; 
	}
}
ShowChart("","");
function ShowChart(Sdate,Edate){
	Sdate=D_1(Sdate);Edate=D_1(Edate); 
	 pageLoad(Sdate,Edate)
	  var myChart = echarts.init(document.getElementById('Charts1'));
	  var myChart2 = echarts.init(document.getElementById('Charts2'));
	  data=Ajax2({atype:"CHART",cp:CompanyID,TYPE:"pie",Sdate:Sdate,Edate:Edate});
	  printr(data)
	  myChart.setOption(SetPieData(data,Cut2(data,"CompanyName")));
	  data=Ajax2({atype:"CHART",cp:CompanyID,TYPE:"line",Sdate:Sdate,Edate:Edate});
	  data=GetJsonData(data)
	  onload(data);
}


function SetPieData(data,CompanyName){
	 var date=Cut2(data,"date")
		data=GetJsonData(data)
	  var PAYMODE=[],NUM=[],M=[];
	  for(i=0;i<data.length;i++){
			PAYMODE[i]=data[i]["PAYMODE"];
			NUM[i]=data[i]["NUM"];
			M[i]=data[i]["M"];
	  } 
	  for(i=0;i<PAYMODE.length;i++){
		switch(PAYMODE[i]){
			case "cash":PAYMODE[i]="现金收入";break;
			case "cz":PAYMODE[i]="充值收入";break;
			case "weixin":PAYMODE[i]="微信收入";break;
			case "zfb":PAYMODE[i]="支付宝收入";break;
			default:PAYMODE[i]="其他收入";break;
		} 
	  }
	  PieData=[];
	  for(i=0;i<PAYMODE.length;i++){
		  var  ARR1= new Object;
		  ARR1.name=PAYMODE[i];
		  ARR1.value=parseInt(M[i]);
		  PieData[i]=ARR1;
	  }
	 
	console.log(PieData)
	  ARR2=[
                {value:335, name:'微信',color:'#FFF'},
                {value:310, name:'2'},
                {value:274, name:'3'},
                {value:235, name:'4'},
                {value:400, name:'5'}
            ]
	console.log(ARR2)
	option = {
    backgroundColor: '#2c343c',

    title: {
        text: '收入分析图',
        left: 'center',
        top: 20,
        textStyle: {
            color: '#ccc' 
        }
    },

  series : [
        {
            name: '收入来源',
            type: 'pie',
            radius: '55%',
            data:ARR2
          
        }  ],
    
  color:['#df576f','#2f4554', '#81d741','#1caceb','#91c7ae','#749f83','#6fc5ba', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
  tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    }
};

option2 = {
    title : {
        text: CompanyName+'收入来源分析',
        subtext: date,
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient : 'vertical',
        x : 'left',
        data:PAYMODE
    },
	
    toolbox: {
        show : true,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {
                show: true, 
                type: ['pie', 'funnel'],
                option: {
                    funnel: {
                        x: '25%',
                        width: '50%',
                        funnelAlign: 'left',
                        max: 1548
                    }
                }
            },
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    series : [
        {
            name:'收入来源',
            type:'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:PieData,
            
        }
    ]
};
return option2;
}

function SetLineData(X,Y,CompanyName){ 
		DATA=Ajax2({atype:"ChartCz"})
		JSONDATA=eval(cut(DATA,"[JSON]","[/JSON]"));
		
		LoadJsonData(JSONDATA)
	
	Test= [{
        name: '支付宝',
        type: 'line',
        smooth: true,
        data: [10, 12, 21, 54, 260, 830, 710]
    },
    {
        name: '微信',
        type: 'line',
        smooth: true,
        data: [30, 182, 434, 791, 390, 30, 10]
    },
    {
        name: '现金',
        type: 'line',
        smooth: true,
        data: [1320, 1132, 601, 234, 120, 90, 20] }];
		console.log(DATA2)
		console.log(Test)
		//alert(JSONDATA.length);
		//prompt(DATA,cut(DATA,"[sql]","[/sql]"))
		
		
		option = {
				title: {
					text: CompanyName+'数据分析',
					subtext: '九月份'
				},
				tooltip: {
					trigger: 'axis'
				},
				legend: {
					data:NameArr
				},
				toolbox: {
					left: 'center',
					feature: {
						dataZoom: {
							yAxisIndex: 'none'
						},
						restore: {},
						saveAsImage: {}
					}
				},
				 dataZoom: [{
						startValue: '2014-06-01'
					}, {
						type: 'inside'
				}],
				xAxis: {
					type: 'category',
					boundaryGap: false,
					data:DATE
				},
				yAxis: {
					type: 'value'
				},
				series:Test
			};
			
			return option;
}

function DiczfName(zf){
	switch(zf){
		case "1":
			return "支付宝";
		break;
		case "2":
			return "微信";
		break;
		case "3":
			return "现金";
		break;
		case "4":
			return "银联卡";
		break;
		default:
			return "其他";
		break;
		
	}
	
}


function GetJsonData(a){
	 return eval(Cut2(a,"JSON"));
}






function onload(data){
			var json=data;
			var dated0=0,dated1=0,dated2=0,dated3=0;
			var json_SZ=[],dated=[],zje=[],X=[],Y=[],ZF=[];
		//	二维数组初始化	
			for(var i=0;i<json.length;i++){
				json_SZ[i]=new Array();
				dated[i]=new Array();
				zje[i]=new Array();
				Y[i]=new Array();
				for(var j=0;j<json.length;j++){
					json_SZ[i][j]=0;
					dated[i][j]=0;
					zje[i][j]=0;
					Y[i][j]=0;
				}
			}
		//	json数据写入二维数组中	
			for(var i=0;i<json.length;i++){
					json_SZ[i][0]=json[i].dated;
					json_SZ[i][1]=json[i].zf;
					json_SZ[i][2]=Number(json[i].zje);
			}
			
		//	单独创建时间段数组，并写入	
			for(var i=0;i<json.length;i++){X[i]=json_SZ[i][0];ZF[i]=json_SZ[i][1];}
			
		//创建类型端数组 并写入
		
			
		//	数据按zf进行分类，分别写入dated，zje二维数组，例：dated[0]为zf=0的时间数据，zje[0]为zf=0的值
			var C=[],Z=[];
			ZF=unique(ZF)//将支付方式数组去重复
			
			for(i=0;i<ZF.length;i++)Z[i]=diczf(ZF[i]); //转换中文支付方式赋值给数组Z[]
			
			for(var i=0;i<json.length;i++){
				for(var j=0;j<ZF.length;j++){
					C[ZF[i]]=0;
					if(json_SZ[i][1]==ZF[j]){
						dated[ZF[j]][C[ZF[j]]]=json_SZ[i][0];
						zje[ZF[j]][C[ZF[j]]]+=Number(json_SZ[i][2]);
						C[ZF[j]]++;
					}
				}
			}
		//	删除时间轴X相同数据，并得到相差值
			X=unique(X);var differ=json.length-X.length;
			console.log(Y)
			
		//	用时间段数组来比较各个dated数组，有，则Y读入该时间段数据zje，无，则为0(可用于该时间段数据未填充，后期可补上)
			
			for(var i=0;i<X.length;i++){
				for(var j=0;j<X.length;j++){
					for(k=0;k<ZF.length;k++){
						if(X[i]==dated[ZF[k]][j])Y[ZF[k]][i]=Number(zje[ZF[k]][j]);
					}
				}
			}
			
		//	删除多余的数组定义
			for(var i=0;i<differ;i++)for(var j=0;j<=3;j++)Y[j].pop();
			console.log(Y)
		//	传值X与Y执行图表
		
		
		   
			D=[];
			for(i=0;i<ZF.length;i++){
				var  O= new Object;
				O.name=Z[i];
				O.type='line';
				O.stack='总量';
				O.smooth=true;
				O.data=1;
				D[i]={
			            name:Z[i],
			            type:'line',
			            stack: '总量',
			            data:Y[i],
						smooth: true
			        }
			}
			echarts_par(X,D,Z);
		}
		function echarts_par(X,D,Z){
			console.log(Z)
			var myChart2 = echarts.init(document.getElementById('Charts2'));
			option = {
			    title: {
			        text: '收入分析'
			    },
			    tooltip: {
			        trigger: 'axis'
			    },
			    legend: {
			        data:Z
			    },
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '3%',
			        containLabel: true
			    },
			    toolbox: {
					show: true,
					feature: {
						magicType: {show: true, type: ['stack', 'tiled']},
						saveAsImage: {show: true}
					}
				},
				dataZoom:{
					id: 'dataZoomX',
					type: 'slider',
					xAxisIndex: [0],
					filterMode: 'filter'
        
				},
			    xAxis: {
			        type: 'category',
			        boundaryGap: false,
			        data: X
			    },
			    yAxis: {
			        type: 'value'
			    },
			    series:D
			};

			myChart2.setOption(option);
		}
		
		function diczf(a){
			switch(a){
				case "0":return "支付宝";break;
				case "1":return "微信";break;
				case "2":return "现金";break;
				case "3":return "银联";break;
				default:return "其他";break;
			}
		}


function pageLoad(S,E){
	PD=Ajax2({cp:CompanyID,atype:"PageData",Sdate:S,Edate:E}); 
	document.getElementById("yyje").innerHTML=Cut2(PD,"ZJE")+"元";
	document.getElementById("xssp").innerHTML=Cut2(PD,"ZSP")+"元";
	document.getElementById("xmxs").innerHTML=Cut2(PD,"ZXM")+"元";
	document.getElementById("hycz").innerHTML=Cut2(PD,"ZCZ")+"元";
}



































































function SetDate(JsonData,DateQujian,CompanyName){
	
	
		/*var billdate=[],billct=[],byye= [];
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
						};*/
	
}

