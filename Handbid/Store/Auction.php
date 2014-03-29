<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Auction extends StoreAbstract{

    /**
     * @return mixed
     */
    public function close(){
        //$result =

        return $result;
    }

    /**
     * @return mixed
     */
    public function recent(){
        $result = $this->query( 'auctions.json' );

        return $result;
    }

    /**
     * @return mixed
     */
    public function current(){
        //$result =

        return $result;
    }

}