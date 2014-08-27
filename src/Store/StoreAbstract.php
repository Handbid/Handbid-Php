<?php

namespace Handbid\Store;

use Handbid\Store\StoreInterface;
use Handbid\Rest\RestInterface;

class StoreAbstract implements StoreInterface
{

    public $_rest;
    public $_base;


    public function __construct(RestInterface $rest)
    {
        $this->_rest = $rest;
    }

    public function all($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC')
    {
        return $this->_rest->get(
            $this->_base . '.json',
            [
                'skip'          => $page * $pageSize,
                'limit'         => $pageSize,
                'sortField'     => $sortField,
                'sortDirection' => $sortDirection
            ]
        );
    }

    public function byId($id)
    {
        return $this->_rest->get($this->_base . '/' . $id . '.json');
    }

    public function byKey($id)
    {
        return $this->_rest->get($this->_base . '/by/key/' . $id . '.json');
    }

    public function byField($name, $value)
    {
        return $this->_rest->get($this->_base . '/by/' . $name . '.json', ['q' => $value]);
    }

    public function search($keywords)
    {
        return $this->_rest->get($this->_base . '.json');
    }

    public function create($values)
    {
        return $this->_rest->post($this->_base . '.json', $values);
    }

}