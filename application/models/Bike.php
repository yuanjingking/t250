<?php

 class BikeModel extends Zend_Db_Table_Abstract {


 	  private $db;
    
    protected $_name = 'moto_bikes';

    protected $_primary = 'id';

    public function __construct(){
      $this->db = Yaf_Registry::get("db");
      parent::__construct(); 
    }



    
//     public function getBikes($limit=NULL){
//     	$sql = "SELECT a.id, a.number, a.name, a.year, a.brand, a.real_km, a.price, a.merchant_num, a.sale_state, a.site, a.create_time, b.image_url
// FROM
//   `moto_bikes` AS a
// LEFT JOIN
//   `moto_images` AS b ON a.id = b.moto_bike_id and b.category=1 and b.main_pic=1
// ORDER BY a.create_time DESC";
// 		$result = $this->db->query($sql);
// 		$bikes = $result->fetchAll();
// 		return $bikes;
//     }

     public function getBikes($where=null){
      if(!is_null($where))
      extract($where);
      $sql = "SELECT a.id, a.number, a.name, a.year, a.brand, a.real_km, a.price, a.merchant_num, a.sale_state, a.site, a.create_time, b.image_url
FROM
  `moto_bikes` AS a
LEFT JOIN
  `moto_images` AS b ON a.id = b.moto_bike_id and b.category=1 and b.main_pic=1
WHERE 1=1";
      if(isset($content)){
        $sql .= " and a.number like '%$content%' or REPLACE(a.name, ' ', '') like '%$content%' ";
      }
      if(isset($price_min)){
        $sql .= " a.price > $price_min ";
      }
      if(isset($price_max)){
        $sql .= " a.price > $price_max ";
      }
      if(isset($brand_id)){
        $sql .= " a.brand_id = $brand_id ";
      }
      if(isset($category_id)){
        $sql .= " a.category_id = $category_id ";
      }
      if(isset($displacement_min)){
        $sql .= " a.displacement > $displacement_min ";
      }
      if(isset($displacement_max)){
        $sql .= " a.displacement > $displacement_max ";
      }
      if(isset($year_min)){
        $sql .= " a.year > $year_min ";
      }
      if(isset($year_max)){
        $sql .= " a.year > $year_max ";
      }
      $sql .=" ORDER BY a.create_time DESC";
      $result = $this->db->query($sql);
      $bikes = $result->fetchAll();
      return $bikes;
    }

    /*
       $bikeModel = new BikeModel();;
 $bike['name'] = "BS 650 GF";
$bike['year'] = 2016;
          $bike['brand_id'] = 1037;
          $bike['brand'] = "BMW";
          $bike['category_id'] = "1002";
          $bike['category'] = "旅行车";
          $bike['param_link_model_id'] = 1001;
          $bike['real_km'] = "1万公里以上";
          $bike['displacement'] = "";
          $bike['price'] = "30000";
          $bike['min_price'] = 25000;
          $bike['view_change'] ="比如包板喷漆，车架喷漆等";
          $bike['diy'] = "比如改装排气，牛角，刹车管等";
          $bike['merchant_num'] = "1604253219";
          $bike['sale_state'] =1;
          $bike['site'] = "碣石";

$bikeModel->addBike($bike);
die(); 

    */
    public function addBike($data){
      try{
          $bike['name'] = @$data['name'];
          $bike['year'] = @$data['year'];
          $bike['brand'] = @$data['brand'];
          $bike['brand_id'] = @$data['brand_id'];
          $bike['category_id'] = @$data['category_id'];
          $bike['category'] = @$data['category'];
          $bike['param_link_model_id'] = @$data['param_link_model_id'];
          $bike['real_km'] = @$data['real_km'];
          $bike['displacement'] = @$data['displacement'];
          $bike['price'] = @$data['price'];
          $bike['min_price'] = @$data['min_price'];
          $bike['view_change'] = @$data['view_change'];
          $bike['diy'] = @$data['diy'];
          $bike['merchant_num'] = @$data['merchant_num'];
          $bike['sale_state'] = @$data['sale_state'];
          $bike['site'] = @$data['site'];
          $bike['number'] = substr(date("Ymd"),2).rand(1000,9999);
          $this->insert($bike);
          $result['status'] = true;
          $result['data'] = Yaf_Registry::get("db")->lastInsertId();
      }catch(Exception $e){
        $result['status'] = false;
        $result['data'] = $e->getMessage();
        print_r($e->getMessage());
      }
      return $result;
    }

    public function getBakeById($id){
        $select = Yaf_Registry::get("db")->select();
        $select->from($this->_name,'*');
        $select->where("id = ?",$id);
        $result=Yaf_Registry::get("db")->fetchRow($select);
        return $result;
    }

    public function priceRangeMinByParamLinkModelId($param_link_model_id){
      $sql = "SELECT min(price) as price_range_min FROM `moto_bikes` WHERE param_link_model_id = $param_link_model_id";
      $result = $this->db->query($sql);
      $data = $result->fetch();
      return $data['price_range_min'];
    }

    public function priceRangeMaxByParamLinkModelId($param_link_model_id){
      $sql = "SELECT max(price) as price_range_max FROM `moto_bikes` WHERE param_link_model_id = $param_link_model_id";
      $result = $this->db->query($sql);
      $data = $result->fetch();
      return $data['price_range_max'];
    }

    public function getSamepriceByPriceSamePriceScale($bike_id,$price,$same_price_scale){
      $same_price_left = $price * (1 - $same_price_scale);
      $same_price_right = $price * (1 + $same_price_scale);
      $sql = "SELECT mb.id, mb.number, mb.name, mb.year, mb.brand, mb.real_km, mb.price, mb.merchant_num, mb.sale_state, mb.site, mb.create_time, mi.image_url
	  FROM `moto_bikes` AS mb
	  LEFT JOIN `moto_images` AS mi ON mb.id = mi.moto_bike_id
	  WHERE price > $same_price_left and price < $same_price_right and mb.id != $bike_id AND mi.category=1 and mi.main_pic=1 ORDER BY mb.create_time DESC";
      $result = $this->db->query($sql);
      $data = $result->fetchAll();
      return $data;
    }

    public function getSamelevelByDisplacementSameLevelScaleCategoryId($bike_id, $displacement,$same_level_scale,$category_id){
      $same_level_left = $displacement  * (1 - $same_level_scale);
      $same_level_right = $displacement  * (1 + $same_level_scale);
      $sql = "SELECT mb.id, mb.number, mb.name, mb.year, mb.brand, mb.real_km, mb.price, mb.merchant_num, mb.sale_state, mb.site, mb.create_time, mi.image_url 
	 FROM `moto_bikes` AS mb 
	 LEFT JOIN `moto_images` AS mi ON mb.id = mi.moto_bike_id 
	 WHERE displacement > $same_level_left and displacement < $same_level_right and category_id=$category_id and mb.id != $bike_id AND mi.category=1 and mi.main_pic=1 ORDER BY mb.create_time DESC";
      $result = $this->db->query($sql);
      $data = $result->fetchAll();
      return $data;
    }

    public function updateBikeById($id,$data){
        $set['name'] = @$data['name'];
        $set['year'] = @$data['year'];
        $set['brand_id'] = @$data['brand_id'];
        $set['brand'] = @$data['brand'];
        $set['category_id'] = @$data['category_id'];
        $set['category'] = @$data['category'];
        $set['param_link_model_id'] = @$data['param_link_model_id'];
        $set['real_km'] = @$data['real_km'];
        $set['displacement'] = @$data['displacement'];
        $set['price'] = @$data['price'];
        $set['min_price'] = @$data['min_price'];
        $set['view_change'] = @$data['view_change'];
        $set['diy'] = @$data['diy'];
        $set['merchant_num'] = @$data['merchant_num'];
        $set['sale_state'] = @$data['sale_state'];
        $set['site'] = @$data['site'];
        $where[] = "id = $id ";
        return $this->update($set,$where);
    }

    public function deleteBikeById($id){
       $where = Yaf_Registry::get("db")->quoteInto('id = ?',$id);
       $this->delete($where);
    }
}
