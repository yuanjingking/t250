<?php
class UsersController extends RootController{
   

   public function indexAction(){
      try{
         $name = $_REQUEST['name'];
         $password = $_REQUEST['password'];
         $usersModel = new UsersModel();
         $result = $usersModel->getUserByNamePassword($name,$password);
         if($result){
            $arr['action'] = 'success';
         }else{
            $arr['action'] = 'failed';
         }
         echo json_encode($arr);
         
      }catch(Exception $e){
         echo $e->getMessage();
      }
   }
	
}
?>