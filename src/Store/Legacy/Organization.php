<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Organization extends StoreAbstract
{

    public $_initBase = 'organization';
    public $_base = 'publicorganization';
    public $_resultsKey = 'Organization';

    public function count($query = []) {
        return $this->_rest->get($this->_base . '/count', $query)->count;
    }

    public function setBasePublicity($public = true)
    {
        $this->_base = $public ? "public" . $this->_initBase : $this->_initBase ;
    }
}