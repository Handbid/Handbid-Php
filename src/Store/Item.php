<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Bid extends StoreAbstract{

    public $_base = 'items';

    public function byAuction($id) {
        return $this->_rest->get('auctions/' . $id . '/items.json');
    }

}