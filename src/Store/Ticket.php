<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Ticket extends StoreAbstract
{

    public $_base = 'tickets';

    /**
     * Auctions by org, simply stubbed out for now.
     *
     * @param $id
     * @return mixed
     */
    public function byAuction($id)
    {
        return $this->all(1, 2);
    }

}