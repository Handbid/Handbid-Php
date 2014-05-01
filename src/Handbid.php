<?php

namespace Handbid;

use Handbid\Store\StoreInterface;

class Handbid
{

    public $_rest,
        $_auth,
        $_consumerKey,
        $_consumerSecret,
        $_storeCache = [];

    /**
     * Include all dependencies
     */
    public static function includeDependencies()
    {
        require __DIR__ . "/Exception/App.php";
        require __DIR__ . "/Exception/Bid.php";
        require __DIR__ . "/Exception/Network.php";
        require __DIR__ . "/Rest/RestInterface.php";
        require __DIR__ . "/Rest/Rest.php";
        require __DIR__ . "/Auth/AuthInterface.php";
        require __DIR__ . "/Auth/AppAuth.php";
        require __DIR__ . "/Auth/UserXAuth.php";
        require __DIR__ . "/Store/StoreInterface.php";
        require __DIR__ . "/Store/StoreAbstract.php";
        require __DIR__ . "/Store/TaxonomyTerm.php";
        require __DIR__ . "/Store/Bid.php";
        require __DIR__ . "/Store/Ticket.php";
        require __DIR__ . "/Store/Auction.php";
        require __DIR__ . "/Store/Bidder.php";
        require __DIR__ . "/Store/Donor.php";
        require __DIR__ . "/Store/ItemCategory.php";
        require __DIR__ . "/Store/Item.php";
        require __DIR__ . "/Store/Organization.php";
    }

    /**
     * @param       $consumerKey
     * @param       $consumerSecret
     * @param array $options
     */
    public function __construct($consumerKey, $consumerSecret, $options = [])
    {
        //defaults
        $endpoint = isset($options['endpoint']) ? $options['endpoint'] : 'http://rest.newbeta.handbid.com';
        $path     = isset($options['path']) ? $options['path'] : '/v1/rest/';

        //build our rest supporting classes
        $this->_rest    = isset($options['rest']) ? $options['rest'] : new Rest\Rest($endpoint, $path);
        $auth           = isset($options['auth']) ? $options['auth'] : new Auth\AppAuth($consumerKey, $consumerSecret);

        $this->setAuth($auth);

    }

    /**
     * Set a new auth adapter. See ./Auth/AuthInterface.php for details.
     *
     * @param Auth\AuthInterface $auth
     *
     * @return $this
     */
    public function setAuth(Auth\AuthInterface $auth)
    {
        $auth->setRest($this->_rest);
        $this->_auth = $auth;
        return $this;
    }

    /**
     * The object responsible for all communication with the handbid servers
     *
     * @return Rest\RestInterface
     */
    public function rest()
    {
        return $this->_rest;
    }

    /**
     * Lets you test your app credentials. Simply attempts to fetch a token for the app
     *
     * @throws \Handbid\Exception\App
     */
    public function testAuth()
    {
        $token = $this->_auth->fetchToken();
        return true;
    }

    /**
     * Factory for creating a store.
     *
     * @param $type
     *
     * @throws \Exception
     */
    public function store($type)
    {

        //lazy load and cache the store.
        if (!isset($this->_storeCache[$type])) {

            //do we have a bearer or access token? (we want one before we create a store)
            if (!$this->_auth->hasToken()) {
                $this->_auth->refreshToken();
            }

            //create the store instance
            $store = null;

            if (strpos($type, '\\') !== false) {
                //it contains a backslash, so its probably a fully qualified namespaced class reference
                $store = class_exists($type) ? new $type : null;

            } else {
                //We'll assume it's an unqualified classname, we'll look it up in the handbid store adapters.
                $classPath = 'Handbid\Store\\' . $type;
                $store     = class_exists($classPath) ? new $classPath($this->_rest, $this->_auth) : null;

            }

            //cache the new store instance
            if (!is_null($store) && $store instanceof StoreInterface) {
                $this->_storeCache[$type] = $store;
            } else {
                //if we got here, things aren't well.
                throw new \Exception('Valid store not found!' . ' ( ' . $type . ' )');

            }

        }

        return $this->_storeCache[$type];

    }


}