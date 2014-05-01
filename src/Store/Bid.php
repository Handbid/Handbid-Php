<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Bid extends StoreAbstract
{

    public $_base = 'items';

    public function byItem($auctionId, $itemId)
    {
        return $this->_rest->get('auctions/' . $auctionId . '/items/' . $itemId . '/bids.json');
    }

}