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

#### Request::getResponse

Execute requested URL and return raw response

``` php
var_dump(
    $request->getResponse()
);
```

#### Request::setHost
#### Request::getHost
#### Request::setPort
#### Request::getPort
#### Request::setPath
#### Request::getPath
#### Request::setQuery
#### Request::getQuery
#### Request::getOptions
#### Request::setOptions