<?php
/**
 * @copyright Copyright (c) 2014-2015 Handbid Inc.
 * @category handbid
 * @package Handbid2-WordPress
 * @license Proprietary
 * @link http://www.handbid.com/
 * @author Master of Code (worldclass@masterofcode.com)
 */


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
        $options         = static::$config->options;
        $options['auth'] = static::goodXAuth();

        return new Handbid(static::$config->consumerKey, static::$config->consumerSecret, $options);
    }

    /**
     * Test getting token
     */
    public function testAcquiringToken()
    {

        $hb    = $this->goodHandbid();
        $token = $hb->testAuth();

        $this->assertTrue($token, 'fetching xauth token failed');

    }

    /**
     * Test getting the bidder's profile
     */
    public function testFetchingProfile()
    {

        $hb         = $this->goodHandbid();
        $profile    = $hb->store('Manager')->profile();

        print_r($profile);exit;

    }


}

