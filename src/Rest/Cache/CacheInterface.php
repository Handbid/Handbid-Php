<?php
/**
 * @copyright Copyright (c) 2014-2015 Handbid Inc.
 * @category handbid
 * @package Handbid2-WordPress
 * @license Proprietary
 * @link http://www.handbid.com/
 * @author Master of Code (worldclass@masterofcode.com)
 */

namespace Handbid\Rest\Cache;

interface CacheInterface {


	public function __construct($options);

	public function hasCache( $route, $query, $headers );

	public function getCache( $route, $query, $headers );

	public function setCache( $route, $query, $headers, $response );

}