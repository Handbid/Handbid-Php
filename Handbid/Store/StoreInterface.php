<?php

namespace Handbid\Store;

interface StoreInterface {

    public function find();
    public function create();
    public function read();
    public function update();
    public function delete();

}