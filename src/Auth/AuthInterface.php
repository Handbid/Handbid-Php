<?php

namespace Handbid\Auth;

interface AuthInterface
{
    public function fetchToken();
    public function hasToken();
    public function token();
    public function refreshToken();
    public function setToken($token);
    public function setRest(\Handbid\Rest\RestInterface $rest);
}