<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Auction extends StoreAbstract
{

    public $_base = 'auctions';

    /**
     * Auctions by org
     *
     * @param $id
     * @return mixed
     */
    public function byOrg($id)
    {
        return $this->_rest->get('/orgs/' . $id . '/auctions/.json');
    }


    public function recent() {
        return $this->all();
    }

    public function past() {
        return $this->all();
    }

}