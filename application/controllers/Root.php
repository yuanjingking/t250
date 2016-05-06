<?php
class RootController extends Yaf_Controller_Abstract{
   

   public function init(){
   	 header("Content-type: text/html; charset=utf-8");
   	 Yaf_Dispatcher::getInstance()->disableView ();
   }
  
}
?>