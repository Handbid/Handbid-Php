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

class Organization extends StoreAbstract
{

    public $_initBase = 'organization';
    public $_base = 'publicorganization';
    public $_resultsKey = 'Organization';

    public function count($query = []) {
        return $this->_rest->get($this->_base . '/count', $query)->count;
    }

    public function setBasePublicity($public = true)
    {
        //$this->_base = $public ? "public" . $this->_initBase : $this->_initBase ;
        $this->_base = "public" . $this->_initBase;
    }
}