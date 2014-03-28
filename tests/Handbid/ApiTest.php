<?php

//We are assuming PHPUnit is installed one directory above the package. Feel free to change this to map to your PHPUnit folder.
//require_once "../../../PHPUnit/Autoload.php";

include( "../../Handbid/Handbid.php" );
include( "../../Handbid/Auth/Auth.php" );
include( "../../Handbid/Store/StoreInterface.php");
include( "../../Handbid/Store/StoreAbstract.php");
include( "../../Handbid/Store/Auction.php");
include( "../../Handbid/Store/Bidders.php");
include( "../../Handbid/Store/Donor.php");
include( "../../Handbid/Store/ItemCategories.php");
include( "../../Handbid/Store/Items.php");
include( "../../Handbid/Store/Organizations.php");


use Handbid\Handbid;
use Handbid\Auth;
//use Handbid\Store\Store;

class ApiTest extends PHPUnit_Framework_TestCase{


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
        assert( is_object( $results ) );

    }

    public function testAuctionStore(){

        //@todo:  Make this something that isn't arbitrary, when our auth module is up.
        $appId = '1234567890';
        $apiKey = '1234567890';

        $auth = new Auth($appId, $apiKey);

        $handbid = new Handbid( $auth );
        $auctions = $handbid->store('Auction')->recent();

        assert( count($auctions) > 0 );
    }



}