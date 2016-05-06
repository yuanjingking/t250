<?php
header("Content-type:text/html;charset=utf-8");
class Controller_IndexModel extends Yaf_Controller_Abstract {
   
   public function init() {
   		if(isset($_SESSION['user']['uid'])){
   			$this->getView()->assign('isLogin',true);
   		}else{
			$this->getView()->assign('isLogin',false);
   		}
   }
}
?>