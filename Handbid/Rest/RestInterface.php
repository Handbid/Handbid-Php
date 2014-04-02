<?php

namespace Handbid;

interface RestInterface{

    public function query( $route, $params = [], $method = 'Get');
    public function setAuth($username,$password);
}