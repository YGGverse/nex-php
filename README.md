# nex-php

PHP 8 Library for Nex Protocol

## Usage

```
composer require yggverse/nex
```

## Client

PHP interface for Nex protocol queries

### Request

``` php
$request = new \Yggverse\Nex\Client\Request(
    'nex://nightfall.city/nex/'
);
```

**Resolved request (SNI)**

For direct connection provide resolved IP as the second argument

``` php
$request = new \Yggverse\Nex\Client\Request(
    'nex://nightfall.city/nex/' // target URL
    '46.23.92.144' // resolved IP, skip to use system-wide resolver
);
```

Alternatively, use `setResolvedHost` method of `Request` object before `getResponse`

#### Request::setResolvedHost

``` php
$request->setResolvedHost(
    '46.23.92.144'
)
```

* to resolve network address with PHP, take a look on the [net-php](https://github.com/YGGverse/net-php) library!

#### Request::getResolvedHost

Get resolved host back

#### Request::setHost
#### Request::getHost
#### Request::setPort
#### Request::getPort
#### Request::setPath
#### Request::getPath
#### Request::setQuery
#### Request::getQuery
#### Request::getResponse

Execute requested URL and return raw response

``` php
var_dump(
    $request->getResponse()
);
```

#### Request::getOptions
#### Request::setOptions