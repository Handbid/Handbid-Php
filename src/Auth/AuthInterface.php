<?php

namespace Handbid\Auth;

interface AuthInterface
{
    public function hasToken();
    public function token();
    public function setToken($token);

    public function fetchToken(\Handbid\Rest\RestInterface $rest);
    public function refreshToken(\Handbid\Rest\RestInterface $rest);
    public function initRequest(&$method, &$url, &$query, &$postData, &$headers);

}