<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Item extends StoreAbstract
{

    public $_base = 'item';
    public $_resultsKey = 'Item';
    public $_itemCache = [];
    public $_bidCache = [];

    public function byAuction($id, $query = [])
    {

        $query = array_merge(
            [
                'config' => [
                    'limit' => 9999
                ],
                'query' => [
                    'auction' => $id
                ]
            ],
            $query
        );

        $queryKey = serialize($query);

        $this->_itemCache[$queryKey] = $this->mapMany(
            $this->_rest->get(
                $this->_base,
                $query,
                [],
                false
            )->{$this->_resultsKeyPlural}
        );

        return $this->_itemCache[$queryKey];

    }

    public function biddableByAuction($id, $query = [])
    {

        $items = $this->byAuction($id, $query);
        $biddable = [];

        foreach ($items as $item) {
            if (!$item->isDirectPurchaseItem) {
                $biddable[] = $item;
            }
        }

        return $biddable;

    }

    public function purchasableByAuction($id, $query = [])
    {

        $items = $this->byAuction($id, $query);
        $purchasable = [];

        foreach ($items as $item) {
            if ($item->isDirectPurchaseItem) {
                $purchasable[] = $item;
            }
        }

        return $purchasable;

    }

    public function map($entity)
    {

        $entity->terms = [$entity->_restMetaData->categoryName];
        $entity->closingTime = $entity->_restMetaData->closingTime;
        $entity->highestBid = isset($entity->highestBid->amount) ? $entity->highestBid->amount : null;

        if (isset($entity->_restMetaData->leadingBidderAlias)) {

            $entity->winningBidder = (object)[
                'alias' => $entity->_restMetaData->leadingBidderAlias,
                'id' => $entity->_restMetaData->leadingBidderId,
                'pin' => $entity->_restMetaData->leadingBidderPin
            ];

        }


        $entity->meta = $entity->_restMetaData;

        return $entity;
    }

    public function byKey($key, $query = [])
    {

        $query = array_merge(
            [
                'query' => [
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

        return parent::byKey($key, $query, false);
    }

    public function related($id, $options = [])
    {

        $query = array_merge(
            [
                'query' => [
                    'itemId'     => $id
                ],
                'config' => [
                    'skip'  => 0,
                    'limit' => 5
                ],
                'options' => [
                    'images' => [
                        'w' => 400,
                        'h' => false
                    ]
                ]
            ],
            $options
        );

        $results = $this->mapMany($this->_rest->get(
            'items/related',
            $query,
            [],
            [],
            false
        ));

        return $results;

    }


}