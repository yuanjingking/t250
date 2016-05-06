<?php

 class UsersModel extends Zend_Db_Table_Abstract {



 	protected $_name = 'users';


 	protected $_primary = 'id';
    
  public  function getUserByNamePassword($name,$password){
      $select = Yaf_Registry::get("db")->select();
      $select->from($this->_name,'*');
      $select->where("name = ?",$name);
      $select->where("password = ?",$password);
      return Yaf_Registry::get("db")->fetchRow($select);
  }
}
