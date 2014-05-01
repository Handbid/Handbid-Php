<?php

use Handbid\Handbid;

require '../../src/Handbid.php';


class ReadTests extends PHPUnit_Framework_TestCase
{

    public static $config;


    /**
     * Include all handbid dependencies (for systems w/out autoloaders)
     */
    public static function setUpBeforeClass()
    {
        Handbid::includeDependencies();
        require './config.php';
        static::$config = $config;
    }

    /**
     * Get us a good handbid instance
     *
     * @return Handbid
     */
    public static function goodHandbid()
    {
        return new Handbid(static::$config->consumerKey, static::$config->consumerSecret, static::$config->options);
    }

    public function testCreatingAuction()
    {

        $hb      = $this->goodHandbid();
        $results = $hb->store('Auction')->create(
            [
                'name'         => 'Unit test auction',
                'organization' => '234234234',
                'app'          => 'aoeuaoeu'
            ]
        );

        var_dump($results);

    }


}

