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

class Legacy implements CacheInterface{

    public $_basePath = null;
    public $_fileCache = [];

    public function __construct($options = [])
    {
        if(isset($options['dir'])) {
            $this->setCacheDirectory($options['dir']);
        }
    }

    public function hasCache($route, $query, $headers)
    {

        $file = $this->_generateFileName($route, $query, $headers);

        return file_exists($file);

    }

    public function getCache($route, $query, $headers)
    {
        $fileName = $this->_generateFileName($route, $query, $headers);

        if(isset($this->_fileCache[$fileName])) {
            return $this->_fileCache[$fileName];
        }

        $this->_fileCache[$fileName] = file_get_contents($fileName);

        return $this->_fileCache[$fileName];
    }

    public function setCache($route, $query, $headers, $response)
    {
        $fileName = $this->_generateFileName($route, $query, $headers);

        $this->_fileCache[$fileName] = $response;

        file_put_contents($fileName, $response);
    }

    public function setCacheDirectory($dir)
    {
        $this->_basePath = $dir . '/handbid';
        if(!is_dir($this->_basePath)) {
            mkdir( $this->_basePath, 0755, true );
        }

    }

    public function _generateFileName($route, $query, $headers) {

        $headerKey = ($headers) ? http_build_query($headers) : '';

        $cacheKey = $route . $query . $headerKey;
        $fileName = md5($cacheKey);


        return $this->_basePath . DIRECTORY_SEPARATOR . $fileName . '.json';


    }
}