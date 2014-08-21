<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class CreditCard extends StoreAbstract
{

    public function byOwner($id)
    {
        $creditCards = $this->_rest->get(
            'models/CreditCard',
            [
                'query' => [
                    'owner' => $id
                ]
            ]
        );

        return $this->mapMany($creditCards->CreditCards);
    }

    public function add($profileId, $values)
    {

        $values['owner']        = $profileId;
        $values['isActiveCard'] = true;

        $creditCard = $this->_rest->post('models/CreditCard', $this->preparePostVars($values));

        return $creditCard;
    }


}