<?php

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

    public function get($route, $query = [], $headers = [], $useCache = true)
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
    public function _request($method, $route, $query = [], $data = [], $headers = [], $useCache = true)
    {

        $method = strtoupper($method);

        //store for posterity
        $this->_curlHandle = curl_init();
        curl_setopt($this->_curlHandle, CURLOPT_RETURNTRANSFER, true);

        $method  = strtoupper($method);
        $headers = ($headers) ? $headers : $this->_headers;
        $uri     = $this->resolveRoute($route);

        if ($this->_auth) {
            $this->_auth->initRequest($method, $uri, $query, $data, $headers);
        }

        //build query string
        $query = ($query) ? http_build_query($query) : '';

        $cacheKey = $uri . '-' . $query . '-' . $method;
        if ($method != 'GET' || !($this->_cacheAdapter->hasCache($route, $query, $headers) && $useCache)) {

            if ($headers) {

                $_headers = [];
                foreach ($headers as $k => $v) {
                    $_headers[] = $v;
                }

                curl_setopt($this->_curlHandle, CURLOPT_HTTPHEADER, $_headers);
            }

            if ($method === 'POST') {
                //setup our request for posting data, yo!

                curl_setopt($this->_curlHandle, CURLOPT_POST, true);
                curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);
                curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $data);

            } elseif ($method === 'GET' && $query) {
//                $uri = $uri . '?' . $query;
                curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);

            } elseif ($method === 'DELETE') {
                curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);
                curl_setopt($this->_curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $query);

            } else {
                curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);

            }

            $responseText = curl_exec($this->_curlHandle);
            $info         = curl_getinfo($this->_curlHandle);

            //no content, should we care?
            if ($info['http_code'] == 204) {
                throw new NetworkException('No response from server', 70000);
            } //oops
            elseif ($info['http_code'] != 200) {

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

}