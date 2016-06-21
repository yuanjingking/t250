<?php
class BrandsController extends RootController{
   
   public function indexAction(){
	$brandModel = new BrandModel();
	
	$result = $brandModel->getBrands($_GET);
	print_r(json_encode($result));
   }
}
?>
