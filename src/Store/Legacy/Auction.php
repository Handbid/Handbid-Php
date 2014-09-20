<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Auction extends StoreAbstract
{

    public $_base = 'models/Auction';
    public $_resultsKey = 'Auction';

    public function byOrg($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $id)
    {

        $query = ['organization' => $id];
        return $this->all($page, $pageSize, $sortField, $sortDirection, $query);

    }

    public function upcoming($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $orgId = '')
    {

        $query = ['startTime' => ['$gt' => time() - 3600]];

        if ($orgId) {
            $query['organization'] = $orgId;
        }

        return $this->all($page, $pageSize, $sortField, $sortDirection, $query);
    }

    public function past($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $orgId = '')
    {
        $query = ['startTime' => ['$lt' => time() - 3600]];

        if ($orgId) {
            $query['organization'] = $orgId;
        }

        return $this->all($page, $pageSize, $sortField, $sortDirection, $query);
    }

    public function map($entity)
    {

        $entity->location->coords = null;
        $entity->meta = (object)[
            'totalItems' => $entity->_restMetaData->numItems,
            'organization' => (object)[
                'key' => isset($entity->_restMetaData->organization) ? $entity->_restMetaData->organization->key : null,
                'name' => isset($entity->_restMetaData->organization) ? $entity->_restMetaData->organization->name : null,
            ]
        ];

        return $entity;

    }

    public function count($query = [])
    {
        return $this->_rest->get('auctions/count', $query)->count;
    }

    public function myRecent($query = [])
    {

        return $this->mapMany($this->_rest->get('my-auctions', [
            'query' => $query
        ])->auctions);

    }
}