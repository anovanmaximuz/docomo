<?php

require_once 'features.php';
Class Docomo_Base 
{
	private     $raw_param;
	protected   $ttl = 30;
    public      $quizid;
    protected   $fitur;
    
    function __construct(){
        
        //if(isset($_SESSION['docomo_service'])){
       //     $this->fitur        = $_SESSION['docomo_service'];
       // }else{
            $this->features     = new Docomo_Features;
            $this->fitur        = $this->features->services;
        //    $_SESSION['docomo_service'] = $this->fitur;
      // }
   //
    }
    
    public function _info($service,$type='parameter'){
        
        if(isset($this->fitur[$service][$type])){
            echo '<pre>';
            echo json_encode($this->fitur[$service][$type],JSON_PRETTY_PRINT);
        }else{
            echo json_encode(array('errors'=>'no data response'));
        }
        
    }
    
    public function document_info(){
        return $this->get_service('document');
    }
    
    protected function get_service($service){
        if(isset($this->fitur[$service])){
            return $this->fitur[$service];
        }else{
            return array('error'=>'service not found');
        }
    }
	
    protected function _check($param=""){
        if(isset($param) && $param !=""){
            return true;
        }else{
            return false;
        }
    
    }
	
	protected function _serviceAPI($service, $param=array(),$flag=false){
        if($flag){
            var_dump($param);die();
        }
        
        $data = $this->_callAPI(
                            $this->fitur['config']['api_endpoint'].$this->fitur['config']['api_resource'], 
                            $service, 
                            $param
                            );
        $data = json_decode($data);
        
        $res  = new stdclass();
        if(isset($data) && isset($data->error)){
            $res->status  = false;
            $res->type    = 'api';
            $res->service = $service;
            $res->data    = (array)$data;
        }else{
                $res->status  = true;
                $res->type    = 'api';
                $res->service = $service;
                $res->data    = (array)$data; 
        }
        return $res;
	}
	
	protected function _callAPI($url, $service, $parameter = '')
    {
        $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		if($parameter != '') {
            //parameter creator
            $postData = array(
                $service => $parameter
            );

			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
			curl_setopt($curl, CURLOPT_TIMEOUT, $this->ttl);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
			if( isset($_SERVER['HTTP_USER_AGENT']) ) curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		}
        
		$response = curl_exec($curl);
            
		if (curl_errno($curl)) {  
            $res = new stdclass();
            $res->errorCode = '403';
            $res->errorMessage = '[Curl error] '.curl_error($curl);
            $response = json_encode(array('error'=>$res));
		}
		else{
            $response = $response;
		}
		curl_close($curl);
		@$this->log->write('debug', "TYPE:API || URL: $url || SERVICE: $service || RAW: " . http_build_query($this->raw_param) . " || PARAM: " . http_build_query($parameter) );
		@$this->log->write('info',"RESULT: ". json_encode($response));
		return $response;
	}
    
    protected function _error($message,$type="unknow"){
        $response = array();
        $response['status']    = false;
		$response['type']      = 'internal';
		$response['service']   = ($type=="")?'unknow': $type;
		$response['data']      = $message;
        return $response;
    }    
    
    protected function _success($message,$type="unknow"){
        $response = array();
        $response['status']     = true;
		$response['type']       = 'internal';
		$response['service']    = ($type=="")?'unknow': $type;
		$response['data']       = $message;
        return $response;
    }
    
    protected function _mandatory($data="",$params=array()){
        $data = (is_array($data)) ? $data: explode(',',$data);
        $ress = array();
        foreach($params as $key=>$val){
            if (in_array($key, $data)) {
                if($val==""){
                    array_push($ress,$this->_error('parameter '.$key.' do not empty'));//array('status'=>false,'message'=>'paremeter '.$key.' do not empty');
                }
            }else{
                array_push($ress,$this->_error('unknow parameter '.$key));//array('status'=>false,'message'=>'invalid parameter '.$key);
            }
        }
        return $ress;
    }
    
    protected function _validation($name,$data,$type="",$length=null,$mandatory=false)
    {
        $min    = 0;
        $max    = 255;
        if($length!=null){
            $length = explode('-',$length);
            $min    = $length[0];
            $max    = $length[1];
        }
        $dataTypes = $this->fitur['config']['data_types'];
        $ress = array();
        
        if(!in_array($type,$dataTypes)){
            $ress[] = $this->_error($name .'['.gettype($data).'] data type ['.$type.'] is not supported','validation');
        }
        
        if($type=='phone' && !in_array(substr($data,0,4),array('1671','1670')) ){
            $ress[] = $this->_error($name .'['.substr($data,0,4).'] Invalid phone number prefix','validation');
        }
        
        if($mandatory==true && empty($data)){
            $ress[] = $this->_error($name .'['.gettype($data).'] do not empty, it must be filled as ['.$type.'] data type','validation');
        }
        
        if($type!=gettype($data) && !in_array($type,array('email','date','phone'))){
            $ress[] = $this->_error($name .'['.gettype($data).'] data type mismates, requirement is ['.$type.']','validation');
        }
        
        
        if(strlen((string)$data)>$max && $length!=null){
            $ress[]= $this->_error($name .'['.gettype($data).'] maximum data length is only ['.$max.'] both number or string','validation');
        }
        
        if(strlen((string)$data)<$min && $length!=null){
            $ress[]= $this->_error($name .'['.gettype($data).'] minimum data length is only ['.$min.'] both number or string','validation');
        }
        
        if($type=='email' && $this->email_check($data)!=true){
            $ress[] = $this->_error($name .'['.gettype($data).'] invalid email format, expected [bla_bla@domain.com]','validation');
        }
        
        if($type=='date' && $this->validateDate($data)!=true){
            $ress[] = $this->_error($name .'['.gettype($data).'] invalid date format, expected format [Y-m-d H:i:s]','validation');
        }
        
        
        return $ress;
    }
    
    protected function validateDate($date, $format = 'Y-m-d\TH:i:s')
    {
        //$format = (isset($this->fitur['config']['date_format'])) ? $this->fitur['config']['date_format'] : $format;
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    
    protected function email_check($email) {
		$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
		return preg_match($pattern,$email);
    }
    
    protected function build($params){
        $data=array();
        $mandatory = array();
        foreach($params as $key=>$val){
            $data['parameter'][$key] = $val;
            $data['mandatory'][]     = $key;
        }
        return $data;
    }
    
    protected function _format_check($params=array(),$service="")
    {
        $manService = $this->get_service($service)['parameter'];

        $ress = array();
        foreach($params as $key=>$val){
            if(is_array($manService[$key])){
                $data       = $manService[$key];
                $value      = (isset($val)) ? $val : "";                
                $type       = (isset($data[0])) ? $data[0] : "";
                if($type=='date'){
                    if(!$this->validateDate($value)){
                        $value  = date($this->fitur['config']['date_format'], strtotime($value)); 
                    }
                }
                $length     = (isset($data[1])) ? $data[1] : null;
                $mandatory  = (isset($data[2])) ? (($data[2]!=true) ? false: true ): false;
                $ress[] = $this->_validation($key,$value,$type,$length,$mandatory);
            }else{
                $ress[] = $this->_error('please use the valid format for ['.$key.'] data load ');
            }
        }
        $reff = array();
        foreach($ress as $key=>$val){
            foreach($val as $rom){
                $reff[]= $rom;
            }
        }
        return $reff;
        
    }
    
    protected function _docomoAPI($service,$params)
    {   
        $fitur      = $this->get_service($service);
        $manService = $fitur['mandatory'];
        $builder    = $this->build($params);

        $mandatory  = $builder['mandatory'];
        $intersect  = array_intersect($manService, $mandatory);
        $different  = (count($manService)!=count($intersect)) ? array_diff($manService, $mandatory):true ;

        if(!is_array($different) && $different==true){
            if(is_array($this->_format_check($params,$service)) && count($this->_format_check($params,$service))<1){
                $result = (array)$this->_serviceAPI($fitur['service'], $builder['parameter']);
            }else{
                $result = $this->_format_check($params,$service);
                @$this->log->write('debug', "TYPE:INTERNAL || SERVICE: $service || PARAMS: " .json_encode($params));
                @$this->log->write('info',"RESULT: ". json_encode($result));
            }
        }else{
            $listing = array();
            foreach($different as $key){
                $listing[] = $this->_error('['.$key.'] invalid mandatory parameter','mandatory');
            }
            $result = $listing;
            @$this->log->write('debug', "TYPE:INTERNAL || SERVICE: $service || PARAMS: " .json_encode($params));
            @$this->log->write('info',"RESULT: ". json_encode($result));
        }
        
        
        return $result; 
	}
    
}
