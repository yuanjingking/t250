<?php
class ErrorController extends Yaf_Controller_Abstract {
	public function indexAction() {
	
		$exception = $this->getRequest()->getException();
		try {
			throw $exception->getMessage();
		}catch (Yaf_Exception_LoadFailed $e) {
			header('HTTP/1.1 404 Not Found');
			header('status: 404 Not Found');
			echo $e->getMessage();
			exit;
		}
	}

	public function errorAction($exception){
		Yaf_Dispatcher::getInstance()->disableView();  
        switch ($exception->getCode()) {  
            case YAF_ERR_NOTFOUND_MODULE:  
            case YAF_ERR_NOTFOUND_CONTROLLER:  
            case YAF_ERR_NOTFOUND_ACTION:  
            case YAF_ERR_NOTFOUND_VIEW:  
                echo 404, ":", $exception->getMessage();  
                break;  
            default :  
                $message = $exception->getMessage();  
                echo 0, ":", $exception->getMessage();  
                break;  
        }  
	}
}