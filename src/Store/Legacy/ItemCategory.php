<?php
/**
 * @copyright Copyright (c) 2014-2015 Handbid Inc.
 * @category handbid
 * @package Handbid2-WordPress
 * @license Proprietary
 * @link http://www.handbid.com/
 * @author Master of Code (worldclass@masterofcode.com)
 */

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class ItemCategory extends StoreAbstract
{

    public $_base = 'category';
    public $_resultsKey = 'ItemCategory';
    public $_resultsKeyPlural = 'ItemCategories';

    /**
     * Gets you
     *
     * @param $id
     *
     * @return mixed
     */
    public function byAuction($id, $query = [])
    {

        $query = array_merge(
            [
                'config' => [
                    'limit' => 9999
                ],
                'query' => [
                    'auction' => $id
                ]
            ],
            $query
        );

        $entities = $this->mapMany(
            $this->_rest->get(
                $this->_base,
                $query
            )->{$this->_resultsKeyPlural}
        );


        return $entities;
    }


    public function populateNumItems($categories, $items)
    {

        foreach ($categories as $category) {

            $count = 0;
            foreach ($items as $item) {
                if (in_array($category->name, $item->terms)) {
                    $count++;
                }
            }

            if (!isset($category->meta)) {
                $category->meta = (object)[];
            }

            $category->meta->numItems = $count;

        }

    }

}