<?php

namespace Handbid\Store;

use Handbid\Rest\RestInterface;

interface StoreInterface
{

    public function __construct(RestInterface $rest);

}