# Simple Geocoder

[![Build Status](https://travis-ci.org/JeroenDeDauw/SimpleGeocoder.svg?branch=master)](https://travis-ci.org/JeroenDeDauw/SimpleGeocoder)

PHP 7.0+ library providing a simple and minimalistic Geocoder interface with some basic implementations.

```php
interface Geocoder {
	/**
	 * @return LatLongValue|null
	 */
	public function geocode( string $address );
}
```

This library is based on code extracted from the [Maps extension for MediaWiki](https://github.com/JeroenDeDauw/Maps).

Geocoders using real geocoding services:

* GeoNamesGeocoder
* GoogleGeocoder
* NomatimGeocoder

Decorators and trivial implementations:

* InMemoryGeocoder
* NullGeocoder
* StubGeocoder
* CoordinateFriendlyGeocoder

## Installation

To use the Simple Geocoder library in your project, simply add a dependency on jeroen/simple-geocoder
to your project's `composer.json` file. Here is a minimal example of a `composer.json`
file that just defines a dependency on Simple Geocoder 1.x:

```json
{
    "require": {
        "jeroen/simple-geocoder": "~1.0"
    }
}
```

## Development

For development you need to have Docker and Docker-compose installed. Local PHP and Composer are not needed.

    sudo apt-get install docker docker-compose

### Running Composer

To pull in the project dependencies via Composer, run:

    make composer install

You can run other Composer commands via `make run`, but at present this does not support argument flags.
If you need to execute such a command, you can do so in this format:

    docker run --rm --interactive --tty --volume $PWD:/app -w /app\
     --volume ~/.composer:/composer --user $(id -u):$(id -g) composer composer install -vvv

### Running the CI checks

To run all CI checks, which includes PHPUnit tests, PHPCS style checks and coverage tag validation, run:

    make
    
### Running the tests

To run just the PHPUnit tests run

    make test

To run only a subset of PHPUnit tests or otherwise pass flags to PHPUnit, run

    docker-compose run --rm app ./vendor/bin/phpunit --filter SomeClassNameOrFilter

## Release notes

### 1.0.0 (2017-11-22)

* Initial release