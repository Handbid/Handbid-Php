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
    public $_restBasePath = '/v1/rest';


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

    /**
     * @param        $route
     * @param array  $data
     * @param string $method
     *
     * @return object
     * @throws \Exception
     */
    public function query( $route, $data = [], $method = 'Get' ){

        //can never be sure what to expect...
        $route = ($route[0] === '/') ? $route : '/'.$route;

        curl_setopt($this->_curlHandle, CURLOPT_URL, ($this->_restServerAddress . $this->_restBasePath . $route) );

        if( $method == 'Post' && $data ){
            //setup our request for posting data, yo!
            $fields = '';

            foreach($data as $key => $value) {
                $fields .= $key . '=' . $value . '&';
            }

            rtrim($fields, '&');

            curl_setopt($this->_curlHandle, CURLOPT_POST, count( $data ) );
            curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $fields );
        }

        //execute the curl request, decode our json response.
        $result = json_decode( curl_exec( $this->_curlHandle ) );

        if( is_object( $result ) ){

            //validate result
            if( $result->Errors[0]->code !== 200 ){

                throw new \Exception('Server Error ['. $result->Errors[0]->code .'] '. $result->Errors[0]->description . ((count($result->Errors) > 1) ? ' (' .(count($result->Errors)-1). ') more errors reported, but not shown.':'') );
            }

            //@todo clean up results to be more consistent.  our use-cases are going to expect arrays of results, probably rows..

            return $result;
        }else{

            throw new \Exception('Unknown response from server. ( '. $result .' ) ');
        }

    }

}