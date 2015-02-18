<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Receipt extends StoreAbstract
{
    public $_base = 'bidder/receipts';
    public $_resultKey = 'Receipt';
    public $_receiptCache = [];

    public function byAuction($auctionId)
    {

        return $this->_rest->get(
            'auction/myreceipt' . $auctionId,
            [
            ],
            [],
            false
        );
    }
}