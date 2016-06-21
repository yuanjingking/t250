<?php

class BrandModel extends Zend_Db_Table_Abstract {


  private $db;
    
  protected $_name = 'moto_brand';

  protected $_primary = 'id';

  public function __construct(){
      $this->db = Yaf_Registry::get("db");
      parent::__construct(); 
  }

  public  function getBrands(){
      $sql = "SELECT * from `moto_brand`";
      $result = $this->db->query($sql);
      return $result->fetchAll();
  }
}
