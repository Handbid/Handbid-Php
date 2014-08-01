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

        if($this->_auth) {
            return $this->_auth;
        }

        if(isset($_GET['handbid-auth'])) {
            $this->_auth = $_GET['handbid-auth'];
            setcookie('handbid-auth', $this->_auth, time()+3600*24*100, COOKIEPATH, COOKIE_DOMAIN, false);
        }

        if(isset($_COOKIE['handbid-auth'])) {
            $this->_auth = $_COOKIE['handbid-auth'];
        }

        return $this->_auth;
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