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
    public function _fetchBidderBids($auctionId, $query = [])
    {

            return $this->_rest->get(
                'auction/mybids/' . $auctionId,
                $query,
                [],
                false
            );
    }


    public function _fetchItemBids($itemId, $query = [])
    {

         return $this->_rest->get(
                'publicitem/bids/' . $itemId,
                [
                    $query
                ],
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

    public function myBids($auctionId)
    {

        return $this->_fetchBidderBids($auctionId, ['all_bids']);
    }

    public function myWinning($auctionId)
    {
        return $this->_fetchBidderBids($auctionId, ['winning']);
    }

    public function myLosing($auctionId)
    {
        return $this->_fetchBidderBids($auctionId, ['losing']);
    }

    public function myProxyBids($auctionId)
    {
        return $this->_fetchBidderBids($auctionId, ['max_bids']);
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

}