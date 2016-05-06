<?php
class MerchantsController extends RootController{
   

   public function indexAction(){
         $merchantsModel= new MerchantsModel();
         if($_SERVER['REQUEST_METHOD']=='GET'){
            $result= $merchantsModel->getMerchants();
            print_r(json_encode($result));
         }else{
            Auth::checkAutch();
            try{
               $result = $merchantsModel->addMerchant($_POST);
               if(!$result['status']) throw new Exception($result['data']);
               $merchant = $merchantsModel->getMerchantById($result['data']);
               print_r(json_encode($merchant));
               }catch(Exception $e){

               }
         }       
   }
	
   public function infoAction(){
       $id = $this->getRequest()->getParam('id');
       $merchantsModel = new MerchantsModel();
       if($_SERVER['REQUEST_METHOD']=='GET'){
         $merchant = $merchantsModel->getMerchantById($id);
         print_r(json_encode($merchant));
       }else if($_SERVER['REQUEST_METHOD']=='PUT'){
    
         $data = Auth::checkAutch();
         $merchantsModel->updateMerchantById($id,$data);

         $merchant = $merchantsModel->getMerchantById($id);
         print_r(json_encode($merchant));
       }else if($_SERVER['REQUEST_METHOD']=="DELETE"){
         Auth::checkAutch();
         $merchantsModel->deleteMerchantById($id);
         $arr['action'] = "success";
         print_r(json_encode($arr));
       } 
   }

}
?>