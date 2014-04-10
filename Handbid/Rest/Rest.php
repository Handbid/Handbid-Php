<?php

namespace Handbid;

use Handbid\Auth\AuthInterface;
use Handbid\RestInterface;

class Rest implements RestInterface
{
    public $_curlHandle,
        $_serverAddress,
        $_basePath,
        $_authUsername,
        $_authPassword,
        $_error = [];

    public function __construct($endpoint, $basePath, $appId, $apiKey)
    {
//        $this->_serverAddress = !is_null($serverAddress) ? $serverAddress : $this->_error[] = 'Rest Error: server address must be defined';
//        $this->_basePath = !is_null($basePath) ? $basePath : $this->_error[] = 'Rest Error: base path must be defined';
//
//        if (count($this->error)) {
//            throw(new \Exception($this->error[0]));
//            //@todo: log the errors
//        }
//
//        $this->_curlHandle = curl_init($this->_serverAddress . $this->_basePath);
//
//        curl_setopt($this->_curlHandle, CURLOPT_RETURNTRANSFER, true);

    }


    public function get($route, $query = [])
    {
        return $this->_request('get', $route, $query);
    }

    public function post($route, $data = [], $query = [])
    {
        return $this->_request('post', $route, $query, $data);
    }

    public function put($route, $data = [], $query = [])
    {
        return $this->_request('PUT', $route, $query, $data);
    }

    public function delete($route, $query = [])
    {
        return $this->_request('DELETE', $route, $query);
    }


    /**
     * Request utility. Actually makes requests.
     *
     * @param string $method [get, post, put, delete]
     * @param $route the path (not including endpoint and base path)
     * @param array $query added to the query string of the route, e.g. ?foo=bar&hello=world
     * @param array $data data for any post or put
     * @throws \Exception
     */
    public function _request($method, $route, $query = [], $data = [])
    {
        $query = http_build_query($query);

        $method = strtoupper($method);

        if ($method === 'POST' && $query) {
            //setup our request for posting data, yo!

            //curl_setopt($this->_curlHandle, CURLOPT_POST, true );
            curl_setopt($this->_curlHandle, CURLOPT_URL, ($this->_serverAddress . $this->_basePath . $route));
            curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $query);

        } elseif ($method === 'GET' && $query) {
            curl_setopt($this->_curlHandle, CURLOPT_URL, ($this->_serverAddress . $this->_basePath . $route . '?' . $query));

        } elseif ($method === 'DELETE') {
            curl_setopt($this->_curlHandle, CURLOPT_URL, ($this->_serverAddress . $this->_basePath . $route));
            curl_setopt($this->_curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $query);

        } else {
            curl_setopt($this->_curlHandle, CURLOPT_URL, ($this->_serverAddress . $this->_basePath . $route));

        }

        //if authorization has been set, use it.
        if ($this->_authUsername && $this->_authPassword) {
            curl_setopt($this->_curlHandle, CURLOPT_USERPWD, $this->_authUsername . ':' . $this->_authPassword);
        }

        $responseText = curl_exec($this->_curlHandle);
        $response = json_decode($responseText);

        if (is_object($response)) {
            //validate response
            if (!is_null($response->Errors) && $response->Errors[0]->code !== 200) {

                foreach ($response->Errors as $error) {
                    $this->_error[] = 'Server Error [' . $response->Errors[0]->code . '] ' . $response->Errors[0]->description;

                    //@TODO: Log errors
                }

            }

            return $response;
        } else {

            throw new \Exception('Unknown response from server. ( ' . $response . ' ) ');
        }

    }

    public function setAuth(AuthInterface $auth)
    {
        throw new Exception('not finished');
    }
}