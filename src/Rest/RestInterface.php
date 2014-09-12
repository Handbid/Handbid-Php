<?php

namespace Handbid\Rest;

use Handbid\Auth\AuthInterface;

interface RestInterface
{

    /**
     * @param $endpoint
     * @param $basePath
     */
    public function __construct($endpoint, $basePath);

    /**
     * If this request is supposed to be under a user account, pass an auth object.
     *
     * @param $auth
     * @return mixed
     */
    public function setAuth(AuthInterface $auth);

    /**
     * Return the auth object if you have one
     *
     * @return mixed
     */
    public function auth();

    /**
     * A GET request to your route. Will prepend endpoint and basePath.
     *
     * @param string $route relative path from endpoint+basePath
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


    /**
     * Give a partial route and it'll come back with the full url (including http, etc.)
     *
     * @param $partial
     *
     * @return string
     */
    public function resolveRoute($partial);
}