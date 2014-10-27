<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Ticket extends StoreAbstract
{

    public $_base = 'tickets';
    public $_ticketCache = [];

    public function byAuction($id, $query = [])
    {

        $query = array_merge(
            [
                'auctionKey' => $id
            ],
            $query
        );

        $queryKey = serialize($query);

        //$this->_ticketCache[$queryKey] = $this->mapMany(
        $tickets = $this->_rest->get(
            $this->_base,
            $query
        );
        //);

        return $tickets;

        return $this->_ticketCache[$queryKey];

    }

}