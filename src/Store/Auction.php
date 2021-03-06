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

class Auction extends StoreAbstract
{

    public $_base = 'auctions';

    /**
     * Auctions by org
     *
     * @param $id
     * @return mixed
     */
    public function byOrg($id)
    {
        return $this->_rest->get('orgs/' . $id . '/auctions.json', [], [], false);
    }


    public function upcoming($orgId = '')
    {

        if ($orgId) {
            return $this->_rest->get('orgs/' . $orgId . '/auctions/upcoming.json');
        } else {

            return $this->_rest->get('auctions/upcoming.json', [], [], false);
        }
    }

    public function past($orgId = '')
    {
        if ($orgId) {
            return $this->_rest->get('orgs/' . $orgId . '/auctions/past.json', [], [], false);
        } else {

            return $this->_rest->get('auctions/past.json', [], [], false);
        }
    }

}