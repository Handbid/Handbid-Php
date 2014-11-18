<?php

namespace Handbid\Rest\Cache;

interface CacheInterface {


	public function __construct($options);

	public function hasCache( $route, $query, $headers );

	public function getCache( $route, $query, $headers );

	public function setCache( $route, $query, $headers, $response );

}