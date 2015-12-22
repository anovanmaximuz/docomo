<?php 

class Docomo_Features
{

    public $services = array(
                'document'=>array(
                            'client'=>'NTT Docomo Pacific',
                            'project_name'=>'NTT Docomo Pacific Share Data Project',
                            'title'=>'Self-Care Mobile App API Document',
                            'issued'=>'2015-05-29',
                            'status'=>'Official',
                            'doc_number'=>'NTT008_REST_01',
                            'version'=>'1.7'
                            ),
                'change_logs'  =>array('2015-09-26'),
                'config'=>array(
                            'api_endpoint'=>'http://192.168.24.70:5454/',//'https://opn.docomopacific.com/',
                            'api_resource'=>'MobileApps',
                            'data_format'=>'JSON',
                            'method'=>'POST',
                            'version'=>'1.0.0.1',
                            'date_format'=>'Y-m-d\TH:i:s',
                            'data_types'=>array('phone','email','boolean','date','integer','double','string','array','object','resource',NULL,'unknown type')
                            ),
                'login'=>array(
                        'service'   =>'LoginRequest',
                        'reff_doc'  =>'2.1',
                        'parameter' =>array(
                                                    //data_type,length,mandatory/empty
                                    'Username'=>array('phone','10-20',true),
                                    'Password'=>array('string','8-12',true),
                                    'DeviceID'=>array('string',null,true)
                                    ),
                        'mandatory' =>array('Username','Password','DeviceID'),
                        'response'  =>array(
                                    'LoginResponse'=>array(
                                                    'AccessToken'=>'4565436789456743',
                                                    'SubscriberId'=>'16789832342'
                                                    )),
                        'errors'    =>array('500','401','551')
                        ),
                'signup'=>array(
                        'service'   =>'SignUpRequest',
                        'reff_doc'  =>'2.2',
                        'parameter' =>array(
                                     'Username'=>array('phone','10-20',true),
                                     'Password'=>array('string','8-12',true),
                                     'ForgotPassword'=>array('integer',null,false),
                                     'AccessCode'=>array('string',null,true)
                                     ),
                        'mandatory' =>array('Username','Password','AccessCode'),
                        'response'  =>array(
                                    'SignUpResponse'=>array(
                                                    'AccessToken'=>'',
                                                    'SubscriberId'=>''
                                                    )),
                        'errors'    =>array('402','551','500')
                        ),
                'subscriber_type'=>array(
                        'service'   =>'SubscriberTypeRequest',
                        'reff_doc'  =>'2.3',
                        'parameter' =>array(
                                     'Username'=>array('phone','10-20',true),
                                     'ForgotPassword'=>array('integer',null,false),
                                     'DeviceID'=>array('string',null,true)
                                     ),
                        'response'  =>array(
                                    'SubscriberTypeResponse'=>array(
                                                    'Type'=>''
                                                    )),
                        'mandatory' =>array('Username','DeviceID'),
                        'errors'    =>array('551','575','500','557')
                        ),
                'read_subscriber'=>array(
                        'service'   =>'ReadSubscriberRequest',
                        'reff_doc'  =>'2.4',
                        'parameter' =>array(
                                     'AccessToken'=>array('string',null,true),
                                     'SubscriberId'=>array('string',null,true)
                                     ),
                        'mandatory' =>array('AccessToken','SubscriberId'),
                        'errors'    =>array('500','550','551','575','403')
                        ),
                'ReadGroupRequest'=>array(
                        'service'   =>'ReadGroupRequest',
                        'reff_doc'  =>'2.5',
                        'parameter' =>array(
                                     'AccessToken'=>array('string',null,true),
                                     'SubscriberId'=>array('string',null,true),
                                     'GroupId'=>array('string',null,true)
                                     ),
                        'mandatory' =>array('AccessToken','SubscriberId','GroupId'),
                        'errors'    =>array('500','550','552','575','403')
                        ),
                'add_offer_to_subscriber_request'=>array(
                        'service'   =>'AddOfferToSubscriberRequest',
                        'reff_doc'  =>'2.6',
                        'parameter' =>array(
                                     'AccessToken'=>array('string',null,true),
                                     'SubscriberId'=>array('string',null,true),
                                     'OfferId'=>array('string',null,true),
                                     'StartDate'=>array('date',null,true),
                                     'EndDate'=>array('date',null,true)
                                     ),
                        'mandatory' =>array('AccessToken','SubscriberId','OfferId','StartDate','EndDate'),
                        'errors'    =>array('500','550','553','554','555','575','403')
                        ),
                'share_offer_to_subscriber_request'=>array(
                        'service'   =>'ShareOfferToSubscriberRequest',
                        'reff_doc'  =>'2.7',
                        'parameter' =>array(
                                     'AccessToken'=>array('string',null,true),
                                     'SubscriberId'=>array('string',null,true),
                                     'OfferId'=>array('string',null,true),
                                     'StartDate'=>array('string',null,true),
                                     'EndDate'=>array('string',null,true),
                                     ),
                        'mandatory' =>array('AccessToken','SubscriberId','OfferId','StartDate','EndDate'),
                        'errors'    =>array('500','550','551','553','554','555','575','403')
                        ),
                'change_password_request'=>array(
                        'service'   =>'ChangePasswordRequest',
                        'reff_doc'  =>'2.8',
                        'parameter' =>array(
                                     'Username'=>array('string',null,true),
                                     'Password'=>array('string',null,true),
                                     'AccessToken'=>array('string',null,true)
                                     ),
                        'mandatory' =>array('Username','Password','AccessToken'),
                        'errors'    =>array('575')
                        ),
                'get_offers_to_subscriber_request'=>array(
                        'service'   =>'GetOffersToSubscriberRequest',
                        'reff_doc'  =>'2.9',
                        'parameter' =>array(
                                     'AccessToken'=>array('string',null,true),
                                     'TransactionId'=>array('string',null,true),
                                     'SubscriberId'=>array('string',null,true)
                                     ),
                        'mandatory' =>array('AccessToken','TransactionId','SubscriberId'),
                        'errors'    =>array('575'),
                        'notes'     =>array(
                                    'Unit'=>'‘M’ for month, ‘D’ for day and ‘W’ for week',
                                    'IsRecurring'=>'True or False',
                                    'Length'=>'Cycle Duration of the Offer e.g. ‘1’ for 1 month, ‘7’ for 7 days',
                                    'Price'=>'Price of the Plan e.g. $5 for 7 days top-up plan',
                                    'Volume'=>'The data available for that offer in bytes. Ex: 1073741824'
                                    )
                        ),
                'GetOffersFromOfferGroupRequest'=>array(
                        'service'   =>'GetOffersFromOfferGroupRequest',
                        'reff_doc'  =>'2.10',
                        'parameter' =>array(
                                     'AccessToken'=>array('string',null,true),
                                     'SubscriberId'=>array('string',null,true),
                                     'TransactionId'=>array('string',null,true),
                                     'OfferGroup'=>array('string',null,true)
                                     ),
                        'mandatory' =>array('AccessToken','SubscriberId','TransactionId','OfferGroup'),
                        'errors'    =>array('575','556'),
                        'notes'     =>array(
                                    'TransactionId'=>'set TransactionId to 1'
                                    )
                        ),
                'AddOfferToGroupRequest'=>array(
                        'service'   =>'AddOfferToGroupRequest',
                        'reff_doc'  =>'2.11',
                        'parameter' =>array(
                                     'AccessToken'=>array('string',null,true),
                                     'TransactionId'=>array('string',null,true),
                                     'SubscriberId'=>array('string',null,true),
                                     'OfferId'=>array('string',null,true),
                                     'GroupId'=>array('string',null,true),
                                     'StartDate'=>array('date',null,true),
                                     'EndDate'=>array('date',null,true)
                                     ),
                        'mandatory' =>array('AccessToken','TransactionId','SubscriberId','OfferId','GroupId','StartDate','EndDate'),
                        'errors'    =>array('500','550','551','552','553','554','555','575','403')
                        ),
                'GetOffersFromGroupRequest'=>array(
                        'service'   =>'GetOffersFromGroupRequest',
                        'reff_doc'  =>'2.12',
                        'parameter' =>array(
                                     'AccessToken'=>array('string',null,true),
                                     'TransactionId'=>array('string',null,true),
                                     'SubscriberId'=>array('string',null,true),
                                     'GroupId'=>array('string',null,true)
                                     ),
                        'mandatory' =>array('AccessToken','TransactionId','SubscriberId','GroupId'),
                        'errors'    =>array('575','552','403')
                        ),
                'GetOperatorInfoRequest'=>array(
                        'service'   =>'GetOperatorInfoRequest',
                        'reff_doc'  =>'2.13',
                        'parameter' =>array(
                                     'AccessToken'=>array('string',null,true)
                                     ),
                        'mandatory' =>array('AccessToken'),
                        'errors'    =>array('575')
                        ),
                'LogoutRequest'=>array(
                        'service'   =>'LogoutRequest',
                        'reff_doc'  =>'2.14',
                        'parameter' =>array(
                                     'SubscriberId'=>array('string',null,false),
                                     'AccessToken'=>array('string',null,false)
                                     ),
                        'mandatory' =>array('SubscriberId','AccessToken'),
                        'errors'    =>array('575')
                        ),
    );
    

}