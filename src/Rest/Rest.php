<?php

namespace Handbid\Rest;

use Handbid\Auth\AuthInterface;
use Handbid\Exception\Network as NetworkException;
use Handbid\Rest\RestInterface;

class Rest implements RestInterface
{
    public $_curlHandle,
           $_endpoint,
           $_basePath,
           $_error      = [],
           $_headers    = [];

    public function __construct($endpoint, $basePath)
    {

        $this->_endpoint = $endpoint;
        $this->_basePath = $basePath;

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

    public function get($route, $query = [], $headers = [])
    {
        return $this->_request('get', $route, $query, [], $headers);
    }

    public function post($route, $data = [], $query = [], $headers = [])
    {
        return $this->_request('post', $route, $query, $data, $headers);
    }

    public function put($route, $data = [], $query = [], $headers = [])
    {
        return $this->_request('PUT', $route, $query, $data, $headers);
    }

    public function delete($route, $query = [], $headers = [])
    {
        return $this->_request('DELETE', $route, $query, $headers);
    }

    /**
     * Request utility. Actually makes requests.
     *
     * @param string $method [get, post, put, delete]
     * @param $route the path (not including endpoint and base path)
     * @param array $query added to the query string of the route, e.g. ?foo=bar&hello=world
     * @param array $data data for any post or put
     * @param array $headers
     * @return mixed
     * @throws \Handbid\Exception\Network
     */
    public function _request($method, $route, $query = [], $data = [], $headers = [])
    {
        $query      = http_build_query($query);
        $method     = strtoupper($method);
        //store for posterity
        $this->_curlHandle = curl_init($this->_endpoint . $this->_basePath);
        curl_setopt($this->_curlHandle, CURLOPT_RETURNTRANSFER, true);

        $method     = strtoupper($method);
        $headers    = ($headers) ? $headers : $this->_headers;
        $uri        = $this->_endpoint . $this->_basePath . $route;

        if($headers) {

            $_headers = [];
            foreach($headers as $k => $v) {
                $_headers[] = $k . ': ' . $v;
            }

            curl_setopt($this->_curlHandle, CURLOPT_HTTPHEADER, $_headers);
        }

        if ($method === 'POST') {
            //setup our request for posting data, yo!

            //curl_setopt($this->_curlHandle, CURLOPT_POST, true );
            curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);
            curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $data);

        } elseif ($method === 'GET' && $query) {
            curl_setopt($this->_curlHandle, CURLOPT_URL, $uri . '?' . $query);

        } elseif ($method === 'DELETE') {
            curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);
            curl_setopt($this->_curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $query);

        } else {
            curl_setopt($this->_curlHandle, CURLOPT_URL, $uri);

        }

        $responseText   = curl_exec($this->_curlHandle);
        $info           = curl_getinfo($this->_curlHandle);

        //no content, should we care?
        if($info['http_code'] == 204) {
            throw new NetworkException('No response from server', 70000);
        }
        //oops
        elseif($info['http_code'] != 200) {

            $response = json_decode($responseText);
            if($response) {
                throw new NetworkException($response->Errors[0]->description, $info['http_code']);
            } else {
                throw new NetworkException('Unknown response from server. ( ' . $response . ' ) ', $info['http_code']);
            }

        }
        //this is a strange one and should really never happen
        elseif(!$responseText) {

            throw new NetworkException('Response was empty.', Network::ERROR_REQUEST_FAILED);

        }
        //all is well
        else {
            $response = json_decode($responseText);
        }

        return $response;
    }

    public function setAuth(AuthInterface $auth)
    {
        throw new Exception('not finished');
    }

    public function setHeader($named, $value) {
        $this->_headers[$named] = $value;
        return $this;
    }

    public function clearHeader($named) {
        unset($this->_headers[$named]);
        return $this;
    }
}