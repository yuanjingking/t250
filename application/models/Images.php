<?php

class ImagesModel extends Zend_Db_Table_Abstract {


	private $db;
    
  protected $_name = 'moto_images';

  protected $_primary = 'id';

  public function __construct(){
      $this->db = Yaf_Registry::get("db");
      parent::__construct(); 
  }

  public function addImage($data){
    try{
          $image['moto_bike_id'] = @$data['moto_bike_id'];
          $image['name'] = @$data['name'];
          $image['category'] = @$data['category'];
          $image['main_pic'] = @$data['main_pic'];
          $image['image_url'] = @$data['image_url'];
          $this->insert($image);
          $result['status'] = true;
          $result['data'] = Yaf_Registry::get("db")->lastInsertId();
      }catch(Exception $e){
        $result['status'] = false;
        $result['data'] = $e->getMessage();
        print_r($e->getMessage());
      }
      return $result;
  }

  public  function getImageUrlByBikeId($id){
      $sql = " SELECT image_url  FROM `moto_images` WHERE moto_bike_id = $id and category=1 and main_pic=1";
      $result = $this->db->query($sql);
      $data = $result->fetch();
      return $data['image_url'];
  }
  
  public function deleteImageById($id){
      $where = Yaf_Registry::get("db")->quoteInto('id = ?',$id);
      $this->delete($where);
  }

  public function updateImageById($id,$data){
      $set['main_pic'] = @$data['main_pic'];
      $where[] = "id = $id ";
      return $this->update($set,$where);
  }

  public function getImagesByBikeId($moto_bike_id ,$where=null){
        $select = Yaf_Registry::get("db")->select();
        $select->from($this->_name,'*');
        if(!is_null($where)){
          foreach ($where as $key => $value) {
            $select->where("$key  = ?",$value );
          }
        }
        $select->where("moto_bike_id  = ?",$moto_bike_id );
        $result=Yaf_Registry::get("db")->fetchAll($select);
        return $result;
  }
}
