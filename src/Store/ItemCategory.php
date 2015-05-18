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

class ItemCategory extends TaxonomyTerm
{

    /**
     * Gets you
     * @param $id
     *
     * @return mixed
     */
    public function byAuction($id, $query = [])
    {
        return $this->_rest->get('auctions/' . $id . '/terms.json', $query);
    }

}