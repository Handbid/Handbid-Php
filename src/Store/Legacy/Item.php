<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Item extends StoreAbstract{

    public $_base = 'models/Item';
    public $_resultsKey = 'Item';

    public function byAuction($id) {
        return $this->mapMany(
            $this->_rest->get(
                $this->_base,
                [
                    'config' => ['limit' => 9999],
                    'query'  => ['auction' => $id]
                ]
            )->{$this->_resultsKeyPlural}
        );
    }

}