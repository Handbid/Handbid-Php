<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Item extends StoreAbstract{

    public $_base = 'items';

    public function byAuction($id, $query = []) {
        return $this->_rest->get('auctions/' . $id . '/items.json', $query);
    }

}