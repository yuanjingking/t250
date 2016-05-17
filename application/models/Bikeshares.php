<?php

 class BikesharesModel extends Zend_Db_Table_Abstract {



 	protected $_name = 'bike_shares';


 	protected $_primary = 'id';
    
    public  function getBikeshare($id){
		  $select = Yaf_Registry::get("db")->select();
		  $select->from($this->_name,'*');
		  $select->where("id = ?",$id);
		  return Yaf_Registry::get("db")->fetchRow($select);
    }

    public  function getBikeShareClickNum($user_id, $bike_id){
		  $select = Yaf_Registry::get("db")->select();
		  $select->from($this->_name,'*');
		  $select->where("user_id = ?", $user_id);
		  $select->where("bike_id = ?", $bike_id);
		  $result =  Yaf_Registry::get("db")->fetchRow($select);
		  return $result['click_num'];
    }
}
