<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Auction extends StoreAbstract
{

    public $_base = 'models/Auction';
    public $_resultsKey = 'Auction';

    public function byOrg($id)
    {
        return $this->mapMany($this->_rest->get($this->_base, ['query' => ['organization' => $id]])->{$this->_resultsKey . 's'});
    }

    public function upcoming($orgId = '')
    {

        $query = ['startTime' => ['$gt' => time() - 3600]];

        if ($orgId) {
            $query['organization'] = $orgId;
        }

        return $this->mapMany($this->_rest->get($this->_base, ['query' => $query])->{$this->_resultsKeyPlural});
    }

    public function past($orgId = '')
    {
        $query = ['startTime' => ['$lt' => time() - 3600]];

        if ($orgId) {
            $query['organization'] = $orgId;
        }

        return $this->mapMany($this->_rest->get($this->_base, ['query' => $query])->{$this->_resultsKeyPlural});
    }

    public function map($entity)
    {

        $entity->location->coords = null;
        $entity->meta = (object)[
            'totalItems' => $entity->_restMetaData->numItems,
            'organization' => (object)[
                'key'  => isset($entity->_restMetaData->organization) ? $entity->_restMetaData->organization->key : null,
                'name' => isset($entity->_restMetaData->organization) ? $entity->_restMetaData->organization->name : null,
            ]
        ];

        return $entity;

    }


}