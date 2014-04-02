<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Organization extends StoreAbstract{

    public function create( $data = [] ){
        $this->_restRoute = '/orgs.json';

        return parent::create( $data );
    }
}