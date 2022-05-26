# Fleetbase Multi-Carrier PHP SDK

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][packagist]
[![Software License][badge-license]][license]
[![PHP Version][badge-php]][php]
[![Build Status][badge-build]][build]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]

Fleetbase Multi-Carrier PHP SDK

This project adheres to a [Contributor Code of Conduct][conduct]. By
participating in this project and its community, you are expected to uphold this
code.


## Requirements

PHP 7.4 and later.


## Installation

The preferred method of installation is via [Composer][]. Run the following
command to install the package and add it as a requirement to your project's
`composer.json`:

```bash
composer require fleetbase/omniship-php
```


## Quick Start

Simple usage looks like:

```php
use Fleetbase\Omniship;

$carrier = Omniship::create('FedEx');
$carrier->setCredentials([]);

$serviceQuotes = $carrier->getQuote([]);
$order = $serviceQuotes->first()->purchase();

if ($order->isSuccessful()) {
    // Order was successful
} else {
    // Order failed
}
```

## Documentation

Check out the [documentation website][documentation] for detailed information
and code examples.


## Contributing

Contributions are welcome! Please read [CONTRIBUTING][] for details.


## Copyright and License

The fleetbase/omniship-php library is copyright © [Fleetbase Pte Ltd.](https://fleetbase.io)
and licensed for use under the MIT License (MIT). Please see [LICENSE][] for
more information.


[conduct]: https://github.com/fleetbase/omniship-php/blob/master/.github/CODE_OF_CONDUCT.md
[composer]: http://getcomposer.org/
[documentation]: https://fleetbase.github.io/omniship-php/
[contributing]: https://github.com/fleetbase/omniship-php/blob/master/.github/CONTRIBUTING.md

[badge-source]: http://img.shields.io/badge/source-fleetbase/fleetbase--php-blue.svg?style=flat-square
[badge-release]: https://img.shields.io/packagist/v/fleetbase/omniship-php.svg?style=flat-square&label=release
[badge-license]: https://img.shields.io/packagist/l/fleetbase/omniship-php.svg?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/fleetbase/omniship-php.svg?style=flat-square
[badge-build]: https://img.shields.io/travis/fleetbase/omniship-php/master.svg?style=flat-square
[badge-coverage]: https://img.shields.io/coveralls/github/fleetbase/omniship-php/master.svg?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/fleetbase/omniship-php.svg?style=flat-square&colorB=mediumvioletred

[source]: https://github.com/fleetbase/omniship-php
[packagist]: https://packagist.org/packages/fleetbase/omniship-php
[license]: https://github.com/fleetbase/omniship-php/blob/master/LICENSE
[php]: https://php.net
[build]: https://travis-ci.org/fleetbase/omniship-php
[coverage]: https://coveralls.io/r/fleetbase/omniship-php?branch=master
[downloads]: https://packagist.org/packages/fleetbase/omniship-php
