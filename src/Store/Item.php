<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Item extends StoreAbstract{

    public $_state;

    public function byAuction($auctionId) {
        return $this->all();
    }

    public function findByCategory( $category ){

    }

    public function findByAuction( $auction ){

    }

    public function currentState(){

    }

}