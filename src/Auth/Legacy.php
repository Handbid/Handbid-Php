<?php

/**
 * This is the Legacy way of handling authentication. It is very bad and will be replaced on the next release.
 */

namespace Handbid\Auth;

class Legacy implements AuthInterface
{

    public $_auth;

    public function hasToken()
    {
        return !!$this->_auth;
    }

    public function token()
    {
        return $this->_auth;
    }

    public function setToken($token)
    {
        $this->_auth = $token;
        return $this;
    }

    /**
     * Fetch auth hash from GET or COOKIE
     * @param \Handbid\Rest\RestInterface $rest
     */
    public function fetchToken(\Handbid\Rest\RestInterface $rest)
    {
        if(isset($_GET['handbid-auth'])) {
            $_COOKIE['handbid-auth'] = $this->_auth = $_GET['handbid-auth'];
        }

        if(isset($_COOKIE['handbid-auth'])) {
            return $_COOKIE['handbid-auth'];
        }

        return null;
    }

    public function refreshToken(\Handbid\Rest\RestInterface $rest)
    {

        $this->setToken($this->fetchToken($rest));

        return $this;
    }

    public function initRequest(&$method, &$url, &$query, &$postData, &$headers)
    {
        if($this->hasToken()) {
            $headers['Authorization'] = 'IronFrame ' . $this->_auth;
        }
    }

}