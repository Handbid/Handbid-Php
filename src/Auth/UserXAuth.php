<?php

/**
 * The auth adapters sole responsibility is configuring headers for requests
 */

namespace Handbid\Auth;

class UserXAuth extends OAuth
{

    public $_email,
           $_password;

    public function __construct($consumerKey, $consumerSecret, $email, $password)
    {
        $this->_email          = $email;
        $this->_password       = $password;
        $this->_consumerKey    = $consumerKey;
        $this->_consumerSecret = $consumerKey;

    }


    public function refreshToken(\Handbid\Rest\RestInterface $rest)
    {
        $response = $this->fetchToken($rest);

        $this->setToken($response['oauth_token']);
        $this->setTokenSecret($response['oauth_token_secret']);

        return $this;

    }

    public function fetchToken(\Handbid\Rest\RestInterface $rest)
    {

        try {

            $headers = $this->oauthHeader();
            $body    = [
                'x_auth_mode'     => 'client_auth',
                'x_auth_email'    => $this->_email,
                'x_auth_password' => $this->_password
            ];

            $url        = $rest->resolveRoute('xauth/access_token.json');

            $headers[]  = 'oauth_signature="' . $this->generateSignature('post', $url, $body, $headers) . '"';

            $response   = $rest->post(
                'xauth/token.json',
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

        return (array) $response;

    }

    public function clearToken() {}
}