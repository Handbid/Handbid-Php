<?php

namespace Handbid;

use Handbid\Rest;

class Auth{
    //@todo: implement

    public $_restServer,
           $_restRoute,
           $_email,
           $_password,
           $_authData;


    public $error = [];


    public function __construct( $restServerAddress, $restBasePath, $restRoute ){

        //override the defaults, if provided
        $this->_restServerAddress   = !is_null($restServerAddress)  ? $restServerAddress    : $this->error[] = 'No rest server address provided.';
        $this->_restBasePath        = !is_null($restBasePath)       ? $restBasePath         : $this->error[] = 'No rest base path provided.';
        $this->_restRoute            = !is_null($restRoute)         ? $restRoute            : $this->error[] = 'No rest auth route provided.';


        if( count( $this->error ) ){
            throw( new \Exception( $this->error[0] ) );
            //@todo: log the errors.
        }

        $this->_restServer = new Rest( $this->_restServerAddress, $this->_restBasePath );

    }

    public function authenticate($email, $password){
        $this->_email               = !is_null($email)              ? $email                : $this->error[] = 'No email provided, can\'t authorize.';
        $this->_password            = !is_null($password)           ? $password             : $this->error[] = 'No password provided, can\'t authorize.';

        if( count( $this->error ) ){
            throw( new \Exception( $this->error[0] ) );
            //@todo: log the errors.
        }

        $route = '/mobile-toolkit/auth/token';

        $params = [
            'email' => $email,
            'password' => $password
        ];

        $response = $this->_restServer->query( $route, $params );

        $this->_authData = $response;

        $this->_restServer->setAuth( $this->getToken, $this->getOwnerId() );

        return $this;

    }

    public function getToken( ){

        return $this->_authData->token;
    }

    public function getOwnerId(){

        return $this->_authData->owner[0];
    }

    public function getUser(){
        $route = $this->_restRoute.'/user';

        $params = [
            'token'  => $this->_authData->token,
            'userId' => $this->_authData->owner[0]
        ];


        $response = $this->_restServer->query( $route, $params );

        return $response;
    }

}