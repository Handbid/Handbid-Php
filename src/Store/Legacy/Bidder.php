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

        try {

            if (!$this->_profileCache) {
                $this->_profileCache = $this->_rest->get('profile')->Users[0];
            }

            $profile = clone $this->_profileCache;
            unset($profile->_restMetaData, $profile->favoriteItems);

        } catch (Excetion $e) {
            $profile = null;
        }

        return $profile;
    }

    /**
     * Because proxy bids, bids, and purchases come back in 1 request i do not want us making the same request
     * many times
     *
     * @param        $auctionId
     * @param string $type
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

    public function updateProfile($values)
    {

        if(!$this->myProfile()) {
            throw new \Exception('You must be logged in to update your profile.');
        }

        $profile = $this->myProfile();

        if($values['photo']) {

            $photo = $values['photo'];

            if(!file_exists($photo)) {
                throw new \Exception('I could not find a photo at ' + $photo);
            }

            $values['photo'] = '@' . $photo . ';filename=' . basename($photo);

        }

        return $this->_rest->post('models/User/' . $profile->_id, ['values' => $values]);


    }

    public function myBids($auctionId)
    {
        $bids = $this->_fetchBids($auctionId);

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

        return $winning;
    }

    public function myProxyBids($auctionId)
    {
        $bids = $this->_fetchBids($auctionId, 'ProxyBid');

        return $bids ? $bids->ProxyBids : null;
    }

    public function myPurchases($auctionId)
    {
        $bids = $this->_fetchBids($auctionId, 'Purchase');

        return $bids ? $bids->Purchases : null;
    }

    public function myLosing($auctionId)
    {

        $bids   = $this->_fetchBids($auctionId);
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

        return $losing;


    }

}