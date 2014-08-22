Handbid-Php
===========

PHP adapters for `Handbid`. This entire library was built to have the fewest dependencies possible and to make interfacing
with `Handbid` as simple and clean as can be.

## Instantiating Handbid
Getting `Handbid` ready to go is as simple as constructing a new one. You can instantiate as many as you want (they are not singletons, but you can should probably use it as one).
```php

$hb = new Handbid();

```

## Fetching Data
All data io is Handbid through the `Store` architecture. We decided to abstract away the actual HTTP request and go with the idea
 of a generic `Store` so we can be ready to pull data from different services (memcache, filesystem, remote endpoint, mongodb, etc.).

The base `Store` API is very simple, but currently tied to our Legacy system (through the legacy `Store` layer). In order
to conform with our new API, some methods were added to the `Stores` that do not work. Point is, only call methods you
see described in this doc.

Every document that is returned from a `Store` will be of type `stdClass.` We are trying to keep things as light as possible.

### Fetching organizations
```php

$store      = $hb->store('Organization');

$orgs       = $store->all();
$org        = $store->byId('234230582340723402342');
$org        = $store->byKey('my-favorite-org');
```

### Fetching auctions
```php

$store      = $hb->store('Auction');

$auctions   = $store->byOrg($org->_id);
$auctions   = $store->upcoming($org->_id);
$auctions   = $store->past($org->_id);

$auction    = $store->byKey('handbid-demo-auction');
$auction    = $store->byId('2342342342342342343242');

echo $auction->name;
```

### Auction Schema
- `_id`: id of the auction assigned by mongo.
- `name`: auction's name
- `key`: auction's key (better for passing through urls)
- `description`: details provided by auction managerp
- `vanityAddress`: something like "Colorado Convention Center." Better to output this than the location if it's set
- `location`: object in this form: `{ city: 'Denver', country: 'us', postalCode: '80202', province: 'CO', street1: '123 Main Street', street2: 'Unit B', street3: 'Never seen it used }`
- `logo`: object in this form: `{ large: 'https://handbid.com/path/to/large.jpg', medium: 'https://handbid.com/path/to/medium.jpg', small: 'https://handbid.com/path/to/small.jpg' }`
- `startTime`: timestamp for start time
- `endTime`: timestamp for end of auction (do not rely on this, it is an estimate of closing time. good to show to the bidders, but not to use for calculations)
- `closingTime`: set when the auction manager starts the countdown timer.
- `status`: use this to check if an auction is open, valid statii are: `setup`, `presale`, `preview`, `open`, `ending`, `extended`, `closed`
- `localOnly`: bidders will need to checkin to bid (usually done by auction manager at the event)
- `enableTicketSales`: we can sell tickets, but it's pretty basic right now.
- `requireCreditCard`: the auction requires a credit card on file to bid
- `spendingThreshold`: the amount of $$$ in dollars.cents (1.50) that we will let someone bid to until we require them to enter their cc
- `meta`: object in this form: `{ totalItems: 71, organization: { key: 'my-org', name: 'My Organization` }  }`

### Fetching Items
```php

//customize query to pass options for resizing images
$query['options']['images']['w'] = 500;
$query['options']['images']['h'] = 0; //image will scale proportionally

$store      = $hb->store('Item');

$items      = $store->byAuction($auction->_id, $query);
$items      = $store->biddableByAuction($auction->_id);
$items      = $store->purchasableByAuction($auction->_id);

$item       = $store->byKey('item-key', $query);
$item       = $store->byId('234234234', $query);

echo $item->itemCode . ': ' . $item->name . '<br />';

```

### Item Schema
- `_id`: id assigned by mongo
- `name`: name of item given by auction manager
- `key`: better for passing through url's
- `auction`: id of auction
- `bidIncrement`: the bid increment
- `buyNowPrice`: if one is set, the bidder can purchase right away
- `category`: the id of the category
- `closingTime`: countdown timer passed through from auction (prepping us for per-item countdowns)
- `description`: entered by auction manager
- `disableMobileBidding`: will keep people from bidding from their phones
- `donor`: who donated the item (string)
- `images`: array in form of: `[ "http://handbid.com/my/item/image.png", "http://handbid.com/another/item/image.png"]`
- `itemCode`: entered by the auction manager
- `minimumBidAmount`: the lowest someone can bid to be on top
- `notables`: think of this as 'fine print' with a nice name
- `status`: can be one of the following: `pending`, `open`, `extended`, `sold`, `paid`, `delivered`, `shipped`
- `value`: the MSRP (street value) of an item
- `showValue`: sometimes the auction manager does not want people to know the value of the item being bid on
- `terms`: array of tags for this item (currently mapped to our category system)
- `winningBidder`: object in form of: `{ alias: 'Tay Tay', id: 'asotneuhanosteuh', pin: 1}`