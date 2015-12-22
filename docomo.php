<?php 
if(session_id() === false) session_start();

 
require_once 'src/util.php';
require_once 'src/logging.php';
require_once 'src/session.php';
require_once 'src/docomo_base.php';


Class Libs_Docomo_Docomo extends Docomo_Base {

	protected $logActive		= true;
	protected $logWhitelist		= false;
	protected $logLevel		    = 'debug';
	protected $logPrefix 		= 'docomo_api';

    protected $logPath		    = 'c:/log/docomo/';
	protected $logTimeFormat	= 'Y-m-d H:i:s';
	protected $logLineFormat	= '{datetime} {exectime} {threadId} {level} {message}';

	protected $requestTimeout	= 30; // in second
	protected $cookiesTimeout   = 3600; // in second

	protected $log;

	public function __construct() {
        parent::__construct();
        
		$this->log = new Logging(array(
			'logLevel' 		=> $this->logLevel,
			'logPath' 		=> $this->logPath,
			'logPrefix'		=> $this->logPrefix,
			'logTimeFormat' => $this->logTimeFormat,
			'logLineFormat' => $this->logLineFormat,
			'logActive'		=> $this->logActive
		));
	}
   
    public function doc_info(){
        return $this->document_info();
    }
    
    /*
    *Authentication 
    */
    public function _signup($params){
        return $this->_docomoAPI('signup',$params);
    }      
    
    public function _send_access_code($params){
        return $this->_docomoAPI('subscriber_type',$params);
    }      
    
    
    public function _login($params){
        return $this->_docomoAPI('login',$params);
    } 
    
    public function _change_password_request($params){
        return $this->_docomoAPI('change_password_request',$params);
    }    
    
    public function _logout($params){
        return $this->_docomoAPI('LogoutRequest',$params);
    }
    
    /*
    *Features
    */
    public function _subscriber_type($params){
        return $this->_docomoAPI('subscriber_type',$params);
    }    
    
    public function _read_subscriber($params){
        return $this->_docomoAPI('read_subscriber',$params);
    }
    
    public function _read_subscriber_group($params){
        return $this->_docomoAPI('read_subscriber_group',$params);
    }
	
	public function _read_group_request($params){
        return $this->_docomoAPI('ReadGroupRequest',$params);
    }
    
    public function _add_offer_to_subscriber_request($params){
        return $this->_docomoAPI('add_offer_to_subscriber_request',$params);
    }
    
    public function _share_offer_to_subscriber_request($params){
        return $this->_docomoAPI('share_offer_to_subscriber_request',$params);
    }
    
    public function _get_offers_to_subscriber_request($params){
        return $this->_docomoAPI('get_offers_to_subscriber_request',$params);
    }
    
    public function _GetOffersFromOfferGroupRequest($params){
        return $this->_docomoAPI('GetOffersFromOfferGroupRequest',$params);
    }
    
    public function _AddOfferToGroupRequest($params){
        return $this->_docomoAPI('AddOfferToGroupRequest',$params);
    }
    
    public function _GetOffersFromGroupRequest($params){
        return $this->_docomoAPI('GetOffersFromGroupRequest',$params);
    }
    
    public function _GetOperatorInfoRequest($params){
        return $this->_docomoAPI('GetOperatorInfoRequest',$params);
    }
}
