<?php

use Handbid\Handbid;

require '../../src/Handbid.php';


class ReadAnon extends PHPUnit_Framework_TestCase
{

    public static
        $config,
        $orgKey = 'aserf',
        $auctionId = '5359d0bc2d7f3897088b62f2',
        $auctionKey = 'bidz4kidz';


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

    /**
     * Make sure creating a new handbid does not crash
     */
    public function testInstantiatingHandbid()
    {
        //make sure we can instantiate a handbid api instance.
        $hb = new Handbid(static::$config->consumerKey, static::$config->consumerSecret);
        $this->assertTrue($hb instanceof Handbid);

    }

    /**
     * Test that our app key and consumerSecret are good.
     *
     * @expectedException \Handbid\Exception\App
     */
    public function testBadAppCreds()
    {
        $hb = new Handbid('0', '1');
        $hb->testAuth();
    }

    /**
     * Test if we can gain an access token
     */
    public function testGoodAppGreds()
    {
        $hb = static::goodHandbid();
        $this->assertTrue($hb->testAuth());
    }


    /**
     * All orgs
     */
    public function testFetchingOrganizations()
    {
        $hb    = static::goodHandbid();
        $store = $hb->store('Organization');

        $orgs = $store->all();

        $this->assertGreaterThan(0, count($orgs));

    }

    /**
     * An org by id
     */
    public function testFetchingOrgById()
    {

        $hb     = static::goodHandbid();
        $store  = $hb->store('Organization');
        $org    = $store->byId(static::$config->orgId);

        $this->assertTrue(!!$org);

    }

    /**
     * Org by key
     */
    public function testFetchingOrgByKey()
    {

        $hb    = static::goodHandbid();
        $store = $hb->store('Organization');

        $org = $store->byKey(static::$orgKey);

        $this->assertTrue(!!$org);

    }

    public function testAuctionByKey()
    {

//        $hb       = static::goodHandbid();
//        $store    = $hb->store('Auction');
//        $auction  = $store->byKey(static::$auctionKey);
//
//        $this->assertNotNull($auction);
    }

    public function testAuctionsByOrg()
    {

        $hb       = static::goodHandbid();
        $store    = $hb->store('Auction');
        $auctions = $store->byOrg(static::$config->orgId);

        $this->assertNotNull($auctions);
        $this->assertGreaterThan(0, count($auctions));
    }

    public function testItemCategoriesByAuction()
    {
        $hb    = static::goodHandbid();
        $store = $hb->store('ItemCategory');
        $cats  = $store->byAuction(static::$auctionId);

        $this->assertNotNull($cats);
        $this->assertGreaterThan(0, count($cats));
    }

    public function testItemsByAuction()
    {
        $hb    = static::goodHandbid();
        $store = $hb->store('Item');
        $items = $store->byAuction(static::$auctionId);

        $this->assertNotNull($items);
        $this->assertGreaterThan(0, count($items));
    }

    public function testUpcomingAuctionsForOrg()
    {
        $hb       = static::goodHandbid();
        $org      = $hb->store('Organization')->byId(self::$config->orgId);
        $auctions = $hb->store('Auction')->upcoming($org->_id);

        $this->assertNotNull($auctions);
        $this->assertGreaterThan(0, count($auctions));
    }

    public function testPastAuctionsForOrg()
    {
        $hb       = static::goodHandbid();
        $org      = $hb->store('Organization')->byId(self::$config->orgId);
        $auctions = $hb->store('Auction')->past($org->_id);

        $this->assertNotNull($auctions);
        $this->assertGreaterThan(0, count($auctions));
    }

    public function testTicketsForAuction()
    {
        $hb       = static::goodHandbid();
        $auction  = $hb->store('Auction')->byId(self::$auctionId);
        $auctions = $hb->store('Ticket')->byAuction($auction->_id);

        $this->assertNotNull($auctions);
        $this->assertGreaterThan(0, count($auctions));
    }

}

