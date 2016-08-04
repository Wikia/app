These are the release notes for the [Maps extension](../README.md).


## Maps 3.5

Released on April 2nd, 2016.

* Added `egMapsGMaps3Language` setting (by James Hong Kong and Karsten Hoffmeyer)
* Added `osm-mapquest` layer for OpenLayers (by Bernhard Krabina)
* Added license lable to display on "Special:Version" (by Karsten Hoffmeyer)
* Improved Mobile Frontend support (by James Hong Kong)
* Added missing Leaflet system messages (by Karsten Hoffmeyer)

## Maps 3.4.1

Released on January 30th, 2016.

* Fixed Open Street Map HTTPS support issues (by Karsten Hoffmeyer)
* Migrated remaining wfMsg* to wfMessage (by Florian Schmidt)
* Migrated wfRunHooks to Hooks::run (by Adam Shorland)

## Maps 3.4

Released on July 25th, 2015.

* Added KML support for OpenLayers via a new `kml` parameter (by akionux)
* Fixed Google Maps HTTPS support issues (by Karsten Hoffmeyer)

## Maps 3.3

Released on June 29th, 2015.

* Added `$egMapsEnableCategory` setting (by Bernhard Krabina)
* Fixed OpenLayers specific path issue (by Simon Heimler)

## Maps 3.2.4

Released on June 21st, 2015.

* Map reside is now triggered when going fullscreen (by Kjetil Volden)
* Improved styling of the fullscreen button (by Kjetil Volden)
* Removed no longer working osmarender layer (by Karsten Hoffmeyer)
* Fixed resource paths for some installation configurations

## Maps 3.2.3

Released on March 23rd, 2015.

* Protocol relative URLs are now used, avoiding HTTPS related problems
* Selecting OpenLayers markers now works on touch devices

## Maps 3.2.2

Released on January 19th, 2015.

* Fixed fatal error in the KML formatter

## Maps 3.2.1

Released on January 13th, 2015.

* Fixed `geocode` right
* Fixed coordinate precision issue after breaking changes in DataValues Geo 

## Maps 3.2

Released on September 12th, 2014.

* Enhanced compatibility with MediaWiki 1.24
* Improved the translations
* Switched to using DataValue Geo 1.x

## Maps 3.1

Released on June 30th, 2014.

* Re added Google Earth support
* Removed support for the deprecated Google JavaScript API
* Updated the translations to use the new MediaWiki JSON format
* Re added support for fill color and fill opacity parameters for circles
* Re added image overlay support for Google Maps

## Maps 3.0.1

Released on March 27th, 2014.

* Fixed bug that prevented non-px units (%, ex, em) from being used in the width and height parameters.
* Translation updates

## Maps 3.0

Released on January 18th, 2014.

In this version a big part of the PHP codebase has been rewritten to decrease technical debt and
thus facilitate maintenance, new feature deployment and debugging. Many tests have been added and a
lot of bugs have been found and fixed. As an experimental feature, allowing the use of custom image
layers with OpenLayers has been reintroduced.

#### Compatibility changes

* The extension now needs to be installed with Composer.
* Changed minimum Validator version from 0.5 to 1.0.

#### New features

* Added leaflet service (by Pavel Astakhov)
* Added Geocoder.us geoservice support (Ike Hecht)
* Experimental: Usage of custom image layers defined in "Layer:" namespaced wiki pages.
  NOTE: This feature has been part of Maps in an old 0.7.x version but got broken shortly after.
        3.0 reintroduces the feature in a similar way but old layer definitions are probably not
        fully compatible for the sake of some advanced features of this rewrite.
  NOTE: Requires running MediaWiki's maintenance/update.php for database schema updates.

#### Bug fixes

* Fixed autoinfowindows functionality.
* Fixed various bugs in geocoordinate parsing and formatting.

#### Breaking internal changes

* Moved classes into Maps namespace
* Removed all Criteria classes
* Removed all Manipulation classes
* Removed MapsCoordinateParser
* Geocoding interfaces changed
* MapsLocation interface changed
* Custom image layers related classes (previously broken feature) changed

#### Infrastructure

* Maps is now hosted on GitHub at https://github.com/JeroenDeDauw/Maps
* Maps now has its tests run on TravisCI at https://travis-ci.org/JeroenDeDauw/Maps
* Maps code quality is now tracked by ScrutinizerCI at https://scrutinizer-ci.com/g/JeroenDeDauw/Maps/
* Maps is now available on Packagist at https://packagist.org/packages/mediawiki/maps

## Maps 2.0 (2012-10-05)

#### Compatibility changes

* Changed minimum PHP version from 5.2 to 5.3.
* Changed minimum MediaWiki version from 1.17 to 1.18.
* Changed minimum Validator version from 0.4 to 0.5.
* Removed support for the deprecated Google Maps v2 API.
* Removed support for the now unsupported Yahoo! Maps API and associated geocoding service.
* Temporary disabled OSM service (you can still use OSM with the OpenLayers service).

#### New features

* Added support for defining an inline label to markers to GoogleMaps.
* Added support for marker clustering to Google Maps.
* Added support for grouping locations.
* Added support for defining image overlays (ground overlays) in Google Maps.
* Added support for defining lines, polygons, rectangles and circles using wikitext for Google Maps and OpenLayers.
* Added a graphical map editing tool that allows exporting to and importing from simple wikitext (Google Maps only).
* Added "copycoords" parameter to Google Maps and OpenLayers that allows copying coordinates after right clicking a location on a map.
* Added "minzoom" and "maxzoom" parameters to #display_map.
* Added support for using the Google JS API key with Google Maps (for increased map display and geocoding call limits).
* Added support for searching markers (searchmarkers=all/title) in Google Maps and OpenLayers
* Added support for creating static maps in OpenLayers and GoogleMaps (static=on)
* Added positional parameter to show polygons only on hover.
* Added an optional link parameter as an alternative to popup bubble with text and title
* Added an optional visitedicon parameter (both global and marker parameter), that will change the icon of a marker on click.

#### Other improvements

* Merged display_map and display_point(s) into a single parser function: display_map (display_points is now an alias).
* Updates parameter definitions from Validator 0.4.x to Validator 0.5.x.
* Improved script loading.
* Added various unit tests that caught some bugs and will now prevent regressions.

#### Bug fixes

* Fixed JavaScript error on some special pages due to incorrect order of map initialization.
* Fixed partially broken kml functionality.

## Maps 1.0.5 (2011-11-30)

* Fixed display of attribution control for OpenLayers.
* Fixed to big precision of geographic coordinates in decimal minutes format (bug 32407).

## Maps 1.0.4 (2011-10-15)

* Updated OpenLayers from 2.10 to 2.11.
* Fixed bug in adding additional markers for Google Maps v3 (mainly affecting the Semantic Maps form input).

## Maps 1.0.3 (2011-09-14)

* Added API module for geocoding.
* Added 'geocoding' right.
* Added kmlrezoom parameter for Google Maps v3 and general $egMapsRezoomForKML setting.
* Fixed Google Maps v3 JavaScript issue occurring on MediaWiki 1.17.

## Maps 1.0.2 (2011-08-24)

* Fixed Google Maps v3 JavaScript issue occurring when using Google Earth on unsupported systems.
* Fixed internationalization of distances (bug 30467).

## Maps 1.0.1 (2011-08-17)

* Added language parameter to the mapsdoc hook.
* Use of Validator 0.4.10s setMessage method instead of setDescription for better i18n.
* Fixed zoom and types parameters for Google Maps v3.
* Minor improvement to script loading.
* Added support for Google Earth in Google Maps v3.
* Added tilt parameter for Google Earth in Google Maps v3.

## Maps 1.0 (2011-07-19)

This version branched from Maps 0.7.x at version 0.7.3.

#### New features ####

* Added full Google Maps v3 support and set it as the default mapping service.
* Added new geocoder making use of the new GeoNames API.
* Added support for the auto-documentation features for parser hooks introduced in Validator 0.4.3.
* Added resizeable parameter to all mapping services except OSM.

#### Removed features ####

* Removed compatibility with pre MediaWiki 1.17.
* Removed overlays parameter for Google Maps v2.
* Removed the previously deprecated "display map", "display point" and "display points" parser hooks.
Use their underscored equivalents, ie "display_map".

#### Internal improvements ####

* Usage of the Resource Loader for all scripts and stylesheets.
* Rewrote all the map JavaScript to jQuery plugins.
* Rewrote the way parameters are translated to JavaScript. Now one big PHP object is json_encoded.
* Improved KML formatter.
* Use of Google Maps geocoding service v3 instead of v2.
* Completed coordinate and distance parser/formatter unit tests and made them compliant with the
MediaWiki unit testing support.

#### Bug fixes ####

* Fixed geocoding service overriding based on mapping service (merged in from Maps 0.7.5).
* Fixed fatal error occurring when running maintenance/refreshLinks.php.
* Fixed DMS coordinate parsing issue (bug 29419).
* Fixed coordinate normalization issue (bug 29421).

#### Other tweaks ####

* Improved default width of maps (merged in from Maps 0.7.5).

## Maps 0.7.3 ##
(2010-11-30)

* Some internal improvements and translation updates.
* Fixed issue occurring when Maps is the only extension adding custom namespaces.

## Maps 0.7.2 ##
(2010-10-28)

#### New features ####

* Added experimental support for KML layer definitions.

#### Internal improvements ####

* Extended the layer handling to support different types of layers, each of which can be supported by one or more mapping services.

#### Bug fixes ####

* Fixed incompatibility with MW 1.15.x.
* Fixed incorrect parsing of certain DM and DMS coordinates.
* Fixed small layout issue with pop-ups in Google Maps.
* Fixed incorrect error on non-existing pages in the Layer namespace.

## Maps 0.7.1 ##
(2010-10-20)

#### New features ####

* Image layers for OpenLayers maps, defined via pages in the Layer namespace.

#### Bug fixes ####

* Support for images without namespace prefix in the display points parser hook.
* Fixed layer oder for OpenLayers maps.

#### Internal improvements ####

* Rewrote OpenLayers layer handling.

## Maps 0.7 ##
(2010-10-15)

#### New features ####

* Tag support for these parser hooks (which previously only had parser function support):
** Coordinates
** Distance
** Finddestination
** Geocode
** Geodistance
* Thumbs and photos parameters for the OSM service.

#### Bug fixes ####

* Fixed compatibility with the MW 1.17 resource loader.
* Fixed i18n issue with the overlays control for Google Maps v2 maps.
* Fixed default zoom level for Yahoo! Maps maps.
* Increased the maximum decimals for DMS coordinates from 2 to 20.

#### Removed features ####

* #geocodelong and #geocodelat parser functions - you can obtain their functionality using #geocode.

#### Internal improvements ####

* Rewrote the geocoding functionality. It's now an integral part of the extension that can not be just pulled out,
while the reverse is true for individual geocoders. Geocoder interaction now uses the same model as mapping
service interaction.
* Use of Validator 0.4, allowing for more robust and consistent error reporting.
* Rewrote the parser hooks to use the ParserHook class provided by Validator.
* Restructured the directory structure of the extension to better match it's architecture.
* Use of OpenLayers 2.10 instead of 2.9.

## Maps 0.6.6 ##
(2010-08-26)

#### New features ####

* Support for geocoding over proxies.
* Added $egMapsInternatDirectionLabels settings, allowing users to disable internationalization of direction labels.

#### Refactoring ####

* Added MapsMappingServices, which serves as factory for MapsPappingService objects and does away
with all the globals previously needed for this.
* Removed the http/curl request code from the geocoder classes - now using Http:get() instead.

#### Bug fixes ####

* Fixed issue that caused pop-up contents to render incorrectly when it contained wiki markup.
* Fixed coordinate parsing bug (direction labels did not get recognized) that was introduced in 0.6.4.
* Fixed spacing issues with several parser functions.

## Maps 0.6.5 ##
(2010-07-27)

#### Refactoring ####

* Added unit tests for the coordinates parser.
* Created iMappingFeature interface, from which iMapParserFunctions inherits.
* Moved map id creation to the mapping service class for all features.
* Moved marker JavaScript creation for display_points to the mapping service class for all features.
* Moved default zoom level access method to the mapping service class for all features.
* Improved the way marker data is turned into JavaScript variables.
* Improved coordinate recognition regexes. 

#### Bug fixes ####

* Fixed several small coordinate parsing and formatting issues.
* Fixed a few small distance parsing issues.

## Maps 0.6.4 ##
(2010-07-08)

#### New features ####

* Added new OSM service based on iframe inclusion of toolserver page that renders OpenStreetMap tiles with Wikipedia overlays.
* Added internationalization to the OpenLayers service.
* Added support for including KML files for Google Maps v2.
* Added 'searchbar' control for Google Maps v2.

#### Refactoring ####

* Moved more functionality over from feature classes to service classes to prevent crazy code-flow and code duplication.

#### Bug fixes ####

* Fixed bug in the OpenLayers service causing it to display badly in Chrome.
* Fixed issue with with and height validation for % values, also causing backward compatibility problems with pre 0.6 setting definitions.
* Fixed several small bugs in the coordinate parser.

## Maps 0.6.3 ##
(2010-06-20)

#### Refactoring ####

* Mayor refactoring of the mapping service handling, to make the code flow less messy and be able to do mapping service related things in a more consistent fashion.
* Upgrade to OpenLayers 2.9.1.

#### Bug fixes ####

* Fixed severe bug in the coordinate parsing that removed the degree symbol from passes values, resulting in rendering most of them invalid. Presumably present since 0.6.2.

## Maps 0.6.2 ##
(2010-06-07)

#### New features ####

* Added #distance parser function parse distances using any of the supported units and outputting them in any of these.
* Made supported distance units configurable and added setting for the default distance unit.
* Added 'decimals' and 'unit' parameters to #geosiatnce.
* Default parameter handling improvements (via Validator 0.3.2).

#### Bug fixes ####

* Re-added parameter name and value insensitivity (via Validator 0.3.2).

## Maps 0.6.1 ##
(2010-06-04)

#### Bug fixes ####

* Fixed bug that caused geocoding requests to fail when using display_points
* Fixed bug that had broken the geoservice parameter for display_points and display_map.
* Fixed bug that made OSM layers in the OpenLayers service fail.
* Fixed issue that made custom markers on Google Maps not show up on initial page load and centred them wrongly.

## Maps 0.6 ##
(2010-05-31)

#### New features ####

* Added support for width and height in px, ex, em and %, instead of only px, allowing for maps that
adjust their size to the screen width and other content.
* Added full support for both directional and non-directional coordinate notations in DMS, DD, DM
and float notation.
* Added #coordinates parser function which allows rewformatting of coordinates to all supported notations.
* Rewrote the #geocode parser function to work with named parameters and added support for smart
geocoding. Now takes in all supported coordinate notations, and is able to output in all of them as well.
* Added #geodistance function (based on the one in MathFunctions) with smart geocoding support.
* Added #finddestination function with smart geocoding support.

#### Refactoring ####

* Rewrote the handling of the display_map and display_point(s) parser functions, esp the way the
service parameter is getting determined and acted upon.
* Removed the MapsMapFeature class to make the base classes for the features more independent and flexible.
* Restructured the directory structure to make what the services and features are more clear.
* Rewrote map divs and added loading message for each map.
* Rewrote individual map JS to be added to the page header.
* Mayor clean up of the coordinate handling, to allow for coordinate formatting and to facilitate
better integration by the GeoCoords data type in Semantic Maps. All this code is now located in MapsCoordinateParser.
* Use native MW hook system for mapping services and features if possible.
* Updated the magic words to mw >=1.16 style, and retained backward compatibility.
* Updated the OpenLayers version from 2.8 to 2.9.
* Rewrote the parameter definitions to work with Validator 0.3.
* Rewrote the resource inclusion html to make the code cleaner and more secure.

#### Bug fixes ####

* Changed parsing of parameters so that '=' signs in values don't cause themselves and
proceeding characters to be omitted.
* Add mapping to the language codes that are send to the Google Maps API to null the naming
differences between MW and the API.
* Added automatic icon image sizing for Google Maps and Yahoo! Maps markers.
* Fixed conflict with prototype library that caused compatibility problems with the Halo extension.

## Maps 0.5.5. ##
(2010-03-20)

#### Refactoring ####

* Stylized the code to conform to MediaWiki's spacing conventions.

#### Bug fixes ####

* Fixed issue with scrollbar in pop-ups on Google Maps maps.
* Fixed Google Maps key issue with OpenLayers that arose from the new OpenLayers layer definition system.
* Fixed JS issue with Google Maps default overlays.

## Maps 0.5.4 ##
(2010-03-01)

#### New features ####

* Added the ability to define the layers (and their dependencies) that can be added by users to an OpenLayers map.
* Added the ability to define "layer groups" for OpenLayers layers.

#### Refactoring ####

* Moved the OpenLayers layer definition validation and selection from JS to PHP.

#### Bug fixes ####

* Fixed bug causing the default zoom for each mapping service to be off.
* Fixed potential xss vectors.
* Fixed minor JS error that was present for all maps except OSM.

## Maps 0.5.3 ##
(2010-02-01)

#### New features ####

* Added Google Maps v3 support for display_map.

#### Refactoring ####

* Added service defaulting for features using a hook themselves.

#### Bug fixes ####

* Fixed JavaScript bug causing all OSM maps to fail.

## Maps 0.5.2 ##
(2010-01-20)

#### New features ####

* Added icon parameter to display_point(s), allowing you to set the icon for all markers that do not
have a specific icon assigned.

#### Refactoring ####

* Usage of Validator 0.2 features for the static map specific parameters.

#### Bug fixes ####

* Fixed escaping issue causing wikitext in the title and label parameters not to be displayed correctly.
* Fixed file path for location specific icons.

## Maps 0.5.1 ##
(2009-12-25)

#### New features ####

* Integrated further with Validator by holding into account the error level for coordinate validation
in the display_ parser functions.

* Added activatable= parameter to the static map support.

#### Refactoring ####

* Cleaned up the static map code for OSM display_map.
* Modified the parameter definitions to work with Validator 0.2
* Removed redundant (because of Validator 0.2) utility function calls from the mapping classes.
* Removed redundant (because of Validator 0.2) utility functions from the mapping service files.

#### Bug fixes ####

* Fixed issue with the hook system that caused code to get executed when it shouldn't.

## Maps 0.5 ##
(2009-12-17)

#### New features ####

* Added strict parameter validation.
* Added smart 'autopanzoom' like control for Google Maps and Yahoo! Maps.
* Added internationalization to the OSM service, and an extra parameter to define per-map languages.
* Static map support, similar and based upon SlippyMap.

#### Refactoring ####

* Rewrite the parameter handling to be more centralized and modular.
** Make it possible to override the info of parameters for mapping services, including
their aliases, default values and criteria.
** Make it possible to add and override parameters in each segment of Maps, instead of only
the mapping services.

* Cleaned up and centralized parser function code.
* Refactored the marker specific data handling code in every display point class up to
a central location.
* Removed backward compatibility (to 0.2.x and earlier) of the earth parameter.
* Removed support for Google Map API map type names for Google Maps.
* Added code to unload any services from the service hook that are not present in the list of
allowed services. This ensures they don't get initialized, and makes any check to see if the
service is one of the allowed ones further on unneeded.
* Added checks for extension dependencies that need to be present for Maps to be initialized.

#### Bug fixes ####

* Fixed bug causing markers not to show up when a specific description was provided.

#### Documenting ####

* Created screencast demonstrating display_map usage.
* Creates screencast demonstrating display_point usage.
* Updated the developer documentation about hooking into and extending Maps to be useful
for the current version.

##Maps 0.4.2##
(2009-11-15)

Changes in 0.4.2 discussed on the authors blog:

* [Maps and Semantic Maps 0.4.2 released](http://www.bn2vs.com/blog/2009/11/16/maps-and-semantic-maps-0-4-2/)
* [New in Maps 0.4.2](http://www.bn2vs.com/blog/2009/11/12/new-in-maps-0-4-2/)

#### New features ####

* Added overlays to Google Maps. This includes both an 'overlay' control, and a new parameter
to choose the available and default loaded overlays.
* Added specific handling for the coordinates= and addresses= parameters for both display_map
and display_point(s). You can now specify you do not want anything that's not a coordinate on
your map (so no geocoding) with the coordinates= parameter, or let Maps know everything is
an address with the addresses= parameter, causing everything to be geocoded. Also modified
the error messages for wrong addresses and coordinates to fit this new behavior.

#### Refactoring ####

* Added the version of Maps to the JS files call, to prevent issues when functions or calls
are changed in new versions.
* Changed the JavaScript map parameters for Google Maps from individual parameters to a group.

#### Bug fixes ####

* Fixed inclusion path to the OSM JS file. This bug prevented any OSM maps from showing up.
* Fixed display_map and the centre parameter of display_point(s). Both are unusable by a bug
introduced in 0.4.1.
* Fixed bug causing to many decimal digits in some coordinate notations, making them unrecognisable
for Maps.
* Fixed bug causing a form of DD notation not to get recognized.

##Maps 0.4.1##
(2009-11-10)

#### Bug fixes ####

* Fixed problems with the ° sign, caused by wrong file encodings, resulting into problems with
the DMS notation.
* Fixed flaw in DMS to float translation, resulting into a map being displayed when the values
where not separated by a comma.

## Maps 0.4 ##
(2009-11-03)

Changes in 0.4 discussed on the authors blog:

* [Finally! Maps and Semantic Maps 0.4!](http://www.bn2vs.com/blog/2009/11/03/finally-maps-and-semantic-maps-0-4/)

#### New features ####

* Added display_map parser function, to display maps without any markers.
* Added parsing of marker-specific title and label values.
* Added geocoding support for the centre parameter. This is based on automatic detection of
non-coordinates to see if geocoding is required, similar to the modified behavior of display_point(s).
* Added minimum and maximum map size restrictions, like done in SlippyMap.
* Added OSM mapping service, which uses OL, but only allows OSM layers and is optimized for OSM.
* Added smart 'autopanzoom' control to OL and OSM services. It will determine for itself if a
panzoom, panzoombar, or no control should be displayed, depending on the maps height.
* Added support for DM and DD coordinate notations.

#### Refactoring ####

* Created a hook system for the parser functions, allowing the adding or removing of additional
parser function support.
* Removed redundant absolute script path variable. This absolute value caused problems for some installations.
* Changed the geocoding functionality into a true feature hook element, enabling easy removal.
* Created service hook for the geocoding feature, loose from the mapping services hook.
* Changed display_point(s) and display_address(es) to display_point(s), with auto detect
functionality to see if the provided value are coordinates or addresses. display_address and
display_addresses have been retained for backward compatibility, but will be removed from the docs.
Backward compatibility will be removed at some point, so the use of these functions is discouraged.

#### Bug fixes ####

* Fixed issue with the default parameter for the display_address(es) parser functions.
* Fixed major bug in the initialization method causing hook code to get executed at a probably
wrong moment. This bug can be the cause of some weird problems that surfaced since 0.3.3.
* Fixed issue with size of pop-ups in Google Maps. They did not stretch far enough vertically
for large contents.

##Maps 0.3.4##
(2009-09-12)

Changes in 0.3.4 discussed on the authors blog:

* [Maps and Semantic Maps 0.3.4 released](http://www.bn2vs.com/blog/2009/09/12/maps-and-semantic-maps-0-3-4-released/)

####New features####

* Created hook system for features, which now also allows you to specify which features
should be enabled and which not.

####Refactoring####

* Added old style geocoding request again for people who do not have cURL enabled, plus a
more consistent fall-back mechanism.
* Added internationalization for the mapping service names.
* Added internationalized list notations.
* Restructured the parser function handling code to work with the new feature hook system.
* Improved structure of geocoding classes.
* Moved Semantic Maps JavaScript code from the Maps JS files to new SM JS files.
* Fixed tiny performance issues all over the code.

####Bug fixes####

* Fixed issue with empty parameters (par=value||par2=value2) that caused the default parameter
(coordinate(s)/address(es)) to be overridden if it occurred after the default one was set.
* Fixed wrong error message when you provide a coordinate(s)/address(es) parameter without
any value (ie |coordinates=|)

##Maps 0.3.3##
(2009-08-25)

Changes in 0.3.3 discussed on the authors blog:

* [Maps and Semantic Maps 0.3.3](http://www.bn2vs.com/blog/2009/08/25/maps-and-semantic-maps-0-3-3/)

####New features####

*Added [http://www.geonames.org GeoNames] geocoding support. This is an open source geocoding
service, that does not require a licence. It has been made the default geocoding service.
* Added wiki-text rendering to the values of the title and label parameters, allowing users
to pass along links, images, and more.

####Refactoring####

* Refactored some common functionality of the geocoder classes up to MapsBaseGeocoder.
* Minor issue - the OpenLayers default zoom should be closer, when displaying one
point - see the last map in [http://discoursedb.org/wiki/One-point_map the same page].

####Bug fixes####

* Fixed small bug in MapsMapper::inParamAliases that caused the determination of the
geoservice to fail in some cases, and set it to the default.

##Maps 0.3.2##
(2009-08-18)

Release for consistency. Only changes to Semantic Maps where made in 0.3.2.

##Maps 0.3.1##
(2009-08-18)

####New features####

* Users can now define a default service for each feature - parser functions, query printers and form inputs.

####Refactoring####

* Added check to see if the classes array is present in a mapping service info array.
* Added check to see if a mapping service has handling for parser functions. In 0.3,
Maps assumed it had, preventing the adding of mapping services that only have a form input or/and query printer.
* The getValidService function now holds into account that not every service has support for
both parser functions, query printers and form inputs.

####Bug fixes####

* Added path to extension directory to non local class item in a service's info array,
since adding the path is impossible in the declaration.

##Maps 0.3##
(2009-08-14)

Changes in 0.3 discussed on the authors blog:

* [Final changes for Maps and SM 0.3](http://www.bn2vs.com/blog/2009/08/13/final-changes-for-maps-and-sm-0-3/)
* [New features in Maps and SM 0.3](http://www.bn2vs.com/blog/2009/08/07/new-features-in-maps-and-sm-0-3/)
* [Structural changes for Maps and SM 0.3](http://www.bn2vs.com/blog/2009/08/05/structural-changes-for-maps-and-sm-0-3/)
 
####New features####

* Multi location parser functions. Two completely new parser functions have been added that
allow the displaying of multiple points on a map.
* Configurable map type controls. Users can now configure the map type controls of Google
maps and Yahoo! maps maps. They can set the available map types, and the order they want
them to be displayed in the map type control.
* Property names now have aliases. This means you can add several alternative ways to name
the same parameter, for instance, you can make so that ‘auto zoom’ and ‘auto-zoom’ will do
excellently the same as the main parameter ‘autozoom’. This is particularly handy for
parameters such as ‘centre’ (British spelling) and ‘center’ (American spelling).
* Added Google Maps moon, Mars and sky support.
* Controls on both Yahoo! Maps and Google Maps map can now be configured by the user with
the controls parameter. Yahoo! Maps maps already have this option for a limited set of
controls since version 0.2, but the amount of available controls has now been expanded
to what the Yahoo! Maps API offers. For Google Maps the change is significantly larger,
since a lot of new controls can now be added. These included an overview map, a scale
line, a drop down menu for map types, an automated reverse geocoding location determiner
and more.
* Added the ability to specify separate title, label and icon values for each marker
in the display_points and display_addresses parser functions.
* Added user friendly notices for when geocoding of an address fails.
* A whole list of OpenLayers base layers have been added. These include the satellite,
street and hybrid views for Yahoo! Maps and Bing Maps, but also finally the OpenStreetMap layers.

####Refactoring####

* Created hook system for the mapping services. All hard-coded references to mapping
services in the core code have been removed. A service is now added by one multi dimensional
array in Maps.php (note that this can also be done in the initialization file of another
extension!), which holds the name of the parser functions class and it’s location, the
aliases for the service name (feature added in 0.2), and their allowed specific parameters
and their aliases. This architecture allows other people to create their own mapping
extension using the Maps (and Semantic Maps) ‘API’.
* Created a class that bundles common functionality from MapsBaseMap and SMFormInput.
* Rewrote parts of the geocoder base class.
* Added separated handling for default parameter for each mapping service.
* Changed the requests in the geocoder classes to CURL requests to avoid security issues.
* Moved common, parser function specific, functions and variables from MapsMapper to a new MapsParserFunctions class.
* Moved common code within the mapping services out of the parser function class to a new utility classes.

####Bug fixes####

* Fixed issue preventing the extension description from showing up in 0.2.1 & 0.2.2.
* Fixed bug that caused Bing maps (for open layers) to not work.

## Maps 0.2 (2009-07-29)

#### New features

* Added Backward compatibility by using the $wgGoogleMapsKey when this one is set and $egGoogleMapsKey isn't.
* Added hook for [[Extension:Admin_Links|Admin Links]].
* Added a true aliasing system for service names.
* Created a centre parameter, that will allow you to set a custom map centre (different from the
place where the marker will be put).
* Added pop-ups for the markers with title and label parameters to determine the pop-up contents.
* Changed the OpenLayers control handling. Make it accept all (36) OL controls by using eval()
instead of a switch statement in the JavaScript.
* Added the 'physical' button in the map type control of Google Maps maps when this map type is set.
* Added Yahoo! geocoder support (for parser functions).

#### Refactoring

* Refactored MapsBaseMap and all it's child classes. This will vastly increase code
centralization and decrease redundant logic and definitions.
* Did a major rewrite of the Google Maps and Yahoo! Maps code. The parser function
classes now only print a call to a JS function with all needed parameters, which then
does all the logic and creates the map.

#### Bug fixes

* Fixed issue causing aliases for service names getting turned into the default
service since they are not in the allowed services list.
* Removed redundant parts of the OpenLayers library.

## Maps 0.1 (2009-07-20)

* Initial release, featuring Google Maps (+ Google Earth), Yahoo! Maps and OpenLayers mapping services.
