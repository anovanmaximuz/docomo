<?php
Class Util {
	
	private static function modified_base64_encode($txt) {
		$search = array("+", "/");
		$replace = array("-", "_");
		$txt = str_replace($search, $replace, base64_encode($txt));
		return $txt;
	}
	
	private static function modified_base64_decode($txt) {
		$search = array("-", "_");
		$replace = array("+", "/");
		$txt = base64_decode(str_replace($search, $replace, $txt));
		return $txt;
	}
	
	public static function encrypt($saltKey, $string) {
	    $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $encrypt = mcrypt_encrypt(MCRYPT_3DES, substr($saltKey,0,20), trim($string), MCRYPT_MODE_ECB, $iv);
	    $msisdn = self::modified_base64_encode($encrypt);
	    return trim($msisdn);
	}

	public static function decrypt($saltKey, $string){
		$decrypt_base64 = self::modified_base64_decode(trim($string));
		$iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypt = mcrypt_decrypt(MCRYPT_3DES, substr($saltKey,0,20), $decrypt_base64, MCRYPT_MODE_ECB, $iv);
		return trim($decrypt);
	}
	
	public static function bytesToSize($number, $precision = 2) {  
		if ($number) {
			$number = doubleval($number);
			if ($number/(float)1024000000 >= 1) {
				$txt = number_format(((float)$number/(float)1024000000), $precision)  ." GB";				
			} else if ($number/(float)1024000 >= 1) {
				$txt = number_format(($number/(float)1024000), $precision)  ." MB";
			} else if ($number/1024 >= 1) {
				$txt = number_format(($number/1024), $precision)  ." KB";
			} else {
				$txt = number_format($number, $precision) . " Byte";
			}
		} else $txt=0;

		return $txt;
	}
}
