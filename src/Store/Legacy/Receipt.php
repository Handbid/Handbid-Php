<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Receipt extends StoreAbstract
{
    public $_base = 'models/Receipt';
    public $_resultKey = 'Receipt';
    public $_receiptCache = [];

    public function byAuction($auctionId)
    {

        if (!isset($this->_receiptCache[$auctionId])) {

            $this->_receiptCache[$auctionId] = $this->_rest->get(
                'receipt',
                [
                    'query' => [
                        'auction' => $auctionId
                    ]
                ],
                [],
                false
            );
        }

        return $this->_receiptCache[$auctionId];
    }
}