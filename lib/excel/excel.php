<?php
  //向xls文件写入内容
  ini_set('display_errors','On');
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);  
  require_once 'Classes/PHPExcel.php';      
  require_once 'Classes/PHPExcel/IOFactory.php';  
  //$data:xls文件内容正文
  //$title:xls文件内容标题
  //$filename:导出的文件名
  //$data和$title必须为utf-8码，否则会写入FALSE值
 function write_xls($data=array(), $title=array(), $filename='report'){
    $objPHPExcel = new PHPExcel();
    //设置文档属性，设置中文会产生乱码，需要转换成utf-8格式！！
    // $objPHPExcel->getProperties()->setCreator("云舒")
               // ->setLastModifiedBy("云舒")
               // ->setTitle("产品URL导出")
               // ->setSubject("产品URL导出")
               // ->setDescription("产品URL导出")
               // ->setKeywords("产品URL导出");
    $objPHPExcel->setActiveSheetIndex(0);
     
  $cols = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //设置www.jb51.net标题
    for($i=0,$length=count($title); $i<$length; $i++) {
      //echo $cols{$i}.'1';
      $objPHPExcel->getActiveSheet()->setCellValue($cols{$i}.'1', $title[$i]);
    }
    //设置标题样式
    $titleCount = count($title);
    $r = $cols{0}.'1';
    $c = $cols{$titleCount}.'1';
     $objPHPExcel->getActiveSheet()->getStyle("$r:$c")->applyFromArray(
      array(
        'font'  => array(
          'bold'   => true
        ),
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        ),
        'borders' => array(
          'top'   => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
          )
        ),
        'fill' => array(
          'type'    => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
          'rotation'  => 90,
          'startcolor' => array(
            'argb' => 'FFA0A0A0'
          ),
          'endcolor'  => array(
            'argb' => 'FFFFFFFF'
          )
        )
      )
    );
 
    $i = 0;
	//print_r($data);
   foreach($data as $d) {
	$j=0;
	foreach($d as $v){
		$objPHPExcel->getActiveSheet()->setCellValue($cols{$j}.($i+2), $v);
		$j++;
	}
	$i++;
   }   
	  
    
    
    
   header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
    header('Cache-Control: max-age=0');
 
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
  }
    $array = array(
    array(1,'名称','品牌','商品名','http://www.jb51.net'),
    array(2,'名称','品牌','商品名','http://www.jb51.net'),
    array(3,'名称','品牌','商品名','http://www.jb51.net'),
    array(4,'名称','品牌','商品名','http://www.jb51.net'),
    array(5,'名称','品牌','商品名','http://www.jb51.net'),
  );
  write_xls($array,array('商品id','供应商名称','品牌','商品名','URL'),'report');
    
?>