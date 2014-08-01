<?php

namespace Handbid\Store;

use Handbid\Store\StoreAbstract;

class Bidder extends StoreAbstract
{

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

    public function profile()
    {
        return [
            "_id"
                             => "4dddf347ba3a209125000008",
            "dateInserted"   => 1306391367,
            "dateUpdated"    => 1406905303,
            "name"           => "Taylor Romero",
            "url"            => "\/user\/taylor-romero-2",
            "key"            => "taylor-romero",
            "roles"          => ["4dcd88c1ba3a207a0d000019"],
            "firstName"      => "Taylor",
            "lastName"       => "Romero",
            "email"          => "liquidg3@mac.com",
            "alias"          => "Taylor",
            "photo"          => "https:\/\/handbidlive-handbid.netdna-ssl.com\/local\/uploads\/user\/taylor-romero-2\/this-is-america.jpg",
            "address"        => [
                "street1"    => "",
                "street2"    => "",
                "city"       => "",
                "province"   => "",
                "postalCode" => "",
                "country"    => "us"
            ],
            "_restMetaData"  => [
                "isManager" => false,
                "isBidder"  => false,
                "bidStats"  => [
                    "4dd1f9d3ba3a20815800002c" => [
                        "numWinning" => 0,
                        "numLosing"  => 0,
                        "winningIds" => [],
                        "losingIds"  => []
                    ],
                    "4e090bdeba3a20e435000002" => [
                        "numWinning" => 1,
                        "numLosing"  => 0,
                        "winningIds" => ["4e1b9084ba3a205016000002"],
                        "losingIds"  => [],
                    ],
                    "4e4ab853bc89295f6c000008" => [
                        "numWinning" => 0,
                        "numLosing"  => 0,
                        "winningIds" => [],
                        "losingIds"  => []
                    ],
                    "4e6d7536bc8929eb39000003" => [
                        "numWinning" => 0,
                        "numLosing"  => 0,
                        "winningIds" => [],
                        "losingIds"  => []
                    ],
                    "4e8c7d95bc8929287d000002" => [
                        "numWinning" => 0,
                        "numLosing"  => 3,
                        "winningIds" => [],
                        "losingIds"  => [
                            "4eb94e27bc8929c80e000033",
                            "4ebef6a0bc8929d20e00000e",
                            "4ebee3f6bc8929740c000008"
                        ]
                    ],
                    "4eaddb8fbc89296279000003" => [
                        "numWinning" => 1,
                        "numLosing"  => 0,
                        "winningIds" => ["4eb2179cbc8929f704000044"],
                        "losingIds"  => []
                    ],
                    "4e97be55bc89290e4900007f" => [
                        "numWinning" => 0,
                        "numLosing"  => 0,
                        "winningIds" => [],
                        "losingIds"  => []
                    ],
                    "4eb8b2d7bc8929df12000012" => false
                ]
            ],
            "phone"          => [
                "value" => "",
                "type"  => null
            ],
            "cellPhone"      => [
                "value" => "(720) 253-5250",
                "type"  => ""
            ],
            "subscriptionId" => null,
            "favoriteItems"  => [
                "4eb8b408bc8929cb0e000043",
                "4f4aad7ebc8929e964000051",
                "4f4aad7ebc8929e96400004e",
                "4f4aad7ebc8929e96400004d",
                "4eb8b407bc8929cb0e000020",
                "4f4aad7ebc8929e964000063",
                "4f4aad7ebc8929e964000061",
                "4f4aad7ebc8929e964000065",
                "4f4aad7ebc8929e96400004a",
                "4f4aad7ebc8929e96400004c",
                "4f4aad7ebc8929e964000059",
                "4eb8b407bc8929cb0e00002a",
                "4f4aad7ebc8929e964000055",
                "4eb8b407bc8929cb0e000024",
                "4f4aad7ebc8929e964000056",
                "4eb8b408bc8929cb0e00003a",
                "4f4aad7ebc8929e96400005b",
                "4dd1f9d3ba3a20815800002c",
                "4f4aad7ebc8929e964000060",
                "4f4aad7ebc8929e96400004f",
                "4f66ae44bc8929993e000022",
                "4f5eb57fbc8929595f000004",
                "4f66adb5bc8929853e000030",
                "4f4aac2ebc8929ed64000058",
                "4eb8b408bc8929cb0e000047",
                "4eb8b407bc8929cb0e000031",
                "4eb8b408bc8929cb0e00004b",
                "4eb8b2d7bc8929df12000012",
                "4eb8b407bc8929cb0e00001c",
                "4eb8b407bc8929cb0e00001e",
                "4eb8b408bc8929cb0e000045",
                "4eb8b408bc8929cb0e000034",
                "4eb8b408bc8929cb0e000049",
                "4e8c7d95bc8929287d000002",
                "4eb8b408bc8929cb0e000036",
                "4f96c0f7bc8929131d00000a",
                "4eb8b407bc8929cb0e000022",
                "4f970e1ebc89291d2f000026",
                "4f9614efbc8929696400001c",
                "4f95cd9bbc8929c044000019",
                "4eb8b407bc8929cb0e00002d",
                "4eb8b407bc8929cb0e000028",
                "4eb8b408bc8929cb0e00003c",
                "4f9615c7bc89295f65000002",
                "4f9615eebc8929dc64000010",
                "4eb8b408bc8929cb0e00003f",
                "4f9761d0bc89292f64000013",
                "4f825715bc8929f475000010",
                "4f96150fbc89296c6400001f",
                "4eb8b408bc8929cb0e000038",
                "4f9abfaebc8929632e000010",
                "4eb8b407bc8929cb0e000026",
                "4f9abeffbc8929912d000020",
                "4f9a26e7bc89299906000002",
                "4f95cd6cbc8929de45000004",
                "4eb8b407bc8929cb0e00002f",
                "4f9db5b4bc8929ae0d00001b",
                "4f97873cbc89293c7e000011",
                "4fc8f89cbc89290c2600000f",
                "4fbaaf89bc8929f947000019",
                "4fd76743bc89296c65000043",
                "4ff1df03bc8929595d00004b",
                "4febd925bc89298356000002",
                "4f96156fbc89292b65000004",
                "4fc7c6b8bc8929b504000035",
                "501c16dfbc8929d306000027",
                "501c0157bc8929023400004b",
                "501c16dfbc8929d30600001d",
                "5026dc18bc8929b266000002",
                "50116c96bc8929a60c000003",
                "4fe156cbbc8929167f00000a",
                "501fce0fbc89292515000033",
                "506a2783bc89297e1c000047",
                "4eb8b408bc8929cb0e000041",
                "508935bfbc8929d17e000036",
                "50d23a97bc89296f2400103d",
                "50d238e5bc8929d704000b2a",
                "51686417a14d9963740067f7",
                "511179eda14d993812001054",
                "51e43518a14d9939260166e3",
                "5266f18fa14d99314a001a53",
                "52f3b999a14d99771a004393",
                "52bc7aeea14d99d969006b65",
                "530d0115a14d99ab20000061",
                "530cffb8a14d99b420000057",
                "523b6131a14d99517c010ed0",
                "53232a84a14d99673f005e3d"
            ],
            "pin"            => 1,
            "_auth"          => [
                "ironframe"           => "liquidg3@mac.com:50aa665c211e68d00b7350757fda501c:48091994cbe274fced5c3e01f7818342",
                "autoLoginUserPhone"  => "7202535250",
                "bidderEmailPassword" => "liquidg3@mac.com:bidder:92edf25123fc35a148c72b72351fc341",
                "bidderEmailPhone"    => "liquidg3@mac.com:bidder:7db7dad4d71161755ae7737daf68b2a1",
                "bidderPinPassword"   => "1:bidder:5cfbc428ad234278875adbbf5b522182",
                "bidderPinPhone"      => "1:bidder:ddcb84ede794e810f94f375cbd735174",
                "bidder"              => "liquidg3@mac.com:bidder:92edf25123fc35a148c72b72351fc341"
            ]
        ];
    }

    public function myBids()
    {
        return $this->_bidCache["Bids"];
    }

    public function myProxyBids()
    {
        return $this->_bidCache["ProxyBids"];
    }

    public function myPurchases()
    {
        return $this->_bidCache["Purchases"];
    }

}