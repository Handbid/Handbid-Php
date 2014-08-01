<?php

/**
 * The auth adapters sole responsibility is configuring headers for requests for apps. For user authentication/authorization
 * use UserAuth
 */

namespace Handbid\Auth;

class Legacy implements AuthInterface
{

    public function hasToken() {

        print_r($_COOKIE);

    }

    public function token() {

    }

    public function setToken($token) {

    }

    public function fetchToken(\Handbid\Rest\RestInterface $rest) {

    }
    public function refreshToken(\Handbid\Rest\RestInterface $rest) {

    }
    public function initRequest(&$method, &$url, &$query, &$postData, &$headers) {

    }

}