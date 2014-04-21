<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Organization extends StoreAbstract
{

    public function total()
    {

    }

    public function all($page = 0, $perPage = 25, $sortField = 'name', $sortDirection = 'ASC')
    {
        return $this->_rest->get('orgs.json', [
            'skip'          => $page * $perPage,
            'limit'         => $perPage,
            'sortField'     => $sortField,
            'sortDirection' => $sortDirection
        ]);
    }

    public function byId($id)
    {
        return $this->_rest->get('orgs/' . $id . '.json');

    }

}