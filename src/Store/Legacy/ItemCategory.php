<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class ItemCategory extends StoreAbstract
{

    public $_base = 'models/ItemCategory';
    public $_resultsKey = 'ItemCategory';
    public $_resultsKeyPlural = 'ItemCategories';

    /**
     * Gets you
     *
     * @param $id
     *
     * @return mixed
     */
    public function byAuction($id)
    {
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