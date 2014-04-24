<?php

use Handbid\Handbid;

require '../../src/Handbid.php';


class ApiTest extends PHPUnit_Framework_TestCase
{

    public static $consumerKey = 'c1f7f60c389d587667f7e1e005c2b55e',
        $consumerSecret = '528e40928d13bd0233cf8caa7727106a',
        $orgId = '533c8249b05f8bc65e000031',
        $options = [
        'endpoint' => 'http://hbs.local'
    ],
        $orgKey = 'dummy-inc',
        $authEmail = 'test@handbid.com',
        $badAuthEmail = 'bad@handbid.com',
        $authPassword = 'password',
        $badAuthPassword = 'badPassword123',
        $dummyOrganization = [
        'name'        => 'Dummy Inc.',
        'address'     => '1234 generic ave.',
        'contactName' => 'Mr. Widget',
        'phone'       => '(123) 456 - 7890',
        'email'       => 'dummyMiester@nodomain.com',
        'website'     => 'www.dummy.inc.com.org.io',
        'description' => 'We are the leading provider of dummys. Specializing in crash test models, with the capacity to meet the demands of all organizations and individuals alike. Please consider a tour of our facility today! A shuttle can be arranged for transport- its a little short though.',
        'public'      => true,
        'tags'        => 'Vince, Larry, Daryl'
    ];


    /**
     * Include all handbid dependencies (for systems w/out autoloaders)
     */
    public static function setUpBeforeClass()
    {
        Handbid::includeDependencies();
    }

    /**
     * Get us a good handbid instance
     *
     * @return Handbid
     */
    public static function goodHandbid()
    {
        return new Handbid(self::$consumerKey, self::$consumerSecret);
    }

    /**
     * Make sure creating a new handbid does not crash
     */
    public function testInstantiatingHandbid()
    {
        //make sure we can instantiate a handbid api instance.
        $hb = new Handbid(static::$consumerKey, static::$consumerSecret);
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
        $hb->testAppCreds();
    }

    /**
     * Test if we can gain an access token
     */
    public function testGoodAppGreds()
    {
        $hb = static::goodHandbid();
        $this->assertTrue($hb->testAppCreds());
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

        $hb    = static::goodHandbid();
        $store = $hb->store('Organization');

        $org = $store->byId(static::$orgId);

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


    public function testAuctionsByOrg()
    {

        $hb       = static::goodHandbid();
        $store    = $hb->store('Auction');
        $auctions = $store->byOrg(static::$orgId);

        $this->assertNotNull($auctions);
    }

    public function itemsByAuction()
    {

    }
//
//    public function testAuth()
//    {
//        //make sure we can authorize our session with no errors.
//        $handbid = new Handbid();
//
//        //test good login
//        $auth = $handbid->auth($this->authEmail, $this->authPassword);
//        $this->assertTrue($auth instanceof Auth);
//
//
//        $authToken = $auth->getToken();
//        $this->assertTrue(strlen($authToken) > 0);
//
//
//        $authOwnerId = $auth->getOwnerId();
//        $this->assertTrue(strlen($authOwnerId) > 0);
//
//
//        $authUser = $auth->getUser();
//        $this->assertTrue(strlen($authUser->_id) > 0);
//
//
//        $this->assertTrue(count($auth->error) === 0);
//
//
//        //test bad login credentials
//        $auth1 = $handbid->auth($this->badAuthEmail, $this->authPassword);
//        $auth2 = $handbid->auth($this->authEmail, $this->badAuthPassword);
//        $auth3 = $handbid->auth($this->badAuthEmail, $this->badAuthPassword);
//
//        $this->assertTrue($auth1->getToken() === null);
//        $this->assertTrue($auth2->getToken() === null);
//        $this->assertTrue($auth3->getToken() === null);
//    }
//
//    public function testOrganizationStore()
//    {
//        $handbid = new Handbid();
//
//        //test good login
//        $auth = $handbid->auth($this->authEmail, $this->authPassword);
//
//        $authToken = $auth->getToken();
//
//
//        $store = $handbid->store('Organization');
//        $this->assertTrue($store instanceof \Handbid\Store\StoreInterface);
//
//        //create
//        try {
//            $storeData = $store->create($this->dummyOrganization);
//
//        } catch (\Exception $error) {
//            print_r($error->getMessage());
//        }
//
//        $this->assertTrue(count($store->_restServer->_error) === 0);
//        $this->assertTrue(strlen($storeData->_id) > 0);
//
//        //@TODO:  It might be a good idea to verify every field against the provided values.
//
//
//        //read
//        $dummyStoreId = $storeData->_id;
//
//        try {
//            $newStoreData = $store->getById($dummyStoreId);
//
//        } catch (\Exception $error) {
//            print_r($error->getMessage());
//        }
//
//        $this->assertTrue(count($store->_restServer->_error) === 0);
//        $this->assertTrue($newStoreData->_id === $dummyStoreId);
//
//
//        //update
//        $dummyStoreId = $storeData->_id;
//
//        $this->dummyOrganization['name'] = 'updated name';
//        $this->dummyOrganization['website'] = 'updated.website.org';
//
//        try {
//            $newStoreData = $store->updateById($dummyStoreId, $this->dummyOrganization);
//
//        } catch (\Exception $error) {
//            print_r($error->getMessage());
//
//        }
//
//        $this->assertTrue(count($store->_restServer->_error) === 0);
//        $this->assertTrue(($newStoreData->name === 'updated name') && ($newStoreData->website === 'updated.website.org'));
//
//
//        //delete
//        $dummyStoreId = $storeData->_id;
//
//        try {
//            $response = $store->deleteById($dummyStoreId);
//            $aggressiveDeleteResponse = $store->deleteById($dummyStoreId);
//
//        } catch (\Exception $error) {
//            print_r($error->getMessage() . ' (we expect only ONE of these messages)');
//        }
//
//
//        $this->assertTrue(count($store->_restServer->_error) === 1);
//        $this->assertTrue($response->deleted === 1);
//
//    }

}

