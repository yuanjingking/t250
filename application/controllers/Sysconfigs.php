<?php
class SysconfigsController extends RootController{
   

   public function indexAction(){
   		$id = $this->getRequest()->getParam('id');
   		$sysconfigsModel = new SysconfigsModel();
   		$result = $sysconfigsModel->getSysconfig($id);
   		print_r(json_encode($result));
   }
  
}
?>