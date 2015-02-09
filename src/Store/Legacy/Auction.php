<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Auction extends StoreAbstract
{

    public $_base = 'auction';
    public $_resultsKey = 'Auction';

    public function _queryAll()
    {
        return [];
    }

    public function _queryUpcoming()
    {
        return ['startTime' => ['$gt' => time() - 3600]];
    }

    public function _queryPast()
    {
        return ['startTime' => ['$lt' => time() - 3600]];
    }

    public function _queryCurrent()
    {
        return ['status' => ['$in' => ['open', 'extended', 'preview', 'presale', 'ending']]];
    }

    public function _queryOpen()
    {
        return ['status' => ['$in' => ['open', 'extended', 'ending']]];
    }

    public function _queryClosed()
    {
        return ['status' => 'closed'];
    }

    public function _queryPreview()
    {
        return ['status' => 'presale'];
    }

    public function _queryPresale()
    {
        return ['status' => 'presale'];
    }

    public function byOrg($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $id = '')
    {
        $query = ['organization' => $id];
        return $this->all($page, $pageSize, $sortField, $sortDirection, $query, false, false);
    }

    public function upcoming($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $orgId = '')
    {

        $query = $this->_queryUpcoming();

        if ($orgId) {
            $query['organization'] = $orgId;
        }

        return $this->all($page, $pageSize, $sortField, $sortDirection, $query, false, false);
    }

    public function past($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $orgId = '')
    {
        $query = $this->_queryPast();

        if ($orgId) {
            $query['organization'] = $orgId;
        }

        return $this->all($page, $pageSize, $sortField, $sortDirection, $query, false, false);
    }

    public function byStatus(
        $status,
        $page = 0,
        $pageSize = 25,
        $sortField = 'name',
        $sortDirection = 'ASC',
        $orgId = ''
    ) {

        $query = $this->{'_query' . ucfirst($status)}();

        if ($orgId) {
            $query['organization'] = $orgId;
        }

        return $this->all($page, $pageSize, $sortField, $sortDirection, $query, false, false);

    }

    public function current($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $orgId = '')
    {
        $query = $this->_queryCurrent();

        if ($orgId) {
            $query['organization'] = $orgId;
        }

        return $this->all($page, $pageSize, $sortField, $sortDirection, $query, false, false);
    }

    public function open($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $orgId = '')
    {
        return $this->byStatus('open', $page, $pageSize, $sortField, $sortDirection, $orgId);
    }

    public function closed($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $orgId = '')
    {
        return $this->byStatus('closed', $page, $pageSize, $sortField, $sortDirection, $orgId);
    }

    public function preview($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $orgId = '')
    {
        return $this->byStatus('preview', $page, $pageSize, $sortField, $sortDirection, $orgId);
    }

    public function presale($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $orgId = '')
    {
        return $this->byStatus('presale', $page, $pageSize, $sortField, $sortDirection, $orgId);
    }

    public function map($entity)
    {

        $entity->location->coords = null;
        $entity->meta             = (object)[
            'totalItems'   => $entity->_restMetaData->numItems,
            'organization' => (object)[
                'key'  => isset($entity->_restMetaData->organization) ? $entity->_restMetaData->organization->key : null,
                'name' => isset($entity->_restMetaData->organization) ? $entity->_restMetaData->organization->name : null,
            ]
        ];

        return $entity;

    }

    public function count($type = 'all')
    {

        $query = $this->{'_query' . ucfirst($type)}();

        return $this->_rest->get('auction/count', ['query' => $query], [], false)->count;
    }

    public function myRecent($query = [])
    {

        return $this->_rest->get(
                'auction',
                [
                    'query' => $query,
                ],
                [],
                false
            );

    }
}