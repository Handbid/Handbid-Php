<?php

namespace Handbid;

use Handbid\Store\StoreInterface;

class Handbid{

    public $_restServerAddress      = 'http://rest.newbeta.handbid.com',
           $_restBasePath           = '/v1/rest',
           $_auth                   = null,
           $_storeCache             = [];

    public function __construct( $restServerAddress = null, $restBasePath = null ){

        //default overrides
        $this->_restServerAddress   = !is_null( $restServerAddress ) ? $restServerAddress   : $this->_restServerAddress;
        $this->_restBasePath        = !is_null( $restBasePath )      ? $restBasePath        : $this->_restBasePath;

        $this->_auth                = new Auth( $this->_restServerAddress, $this->_restBasePath, '/mobile-toolkit/auth' );

    }

    public function auth( $username, $password ){

        if( is_null( $username ) ){
            throw( new \Exception('Auth Failure: Must provide a username for authorization.') );

        }

        if( is_null( $password ) ){
            throw( new \Exception('Auth Failure: Must provide a password for authorization.') );

        }

        $auth = $this->_auth->authenticate( $username, $password );

        //@todo: validate auth results;

        return $auth;
    }

    public function store( $type ){

        //lazy load and cache the store.
        if( $this->_storeCache[ $type ] ) return $this->_storeCache[ $type ];


        //create the store instance
        $store = null;

        if( strpos($type,'\\') !== false ){
            //it contains a backslash, so its probably a fully qualified namespaced class reference
            $store = class_exists( $type ) ? new $type : null;

        }else{
            //We'll assume it's an unqualified classname, we'll look it up in the handbid store adapters.
            $classPath = 'Handbid\Store\\'.$type;
            $store = class_exists( $classPath ) ? new $classPath( $this->_restServerAddress, $this->_restBasePath, $this->_auth ) : null;

        }


        //cache the new store instance
        if( !is_null( $store ) && $store instanceof StoreInterface ){
            $this->_storeCache[ $type ] = $store;

            return $store;
        }

        //if we got here, things aren't well.
        throw new \Exception( 'Store not found!'.' ( '.$type.' )' );

    }

}