# Kuna.io PHP API V2 Client

[![Build Status](https://travis-ci.org/codenix-sv/kuna-api.svg?branch=master)](https://travis-ci.org/codenix-sv/kuna-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/codenix-sv/kuna-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/codenix-sv/kuna-api/?branch=master)
[![License: MIT](https://img.shields.io/github/license/codenix-sv/kuna-api)](https://github.com/codenix-sv/kuna-api/blob/master/LICENSE)

A simple PHP API client, written with PHP for [kuna.io](https://kuna.io).

Kuna.io [API documentation](https://kuna.io/documents/api?lang=en).

## Requirements

* PHP >= 7.2
* ext-json

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require codenix-sv/kuna-api
```
or add

```json
"codenix-sv/kuna-api": "^0.1"
```
## Basic usage

### Example
```php
use Codenixsv\KunaApi\KunaClient;

$client = new KunaClient('publicKey', 'secretKey');

$data = $client->publicApi()->getTimestamp();
```

### Public Methods

#### getTimestamp

Server time.

```php
$data = $client->publicApi()->getTimestamp();
```

#### getTickers

Recent market data.

```php
$market = 'btcuah';

$data = $client->publicApi()->getTickers($market);
```

#### getDept

Order book.

```php
$market = 'btcuah';

$data = $client->publicApi()->getDepth($market);
```

#### getTrades

Trades history.

```php
$market = 'btcuah';

$data = $client->publicApi()->getTrades($market);
```

### User Methods

#### getMe

Information about the user and assets.

```php
$data = $client->privateApi()->getMe();
```

#### createOrder

Order placing.

```php
$side = 'buy';
$volume = 1.00;
$market = 'btcuah';
$price = 2000.00;

$data = $client->privateApi()->createOrder($side, $volume, $market, $price);
```

#### deleteOrder

Order cancel.

```php
$id = 32555;

$data = $client->privateApi()->deleteOrder($id);
```

#### getOrders

Active user orders.

```php
$market = 'btcuah';

$data = $client->privateApi()->getOrders($market);
```

#### getMyTrades

User trade history.

```php
$market = 'btcuah';

$data = $client->privateApi()->getMyTrades($market);
```

## License

`codenix-sv/kuna-api` is released under the MIT License. See the bundled [LICENSE](./LICENSE) for details.
