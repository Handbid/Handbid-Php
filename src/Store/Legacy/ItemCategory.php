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
    public function byAuction($id, $query = [])
    {
        $query = array_merge(
            [
                'config' => [
                    'limit' => 9999
                ],
                'query'  => [
                    'auction' => $id
                ]
            ],
            $query
        );

        return $this->mapMany(
            $this->_rest->get(
                $this->_base,
                $query
            )->{$this->_resultsKeyPlural}
        );
    }

}