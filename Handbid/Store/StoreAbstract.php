<?php

namespace Handbid\Store;

use Handbid\Store\StoreInterface;

class StoreAbstract implements StoreInterface{

    /* This is an api for a set of rest endpoints
     * They are to make their query, and pass through the decoded json results.
     * on error, we will be throwing exceptions.
     */

    //caching the curl handle like this could significantly improve performance if we have to do a lot of requests to the server.
    public $_curlHandle;

    public $_restServerAddress = 'http://rest.newbeta.handbid.com';
    public $_restServerRout;


    public function __construct(){
        $this->_curlHandle = curl_init( $this->_restServerAddress );
        curl_setopt($this->_curlHandle, CURLOPT_RETURNTRANSFER, true);

    }

    /**
     *
     */
    public function find(){

    }

    /**
     *
     */
    public function create(){

    }

    /**
     *
     */
    public function read(){

    }

    /**
     *
     */
    public function update(){

    }

    /**
     *
     */
    public function delete(){

    }

    public function setRout( $rout ){
        //@todo validate and clean the rout provided
        $this->_restServerRout = $rout;
    }

    public function query( $queryString, $postData = null ){

        //@todo:  if $postData, then we should be sending a post request instead of a get request
        //We'll be expecting an associative array of key value pairs.

        curl_setopt($this->_curlHandle, CURLOPT_URL, $this->_restServerAddress . $this->_restServerRout );

        $result = json_decode( curl_exec( $this->_curlHandle ) );

        if( is_object( $result ) ){

            //validate result
            if( $result->Errors ){ //this ...  needs to be broken out a little.

                throw new \Exception('Server Error ['. $result->Errors[0]->code .'] '. $result->Errors[0]->description . ((count($result->Errors) > 1) ? ' (' .(count($result->Errors)-1). ') more errors reported, but not shown.':'') );
            }

            //@todo clean up results to be more consistent.  our use-cases are going to expect arrays of results, probably rows..


            return $result;
        }else{

            throw new \Exception('Unknown response from server. ( '. $result .' ) ');
        }


    }

}