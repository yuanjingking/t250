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
          $image['image_thumb_url'] = @$data['image_thumb_url'];
          $image['image_medium_url'] = @$data['image_medium_url'];
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
      $sql = " SELECT image_url FROM `moto_images` WHERE moto_bike_id = $id and category=1 and main_pic=1";
      $result = $this->db->query($sql);
      $data = $result->fetch();
      return $data['image_url'];
  }

  public  function getImageThumbUrlByBikeId($id){
      $sql = " SELECT image_thumb_url  FROM `moto_images` WHERE moto_bike_id = $id and category=1 and main_pic=1";
      $result = $this->db->query($sql);
      $data = $result->fetch();
      return $data['image_thumb_url'];
  }
  
  public function deleteImageById($id){
      // 清除文件
      $sql = " SELECT name FROM `moto_images` WHERE id = $id";
      $result = $this->db->query($sql);
      $row = $result->fetch();
      $file = "/www/upload/".$row['name'];
      unlink($file);
      $image_medium_file = "/www/upload/medium/".$row['name'];
      unlink($image_medium_file);
      $image_thumb_file = "/www/upload/thumbnail/".$row['name'];
      unlink($image_thumb_file);

      $where = Yaf_Registry::get("db")->quoteInto('id = ?',$id);
      $this->delete($where);
  }

  // 删除关联图片
  public function deleteImageByBikeId($id){
      $sql = " SELECT name FROM `moto_images` WHERE moto_bike_id = $id";
      $result = $this->db->query($sql);
      $rows = $result->fetchAll();
      foreach($rows as $r){
        $file = "/www/upload/".$r['name'];
        unlink($file);
        $image_medium_file = "/www/upload/medium/".$r['name'];
        unlink($image_medium_file);
        $image_thumb_file = "/www/upload/thumbnail/".$r['name'];
        unlink($image_thumb_file);
      }

      $where = Yaf_Registry::get("db")->quoteInto('moto_bike_id = ?',$id);
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
