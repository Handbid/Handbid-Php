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
    public function _fetchBidderBids($auctionId)
    {

            return $this->_rest->get(
                'auction/mybids/' . $auctionId,
                [
                ],
                [],
                false
            );
    }


    public function _fetchItemBids($itemId)
    {

         return $this->_rest->get(
                'item/bids/' . $itemId,
                [],
                [],
                false
            );

    }

    public function itemBids($itemId)
    {
        return $this->_fetchItemBids($itemId);
    }

    public function itemProxyBids($itemId)
    {
        return $this->_fetchItemBids($itemId);

    }

    public function itemPurchases($itemId)
    {
        return $this->_fetchItemBids($itemId);
    }

    public function myWinning($auctionId)
    {

        $bids = $this->_fetchBidderBids($auctionId);

        $winning = [];

        if ($bids) {

            foreach ($bids as $bid) {

                if ($bid->status == 'winning') {
                    $winning[] = $bid;
                }

            }

        }

        return $winning;

    }

    public function myBids($auctionId)
    {

        return $this->_fetchBidderBids($auctionId);
    }

    public function myProxyBids($auctionId)
    {
        return $this->_fetchBidderBids($auctionId);
    }

    public function myPurchases($auctionId)
    {
        $purchases = $this->_rest->get(
            'auction/purchases/' . $auctionId,
            [
            ],
            [],
            false
        );

        return $purchases;
    }

    public function myLosing($auctionId)
    {

        $bids   = $this->_fetchBidderBids($auctionId);

        $losing = [];

        if ($bids) {

            foreach ($bids as $bid) {

                if ($bid->status == 'losing') {
                    $losing[] = $bid;
                }

            }

        }

        return $losing;


    }
}