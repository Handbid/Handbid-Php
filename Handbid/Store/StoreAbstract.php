<?php

namespace Handbid\Store;

use Handbid\Store\StoreInterface;

use Handbid\Rest;

class StoreAbstract implements StoreInterface{

    public  $_restServer,
            $_restRoute,
            $_restServerAddress,
            $_restBasePath,
           $_restCollection,            //collection must be overridden in the store implementation class for correct routing.
            $_restAuthToken,
            $_restUserId;


    public $error = [];


    public function __construct( $restServerAddress, $restBasePath, $auth ){

        $this->_restServerAddress   = $restServerAddress     ? $restServerAddress    : $this->error[] = 'No rest server address provided.';
        $this->_restBasePath        = $restBasePath          ? $restBasePath         : $this->error[] = 'No rest base path provided.';
        $this->_restAuthToken       = $auth->getToken()      ? $auth->getToken()     : $this->error[] = 'No Auth Token returned, can\'t proceed';
        $this->_restUserId          = $auth->getOwnerId()    ? $auth->getOwnerId()   : $this->error[] = 'No User Id returned, can\'t proceed';

        if( count( $this->error ) ){
            throw( new \Exception( $this->error[0] ) );
            //@todo: log the errors
        }

        $this->_restServer = new Rest( $this->_restServerAddress, $this->_restBasePath );
        $this->_restServer->setAuth( $this->_restAuthToken, $this->_restUserId );
    }

    /**
     *
     */
    public function find( $data = [] ){
        throw( new \Exception('coming soon') );
    }

    /**
     *
     */
    public function create( $data = [] ){
        $response = $this->_restServer->query( $this->_restRoute, $data, 'Post' );
        //@TODO: validate response

        if( count( $this->_restServer->_error ) ){
            throw( new \Exception( $this->_restServer->_error[0] ) );
        }

        return $response;
    }

    /**
     *
     */
    public function read( $data = [] ){
        $response = $this->_restServer->query( $this->_restRoute, $data );

        if( count( $this->_restServer->_error ) ){
            throw( new \Exception( $this->_restServer->_error[0] ) );
        }

        return $response;
    }

    /**
     *
     */
    public function update( $data = [] ){
        $response = $this->_restServer->query( $this->_restRoute, $data, 'Post' );

        if( count( $this->_restServer->_error ) ){
            throw( new \Exception( $this->_restServer->_error[0] ) );
        }

        return $response;
    }

    /**
     *
     */
    public function delete( $data = [] ){
        $response = $this->_restServer->query( $this->_restRoute, $data, 'Delete' );

        if( count( $this->_restServer->_error ) ){
            throw( new \Exception( $this->_restServer->_error[0] ) );
        }

        return $response;
    }

}