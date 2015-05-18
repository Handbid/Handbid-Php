<?php
/**
 * @copyright Copyright (c) 2014-2015 Handbid Inc.
 * @category handbid
 * @package Handbid2-WordPress
 * @license Proprietary
 * @link http://www.handbid.com/
 * @author Master of Code (worldclass@masterofcode.com)
 */

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Bid extends StoreAbstract
{

    public $_base = 'items';

    public function byItem($auctionId, $itemId)
    {
        return $this->_rest->get('auctions/' . $auctionId . '/items/' . $itemId . '/bids.json');
    }

}