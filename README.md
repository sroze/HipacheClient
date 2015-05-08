# Hipache Client

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sroze/HipacheClient/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sroze/HipacheClient/?branch=master)

This library is an Hipache PHP client.

## Installation

Use Composer to install this library as dependency:
```
composer require sroze/hipache-client
```

## Usage

Usage is made to be quite simple and can be done though the `Client` object endpoint.

### Create a client

This `Client` class should be created with an adapter, because Hipchat supports multiple adapters (called drivers).
See the [adapters](#adapters) section to how instanciate an adapter.

```php
use Hipache\Client;

$client = new Client($adapter);
```

### List all frontends

Just call the `getFrontendCollection` method to have a traversable collection of frontends:
```php
$frontendCollection = $client->getFrontendCollection();

foreach ($frontendCollection as $frontend) {
    echo $frontend->getHostname();
}
```

### Create a frontend

There's a `createFrontend` method on the client that allows you to create a frontend:
```php
use Hipache\Frontend\Frontend;
use Hipache\Frontend\Exception\FrontendAlreadyExists;

try {
    $frontend = $client->createFrontend(new Frontend('www.example.com'));
} catch (FrontendAlreadyExists $e) {
    // Given frontend can't be created since it already exists...
}
```

### Get a frontend by its domain name

There's a `getFrontend` method that returns a `Frontend` object based on its name.
```php
use Hipache\Frontend\Exception\FrontendNotFound;

try {
    $frontend = $client->getFrontend('www.example.com');
} catch (FrontendNotFound $e) {
    // Frontend was not found...
}
```

### Updating frontends' backends

When you've fetched a frontend with the `Client` class, you have a `WritableFrontend` instance. That means that you just
have to call one of the `add` or `remove` methods to respectively add or remove a backend from it.

Here's an example how to add 2 backends to a given frontend:

```php
use Hipache\Backend\Backend;

$frontend = $client->getFrontend('sroze.io');
$frontend->add(new Backend('http://1.2.3.4:8000'));
$frontend->add(new Backend('http://1.2.3.4:8001'));
```

If you want to remove backends, just add the `remove` method:
```php
$frontend = $client->getFrontend('sroze.io');
$frontend->remove(new Backend('http://1.2.3.4:8000'));
```

## Adapters

There's right know only the Redis adapter (recommended one) that is supported.

### Redis adapter

The `RedisAdapter` class needs to be constructed with a configured Predis client, and that's all.

Here's an example how to create an instance of a Redis adapter:
```php
use Predis\Client as RedisClient;
use Hipache\Adapter\RedisAdapter;

$adapter = new RedisAdapter(new RedisClient('tcp://172.17.0.18:6379'));
```
