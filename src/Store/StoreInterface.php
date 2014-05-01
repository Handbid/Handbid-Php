<?php

namespace Handbid\Store;

use Handbid\Rest\RestInterface;

interface StoreInterface
{

    public function __construct(RestInterface $rest);

    public function all($page = 0, $perPage = 25, $sortField = 'name', $sortDirection = 'ASC');
    public function byId($id);
    public function byKey($id);
    public function byField($name, $value);
    public function search($keywords);
    public function create($values);

}