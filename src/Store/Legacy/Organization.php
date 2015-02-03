<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Organization extends StoreAbstract
{

    public $_base = 'organization';
    public $_resultsKey = 'Organization';


    public function count($query = []) {
        return $this->_rest->get('organization/count', $query)->count;
    }
}