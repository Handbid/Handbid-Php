<?php

namespace Handbid;

use Handbid\Auth\AuthInterface;

interface RestInterface{

    /**
     * @param $endpoint
     * @param $basePath
     * @param $appId
     * @param $apiKey
     */
    public function __construct($endpoint, $basePath, $appId, $apiKey);

    /**
     * If this request is supposed to be under a user account, pass an auth object.
     *
     * @param $auth
     * @return mixed
     */
    public function setAuth(AuthInterface $auth);

    /**
     * A GET request to your route. Will prepend endpoint and basePath.
     *
     * @param $route relative path from endpoint+basePath
     * @param array $query added to query string.
     * @return mixed the results of the request
     * @throws \Handbid\Exception\*
     */
    public function get($route, $query = []);

    /**
     * POST to your route.
     *
     * @param $route relative path
     * @param array $data POST data
     * @param array $query added to querystring of route
     * @return mixed the results of the call
     * @throws \Handbid\Exception\*
     */
    public function post($route, $data = [], $query = []);

    /**
     * Same as POST, but uses PUT. Use PUT for updates (whenever you do NOT want a resource created)
     *
     * @param $route relative path
     * @param array $data submitted as body of request
     * @param array $query added to querystring
     * @return mixed
     */
    public function put($route, $data = [], $query = []);

    /**
     * DELETE a resource
     *
     * @param $route the relative path
     * @param array $query added to querystring
     * @return mixed
     */
    public function delete($route, $query = []);


}