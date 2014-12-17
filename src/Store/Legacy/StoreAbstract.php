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

        if (!$this->_resultsKeyPlural) {
            $this->_resultsKeyPlural = $this->_resultsKey . 's';
        }
    }

    public function all($page = 0, $pageSize = 25, $sortField = 'name', $sortDirection = 'ASC', $query = false, $options = false, $cache = true)
    {

        $skip = $page * $pageSize;

        $results = $this->_rest->get(
            $this->_base,
            [
                'query'  => $query ? $query : false,
                'options' => $options ? $options : false,
                'config' => [
                    'skip'  => $skip,
                    'limit' => $pageSize,
                    'sort'  => [$sortField => $sortDirection]
                ]
            ],
            [],
            [],
            $cache
        );

        if ($results) {
            $results = $this->mapMany($results->{$this->_resultsKeyPlural});
        }

        return $results;
    }

    public function byId($id, $cache = true)
    {
        $results = $this->_rest->get($this->_base . '/' . $id, [], [], $cache);

        if ($results) {
            $results = $this->map($results->{$this->_resultsKey});
        }

        return $results;
    }

    public function byKey($key, $query = [], $cache = true)
    {

        $query   = array_merge(
            [
                'query' => [
                    'key' => $key
                ]
            ],
            $query
        );
        $results = $this->_rest->get($this->_base, $query, [], $cache);
        $results = $results ? $results->{$this->_resultsKeyPlural} : [];

        if(!$results) {
            return $results;
        }
        return $this->map($results[0]);
    }

    public function preparePostVars($values)
    {

        $post = [];

        foreach ($values as $k => $v) {
            $post['values[' . $k . ']'] = $v;
        }


        return $post;

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