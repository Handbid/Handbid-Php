<?php

namespace Handbid\Store;

use Handbid\Store\Legacy\StoreAbstract;

class Bidder extends StoreAbstract
{

    public $_profileCache = null;
    public $_bidCache = [
        "Bids"      => [
            [
                "_id"           => "53dbd74db05f8b8e500000a4",
                "name"          => "$200 bid for `Callaway Big Birtha Driver` by Taylor",
                "microtime"     => 1406916429.2464,
                "user"          => "4dddf347ba3a209125000008",
                "item"          => "4eb8b408bc8929cb0e000043",
                "auction"       => "4eb8b2d7bc8929df12000012",
                "amount"        => 200,
                "status"        => "winning",
                "_restMetaData" => ["bidderName" => "Taylor", "bidderAlias" => "Taylor", "bidderPin" => 1]
            ],
            [
                "_id"           => "53dbd653b05f8be95600009f",
                "name"          => "$100 bid for `Birthday Party at Monkey Bizness` by Taylor",
                "microtime"     => 1406916179.9646,
                "user"          => "4dddf347ba3a209125000008",
                "item"          => "4eb8b408bc8929cb0e00003c",
                "auction"       => "4eb8b2d7bc8929df12000012",
                "amount"        => 100,
                "status"        => "winning",
                "_restMetaData" => [
                    "bidderName"  => "Taylor",
                    "bidderAlias" => "Taylor",
                    "bidderPin"   => 1
                ]
            ],
            [
                "_id"           => "53dbd75cb05f8b8d500000b9",
                "name"          => "$60 bid for `Dinner and Dessert at Park Meadows` by Taylor",
                "microtime"     => 1406916444.7238,
                "user"          => "4dddf347ba3a209125000008",
                "item"          => "4eb8b407bc8929cb0e000024",
                "auction"       => "4eb8b2d7bc8929df12000012",
                "amount"        => 60,
                "status"        => "winning",
                "_restMetaData" => [
                    "bidderName"  => "Taylor",
                    "bidderAlias" => "Taylor",
                    "bidderPin"   => 1
                ]
            ],
            [
                "_id"           => "53dbd726b05f8bd36a000097",
                "name"          => "$50 bid for `Dining With Kids` by Taylor",
                "microtime"     => 1406916390.0106,
                "user"          => "4dddf347ba3a209125000008",
                "item"          => "4eb8b407bc8929cb0e000020",
                "auction"       => "4eb8b2d7bc8929df12000012",
                "amount"        => 50,
                "status"        => "winning",
                "_restMetaData" => [
                    "bidderName"  => "Taylor",
                    "bidderAlias" => "Taylor",
                    "bidderPin"   => 1
                ]
            ]
        ],
        "ProxyBids" => [
            [
                "_id"           => "53dbd773b05f8b91500000ad",
                "type"          => "ProxyBid",
                "dateInserted"  => 1406916467,
                "dateUpdated"   => 1406916468,
                "owner"         => ["4dddf347ba3a209125000008"],
                "name"          => "$300 proxy bid for `Callaway Big Birtha Driver` by Taylor",
                "menuTitle"     => null,
                "url"           => "\/proxybid\/0.120480001406916467\/0\/300-proxy-bid-for--callaway-big-birtha-driver--by-taylor",
                "key"           => "0.121494001406916467-0-300-proxy-bid-for--callaway-big-birtha-driver--by-taylor",
                "group"         => null,
                "module"        => null,
                "roles"         => [],
                "permissions"   => [],
                "keywords"      => [
                    "53dbd773b05f8b91500000ad",
                    "proxybid",
                    "1406916467",
                    "300",
                    "proxy",
                    "bid",
                    "for",
                    "callaway",
                    "big",
                    "birtha",
                    "driver",
                    "taylor",
                    "0.120480001406916467",
                    "0.121494001406916467",
                    "1406916467.1161",
                    "users",
                    "items",
                    "auctions",
                    "winning",
                    "bidphone",
                    "2.200",
                    "iphone",
                    "7.1.2"
                ],
                "microtime"     => 1406916467.1161,
                "user"          => "4dddf347ba3a209125000008",
                "item"          => "4eb8b408bc8929cb0e000043",
                "auction"       => "4eb8b2d7bc8929df12000012",
                "maxAmount"     => 300,
                "status"        => "winning",
                "_restMetaData" => [
                    "bidderName"  => "Taylor",
                    "bidderAlias" => "Taylor",
                    "bidderPin"   => 1
                ]
                ,
                "app"           => "BidPhone",
                "appVersion"    => "2.200",
                "device"        => "iPhone",
                "deviceVersion" => "7.1.2"
            ]
        ],
        "Purchases" => [
            [
                "_id"              => "53dbd731b05f8b925000009b",
                "type"             => "Purchase",
                "dateInserted"     => 1406916401,
                "dateUpdated"      => 1406916401,
                "owner"            => ["4dddf347ba3a209125000008"],
                "name"             => "Purchase of Drink Ticket by Taylor.",
                "menuTitle"        => null,
                "url"              => "\/purchase\/0.372528001406916401\/0\/purchase-of-drink-ticket-by-taylor",
                "key"              => "0.373488001406916401-0-purchase-of-drink-ticket-by-taylor",
                "group"            => null,
                "module"           => null,
                "roles"            => [],
                "permissions"      => [],
                "keywords"         => [
                    "purchase",
                    "drink",
                    "ticket",
                    "taylor.",
                    "0.372528001406916401",
                    "taylor",
                    "0.373488001406916401",
                    "items",
                    "sold",
                    "users",
                    "auctions"
                ],
                "item"             => [
                    "_id"                  => "4f4be4bebc8929eb64000173",
                    "name"                 => "Drink Ticket",
                    "key"                  => "drink-ticket",
                    "dateUpdated"          => 1406761772,
                    "status"               => "open",
                    "images"               => ["http:\/\/beta.handbid.com\/local\/uploads\/image-cache\/5e1c908f11db3d9ce3d8a36367c1774b-800x800.jpg"],
                    "table"                => null,
                    "category"             => "4fa0bb22bc89293c0d000074",
                    "donor"                => "",
                    "buyNowPrice"          => 7,
                    "startingPrice"        => 0,
                    "bidIncrement"         => 0,
                    "minimumBidAmount"     => 0,
                    "currentPrice"         => 0,
                    "highestBid"           => null,
                    "isDirectPurchaseItem" => 1,
                    "isRedeemable"         => 1,
                    "description"          => "\u00a0One drink ticket good for wine or beer at any bar.",
                    "auction"              => "4eb8b2d7bc8929df12000012",
                    "itemCode"             => "1000",
                    "notables"             => "",
                    "_restMetaData"        => [
                        "leadingBidderAlias" => "",
                        "leadingBidderId"    => "",
                        "categoryName"       => "Dining",
                        "tableNumber"        => "",
                        "totalBids"          => 0,
                        "roi"                => 0,
                        "proxyBidAmount"     => 0,
                        "isAProxyActive"     => false,
                        "totalSold"          => 0,
                        "totalProxyBids"     => 0,
                        "efficiency"         => null,
                        "closingTime"        => 1405383855
                    ],
                    "showValue"            => 0,
                    "value"                => 0,
                    "disableMobileBidding" => 0
                ],
                "status"           => "sold",
                "bidder"           => "4dddf347ba3a209125000008",
                "quantity"         => 1,
                "quantityRedeemed" => 0,
                "auction"          => "4eb8b2d7bc8929df12000012",
                "pricePerItem"     => 7,
                "grandTotal"       => 7,
                "bidderPin"        => "1",
                "itemType"         => "Item"
            ],
            [
                "_id"              => "53dbd73bb05f8bd46a000091",
                "type"             => "Purchase",
                "dateInserted"     => 1406916411,
                "dateUpdated"      => 1406916411,
                "owner"            => ["4dddf347ba3a209125000008"],
                "name"             => "Purchase of Margarita Party by Taylor.",
                "menuTitle"        => null,
                "url"              => "\/purchase\/0.800276001406916411\/0\/purchase-of-margarita-party-by-taylor",
                "key"              => "0.801300001406916411-0-purchase-of-margarita-party-by-taylor",
                "group"            => null,
                "module"           => null,
                "roles"            => [],
                "permissions"      => [],
                "keywords"         => [
                    "purchase",
                    "margarita",
                    "party",
                    "taylor.",
                    "0.800276001406916411",
                    "taylor",
                    "0.801300001406916411",
                    "items",
                    "sold",
                    "users",
                    "auctions"
                ],
                "item"             => [
                    "_id"                  => "4f9b0db5bc89296c5400000f",
                    "name"                 => "Margarita Party",
                    "key"                  => "poker-party--copy",
                    "dateUpdated"          => 1406761772,
                    "status"               => "open",
                    "images"               => ["http:\/\/beta.handbid.com\/local\/uploads\/image-cache\/5e1c908f11db3d9ce3d8a36367c1774b-800x800.jpg"],
                    "table"                => null,
                    "category"             => "4fa0bb22bc89293c0d000074",
                    "donor"                => "Jeff Porter",
                    "buyNowPrice"          => 10,
                    "startingPrice"        => 0,
                    "bidIncrement"         => 0,
                    "minimumBidAmount"     => 0,
                    "currentPrice"         => 0,
                    "highestBid"           => null,
                    "isDirectPurchaseItem" => 1,
                    "isRedeemable"         => 0,
                    "description"          => "",
                    "auction"              => "4eb8b2d7bc8929df12000012",
                    "itemCode"             => "1050-2",
                    "notables"             => "",
                    "_restMetaData"        => [
                        "leadingBidderAlias" => "",
                        "leadingBidderId"    => "",
                        "categoryName"       => "Dining",
                        "tableNumber"        => "",
                        "totalBids"          => 0,
                        "roi"                => 0,
                        "proxyBidAmount"     => 0,
                        "isAProxyActive"     => false,
                        "totalSold"          => 0,
                        "totalProxyBids"     => 0,
                        "efficiency"         => null,
                        "closingTime"        => 1405383855
                    ],
                    "showValue"            => 1,
                    "value"                => 0,
                    "disableMobileBidding" => 0
                ],
                "status"           => "sold",
                "bidder"           => "4dddf347ba3a209125000008",
                "quantity"         => 1,
                "quantityRedeemed" => 0,
                "auction"          => "4eb8b2d7bc8929df12000012",
                "pricePerItem"     => 10,
                "grandTotal"       => 10,
                "bidderPin"        => "1",
                "itemType"         => "Item"
            ]
        ]
    ];

    public function myProfile()
    {

        if (!$this->_profileCache) {
            $this->_profileCache = $this->_rest->get('profile');
        }

        return $this->_profileCache;
    }

    /**
     * Because proxy bids, bids, and purchases come back in 1 request i do not want us making the same request
     * many times
     *
     * @return array
     */
    public function _fetchBids($auction)
    {
        if (!$this->_bidCache) {
            $profile         = $this->myProfile();

            $this->_bidCache = $this->_rest->get(
                'models/Bid',
                [
                    'auction' => $auction['_id'],
                    'pin'     => $profile['pin']
                ]
            );
        }

        return $this->_bidCache;
    }

    public function myBids($auction)
    {
        return $this->_bidCache["Bids"];
    }

    public function myProxyBids($auction)
    {
        return $this->_bidCache["ProxyBids"];
    }

    public function myPurchases($auction)
    {
        return $this->_bidCache["Purchases"];
    }

}