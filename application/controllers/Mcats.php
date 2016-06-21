<?php
class McatsController extends RootController{
   
   public function indexAction(){
	$mcatModel = new McatModel();
	
	$result = $mcatModel->getMcats($_GET);
	print_r(json_encode($result));
   }
}
?>
