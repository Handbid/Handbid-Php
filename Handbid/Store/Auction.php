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
        $this->setRout('/v1/rest/auctions.json');
        $queryString = '';

        $result = $this->query( $queryString );

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