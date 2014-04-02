<?php

namespace Handbid\Store;

interface StoreInterface {

    public function find(   $data = [] );
    public function create( $data = [] );
    public function read(   $data = [] );
    public function update( $data = [] );
    public function delete( $data = [] );

}