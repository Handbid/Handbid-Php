<?php

namespace Handbid\Rest\Cache;


class Noop implements CacheInterface {

	public function __construct($options)
	{
		// TODO: Implement __construct() method.
	}

	public function hasCache( $route, $query, $headers ) {
		return false;
	}

	public function getCache( $route, $query, $headers ) {
		// TODO: Implement getCache() method.
	}

	public function setCache( $route, $query, $headers, $response ) {
		// TODO: Implement setCache() method.
	}

}