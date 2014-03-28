<?php

namespace Handbid;

//use Handbid\Store\Auction;

class Handbid{

    public $_stores = array();

    public function __construct( $auth ){}

    public function store( $type ){


        if( $this->stores[ $type ] ){

            return $this->stores[ $type ];
        }else{
            $class = 'Handbid\Store\\'.$type;
            $store = class_exists( $class ) ? new $class : null;

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