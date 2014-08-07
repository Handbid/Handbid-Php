<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Bidder extends StoreAbstract
{

    public $_profileCache = null;
    public $_bidCache = null;

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
    public function _fetchBids($auctionId)
    {

        if (!$this->myProfile()) {
            return (object)[
                'Bids'      => [],
                'ProxyBids' => [],
                'Purchases' => []
            ];
        }

        if (!$this->_bidCache) {

            $profile = $this->myProfile();

            $this->_bidCache = $this->_rest->get(
                'models/Bid',
                [
                    'query' => [
                        'auction' => $auctionId,
                        'pin'     => $profile->pin
                    ]
                ]
            );
        }

        return $this->_bidCache;
    }

    public function myStats($auctionId)
    {
        if (!$this->myProfile()) {
            return [];
        }

        return $this->_profileCache && isset($this->_profileCache->_restMetaData->bidStats->{$auctionId}) ? $this->_profileCache->_restMetaData->bidStats->${auctionId} : null;

    }

    public function myBids($auctionId)
    {
        $bids = $this->_fetchBids($auctionId);

        return $bids->Bids;
    }

    public function myProxyBids($auctionId)
    {
        $bids = $this->_fetchBids($auctionId);

        return $bids->ProxyBids;
    }

    public function myPurchases($auctionId)
    {
        $bids = $this->_fetchBids($auctionId);

        return $bids->Purchases;
    }

}