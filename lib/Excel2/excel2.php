<? 
Header("Content-type:   application/octet-stream"); 
Header("Accept-Ranges:   bytes"); 
Header("Content-type:application/vnd.ms-excel");   
Header("Content-Disposition:attachment;filename=".date("Y-m-d").".xls");   
$S_Data_User = "root"; 
$S_Data_Pass = "root"; 
$S_Data_Host = "localhost"; 
$S_Data_Post = "3306"; 
$conn=mysql_connect($S_Data_Host,$S_Data_User,$S_Data_Pass) or die("��������æ�����Ժ���ʣ�лл�� "); 
$select = mysql_select_db("destoon",$conn); 
mysql_query("SET character_set_connection='gbk', character_set_results='gbk', character_set_client=binary"); 
echo   "��Ʒ���"."\t"; 
echo   "��˾��"."\t"; 
echo   "����"."\t"; 
echo   "ʱ��"."\t"; 
echo   "����"."\t"; 
echo   "����"."\t"; 
echo   "����"."\t"; 
echo   "��ע"."\t"; 
echo   "\n"; 
$sql = "select * from destoon_orderlist"; 
$query_count = mysql_query($sql,$conn); 
while ($array = mysql_fetch_array($query_count)){ 
  echo "=\"".$array['id']."\""."\t"; 
  echo "=\"".$array['company']."\""."\t"; 
  echo "=\"".$array['price']."\""."\t"; 
  echo "=\"".date("H:i:s",$array['addtime'])."\""."\t"; 
  echo "=\"".$array['adddate']."\""."\t"; 
  echo "=\"".$array['tody']."\""."\t"; 
  echo "=\"".$array['city']."\""."\t"; 
  echo "=\"".$array['content']."\""."\t"; 
  echo "\n"; 

} 
?>