<?php
/**
 * @copyright Copyright (c) 2014-2015 Handbid Inc.
 * @category handbid
 * @package Handbid2-WordPress
 * @license Proprietary
 * @link http://www.handbid.com/
 * @author Master of Code (worldclass@masterofcode.com)
 */

namespace Handbid\Store\Legacy;

use Handbid\Handbid;
use Handbid\Store\Legacy\StoreAbstract;
use Handbid\Store\StoreInterface;
use Handbid\Rest\RestInterface;

class Auction extends StoreAbstract
{

    public $_initBase = 'auction';
    public $_base = 'publicauction';
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
        return ['status' => ['$in' => ['closed', 'reconciled']]];
    }

    public function _queryPreview()
    {
        return ['status' => 'preview'];
    }

    public function _queryPresale()
    {
        return ['status' => 'presale'];
    }

    public function byOrg($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $id = '')
    {
        $query = ['organization' => $id];
        $result = [];
        $auctions = $this->all($page, $pageSize, $sortField, $sortDirection, $query, false, false);
        //$result = $auctions;
        if($id and count($auctions) == 0) return $result;
        foreach($auctions as $auction){
            if($auction->organizationId == $id)
                $result[] = $auction;
        }
        return $result;
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

        return $this->_rest->get($this->_base.'/count', ['query' => $query], [], false)->count;
    }

    public function publicAuctions()
    {

        return $this->_rest->get('publicauction', [], [], false);
    }

    public function allAuctions()
    {

        return $this->_rest->get('auction', [], [], false);
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

    public function setBasePublicity($public = true)
    {
        $this->_base = $public ? "public" . $this->_initBase : $this->_initBase ;
    }



    public function auctionMyInventory($auctionId)
    {
        $purchases = $this->_rest->get(
            'auction/myinventory/' . $auctionId,
            [
            ],
            [],
            false
        );

        return $purchases;
    }


    public function byGuid($guid)
    {
        return $this->_rest->get('publicauction/show', ['query' => ['guid' => $guid]], [], false);
    }
}