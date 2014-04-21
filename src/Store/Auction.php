<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Auction extends StoreAbstract
{

    public $_base = 'auctions';

    /**
     * Auctions by org, simply stubbed out for now.
     *
     * @param $id
     * @return mixed
     */
    public function byOrg($id)
    {
        return $this->all(1, 2);
    }

}