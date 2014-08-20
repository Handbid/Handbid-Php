<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class CreditCard extends StoreAbstract
{

    public function getCardByOwnerId($id)
    {
        $creditCard = $this->_rest->get(
            'models/CreditCard',
            [
                'query' => [
                    'owner' => $id
                ]
            ]
        );

        return $creditCard;
    }

    public function saveCardByOwnerId($id, $options)
    {

        $creditCard = $this->_rest->post('models/CreditCard', $options);

        return $creditCard;
    }


}