<?php

class McatModel extends Zend_Db_Table_Abstract {


  private $db;
    
  protected $_name = 'moto_mcat';

  protected $_primary = 'id';

  public function __construct(){
      $this->db = Yaf_Registry::get("db");
      parent::__construct(); 
  }

  public  function getMcats(){
      $sql = "SELECT * from `moto_mcat`";
      $result = $this->db->query($sql);
      return $result->fetchAll();
  }
}
