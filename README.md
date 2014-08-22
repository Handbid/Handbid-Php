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
All data io is handled through the `Store` architecture. We decided to abstract away the actual HTTP request to the idea
 of a generic `Store` so we can be ready to pull data from different services (memcache, filesystem, remote endpoint, mongodb, etc.).

The base `Store` API is very simple, but currently tied to our Legacy system (through the legacy `Store` layer). In order
to conform with our new API, some methods were added to the `Stores` that do not work. Point is, only call methods you
see described in this doc.


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
- `endTime`: timestamp for end time
- `status`: use this to check if an auction is open, valid statii are: `setup`, `presale`, `preview`, `open`, `ending`, `extended`, `closed`





# Logging in a user
```php

$hb         = new Handbid();
$auth       = new


```