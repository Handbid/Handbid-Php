<?php

use Handbid\Handbid;

require '../../src/Handbid.php';


class TicketsTests extends PHPUnit_Framework_TestCase
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
    public static function handbidInstance()
    {
        return new Handbid(static::$config->consumerKey, static::$config->consumerSecret, static::$config->options);
    }

    public function testCreatingAuction()
    {

        $hb      = $this->handbidInstance();
        $results = $hb->store('Ticket')->create(
            [
                'name'         => 'Unit test auction',
                'organization' => '234234234',
                'app'          => 'aoeuaoeu'
            ]
        );

        var_dump($results);

    }


}

