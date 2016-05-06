<?php

 class MdetailModel extends Zend_Db_Table_Abstract {


 	  private $db;
    
    protected $_name = 'moto_mdetail';

    protected $_primary = 'id';

    public function __construct(){
      $this->db = Yaf_Registry::get("db");
      parent::__construct(); 
    }

    /*
	$mdetailModel =	new MdetailModel();
	$mdetailModel->getDisplacementByModelId(1000);
    */
  public  function getDisplacementByModelId($model_id){
     $sql = "SELECT substring_index(item_value, 'c', 1) as item  FROM `moto_mdetail` WHERE mitem_id =1004 AND model_id= $model_id";
		$result = $this->db->query($sql);
		$data = $result->fetch();
		return $data['item'];
		//return $bikes;
  }

  public function getMdetailsByParamLinkModelId($param_link_model_id){
    $sql = "SELECT a.id, c.name_cn as mtitle, b.name_cn as item_cn, a.item_value
FROM
`moto_mdetail` AS a
LEFT JOIN
`moto_mitem` AS b ON b.id = a.mitem_id
LEFT JOIN
`moto_mtitle` AS c ON c.id = a.mtitle_id
WHERE
a.model_id = $param_link_model_id";
    $result = $this->db->query($sql);
    $data = $result->fetchAll();
    return $data;
    
  }
}
