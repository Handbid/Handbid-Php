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

use Handbid\Rest\RestInterface;

interface StoreInterface
{

    public function __construct(RestInterface $rest);

    public function all($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC');
    public function byId($id);
    public function byKey($id);
    public function byField($name, $value);
    public function search($keywords);
    public function create($values);

}