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

## Server

Build interactive server instance to listen Nex protocol connections!

``` php
$server = new \Yggverse\Nex\Server;
```

Provide optional `host`, `port` and `size` arguments in constructor or use available setters after object initiation.

``` php
$server = new \Yggverse\Nex\Server('127.0.0.1', 1915);
```

#### Server::setHost
#### Server::getHost
#### Server::setPort
#### Server::getPort
#### Server::setSize
#### Server::getSize
#### Server::setLive
#### Server::getLive

#### Server::start

Run server object using this method.

Define handler function as the argument to process application logic dependent of client request.

``` php
$server->start(
    function (
        string $request,
        string $connect
    ) {
        printf(
            'connection: %s request: %s',
            $connect,
            $request
        );
    }
);
```

#### Server::stop

Stop server instance.

Same to `Server::setLive(false)`
