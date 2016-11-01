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

use Handbid\Store\Legacy\StoreAbstract;

class Ticket extends StoreAbstract
{

    public $_base = 'ticket';
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

    public function checkDiscountCode($ticketIds, $code) {
        try {

            $post = $this->preparePostVars(
                [
                    'ticketIds' => implode(',',$ticketIds),
                    'discountCode' => $code,
                ]
            );
            $resp = $this->_rest->post('ticket/checkdiscount', $post);

            return $resp;

        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage(),
            ];
        }
    }

}