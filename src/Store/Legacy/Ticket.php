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
                'auctionKey' => $key
            ],
            $query
        );

        $queryKey = serialize($query);

        //$this->_ticketCache[$queryKey] = $this->mapMany(
        $tickets = $this->_rest->get(
            $this->_base,
            $query,
            [],
            false
        );
        //);

        return $tickets;

        return $this->_ticketCache[$queryKey];

    }

}