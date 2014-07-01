<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\StoreInterface;
use Handbid\Rest\RestInterface;

class StoreAbstract implements StoreInterface
{

    public $_rest;
    public $_base;
    public $_resultsKey;
    public $_resultsKeyPlural;


    public function __construct(RestInterface $rest)
    {
        $this->_rest = $rest;

        if(!$this->_resultsKeyPlural) {
            $this->_resultsKeyPlural = $this->_resultsKey . 's';
        }
    }

    public function all($page = 0, $perPage = 25, $sortField = 'name', $sortDirection = 'ASC')
    {
        return $this->mapMany($this->_rest->get($this->_base)->{$this->_resultsKeyPlural});
    }

    public function byId($id)
    {
        return $this->map($this->_rest->get($this->_base . '/' . $id)->{$this->_resultsKey});
    }

    public function byKey($key)
    {
        $results = $this->_rest->get($this->_base, ['query' => ['key' => $key]])->{$this->_resultsKeyPlural};

        if (count($results) == 0) {
            throw new \Handbid\Exception\Network('Could not find entity with key ' . $key);
        }

        return $this->map($results[0]);
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

    public function map($entity)
    {
        return $entity;
    }

    public function mapMany($entities)
    {
        foreach ($entities as $entity) {
            $this->map($entity);
        }

        return $entities;
    }

}