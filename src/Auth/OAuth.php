<?php

/**
 * The auth adapters sole responsibility is configuring headers for requests
 */

namespace Handbid\Auth;

class OAuth implements AuthInterface
{

    public $_rest,
        $_accessToken,
        $_tokenSecret,
        $_consumerSecret,
        $_consumerKey;

    public function __construct($consumerKey, $consumerSecret, $accessToken, $tokenSecret)
    {
        $this->_accessToken    = $accessToken;
        $this->_consumerKey    = $consumerKey;
        $this->_consumerSecret = $consumerKey;
        $this->_tokenSecret    = $tokenSecret;

    }

    public function hasToken()
    {
        return !!$this->_accessToken;
    }

    public function token()
    {
        return $this->_accessToken;
    }

    public function refreshToken(\Handbid\Rest\RestInterface $rest)
    {
        throw new \Exception('You cannot refresh a token through OAuth programatically. Use UserXAuth or 3-legged OAuth to get an access token.');
    }

    public function oauthHeader()
    {
        $header = [
            'oauth_consumer_key="' . $this->_consumerKey . '"',
            'oauth_consumer_nonce="' . preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(microtime())) . '"',
            'oauth_signature_method="HMAC-SHA1"',
            'oauth_timestamp="' . time() . '"',
            'oauth_version="1.0"',
        ];

        if($this->_accessToken) {
            $header[] = 'oauth_token="' . $this->_accessToken . '"';
        }

        return $header;
    }

    public function generateSignature($method, $url, $body, $headers = null)
    {
        $headers = ($headers) ? $headers : $this->oauthHeader();
        $params  = $body;

        foreach ($headers as $v) {
            $parts             = explode('=', $v);
            $params[$parts[0]] = str_replace('"', '', $parts[1]);
        }

        ksort($params);

        $paramstring = http_build_query($params);
        $base        = strtoupper($method) . '&' . urlencode($url) . '&' . urlencode($paramstring);
        $signingKey  = urlencode($this->_consumerSecret) . '&';

        //if we have a user's token secret
        if ($this->_tokenSecret) {
            $signingKey .= $this->_tokenSecret;
        }

        $hmac = hash_hmac('sha1', $base, $signingKey);
        $sig  = base64_encode($hmac);

        return urlencode($sig);

    }

    public function fetchToken(\Handbid\Rest\RestInterface $rest)
    {
        throw new \Exception('You cannot fetch a token using OAuth. User UserXAuth or 3-legged OAuth');
    }

    public function setToken($token)
    {
        $this->_accessToken = $token;
    }

    public function setTokenSecret($secret)
    {
        $this->_tokenSecret = $secret;
    }

    public function initRequest(&$method, &$url, &$query, &$postData, &$headers)
    {
        if($this->_accessToken && $this->_tokenSecret) {

            $_headers   = $this->oauthHeader();
            $_headers[] = 'oauth_signature="' . $this->generateSignature($method, $url, $postData + $query);

            $headers['Authorization']  = 'OAuth ' . implode(',',$_headers);
        }
    }

    public function clearToken() {}
}