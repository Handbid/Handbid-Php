<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Organization extends StoreAbstract
{

    public $_base = 'models/Organization';
    public $_resultsKey = 'Organization';


    public function count($query = []) {
        return $this->_rest->get('organizations/count', $query)->count;
    }
}