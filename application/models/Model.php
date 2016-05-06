<?php

class ModelModel extends Zend_Db_Table_Abstract {


	private $db;
    
  protected $_name = 'moto_model';

  protected $_primary = 'id';

  public function __construct(){
      $this->db = Yaf_Registry::get("db");
      parent::__construct(); 
  }

  public  function getModelByParamLinkModelId($param_link_model_id){
       $sql = "SELECT id, name, year from `moto_model`  WHERE id = $param_link_model_id";
      $result = $this->db->query($sql);
      return $result->fetchAll();
  }
  
  public  function getModels($where=null){
    $select = Yaf_Registry::get("db")->select();
    $select->from($this->_name,'*');
    if(isset($where['brand_id']))
    $select->where('brand_id =  ?',$where['brand_id']);
    if(isset($where['cat_id']))
    $select->where('cat_id =  ?',$where['cat_id']);
    if(isset($where['year']))
    $select->where('year =  ?',$where['year']);
    if(isset($where['name_cn']))
    $select->where('name_cn like ? ','%'.$where['name_cn'].'%');

    if(isset($_GET['limit']))
    $select->limit($_GET['limit'],$_GET['offset']);
    $result=Yaf_Registry::get("db")->fetchAll($select);
    return $result;
  }
  
  public  function getQitaModels($where=null){
    $select = Yaf_Registry::get("db")->select();
    $select->from($this->_name,'*');
    if(isset($where['brand_id']))
    $select->where('brand_id =  ?',$where['brand_id']);
    if(isset($where['cat_id']))
    $select->where('cat_id =  ?',$where['cat_id']);
    if(isset($where['year']))
    $select->where('year !=  ?',$where['year']);
    if(isset($where['name_cn']))
    $select->where('name_cn like ? ','%'.$where['name_cn'].'%');
    if(isset($_GET['limit']))
    $select->limit($_GET['limit'],$_GET['offset']);
    $result=Yaf_Registry::get("db")->fetchAll($select);
    return $result;
  }
  
}
