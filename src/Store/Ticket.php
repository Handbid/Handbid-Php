<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Ticket extends StoreAbstract
{

    public $_base = 'tickets';

    public function byAuction($id, $query = []) {
        return $this->_rest->get('auctions/' . $id . '/tickets.json', $query);
    }

}