<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class CreditCard extends StoreAbstract
{
    public $_base = 'creditcard';

    public function byOwner($id)
    {
        $creditCards = $this->_rest->get(
            'creditcard',
            [
            ],
            [],
            false
        );

        return $creditCards;
    }

    public function add($values)
    {
        $creditCard = $this->_rest->post('creditcard/create', $this->preparePostVars($values));

        return $creditCard;
    }
    public function delete($id)
    {
        $creditCard = $this->_rest->delete('creditcard/delete/' . $id);

        return $creditCard;
    }


}