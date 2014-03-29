<?php

namespace Handbid;

//use Handbid\Store\Auction;

use Handbid\Store\StoreInterface;

class Handbid{

    public $_stores = array();

    public function __construct( $auth ){}

    public function store( $type ){
        //$type could be a number of things.
        //1. a string representing a class in the Handbid\Store namespace
        //2. a string representing a namespaced class path to some other store class
        //3. a class reference.

        //lazy load and cache the store.
        if( $this->stores[ $type ] ){

            return $this->stores[ $type ];
        }else{

            $store = null;

            if( $type instanceof StoreInterface ){
                //its a class instance
                $store = $type;

                $type = get_class( $store );

            }elseif( strpos($type,'\\') !== false ){
                //it contains a backslash, so its probably a fully qualified namespaced class reference
                $store = class_exists( $type ) ? new $type : null;

            }else{
                //We'll assume it's an unqualified classname, we'll look it up in the handbid store adapters.
                $classPath = 'Handbid\Store\\'.$type;
                $store = class_exists( $classPath ) ? new $classPath : null;

            }


            if( !is_null( $store ) ){

                $this->_stores[ $type ] = $store;

                return $store;
            }else{

                throw new \Exception( 'Store not found!'.' ( '.$type.' )' );
            }

        }

    }

    public function auth(){

    }

    public function setAuth( $auth ){

    }

}