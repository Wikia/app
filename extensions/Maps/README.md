# Maps

Maps is a [MediaWiki](https://www.mediawiki.org) extension to work with and visualise geographical
information.

Features:

* Powerful `#display_map` parser hook for embedding highly customizable dynamic maps into wiki pages.
* Support for multiple mapping services: Google Maps, [OpenLayers](http://www.openlayers.org/),
[OpenStreetMap](www.openstreetmap.org/) and [Leaflet](http://leafletjs.com/).
* Coordinate formatting and format conversion via the `#coordinates` parser function.
* Geocoding via several supported services with the `#geocode` parser function.
* Geospatial operations
    * Calculating the distance between two points with `#geodistance`
    * Finding a destination given a starting point, bearing and distance with `#finddestination`
* Distance formatting and format conversion via the `#distance` parser function.
* Visual map editor (Special:MapEditor) to edit `#display_map` wikitext.
* Structured data support provided by the [Semantic Maps extension]
(https://www.mediawiki.org/wiki/Extension:Semantic_Maps).

View the [release notes](RELEASE-NOTES.md) for recent changes to Maps.

### User manual

* [Installation and configuration](INSTALL.md)
* [Usage instructions and examples](https://www.semantic-mediawiki.org/wiki/Maps)

## Project status

[![Build Status](https://secure.travis-ci.org/JeroenDeDauw/Maps.png?branch=master)](http://travis-ci.org/JeroenDeDauw/Maps)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/JeroenDeDauw/Maps/badges/quality-score.png?s=3881a27e63cb64e7511d766bfec2e2db5d39bec3)](https://scrutinizer-ci.com/g/JeroenDeDauw/Maps/)
[![Dependency Status](https://www.versioneye.com/php/mediawiki:maps/dev-master/badge.png)](https://www.versioneye.com/php/mediawiki:maps/dev-master)

On [Packagist](https://packagist.org/packages/mediawiki/maps):
[![Latest Stable Version](https://poser.pugx.org/mediawiki/maps/version.png)](https://packagist.org/packages/mediawiki/maps)
[![Download count](https://poser.pugx.org/mediawiki/maps/d/total.png)](https://packagist.org/packages/mediawiki/maps)

* [Open bugs and feature requests](https://github.com/JeroenDeDauw/Maps/issues)
* [Maps on Ohloh](https://www.ohloh.net/p/maps/)
* [Blog posts about Maps](https://www.entropywins.wtf/blog/tag/maps/)

## Contributing

Feel free to fork the [code on GitHub](https://github.com/JeroenDeDauw/Maps) and to submit pull
requests.

You can run the PHPUnit tests by changing into the `tests/phpunit` directory of your MediaWiki
install and running

    php phpunit.php -c ../../extensions/Maps/

## Credits to other projects

### jQuery

This extension uses code from the jQuery library.
jQuery is dual licensed under the
[MIT](http://www.opensource.org/licenses/mit-license.php)
and
[GPL](http://www.opensource.org/licenses/gpl-license.php)
licenses.

### OpenLayers

This extension includes code from the OpenLayers application.
OpenLayers is an open-source product released under a
[BSD-style license](http://svn.openlayers.org/trunk/openlayers/license.txt).

### geoxml3

This extension includes a copy of the geoxml3 KML processor.
geoxml3 is released under the
[Apache License 2.0 license](http://www.apache.org/licenses/LICENSE-2.0).

### google-maps-utility-library-v3

This extension includes code from the google-maps-utility-library-v3 (googleearth.js).
It is released under the
[Apache License 2.0 license](http://www.apache.org/licenses/LICENSE-2.0).

### OpenStreetMap.js

This extension includes the OpenStreetMap.js file which can be found
[here](http://www.openstreetmap.org/openlayers/OpenStreetMap.js).

## Links

* [Maps examples](https://www.semantic-mediawiki.org/wiki/Maps_examples)
* [Maps on Ohloh](https://www.ohloh.net/p/maps)
* [Maps on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:Maps)
* [Maps on Packagist](https://packagist.org/packages/mediawiki/maps)
* [TravisCI build status](https://travis-ci.org/JeroenDeDauw/Maps)
* [Semantic Maps on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:Semantic_Maps)
