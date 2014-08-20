<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class CreditCard extends StoreAbstract
{

    public function getCardForBidder($profile)
    {
        if (!$this->_rest->auth()->hasToken()) {
            return null;
        }

        $creditCard = $this->_rest->get(
            'models/CreditCard',
            [
                'query' => [
                    'owner' => $profile->_id
                ]
            ]
        );

        return $creditCard;
    }

}