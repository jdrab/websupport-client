# websupport.sk rest api - client

**1st Warning** - for some odd reason websupport api does not use the full payload
to generate the signature eg:

```php
# https://rest.websupport.sk/docs/v1.intro

# if you're updating your DNS A record you're not generating signature 
# using your updated IP address
$canonicalRequest = sprintf('%s %s %s', $method, $path, $time);
$signature = hash_hmac('sha1', $canonicalRequest, $secret);
```
keep in mind that potential attacker may be able to change your payload "on the fly" without actually making the hmac invalid for your request. Attacker must be able to forge an valid https certificate, which is not easy but..


**Notice**: only some functionality is implemented 

- DNS management - done
- User management - bare minimum needed for DNS management 
- Service management - TODO
- Invoice management - TODO
- Ordering new services - TODO
- iOS & Android notifications - TODO
- Hosting management - TODO
- VPS management - TODO

usage:
```php
// create a record
$restUrl = "https://rest.websupport.sk";
$ws = new \Websupport\Client\Request($restUrl, $apiKey, $secret);
$dns = new \Websupport\Client\DNS($ws, $domainName);

$records = new \Websupport\Client\DNS\Records(
    $dns,
    new \Websupport\Client\DNS\ARecord([
        'name' => $hostname, 
        'content' => $ip
    ])
);

$res = $records->validate()->create();

echo $res->jsonResponse(); // or response()
```

```php
// update record
$restUrl = "https://rest.websupport.sk";
$ws = new \Websupport\Client\Request($restUrl, $apiKey, $secret);
$dns = new \Websupport\Client\DNS($ws, $domainName);

$record = new \Websupport\Client\DNS\Records(
    $dns,
    new \Websupport\Client\DNS\ARecord([
        'name' => $hostname, 
        'content' => 'ip.ad.dr.re.ss'
    ])
);

$update = $record->validate()->update($recordIdNotHostname);

echo $update->jsonResponse(); // or response()
```

```php
$restUrl = "https://rest.websupport.sk";
$ws = new \Websupport\Client\Request($restUrl, $apiKey, $secret);
$dns = new \Websupport\Client\DNS($ws, $domainName);

$record = new \Websupport\Client\DNS\Records($dns);

$delete = $record->delete($recordIIdNotHostname);

echo $delete->jsonResponse(); // or response()
```