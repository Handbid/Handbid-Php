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

    public function map($entity)
    {

        $entity->terms = [$entity->_restMetaData->categoryName];
        $entity->closingTime = $entity->_restMetaData->closingTime;
        $entity->highestBid = isset($entity->highestBid->amount) ? $entity->highestBid->amount : null;

        return $entity;
    }

    public function byKey($key)
    {

        $results = $this->_rest->get($this->_base, [
                'query' => [
                    'key' => $key
                ],
                'options' => [
                    'images' => [
                        'w' => 400,
                        'h' => false
                    ]
                ]
            ])->{$this->_resultsKeyPlural};

        if (count($results) == 0) {
            throw new \Handbid\Exception\Network('Could not find entity with key ' . $key);
        }

        $result = $this->map($results[0]);

        return $result;
    }

}