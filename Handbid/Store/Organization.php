<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Organization extends StoreAbstract{

    public function create( $data = [] ){
        $this->_restRoute = '/orgs.json';

        return parent::create( $data );
    }

    public function getById( $id ){
        $this->_restRoute = '/orgs/' . $id . '.json';

        return parent::read();
    }

    public function updateById( $id, $data ){
        $this->_restRoute = '/orgs/' . $id . '.json';

        return parent::update( $data );
    }

    public function deleteById( $id ){
        $this->_restRoute = '/orgs/' . $id . '.json';

        return parent::delete( );
    }

}