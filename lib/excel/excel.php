<?php
  //��xls�ļ�д������
  ini_set('display_errors','On');
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);  
  require_once 'Classes/PHPExcel.php';      
  require_once 'Classes/PHPExcel/IOFactory.php';  
  //$data:xls�ļ���������
  //$title:xls�ļ����ݱ���
  //$filename:�������ļ���
  //$data��$title����Ϊutf-8�룬�����д��FALSEֵ
 function write_xls($data=array(), $title=array(), $filename='report'){
    $objPHPExcel = new PHPExcel();
    //�����ĵ����ԣ��������Ļ�������룬��Ҫת����utf-8��ʽ����
    // $objPHPExcel->getProperties()->setCreator("����")
               // ->setLastModifiedBy("����")
               // ->setTitle("��ƷURL����")
               // ->setSubject("��ƷURL����")
               // ->setDescription("��ƷURL����")
               // ->setKeywords("��ƷURL����");
    $objPHPExcel->setActiveSheetIndex(0);
     
  $cols = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //����www.jb51.net����
    for($i=0,$length=count($title); $i<$length; $i++) {
      //echo $cols{$i}.'1';
      $objPHPExcel->getActiveSheet()->setCellValue($cols{$i}.'1', $title[$i]);
    }
    //���ñ�����ʽ
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
    array(1,'����','Ʒ��','��Ʒ��','http://www.jb51.net'),
    array(2,'����','Ʒ��','��Ʒ��','http://www.jb51.net'),
    array(3,'����','Ʒ��','��Ʒ��','http://www.jb51.net'),
    array(4,'����','Ʒ��','��Ʒ��','http://www.jb51.net'),
    array(5,'����','Ʒ��','��Ʒ��','http://www.jb51.net'),
  );
  write_xls($array,array('��Ʒid','��Ӧ������','Ʒ��','��Ʒ��','URL'),'report');
    
?>