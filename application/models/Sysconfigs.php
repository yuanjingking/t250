<?php

 class SysconfigsModel extends Zend_Db_Table_Abstract {



 	protected $_name = 'sys_configs';


 	protected $_primary = 'id';
    
    public  function getSysconfig($id){
		  $select = Yaf_Registry::get("db")->select();
		  $select->from($this->_name,'*');
		  $select->where("id = ?",$id);
		  return Yaf_Registry::get("db")->fetchRow($select);
    }

    public  function getSamePriceScale(){
		  $select = Yaf_Registry::get("db")->select();
		  $select->from($this->_name,'*');
		  $select->where("name = ?",'same_price_scale');
		  $result =  Yaf_Registry::get("db")->fetchRow($select);
		  return $result['content'];
    }

    public function getSameLevelScale(){
    	$select = Yaf_Registry::get("db")->select();
		  $select->from($this->_name,'*');
		  $select->where("name = ?",'same_level_scale');
		  $result =  Yaf_Registry::get("db")->fetchRow($select);
		  return $result['content'];
    }

    public function getImagesBaseUrl(){
    	$select = Yaf_Registry::get("db")->select();
		  $select->from($this->_name,'*');
		  $select->where("name = ?",'images_base_url');
		  $result =  Yaf_Registry::get("db")->fetchRow($select);
		  return $result['content'];
    }
    public function getShareBaseNumber(){
    	$select = Yaf_Registry::get("db")->select();
		  $select->from($this->_name,'*');
		  $select->where("name = ?",'share_base_num');
		  $result =  Yaf_Registry::get("db")->fetchRow($select);
		  return $result['content'];
    }
}
