<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Item extends StoreAbstract{

    public $_base = 'items';

    public function byItem($auctionId, $itemId) {
        return $this->_rest->get('auctions/' . $auctionId . '/items/' . $itemId . '/bids.json');
    }

}