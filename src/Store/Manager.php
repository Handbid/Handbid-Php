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

class Manager extends StoreAbstract
{

    public $_base = 'managers';

    public function profile()
    {
        return $this->_rest->get('profile.json');
    }

}