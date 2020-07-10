# websupport.sk rest api - client

**warning**: only some functionality is implemented 

- DNS management - done
- User management - bare minimum needed for DNS management 
- Service management - TODO
- Invoice management - TODO
- Ordering new services - TODO
- iOS & Android notifications - TODO
- Hosting management - TODO
- VPS management - TODO

usage:
~~~php
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
~~~

~~~php
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
~~~

~~~php
$restUrl = "https://rest.websupport.sk";
$ws = new \Websupport\Client\Request($restUrl, $apiKey, $secret);
$dns = new \Websupport\Client\DNS($ws, $domainName);

$record = new \Websupport\Client\DNS\Records($dns);

$delete = $record->delete($recordIIdNotHostname);

echo $delete->jsonResponse(); // or response()
~~~
