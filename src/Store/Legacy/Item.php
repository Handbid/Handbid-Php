<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Item extends StoreAbstract
{

    public $_base = 'models/Item';
    public $_resultsKey = 'Item';
    public $_itemCache = [];

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

        $queryKey = serialize($query);

        $this->_itemCache[$queryKey] = $this->mapMany(
            $this->_rest->get(
                $this->_base,
                $query
            )->{$this->_resultsKeyPlural}
        );

        return $this->_itemCache[$queryKey];

    }

    public function biddableByAuction($id, $query = [])
    {

        $items = $this->byAuction($id, $query);
        $biddable = [];

        foreach($items as $item) {
            if(!$item->isDirectPurchaseItem) {
                $biddable[] = $item;
            }
        }

        return $biddable;

    }

    public function purchasableByAuction($id, $query = [])
    {

        $items = $this->byAuction($id, $query);
        $purchasable = [];

        foreach($items as $item) {
            if($item->isDirectPurchaseItem) {
                $purchasable[] = $item;
            }
        }

        return $purchasable;

    }

    public function map($entity)
    {

        $entity->terms       = [$entity->_restMetaData->categoryName];
        $entity->closingTime = $entity->_restMetaData->closingTime;
        $entity->highestBid  = isset($entity->highestBid->amount) ? $entity->highestBid->amount : null;

        return $entity;
    }

    public function byKey($key, $query = [])
    {

        $query   = array_merge(
            [
                'query'   => [
                    'key' => $key
                ],
                'options' => [
                    'images' => [
                        'w' => 400,
                        'h' => false
                    ]
                ]
            ],
            $query
        );
        $results = $this->_rest->get(
            $this->_base,
            $query
        )->{$this->_resultsKeyPlural};

        if (count($results) == 0) {
            throw new \Handbid\Exception\Network('Could not find entity with key ' . $key);
        }

        $result = $this->map($results[0]);

        return $result;
    }


}