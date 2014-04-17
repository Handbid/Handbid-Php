<?php

namespace Handbid\Store;

use Handbid\Store\StoreInterface;
use Handbid\Rest\RestInterface;

class StoreAbstract implements StoreInterface
{

    public $_rest;
    public $_basePath;
    public $error = [];


    public function __construct(RestInterface $rest)
    {
        $this->_rest        = $rest;
    }



}