<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Bidder extends StoreAbstract
{

    public $_profileCache = null;
    public $_bidCache = [];

    public function myProfile()
    {

        if (!$this->_rest->auth()->hasToken()) {
            return null;
        }

        if (!$this->_profileCache) {
            $this->_profileCache = $this->_rest->get('profile')->Users[0];
        }

        $profile = clone $this->_profileCache;
        unset($profile->_restMetaData, $profile->favoriteItems);

        return $profile;
    }

    /**
     * Because proxy bids, bids, and purchases come back in 1 request i do not want us making the same request
     * many times
     *
     * @return array
     */
    public function _fetchBids($auctionId, $type = 'Bid')
    {

        if (!$this->myProfile()) {
            return null;
        }

        if (!isset($this->_bidCache[$auctionId])) {

            $profile = $this->myProfile();

            $this->_bidCache[$auctionId] = $this->_rest->get(
                'models/' . $type,
                [
                    'query' => [
                        'auction' => $auctionId,
                        'pin'     => $profile->pin
                    ]
                ]
            );
        }

        return $this->_bidCache[$auctionId];
    }


    public function myBids($auctionId)
    {
        $bids = $this->_fetchBids($auctionId);
        $winning = [];

        if($bids) {

            $bids = $bids->Bids;

            foreach($bids as $bid) {

                if($bid->status == 'winning') {
                    $winning[] = $bid;
                }

            }

        }

        return $winning;
    }

    public function myProxyBids($auctionId)
    {
        $bids = $this->_fetchBids($auctionId, 'ProxyBid');

        return $bids ? $bids->ProxyBids : [];
    }

    public function myPurchases($auctionId)
    {
        $bids = $this->_fetchBids($auctionId, 'Purchase');

        return $bids ? $bids->Purchases : [];
    }

    public function myLosing($auctionId) {

        $bids = $this->_fetchBids($auctionId);
        $losing = [];

        if($bids) {

            $bids = $bids->Bids;

            foreach($bids as $bid) {

                if($bid->status == 'losing') {
                    $losing[] = $bid;
                }

            }

        }

        return $losing;


    }

}