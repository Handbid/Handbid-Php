<?php

namespace Handbid;

class Auth{
    public $_appId;
    public $_apiKey;

    public $user;     // perhaps we could preset this to the current user instance, and allow an internal override?
    public $address = 'localhost';
    public $port    = 80;

    public function __construct( $appId, $apiKey ){
        //do all the cool stuff we need to authorize our connection to the rest server.
        //@todo Build this out when we have an app registration module.  We'll just bypass authorization for now on the Handbid class.
    }


}