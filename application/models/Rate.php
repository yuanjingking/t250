<?php

class RateModel extends Zend_Db_Table_Abstract {


    private $db;
    
    protected $_name = 'moto_rate';

    protected $_primary = 'id';

    public function __construct(){
      $this->db = Yaf_Registry::get("db");
      parent::__construct(); 
    }


  
  public  function getRatesByParamLinkModelId($param_link_model_id){
      $sql = "SELECT a.id, b.name_cn, a.rate1, a.rate2, a.rate3
FROM
  `moto_rate` AS a
LEFT JOIN
  `moto_rate_item` AS b ON b.id = a.rate_item_id
WHERE
  a.model_id = $param_link_model_id";
      $result = $this->db->query($sql);
      return  $result->fetchAll();
     
  }
  

}
