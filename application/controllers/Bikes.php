<?php
class BikesController extends RootController{
   

   public function infoAction(){
       $bikeModel = new BikeModel();
   	   $id = $this->getRequest()->getParam('id');
       if($_SERVER['REQUEST_METHOD']=='GET'){
         $sysconfigsModel = new SysconfigsModel();
         $same_price_scale = $sysconfigsModel->getSamePriceScale();
         $same_level_scale = $sysconfigsModel->getSameLevelScale();

         $bike = $bikeModel->getBikeById($id);
         if(is_null($bike['param_link_model_id'])){
           $bike['param_link_model_id'] = 0;
         }
         $bike['price_range_min'] = $bikeModel->priceRangeMinByParamLinkModelId($bike['param_link_model_id']);
         $bike['price_range_max'] = $bikeModel->priceRangeMaxByParamLinkModelId($bike['param_link_model_id']);
         $bike['sameprice'] = $bikeModel->getSamepriceByPriceSamePriceScale($id, $bike['price'],$same_price_scale);
         $bike['samelevel'] = $bikeModel->getSamelevelByDisplacementSameLevelScaleCategoryId($id,$bike['displacement'],$same_level_scale,$bike['category_id']);

         $imagesModel = new ImagesModel();
         $bike['image_url'] = $imagesModel->getImageUrlByBikeId($bike['id']);

         $modelModel = new ModelModel();
         $bike['param_link_model'] =$modelModel->getModelByParamLinkModelId($bike['param_link_model_id']);

         $merchantsModel = new MerchantsModel();
         $bike['merchant'] = $merchantsModel->getMerchantByMerchantNum($bike['merchant_num']);

         //判断是否显示最低价
         if(isset($wechat_user_id)){
           $wechat_user_id = $this->getRequest()->getParam('wechat_user_id');
           if($this->checkoutShareClick($wechat_user_id, $id)){
             $bike['min_price'] = '点击微信右上角分享后可查看';
           }
         }

         print_r(json_encode($bike));
       }else if($_SERVER['REQUEST_METHOD']=='PUT'){
         $data = Auth::checkAutch();
         $bikeModel->updateBikeById($id,$data);
         $bike = $bikeModel->getBikeById($id);
         print_r(json_encode($bike));
       }else if($_SERVER['REQUEST_METHOD']=="DELETE"){
         Auth::checkAutch();
         $bikeModel->deleteBikeById($id);
         $arr['action'] = 'success';
         print_r(json_encode($arr));
       } 

   }
	
   public function indexAction(){
      $bikeModel = new BikeModel();
      if($_SERVER['REQUEST_METHOD']=='GET'){
  		   $result  = $bikeModel->getBikes($_GET);
   		   echo json_encode($result);
      }else{
         Auth::checkAutch();
         try{
            if(!isset($_POST['displacement'])){
               $mdetailModel =   new MdetailModel();
               if(isset($_POST['param_link_model_id']))
               $_POST['displacement'] = $mdetailModel->getDisplacementByModelId($_POST['param_link_model_id']);; 
            }
            $result = $bikeModel->addBike($_POST);
            if(!$result['status']) throw new Exception($result['data']);
            $bike = $bikeModel->getBikeById($result['data']);
            print_r(json_encode($bike));
         }catch(Exception $e){
            print_r($e->getMessage());
         }
      }
   }  

 

   public function uploadAction(){
      Auth::checkAutch();
      $upload = new Zend_File_Transfer_Adapter_Http();
      $files = $upload->getFileInfo();
      $result['status'] = true;
      $data = array();
      foreach ($files as $file => $info) {
        $filename = md5($info['name'].time().$file).'.'.pathinfo($info['name'], PATHINFO_EXTENSION);
        //$filename = $info['name'];
        $key = '/www/upload/'.$filename;
        $upload->addFilter('Rename',$key);
        //$upload->addValidator('Size', false, array('max' => 2097152));
        //$upload->addValidator('Extension',false,'image/gif','image/jpeg');
        if (!$upload->isUploaded($file)) {
           $result['action']= "failed";
        }
        if (!$upload->isValid($file)) {
           $result['action']= "failed";
        }
        $upload->receive($file);
        $result['filename'] = $filename;
      }
      $result['action'] = "success";
      print_r(json_encode($result));
   }

   // /bikes/{id}/images
   public function imagesAction(){
      if($_SERVER['REQUEST_METHOD']=='GET'){
        $id = $this->getRequest()->getParam('id');
        $imagesModel = new ImagesModel();
        $result = $imagesModel->getImagesByBikeId($id);
        print_r(json_encode($result));
      }else{
        $data = Auth::checkAutch();
        $sysconfigsModel = new SysconfigsModel();
        $images_base_url = $sysconfigsModel->getImagesBaseUrl();
        $data['image_url'] = $images_base_url.$data['name'];
        $imagesModel = new ImagesModel();
        $result = $imagesModel->addImage($data);
        if($result){
          $arr['action'] = 'success';
        }else{
          $arr['action'] = 'false';
        }
        print_r(json_encode($arr));
      }
   		 
   }

    public function deleteimagesAction(){
      $data = Auth::checkAutch();
      $id = $this->getRequest()->getParam('id');
      $imagesModel = new ImagesModel();

      if($_SERVER['REQUEST_METHOD']=='PUT'){
        $imagesModel->updateImageById($id,$data);
        $arr['action'] = 'success';
        print_r(json_encode($arr));
      }else{
        $imagesModel ->deleteImageById($id);
        $arr['action'] = 'success';
        print_r(json_encode($arr));
      }
   }

   private function checkoutShareClick($wechat_user_id, $bike_id){
      $bikeshareModel = new BikesharesModel();
      $bike_share_click_num = $bikeshareModel->getBikeShareClickNum($wechat_user_id, $bike_id);

      $sysconfigsModel = new SysconfigsModel();
      $share_base_num =  $sysconfigsModel->getShareBaseNumber();

      if($bike_share_click_num > $share_base_num){
        return true;
      }else{
        return false;
      }
   }
}
?>
