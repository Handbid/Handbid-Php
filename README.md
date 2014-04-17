Handbid-Php
===========

PHP adapters for Handbid. This entire library was built to have the fewest dependencies possible and to make interfacing
with Handbid as simple and clean as can be.

# Testing app credentials
So, you have your consumer key and your consumer secret and want to see if they are legit? Try this:

```php
$hb = new Handbid($consumerKey, $consumerSecret);
try

    $hb->testAppCreds();

} catch(\Handbid\Exception\App $e) {

    //an app related exception occurred
    if($e->getCode() == \Handbid\Exception\App::ERROR_INVALID_CREDS) {

        //you should check the source of \Handbid\Exception\App for list of errors

    }

} catch(\Handbid\Exception\Rest $e) {

    //a network related exception occurred

} catch (\Exception $e) {

    //i have no idea what you did wrong

}
```