<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Ticket extends StoreAbstract
{

    public $_base = 'tickets';
    public $_ticketCache = [];

    public function byAuction($key, $query = [])
    {

        $query = array_merge(
            [
                'config' => [
                    'limit' => 9999
                ],
                'query' => [
                    'auctionKey' => $key
                ]
            ],
            $query
        );

        $queryKey = serialize($query);

        $this->_ticketCache[$queryKey] = $this->mapMany(
            $this->_rest->get(
                $this->_base,
                $query
            )->{$this->_resultsKeyPlural}
        );

        return $this->_ticketCache[$queryKey];

    }

}