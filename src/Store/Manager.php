<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Manager extends StoreAbstract
{

    public $_base = 'managers';

    public function profile()
    {
        return $this->_rest->get('profile.json');
    }

}