<?php
/**
 * @copyright Copyright (c) 2014-2015 Handbid Inc.
 * @category handbid
 * @package Handbid2-WordPress
 * @license Proprietary
 * @link http://www.handbid.com/
 * @author Master of Code (worldclass@masterofcode.com)
 */

/**
 * The auth adapters sole responsibility is configuring headers for requests for apps. For user authentication/authorization
 * use UserAuth
 */

namespace Handbid\Auth;

class AppAuth implements AuthInterface
{

    public  $_consumerKey,
            $_consumerSecret,
            $_bearerToken;

    public function __construct($consumerKey, $consumerSecret, $bearerToken = null)
    {
        $this->_consumerKey    = $consumerKey;
        $this->_consumerSecret = $consumerSecret;
        $this->_bearerToken    = $bearerToken;

    }

    /**
     * Attempt to fetch a token based off consumer key and secret.
     *
     * @throws Network|\Handbid\Exception\App
     */
    public function fetchToken(\Handbid\Rest\RestInterface $rest)
    {

        try {

            $response = $rest->post(
                'apps/token.json',
                [
                    'grant_type' => 'client_credentials'
                ],
                [],
                [
                    'Authorization' => 'Basic ' . base64_encode($this->_consumerKey . ':' . $this->_consumerSecret)
                ]
            );
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

    /**
     * Our bearer token if we have one
     *
     * @return string
     */
    public function token()
    {
        return $this->_bearerToken;
    }

    /**
     * Fetches a new bearer token and sets it to ourselves
     *
     * @param \Handbid\Rest\RestInterface $rest
     *
     * @return $this
     */
    public function refreshToken(\Handbid\Rest\RestInterface $rest)
    {
        $this->setToken($this->fetchToken($rest));
        return $this;
    }

    /**
     * Sets a new bearer token locall, and then updates Rest to have the proper headings
     *
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->_bearerToken = $token;
        return $this;
    }

    public function initRequest(&$method, &$url, &$query, &$postData, &$headers)
    {
        if($this->_bearerToken) {
            $headers['Authorization'] = 'Bearer' . $this->_bearerToken;
        }
        return $this;
    }


    public function clearToken() {}
}