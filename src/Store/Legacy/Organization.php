<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Organization extends StoreAbstract
{

    public $_base = 'models/Organization';
    public $_resultsKey = 'Organization';

    public function byKey($key, $query = [])
    {
        $query   = array_merge(
            [
                'query' => [
                    'key' => $key
                ]
            ],
            $query
        );
        $results = $this->_rest->get($this->_base, $query);
        $results = $results ? $results->{$this->_resultsKeyPlural} : [];

        if (count($results) == 0) {
            throw new \Handbid\Exception\Network('Could not find entity with key ' . $key);
        }

        return $this->map($results[0]);
    }


}