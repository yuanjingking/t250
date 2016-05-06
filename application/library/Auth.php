<?php
	class Auth{

		static function checkAutch(){
			parse_str(file_get_contents('php://input'), $data);
         	$data = array_merge($_GET, $_POST, $data);
			if(!isset($data['access_token'])){
				echo 'no auth';
				die();
			}
			if($data['access_token']!="AABBCCDD"){
				echo 'no auth';
				die();
			}
			return $data;
		}
	}
?>