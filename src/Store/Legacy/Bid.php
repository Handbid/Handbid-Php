<?php
/**
 * @copyright Copyright (c) 2014-2015 Handbid Inc.
 * @category handbid
 * @package Handbid2-WordPress
 * @license Proprietary
 * @link http://www.handbid.com/
 * @author Master of Code (worldclass@masterofcode.com)
 */

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

        return $this->_rest->get(
            'auction/bids/' . $auctionId,
            [],
            [],
            false
        );

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

    public function createBid($values) {
        try {

            $post = $this->preparePostVars($values);

            return $this->_rest->post('bid/create', $post);


        } catch (\Exception $e) {
            return $e;
        }
    }

    public function removeBid($bidID) {
        try {

            return $this->_rest->post('bid/remove/'. ((int) $bidID), array());

        } catch (\Exception $e) {
            return $e;
        }
    }

}