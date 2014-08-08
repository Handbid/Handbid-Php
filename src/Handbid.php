<?php

namespace Handbid;

use Handbid\Store\StoreInterface;

class Handbid
{

    public $_rest,
        $_auth,
        $_consumerKey,
        $_consumerSecret,
        $_storeCache = [],
        $_storePrefix = 'Handbid\\Store\\';

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
        require __DIR__ . "/Auth/Legacy.php";
        require __DIR__ . "/Auth/AppAuth.php";
        require __DIR__ . "/Auth/OAuth.php";
        require __DIR__ . "/Auth/UserXAuth.php";

        //store abstract
        require __DIR__ . "/Store/StoreInterface.php";
        require __DIR__ . "/Store/Legacy/StoreAbstract.php";
        require __DIR__ . "/Store/StoreAbstract.php";

        //org
        require __DIR__ . "/Store/Organization.php";
        require __DIR__ . "/Store/Legacy/Organization.php";


        //auction
        require __DIR__ . "/Store/Auction.php";
        require __DIR__ . "/Store/Legacy/Auction.php";

        //categories
        require __DIR__ . "/Store/TaxonomyTerm.php";
        require __DIR__ . "/Store/ItemCategory.php";
        require __DIR__ . "/Store/Legacy/ItemCategory.php";

        //item
        require __DIR__ . "/Store/Item.php";
        require __DIR__ . "/Store/Legacy/Item.php";


        require __DIR__ . "/Store/Bid.php";
        require __DIR__ . "/Store/Ticket.php";
        require __DIR__ . "/Store/Legacy/Bidder.php";
        require __DIR__ . "/Store/Donor.php";
        require __DIR__ . "/Store/Manager.php";
    }

    /**
     * @param       $consumerKey
     * @param       $consumerSecret
     * @param array $options
     */
    public function __construct($consumerKey, $consumerSecret, $options = [])
    {
        //default support is legacy now
        if (!isset($options['legacy']) || $options['legacy']) {
            $this->_storePrefix  = 'Handbid\\Store\\Legacy\\';
        }

        //defaults
        $endpoint = isset($options['endpoint']) ? $options['endpoint'] : 'http://beta.handbid.com';
        $path     = isset($options['path']) ? $options['path'] : '/v1/rest/';

        //build our rest supporting classes
        $this->_rest = isset($options['rest']) ? $options['rest'] : new Rest\Rest($endpoint, $path);
        $auth        = isset($options['auth']) ? $options['auth'] : new Auth\Legacy();

        if ($auth) {
            $this->setAuth($auth);
        }

    }

    /**
     * Set a new auth adapter. See ./Auth/AuthInterface.php for details. Anything you set here is passed through to the
     * REST class.
     *
     * @param Auth\AuthInterface $auth
     *
     * @return $this
     */
    public function setAuth(Auth\AuthInterface $auth)
    {
        $this->_auth = $auth;
        $this->_rest->setAuth($auth);

        //if our auth is missing a token, lets try and refresh it from the server (this will throw an exception on failure)
        if ($this->_auth && !$this->_auth->hasToken()) {
            $this->_auth->refreshToken($this->_rest);
        }

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

        if($this->_auth) {
            $token = $this->_auth->fetchToken($this->_rest);
        } else {
            throw new \Handbid\Exception\App('No valid auth set.');
        }

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

            //create the store instance
            $store = null;

            if (strpos($type, '\\') !== false) {
                //it contains a backslash, so its probably a fully qualified namespaced class reference
                $store = class_exists($type) ? new $type : null;

            } else {
                //We'll assume it's an unqualified classname, we'll look it up in the handbid store adapters.
                $classPath = $this->_storePrefix . $type;
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