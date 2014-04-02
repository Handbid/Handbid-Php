<?php

namespace Handbid;

use Handbid\RestInterface;

class Rest implements RestInterface{
    public  $_curlHandle,
            $_serverAddress,
            $_basePath,
            $_authUsername,
            $_authPassword,
            $_error = [];

    public function __construct( $serverAddress, $basePath ){
        $this->_serverAddress = !is_null( $serverAddress ) ? $serverAddress : $this->_error[] = 'Rest Error: server address must be defined';
        $this->_basePath      = !is_null( $basePath )      ? $basePath      : $this->_error[] = 'Rest Error: base path must be defined';

        if( count( $this->error ) ){
            throw( new \Exception( $this->error[0] ) );
            //@todo: log the errors
        }

        $this->_curlHandle = curl_init( $this->_serverAddress . $this->_basePath );

        curl_setopt( $this->_curlHandle, CURLOPT_RETURNTRANSFER, true );

    }

    public function query( $route, $params = [], $method = 'Get' ){
        $query = http_build_query( $params );



        if( $method === 'Post' && $query ){
            //setup our request for posting data, yo!

            //curl_setopt($this->_curlHandle, CURLOPT_POST, true );
            curl_setopt($this->_curlHandle, CURLOPT_URL, ($this->_serverAddress . $this->_basePath . $route) );
            curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $query );

        }elseif($method === 'Get' && $query ){
            curl_setopt($this->_curlHandle, CURLOPT_URL, ($this->_serverAddress . $this->_basePath . $route . '?'. $query ) );

        }elseif($method === 'Delete' ){
            curl_setopt($this->_curlHandle, CURLOPT_URL, ($this->_serverAddress . $this->_basePath . $route) );
            curl_setopt($this->_curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE' );
            curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $query );

        }else{
            curl_setopt($this->_curlHandle, CURLOPT_URL, ($this->_serverAddress . $this->_basePath . $route ) );

        }

        //if authorization has been set, use it.
        if($this->_authUsername && $this->_authPassword){
            curl_setopt($this->_curlHandle, CURLOPT_USERPWD, $this->_authUsername.':'.$this->_authPassword );
        }

        $responseText = curl_exec( $this->_curlHandle );
        $response = json_decode( $responseText );

        if( is_object( $response ) ){
            //validate response
            if( !is_null($response->Errors) && $response->Errors[0]->code !== 200 ){

                foreach( $response->Errors as $error ){
                    $this->_error[] = 'Server Error ['. $response->Errors[0]->code .'] '. $response->Errors[0]->description;

                    //@TODO: Log errors
                }

            }

            return $response;
        }else{

            throw new \Exception('Unknown response from server. ( '. $response .' ) ');
        }

    }

    public function setAuth( $username, $password ){
        $this->_authUsername = $username;
        $this->_authPassword = $password;

    }
}