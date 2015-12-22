<?php
require_once 'logging/file.php';

class Logging {
	
	private $objDriver;
	
	// storage
	private $storage = '';
	private $enable  = true;
	
	public function __construct($option) {
		$this->objDriver = new Logging_File(array(
			'logLevel' 		=> $option['logLevel'],
			'logPath' 		=> $option['logPath'],
			'logPrefix'		=> $option['logPrefix'],
			'logTimeFormat' => $option['logTimeFormat'],
			'logLineFormat' => $option['logLineFormat']
		));
		
		$this->enable = $option['logActive'];
	}
	
	public function write($level, $message){
		if( $this->enable==true ) {
			if($level == 'summary'){
				$this->_store($message);
			}else{
				$this->objDriver->write($level, $message);
			}
		}
	}
	
	private function _store($message){
		$this->storage .= $message . "\t";
	}
	
	public function __destruct(){
		if($this->storage != '') $this->objDriver->write('summary', $this->storage);
	}
}
