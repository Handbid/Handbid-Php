<?php

use Handbid\Handbid;

require '../../src/Handbid.php';


class UserXAuth extends PHPUnit_Framework_TestCase
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

    public static function goodXAuth()
    {
        return new \Handbid\Auth\UserXAuth(static::$config->consumerKey, static::$config->consumerSecret, static::$config->managerEmail, static::$config->managerPassword);
    }

    /**
     * Get us a good handbid instance
     *
     * @return Handbid
     */
    public static function goodHandbid()
    {
        $options            = static::$config->options;
        $options['auth']    = static::goodXAuth();

        return new Handbid(static::$config->consumerKey, static::$config->consumerSecret, $options);
    }

    public function testAcquiringToken()
    {

        $hb      = $this->goodHandbid();
        $token   = $hb->testAuth();

        var_dump($token);

    }


}

