<?php
class ModelsController extends RootController{
   

   public function indexAction(){
   		$modelModel = new ModelModel();
   		
   		$result = $modelModel->getModels($_GET);
   		if(!$result){
   			$result = $modelModel->getQitaModels($_GET);
   		}
   		print_r(json_encode($result));
   }
  	

     public function mdetailsAction(){
     	$id = $this->getRequest()->getParam('id');
         $mdetailModel = new MdetailModel();
         $result = $mdetailModel->getMdetailsByParamLinkModelId($id);
         $mtitle =array();
         $data = array();
         $result2 = array();
         foreach ($result as $key => $value) {
            $mtitle[] = $value['mtitle'];
         }
         $mtitle = array_unique($mtitle);
         foreach ($mtitle as $key => $value) {
            $data['mtitle'] = $value;
            $sub_param = array();
            foreach ($result as $key2 => $value2) {
               if($value2['mtitle']==$value){
                  $tmp['item_cn'] = $value2['item_cn'];
                  $tmp['item_value'] = $value2['item_value'];
                  $sub_param[] = $tmp;
               }
            }
            $data['sub_param'] = $sub_param;
            $result2[] =$data;
         }
         print_r(json_encode($result2));
   }

    public function ratesAction(){
    	$id = $this->getRequest()->getParam('id');
        $rateModel = new RateModel();
        $result = $rateModel->getRatesByParamLinkModelId($id);
        print_r(json_encode($result));
   }

}
?>