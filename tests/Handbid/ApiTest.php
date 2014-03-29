<?php

//We are assuming PHPUnit is installed one directory above the package. Feel free to change this to map to your PHPUnit folder.
//require_once "../../../PHPUnit/Autoload.php";

include( "../../Handbid/Handbid.php" );
include( "../../Handbid/Auth/Auth.php" );
include( "../../Handbid/Store/StoreInterface.php");
include( "../../Handbid/Store/StoreAbstract.php");
include( "../../Handbid/Store/Auction.php");
include( "../../Handbid/Store/Bidder.php");
include( "../../Handbid/Store/Donor.php");
include( "../../Handbid/Store/ItemCategory.php");
include( "../../Handbid/Store/Item.php");
include( "../../Handbid/Store/Organization.php");


use Handbid\Handbid;
use Handbid\Auth;

class DummyStore extends \Handbid\Store\StoreAbstract{ }

class ApiTest extends PHPUnit_Framework_TestCase{
    public $appId  = '1234567890';
    public $apiKey = '1234567890';

    public function testServer(){
        $domain = 'http://rest.newbeta.handbid.com';
        $resourcePath = '/v1/rest/organizations.json';


        //build a curl request
        $curlHandle = curl_init();

        curl_setopt($curlHandle, CURLOPT_URL, $domain.$resourcePath);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

        //execute the request and decode the results, we expect the response to be json, if we're talking to our handbid rest server.
        $results = json_decode( curl_exec($curlHandle) );

        //if its not an object, then the response wasn't json, and it probably means a connectivity problem, or a data problem...
        $this->assertTrue( is_object( $results ) );

    }

    public function testAuth(){
        $appId  = $this->appId;
        $apiKey = $this->apiKey;

        $auth = new Auth($appId, $apiKey);

        $this->assertTrue( $auth instanceof Auth );
    }

    public function testHandbid(){
        $appId  = $this->appId;
        $apiKey = $this->apiKey;

        $auth = new Auth($appId, $apiKey);

        //make sure we can authorize our session
        $handbid = new Handbid( $auth );

        //make sure we get back a handbid instance.
        $this->assertTrue( $handbid instanceof Handbid );

        //a few different ways to use this method...
        $store1 = $handbid->store( 'Auction' );
        $store2 = $handbid->store( 'Handbid\Store\Auction' );
        $store3 = $handbid->store( new DummyStore() );

        $this->assertTrue( $store1 instanceof \Handbid\Store\StoreInterface );
        $this->assertTrue( $store2 instanceof \Handbid\Store\StoreInterface );
        $this->assertTrue( $store3 instanceof \Handbid\Store\StoreInterface );



    }

    public function testStoreInterface(){
        $appId  = $this->appId;
        $apiKey = $this->apiKey;

        $auth = new Auth($appId, $apiKey);

        $handbid = new Handbid( $auth );

        $dummyStore = $handbid->store( new DummyStore() );

        //@todo: Fills this out when we know more about how our system is supposed to work.
        $dummyStore->find();
        $dummyStore->create();
        $dummyStore->read();
        $dummyStore->update();
        $dummyStore->delete();

    }

    public function testStoreAbstract(){
        $appId  = $this->appId;
        $apiKey = $this->apiKey;

        $auth = new Auth($appId, $apiKey);

        $handbid = new Handbid( $auth );


    }

    public function testAuctionStore(){

        //@todo:  Make this something that isn't arbitrary, when our auth module is up.
        $appId = '1234567890';
        $apiKey = '1234567890';

        $auth = new Auth($appId, $apiKey);

        $handbid = new Handbid( $auth );
        $store = $handbid->store('Auction');


        //recent
        $recentAuctions = $store->recent();

            $this->assertTrue( count($recentAuctions) > 0 );

        //current

        //create

        //open

        //close

    }



}