<?php

/**
 * The auth adapters sole responsibility is configuring headers for requests
 */

namespace Handbid\Auth;

class UserXAuth implements AuthInterface
{

    public $_rest,
        $_email,
        $_password,
        $_consumerKey,
        $_consumerSecret,
        $_accessToken;

    public function __construct($consumerKey, $consumerSecret, $email, $password)
    {
        $this->_email          = $email;
        $this->_password       = $password;
        $this->_consumerKey    = $consumerKey;
        $this->_consumerSecret = $consumerKey;

    }

    public function hasToken()
    {
        return !!$this->_accessToken;
    }

    public function token()
    {
        return $this->_accessToken;
    }

    public function refreshToken()
    {
        $this->setAccessToken($this->fetchAccessToken());
    }

    public function setRest(\Handbid\Rest\RestInterface $rest)
    {
        $this->_rest = $rest;
        return $this;
    }

    public function oauthHeaders()
    {
        return [
            'oauth_consumer_key="' . $this->_consumerKey . '"',
            'oauth_consumer_nonce="' . preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(microtime())) . '"',
            'oauth_signature_method="HMAC-SHA1"',
            'oauth_timestamp="' . time() . '"',
            'oauth_version="1.0"',
        ];
    }

    public function generateSignature($method, $url, $body, $headers = null)
    {
        $headers = ($headers) ? $headers : $this->oauthHeaders();
        $params  = $body;

        foreach ($headers as $v) {
            $parts             = explode('=', $v);
            $params[$parts[0]] = str_replace('"', '', $parts[1]);
        }

        ksort($params);

        $paramstring = http_build_query($params);
        $base        = strtoupper($method) . '&' . urlencode($url) . '&' . urlencode($paramstring);
        $signingKey  = urlencode($this->_consumerSecret) . '&'; //we have no user token
        $hmac        = hash_hmac('sha1', $base, $signingKey);
        $sig         = base64_encode($hmac);

        return $sig;

    }

    public function fetchToken()
    {

        try {

            $headers = $this->oauthHeaders();
            $body    = [
                'x_auth_model'    => 'client_auth',
                'x_auth_email'    => $this->_email,
                'x_auth_password' => $this->_password
            ];
            $url     = $this->_rest->resolveRoute('oauth/access_token.json');

            $headers[] = 'oauth_signature="' . $this->generateSignature('post', $url, $body, $headers) . '"';

            $response = $this->_rest->post(
                'oauth/access_token.json',
                $body,
                [],
                [
                    'Authorization' => 'OAuth ' . implode(
                            ',',
                            $headers
                        )
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

    public function setToken($token)
    {
        $this->_accessToken = $token;
    }

}