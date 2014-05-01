<?php

/**
 * The auth adapters sole responsibility is configuring headers for requests for apps. For user authentication/authorization
 * use UserAuth
 */

namespace Handbid\Auth;

class AppAuth implements AuthInterface
{

    public $_rest,
           $_consumerKey,
           $_consumerSecret,
           $_bearerToken;

    public function __construct($consumerKey, $consumerSecret, $bearerToken = null)
    {
        $this->_consumerKey     = $consumerKey;
        $this->_consumerSecret  = $consumerSecret;
        $this->_bearerToken     = $bearerToken;

    }

    public function setRest(\Handbid\Rest\RestInterface $rest) {
        $this->_rest = $rest;
        return $this;
    }

    /**
     * Attempt to fetch a token based off consumer key and secret.
     *
     * @throws Network|\Handbid\Exception\App
     */
    public function fetchToken()
    {

        try {

            $response = $this->_rest->post('apps/token.json', [
                'grant_type' => 'client_credentials'
            ], [], [
                'Authorization' => 'Basic ' . base64_encode($this->_consumerKey . ':' . $this->_consumerSecret)
            ]);
        } //i will attempt to help the user out
        catch (\Handbid\Exception\Network $e) {

            //this was a bad key and secret and I consider it an App error
            if ($e->getCode() == 401) {
                throw new \Handbid\Exception\App($e->getMessage(), $e->getCode(), $e);
            } else {
                throw $e;
            }

        }

        return $response->access_token;

    }

    /**
     * Tells us if a bearer token is available (if one is not, you should get one before making any requests).
     *
     * @return bool
     */
    public function hasToken()
    {
        return !!$this->_bearerToken;
    }

    public function token() {
        return $this->_bearerToken;
    }

    /**
     * /* Fetches a new bearer token and sets it to ourselves
     * @return $this
     */
    public function refreshToken()
    {
        $this->setToken($this->fetchToken());
        return $this;
    }

    /**
     * Sets a new bearer token locall, and then updates Rest to have the proper headings
     *
     * @param $token
     */
    public function setToken($token)
    {
        $this->_bearerToken = $token;
        $this->_rest->setHeader('Authorization', 'Bearer' . $this->_bearerToken);

    }
}