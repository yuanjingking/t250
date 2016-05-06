<?php

/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract{
	
        protected $_config;

        public function _initConfig() {
                $this->_config = Yaf_Application::app()->getConfig();
                Yaf_Registry::set("config", $this->_config);
        }

        //默认地址
        public function _initDefaultName(Yaf_Dispatcher $dispatcher) {
            //$dispatcher->disableView();
            Yaf_Registry::set("dispatcher", $dispatcher);
            $dispatcher->setDefaultModule("Index")->setDefaultController("Index")->setDefaultAction("index");
        }
	       

       public function _initLoader(Yaf_Dispatcher $dispatcher) {
            //Yaf_Loader::import(APP_PATH . '/conf/defines.inc.php');
       }
        
        
       public function _initIncludePath(){
         set_include_path(get_include_path().PATH_SEPARATOR.Yaf_Registry::get("config")->get("application")->get("library"));
       }
        
       
        /**
        * 连接数据库,设置数据库适配器
        */
        public function _initDefaultDbAdapter(){
            $params = $this->_config->database->params->toArray();
            $db = Zend_Db::factory('PDO_MYSQL', $params);
            Yaf_Registry::set("db", $db);
            Zend_Db_Table_Abstract::setDefaultAdapter($db);
            
        }

        public function _initError(Yaf_Dispatcher $dispatcher) {
            if ($this->_config->application->debug){
                    define('DEBUG_MODE', true);
                    ini_set('display_errors', 'On');
            }else{
                define('DEBUG_MODE', false);
                ini_set('display_errors', 'Off');
            }
        }



        //http://www.laruence.com/manual/yaf.routes.static.html
        public function _initRoute(Yaf_Dispatcher $dispatcher){
            $router = Yaf_Dispatcher::getInstance()->getRouter();
            $config  = new Yaf_Config_ini('../conf/routes.ini');
            $router->addConfig($config->routes);
        }





        public function _initPlugin(Yaf_Dispatcher $dispatcher) {
            $dispatcher->registerPlugin(new LayoutPlugin());
        }

       

}
  
