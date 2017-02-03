<?php
/**
 * @copyright Copyright (c) 2014-2015 Handbid Inc.
 * @category handbid
 * @package Handbid2-WordPress
 * @license Proprietary
 * @link http://www.handbid.com/
 * @author Master of Code (worldclass@masterofcode.com)
 */

namespace Handbid\Rest;

use Handbid\Auth\AuthInterface;
use Handbid\Exception\Network as NetworkException;
use Handbid\Rest\Cache\CacheInterface;
use Handbid\Rest\Cache\Noop;
use Handbid\Rest\RestInterface;

class Rest implements RestInterface
{
    public $_curlHandle,
        $_endpoint,
        $_basePath,
        $_auth,
        $_cacheAdapter = null,
        $_error = [],
        $_headers = [];

    public function __construct($endpoint, $basePath, $cacheAdapter = null)
    {

        if (!$cacheAdapter) {
            $cacheAdapter = new Noop();
        }

        $this->_endpoint     = $endpoint;
        $this->_basePath     = $basePath;
        $this->_cacheAdapter = $cacheAdapter;

//        $this->_serverAddress = !is_null($serverAddress) ? $serverAddress : $this->_error[] = 'Rest Error: server address must be defined';
//        $this->_basePath = !is_null($basePath) ? $basePath : $this->_error[] = 'Rest Error: base path must be defined';
//
//        if (count($this->error)) {
//            throw(new \Exception($this->error[0]));
//            //@todo: log the errors
//        }
//
//

    }

    public function get($route, $query = [], $headers = [], $useCache = false)
    {
        return $this->_request('get', $route, $query, [], $headers, $useCache);
    }

    public function post($route, $data = [], $query = [], $headers = [])
    {
        return $this->_request('post', $route, $query, $data, $headers);
    }

    public function setAuth(\Handbid\Auth\AuthInterface $auth)
    {
        $this->_auth = $auth;
    }

    public function put($route, $data = [], $query = [], $headers = [])
    {
        return $this->_request('PUT', $route, $query, $data, $headers);
    }

    public function delete($route, $query = [], $headers = [])
    {
        return $this->_request('DELETE', $route, $query, $headers);
    }

    public function auth()
    {
        return $this->_auth;
    }

    /**
     * Request utility. Actually makes requests.
     *
     * @param string $method [get, post, put, delete]
     * @param        $route  the path (not including endpoint and base path)
     * @param array  $query  added to the query string of the route, e.g. ?foo=bar&hello=world
     * @param array  $data   data for any post or put
     * @param array  $headers
     *
     * @param bool   $useCache
     *
     * @throws NetworkException
     * @return mixed
     */
    public function _request($method, $route, $query = [], $data = [], $headers = [], $useCache = false)
    {
        $method = strtoupper($method);

        //store for posterity
        $this->_curlHandle = curl_init();
        curl_setopt($this->_curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_curlHandle, CURLOPT_SSL_VERIFYHOST, '2');
        curl_setopt($this->_curlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);

        $method  = strtoupper($method);
        $headers = ($headers) ? $headers : $this->_headers;
        $uri     = $this->resolveRoute($route);

        if ($this->_auth) {
            $this->_auth->initRequest($method, $uri, $query, $data, $headers);
        }

        //build query string
        //$query = ($query) ? $this->buildFilter($query) : '';
        $query = ($query) ? $this->buildParamQuery($query) : '';

        $cacheKey = $uri . '-' . $query . '-' . $method;
        if ($method != 'GET' || !($this->_cacheAdapter->hasCache($route, $query, $headers) && $useCache)) {

            if ($headers) {

                $_headers = [];
                foreach ($headers as $k => $v) {
                    $_headers[] = $v;
                }

                curl_setopt($this->_curlHandle, CURLOPT_HTTPHEADER, $_headers);
            }

            if($method === 'POST' OR $method === 'PUT') {
                $h = [];

                if(isset($_headers) && $_headers) {

                    // Lets add the proper headers
                    forEach($_headers as $k => $v) {
                        $h[] = $v;
                    }

                }

                $_mixedHeaders = array_merge(array(
                    'Content-Type: application/json',
                    'Expect:',
                ), $h);
            }


            if ($method === 'POST') {
                //setup our request for posting data, yo!

                $_mixedHeaders[] = 'Accept: application/json';

                curl_setopt($this->_curlHandle, CURLOPT_HTTPHEADER, $_mixedHeaders);
                curl_setopt($this->_curlHandle, CURLOPT_POST, true);
                curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);
                curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $data);

            } elseif ($method === 'GET') {
                if($query) {
                    $uri = $uri . '?' . $query;
                }
                curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);

            } elseif ($method === 'DELETE') {
                curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);
                curl_setopt($this->_curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $query);

            } elseif ($method === 'PUT') {

                curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);
                curl_setopt($this->_curlHandle, CURLOPT_CUSTOMREQUEST, 'PUT');

                curl_setopt($this->_curlHandle, CURLOPT_HTTPHEADER, $_mixedHeaders);
                curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $data);
            }
            else {
                curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);
            }

            $responseText = curl_exec($this->_curlHandle);
            $info         = curl_getinfo($this->_curlHandle);
//echo "<pre>" . print_r($uri, true) . "</pre>";
            //no content, should we care?
            if ($info['http_code'] == 204) {
                throw new NetworkException('No response from server', 70000);
            } //oops
            if ($info['http_code'] == 401) {
                return null;
            }
            elseif ($info['http_code'] != 200 and $info['http_code'] != 201) {

                $response = json_decode($responseText);
                if ($response && isset($response->Errors)) {
                    throw new NetworkException($response->Errors[0]->description, $info['http_code']);
                } else {
                    throw new NetworkException(
                        'Unknown response from server with url of (' . $info['url'] . ') Http Code:' . $info['http_code']
                    );
                }

            } //this is a strange one and should really never happen
            elseif (!$responseText) {

                throw new NetworkException('Response was empty.', Network::ERROR_REQUEST_FAILED);

            } //all is well
            else {
                if ($useCache) {
                    $this->_cacheAdapter->setCache($route, $query, $headers, $responseText);
                }

                $response = json_decode($responseText);
            }


        } else {

            $response = json_decode($this->_cacheAdapter->getCache($route, $query, $headers));

        }

        return $response;
    }

    public function resolveRoute($partial)
    {
        return $this->_endpoint . $this->_basePath . $partial;
    }

    public function buildFilter($filters) {

        $filter = (isset($filters[0]) && $filters[0]) ? 'filter=' . implode(',', $filters) : '';

        return $filter;

    }

    public function buildParamQuery($filters) {

        $params = [];

        if(isset($filters["query"]) and is_array($filters["query"]) and count($filters["query"])){
            foreach($filters["query"] as $param => $value){
                if(!is_array($value) and !is_object($value) and trim($value))
                    $params[] = $param . "=" . urlencode($value);
                if(is_array($value)){
                    if(is_array($value['$in']) and count($value['$in'])){
                        $params[] = $param . "=" . implode(",", $value['$in']);
                    }
                }
            }
        }

        if(isset($filters["config"]) and is_array($filters["config"]) and count($filters["config"])){
            foreach($filters["config"] as $param => $value){
                if(!is_array($value) and !is_object($value) and trim($value))
                    $params[] = $param . "=" . urlencode($value);
            }
        }

        if(!empty($filters["options"]["search"])){
            $params[] = "search=" . urlencode($filters["options"]["search"]);
        }

        $params[] = 'web_app=true';

        return (count($params)) ? implode("&", $params) : "" ;

    }

}