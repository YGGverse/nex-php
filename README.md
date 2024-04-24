# nex-php

PHP 8 Library for Nex Protocol (see also [nps-php](https://github.com/YGGverse/nps-php))

## Usage

```
composer require yggverse/nex
```

## Client

PHP interface for Nex protocol queries

``` php
$client = new \Yggverse\Nex\Client;
```

#### Client::request

Request data from URL | URI if constructed by URL

``` php
var_dump(
    $client->request(
        'nex://nightfall.city/nex/'
    )
);
```

#### Client::setHost
#### Client::getHost
#### Client::setPort
#### Client::getPort
#### Client::setPath
#### Client::getPath
#### Client::setQuery
#### Client::getQuery
#### Client::getOptions
#### Client::setOptions

## Server

Build interactive server instance to listen Nex protocol connections!

``` php
$server = new \Yggverse\Nex\Server;
```

Provide optional `host`, `port` and `size` arguments in constructor or use available setters after object initiation.

``` php
$server = new \Yggverse\Nex\Server('127.0.0.1', 1900);
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
