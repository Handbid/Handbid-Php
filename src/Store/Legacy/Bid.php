<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Bid extends StoreAbstract
{

    public $_bidCache = [];
    public $_base = 'bid';

    /**
     * Because proxy bids, bids, and purchases come back in 1 request i do not want us making the same request
     * many times
     *
     * @param $bidderPin
     * @param $auctionId
     *
     * @internal param string $type
     *
     * @return array
     */
    public function _fetchBidderBids($bidderPin, $auctionId)
    {


        if (!isset($this->_bidCache[$auctionId])) {

            $this->_bidCache[$auctionId] = $this->_rest->get(
                'models/Bid',
                [
                    'query' => [
                        'auction' => $auctionId,
                        'pin'     => $bidderPin
                    ]
                ],
                [],
                false
            );
        }

        return $this->_bidCache[$auctionId];
    }


    public function _fetchItemBids($itemId)
    {

//        if (!isset($this->_bidCache[$itemId])) {

         return $this->_rest->get(
                'models/Bid',
                [
                    'query' => [
                        'item' => $itemId
                    ]
                ],
                [],
                false
            );
//        }

//        return $this->_bidCache[$itemId];

    }

    public function itemBids($itemId)
    {
        $bids = $this->_fetchItemBids($itemId);
        return $bids ? $this->mapMany($bids->Bids) : [];
    }

    public function itemProxyBids($itemId)
    {
        $bids = $this->_fetchItemBids($itemId);
        return $bids ? $this->mapMany($bids->ProxyBids) : [];
    }

    public function itemPurchases($itemId)
    {
        $bids = $this->_fetchItemBids($itemId);
        return $bids ? $this->mapMany($bids->Purchases) : [];
    }

    public function myBids($bidderPin, $auctionId)
    {
        $bids = $this->_fetchBidderBids($bidderPin, $auctionId);

        if (!$bids) {
            return null;
        }

        $winning = [];

        if ($bids) {

            $bids = $bids->Bids;

            foreach ($bids as $bid) {

                if ($bid->status == 'winning') {
                    $winning[] = $bid;
                }

            }

        }

        return $this->mapMany($winning);
    }

    public function myProxyBids($bidderPin, $auctionId)
    {
        $bids = $this->_fetchBidderBids($bidderPin, $auctionId);

        return $bids ? $this->mapMany($bids->ProxyBids) : null;
    }

    public function myPurchases($bidderPin, $auctionId)
    {
        $bids = $this->_fetchBidderBids($bidderPin, $auctionId);

        return $bids ? $this->mapMany($bids->Purchases) : null;
    }

    public function myLosing($bidderPin, $auctionId)
    {

        $bids   = $this->_fetchBidderBids($bidderPin, $auctionId);
        $losing = [];

        if (!$bids) {
            return null;
        }

        if ($bids) {

            $bids = $bids->Bids;

            foreach ($bids as $bid) {

                if ($bid->status == 'losing') {
                    $losing[] = $bid;
                }

            }

        }

        return $this->mapMany($losing);


    }

    public function map($bid)
    {

        if (isset($bid->_restMetaData)) {

            $bid->winningBidder = (object)[
                'alias' => $bid->_restMetaData->bidderAlias,
                'name'  => $bid->_restMetaData->bidderName,
                'pin'   => isset($bid->_restMetaData->bidderPin) ? $bid->_restMetaData->bidderPin : null,
                'id'    => isset($bid->_restMetaData->bidderId) ? $bid->_restMetaData->bidderId : null
            ];

            $bid->meta = [
                'itemName' => isset($bid->_restMetaData->itemName) ? $bid->_restMetaData->itemName : null,
                'itemKey'  => isset($bid->_restMetaData->itemKey) ? $bid->_restMetaData->itemKey : null
            ];

            unset($bid->_restMetaData);
        }

        return $bid;
    }

}