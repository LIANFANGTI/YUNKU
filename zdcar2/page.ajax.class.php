<?php  
    class Page2{  
          private $total;      //总记录  
          private $pagesize;    //每页显示多少条  
          private $limit;          //limit  
          private $page;           //当前页码  
          private $pagenum;      //总页码  
          private $url;           //地址  
          private $bothnum;      //两边保持数字分页的量
		  private $SearchVal;      //查找值
		  private $_page="";  
    
      //构造方法初始化  
      public function __construct($_total, $_pagesize,$NowPage,$SearchVal) {  
         $this->total = $_total ? $_total : 1;  
         $this->pagesize = $_pagesize;  
         $this->pagenum = ceil($this->total / $this->pagesize);  
         $this->page = $NowPage; 
		 $this->SearchVal=$SearchVal;
         if($this->page>1){
			 $this->limit = "LIMIT ".($this->page-1)*$this->pagesize.",".$this->pagesize."";  
		 }else{
			 $this->limit = "LIMIT ".(1-1)*$this->pagesize.",".$this->pagesize."";  
		 }
         $this->url = $this->setUrl();  
         $this->bothnum = 2;  
      }  
    
      //拦截器  
      public function limit1() {  
         return $this->limit;  
      }  
    
      //获取当前页码  
      public function setPage($npage) {  
         if (!empty($npage)) {  
                if ($npage > 0) {  
                   if ($npage > $this->pagenum) {  
                          return $this->pagenum;  
                   } else {  
                          return $npage;  
                   }  
                } else {  
                   return 1;  
                }  
         } else {  
                return 1;  
         }  
      }   
    
      //获取地址  
      private function setUrl() {  
         $_url = $_SERVER["REQUEST_URI"];  
         $_par = parse_url($_url);  
         if (isset($_par['query'])) {  
                parse_str($_par['query'],$_query);  
                unset($_query['page']);  
                $_url = $_par['path'].'?'.http_build_query($_query);  
         }  
         return $_url;  
      }     //数字目录  
      private function pageList() {  
	  $_pagelist ="";
         for ($i=$this->bothnum;$i>=1;$i--) {  
            $_page = $this->page-$i;  
            if ($_page < 1) continue;  
                $_pagelist .= ' <a class="btn btn-info btn-xs" href="javascript:khcx(\''.$this->SearchVal.'\','.$_page.')">'.$_page.'</a> ';  
         }  
         $_pagelist .= ' <span class="btn btn-danger btn-xs disabled">'.$this->page.'</span> ';  
         for ($i=1;$i<=$this->bothnum;$i++) {  
            $_page = $this->page+$i;  
                if ($_page > $this->pagenum) break;  
                $_pagelist .= ' <a class="btn btn-info btn-xs"  href="javascript:khcx(\''.$this->SearchVal.'\','.$_page.')">'.$_page.'</a> ';  
         }  
         return $_pagelist;  
      }  
    
      //首页  
      private function first() {  
         if ($this->page > $this->bothnum+1) {  
                return ' <a class="btn btn-info btn-xs"  href="javascript:khcx(\''.$this->SearchVal.'\','.(1).')">1</a> ...';  
         }  
      }  
    
      //上一页  
      private function last() {  
         if ($this->page == 1) {  
                return '<span class="btn btn-info btn-xs disabled">上一页</span>';  
         }  
		 $urla="javascript:khcx('".$this->SearchVal."',".($this->page-1).")";
         return ' <a  class="btn btn-info btn-xs" href='.$urla.'>上一页</a> ';  
      }  
    
      //下一页  
      private function next1() {  
         if ($this->page == $this->pagenum) {  
                return '<span class="btn btn-info btn-xs disabled">下一页</span>';  
         }  
		 $urla="javascript:khcx('".$this->SearchVal."',".($this->page+1).")";
         return ' <a class="btn btn-info btn-xs" href='.$urla.' >下一页</a> ';  
		 //href="'.$this->url.'?&page='.($this->page+1).'"
      }  
    
      //尾页  
      private function endp() {  
			
         if ($this->pagenum - $this->page > $this->bothnum) {  
				$urla="javascript:khcx('".$this->SearchVal."',".$this->pagenum.")";
                return ' ...<a class="btn btn-info btn-xs" href="'.$urla.'">'.$this->pagenum.'</a> ';  
         }  
      }  
    
      //分页信息  
      public function showpage() { 
	  $_page=""; 
         $_page .= $this->first();  
         $_page .= $this->pageList();  
         $_page .= $this->endp();  
         $_page .= $this->last();  
         $_page .= $this->next1();  
         return $_page;  
      }  
 } 
 /*使用说明
 $_page = new Page($_total,$_pagesize); //其中 $_total 是数据集的总条数,$_pagesize 是每页显示的数量.  
 
 */ 
?>  