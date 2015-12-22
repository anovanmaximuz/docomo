<?php
if(session_id() === false) session_start();
class Libs_Session {
	
	public static function clear($key='') {
		if($key == ''){
			unset($_SESSION['axisnet']);
		}
		else{
			unset($_SESSION['axisnet'][$key]);
		}
	}

	public static function set($key, $value) {		
		$_SESSION['axisnet'][$key] = serialize($value);
	}
	
	public static function get($key){
		return isset($_SESSION['axisnet'][$key]) ? unserialize($_SESSION['axisnet'][$key]) : false;
	}
}
