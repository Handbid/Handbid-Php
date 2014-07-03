<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class ItemCategory extends TaxonomyTerm
{

    /**
     * Gets you
     * @param $id
     *
     * @return mixed
     */
    public function byAuction($id, $query = [])
    {
        return $this->_rest->get('auctions/' . $id . '/terms.json', $query);
    }

}