<?php

namespace Handbid;

use Handbid\Store\StoreInterface;

class Handbid
{

    public $_rest = null,
        $_auth = null,
        $_storeCache = [];

    public static function includeDependencies()
    {
        require __DIR__ . "/Rest/RestInterface.php";
        require __DIR__ . "/Rest/Rest.php";
        require __DIR__ . "/Auth/AuthInterface.php";
        require __DIR__ . "/Auth/Auth.php";
        require __DIR__ . "/Store/StoreInterface.php";
        require __DIR__ . "/Store/StoreAbstract.php";
        require __DIR__ . "/Store/Auction.php";
        require __DIR__ . "/Store/Bidder.php";
        require __DIR__ . "/Store/Donor.php";
        require __DIR__ . "/Store/ItemCategory.php";
        require __DIR__ . "/Store/Item.php";
        require __DIR__ . "/Store/Organization.php";
        require __DIR__ . "/Exception/App.php";
        require __DIR__ . "/Exception/Bid.php";
    }

    /**
     * @param $appId
     * @param $apiKey
     * @param array $options
     */
    public function __construct($appId, $apiKey, $options = [])
    {

        //defaults
        $endpoint = isset($options['endpoint']) ? $options['endpoint'] : 'http://rest.newbeta.handbid.com';
        $path = isset($options['path']) ? $options['path'] : '/v1/rest';

        //build our rest class
        $this->_rest = isset($options['rest']) ? $options['rest'] : new Rest\Rest($endpoint, $path, $appId, $apiKey);

    }

    /**
     * Lets you test your app credentials.
     *
     * @throws Exception\App
     */
    public function testAppCreds()
    {
        throw new Exception\App('Invalid appId or apiKey.', Exception\App::ERROR_INVALID_CREDS);
    }


    /**
     * @param $username
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function auth($username, $password)
    {

        if (is_null($username)) {
            throw(new \Exception('Auth Failure: Must provide a username for authorization.'));

        }

        if (is_null($password)) {
            throw(new \Exception('Auth Failure: Must provide a password for authorization.'));

        }

        $auth = $this->_auth->authenticate($username, $password);

        //@todo: validate auth results;

        return $auth;
    }

    public function store($type)
    {

        //lazy load and cache the store.
        if ($this->_storeCache[$type]) return $this->_storeCache[$type];


        //create the store instance
        $store = null;

        if (strpos($type, '\\') !== false) {
            //it contains a backslash, so its probably a fully qualified namespaced class reference
            $store = class_exists($type) ? new $type : null;

        } else {
            //We'll assume it's an unqualified classname, we'll look it up in the handbid store adapters.
            $classPath = 'Handbid\Store\\' . $type;
            $store = class_exists($classPath) ? new $classPath($this->_restServerAddress, $this->_restBasePath, $this->_auth) : null;

        }


        //cache the new store instance
        if (!is_null($store) && $store instanceof StoreInterface) {
            $this->_storeCache[$type] = $store;

            return $store;
        }

        //if we got here, things aren't well.
        throw new \Exception('Store not found!' . ' ( ' . $type . ' )');

    }

}