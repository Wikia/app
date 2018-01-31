# Maps

Maps is a [MediaWiki](https://www.mediawiki.org) extension to work with and visualize geographical
information. 

Features:

* Powerful `#display_map` parser hook for embedding highly customizable dynamic maps into wiki pages.
* Support for multiple mapping services: [Leaflet](http://leafletjs.com/), Google Maps, [OpenLayers](http://www.openlayers.org/) and [OpenStreetMap](www.openstreetmap.org/).
* Integration with [Semantic MediaWiki](https://www.semantic-mediawiki.org) via a [coordinate datatype](https://www.semantic-mediawiki.org/wiki/Help:Type_Geographic_coordinate)
    * Query your stored coordinates and visualize them on dynamic maps, as tables or as lists
    * Export your coordinates as KML or RDF
    * Combine coordinates with other structured data stored in your wiki
* Coordinate formatting and format conversion via the `#coordinates` parser function.
* Geocoding via several supported services with the `#geocode` parser function.
* Geospatial operations
    * Calculating the distance between two points with `#geodistance`
    * Finding a destination given a starting point, bearing and distance with `#finddestination`
* Distance formatting and format conversion via the `#distance` parser function.
* Visual map editor (Special:MapEditor) to edit `#display_map` wikitext (requires Google Maps).

Maps has been maintained since 2009 and is installed on over 1000 public wikis.

## User manual

### For administrators

* [Installation and configuration](INSTALL.md)
* [Release notes](RELEASE-NOTES.md) - detailed list of changes per release
* [Platform compatibility](INSTALL.md#platform-compatibility-and-release-status) - overview of PHP and MediaWiki support per release

### For wiki users

* [Usage instructions](https://www.semantic-mediawiki.org/wiki/Extension:Maps)
* [Usage examples](https://www.semantic-mediawiki.org/wiki/Category:Maps_examples)
* [Semantic usage examples](https://www.semantic-mediawiki.org/wiki/Semantic_Maps_examples)

### Getting support

* Ask a question on [the mailing list](https://www.semantic-mediawiki.org/wiki/Mailing_list)
* Ask a question on the #mediawiki IRC channel on Freenode.
* File an issue on [our issue tracker](https://github.com/JeroenDeDauw/Maps/issues) (technical issues only)

## Project status

* Latest version &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [![Latest Stable Version](https://poser.pugx.org/mediawiki/maps/version.png)](https://packagist.org/packages/mediawiki/maps)
* Downloads on [Packagist](https://packagist.org/packages/mediawiki/maps) [![Download count](https://poser.pugx.org/mediawiki/maps/d/total.png)](https://packagist.org/packages/mediawiki/maps)
* TravisCI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [![Build Status](https://secure.travis-ci.org/JeroenDeDauw/Maps.png?branch=master)](http://travis-ci.org/JeroenDeDauw/Maps)
* Code quality &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/JeroenDeDauw/Maps/badges/quality-score.png?s=3881a27e63cb64e7511d766bfec2e2db5d39bec3)](https://scrutinizer-ci.com/g/JeroenDeDauw/Maps/)
* [Open bugs and feature requests](https://github.com/JeroenDeDauw/Maps/issues)
* [Maps on OpenHub](https://www.ohloh.net/p/maps/)
* [Blog posts about Maps](https://www.entropywins.wtf/blog/tag/maps/)

## Contributing

* [File an issue](https://github.com/JeroenDeDauw/Maps/issues)
* [Submit a pull request](https://github.com/JeroenDeDauw/Maps/pulls) ([tasks for newcomers](https://github.com/JeroenDeDauw/Maps/issues?q=is%3Aissue+is%3Aopen+label%3Anewcomer))

### Running the tests

As setup, run `composer install` inside of the Maps root directory.

You can run the MediaWiki independent tests by changing into the Maps root directory and running

    phpunit
    
This is possible without having a MediaWiki installation or webserver. A clone of the Maps code suffices.

To run the tests with MediaWiki, change into `tests/phpunit` of your MediaWiki installation and run

    php phpunit.php --wiki wiki -c ../../extensions/Maps/phpunit.xml.dist
    
Where you either update `wiki` to match your wikis name, or drop the parameter. The above command
works without modification if you are using the [MediaWiki Vagrant](https://www.mediawiki.org/wiki/MediaWiki-Vagrant).

Beware that due to severe technical debt, some tests access the network.

## Links

* [Maps on OpenHub](https://www.openhub.net/p/maps/)
* [Maps on Packagist](https://packagist.org/packages/mediawiki/maps)
* [Maps on WikiApiary](https://wikiapiary.com/wiki/Extension:Maps)
* [Maps on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:Maps)
* [TravisCI build status](https://travis-ci.org/JeroenDeDauw/Maps)
* [Semantic Maps on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:Semantic_Maps)
