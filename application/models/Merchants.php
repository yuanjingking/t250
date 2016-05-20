<?php

class MerchantsModel extends Zend_Db_Table_Abstract {


	private $db;
    
  protected $_name = 'moto_merchants';

  protected $_primary = 'id';

  public function __construct(){
      $this->db = Yaf_Registry::get("db");
      parent::__construct(); 
  }

  public  function getMerchantByMerchantNum($merchant_num){
       $sql = "  SELECT id, number, name from `moto_merchants` WHERE number = $merchant_num";
      $result = $this->db->query($sql);
      return $result->fetchAll();
  }

  public  function getMerchants(){
    $select = Yaf_Registry::get("db")->select();
    $select->from($this->_name,'*');
    $result=Yaf_Registry::get("db")->fetchAll($select);
    return $result;
  }
  
   public function addMerchant($data){
      try{
          $merchant['name'] = $data['name'];
          $merchant['phone'] = $data['phone'];
          $merchant['number'] = substr(date("Ymd"),2).rand(100,999);
          $this->insert($merchant);
          $result['status'] = true;
          $result['data'] = Yaf_Registry::get("db")->lastInsertId();
      }catch(Exception $e){
        $result['status'] = false;
        $result['data'] = $e->getMessage();
      }
      return $result;
    }

    public function getMerchantById($id){
        $select = Yaf_Registry::get("db")->select();
        $select->from($this->_name,'*');
        $select->where("id = ?",$id);
        $result=Yaf_Registry::get("db")->fetchRow($select);
        return $result;
    }

    public function updateMerchantById($id,$data){
        $set['name'] = $data['name'];
        $set['phone'] = $data['phone'];
        $where[] = "id = $id ";
        return $this->update($set,$where);
    }

    public function deleteMerchantById($id){
      $where = Yaf_Registry::get("db")->quoteInto('id = ?',$id);
      $this->delete($where);
    }
}
