<?php
/**
 * Initialization file for the Maps extension.
 *
 * @links https://github.com/JeroenDeDauw/Maps/blob/master/README.md#maps Documentation
 * @links https://github.com/JeroenDeDauw/Maps/issues Support
 * @links https://github.com/JeroenDeDauw/Maps Source code
 *
 * @license https://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( defined( 'Maps_VERSION' ) ) {
	// Do not initialize more than once.
	return 1;
}

define( 'Maps_VERSION' , '3.5.0' );

// Include the composer autoloader if it is present.
if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	include_once( __DIR__ . '/vendor/autoload.php' );
}

// Only initialize the extension when all dependencies are present.
if ( !defined( 'Validator_VERSION' ) ) {
	throw new Exception( 'You need to have Validator installed in order to use Maps' );
}

if ( version_compare( $GLOBALS['wgVersion'], '1.18c' , '<' ) ) {
	throw new Exception( 'This version of Maps requires MediaWiki 1.18 or above; use Maps 1.0.x for MediaWiki 1.17 and Maps 0.7.x for older versions.' );
}

call_user_func( function() {
	$GLOBALS['wgExtensionCredits']['parserhook'][] = array(
		'path' => __FILE__ ,
		'name' => 'Maps' ,
		'version' => Maps_VERSION ,
		'author' => array(
			'[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
			'...'
		) ,
		'url' => 'https://github.com/JeroenDeDauw/Maps/blob/master/README.md#maps' ,
		'descriptionmsg' => 'maps-desc',
		'license-name' => 'GPL-2.0+'
	);

	// The different coordinate notations.
	define( 'Maps_COORDS_FLOAT' , 'float' );
	define( 'Maps_COORDS_DMS' , 'dms' );
	define( 'Maps_COORDS_DM' , 'dm' );
	define( 'Maps_COORDS_DD' , 'dd' );

	$mapsDir = __DIR__ . '/';

	$GLOBALS['egMapsStyleVersion'] = $GLOBALS['wgStyleVersion'] . '-' . Maps_VERSION;

	$GLOBALS['wgMessagesDirs']['Maps']							= __DIR__ . '/i18n';
	$GLOBALS['wgExtensionMessagesFiles']['Maps'] 				= __DIR__ . '/Maps.i18n.php';
	$GLOBALS['wgExtensionMessagesFiles']['MapsMagic'] 			= __DIR__ . '/Maps.i18n.magic.php';
	$GLOBALS['wgExtensionMessagesFiles']['MapsNamespaces'] 		= __DIR__ . '/Maps.i18n.namespaces.php';
	$GLOBALS['wgExtensionMessagesFiles']['MapsAlias'] 			= __DIR__ . '/Maps.i18n.alias.php';

	$GLOBALS['wgResourceModules'] = array_merge( $GLOBALS['wgResourceModules'], include 'Maps.resources.php' );

	$GLOBALS['wgAPIModules']['geocode'] = 'Maps\Api\Geocode';

	// Register the initialization function of Maps.
	$GLOBALS['wgExtensionFunctions'][] = function () {

		if ( $GLOBALS['egMapsGMaps3Language'] === '' ) {
			$GLOBALS['egMapsGMaps3Language'] = $GLOBALS['wgLang'];
		}

		Hooks::run( 'MappingServiceLoad' );
		Hooks::run( 'MappingFeatureLoad' );

		if ( in_array( 'googlemaps3', $GLOBALS['egMapsAvailableServices'] ) ) {
			$GLOBALS['wgSpecialPages']['MapEditor'] = 'SpecialMapEditor';
			$GLOBALS['wgSpecialPageGroups']['MapEditor'] = 'maps';
		}

		return true;
	};

	$GLOBALS['wgHooks']['AdminLinks'][]                = 'MapsHooks::addToAdminLinks';
	$GLOBALS['wgHooks']['ArticleFromTitle'][]          = 'MapsHooks::onArticleFromTitle';
	$GLOBALS['wgHooks']['MakeGlobalVariablesScript'][] = 'MapsHooks::onMakeGlobalVariablesScript';
	$GLOBALS['wgHooks']['CanonicalNamespaces'][]       = 'MapsHooks::onCanonicalNamespaces';	$GLOBALS['wgHooks']['LoadExtensionSchemaUpdates'][] = 'MapsHooks::onLoadExtensionSchemaUpdates';
	$GLOBALS['wgHooks']['ArticlePurge'][]              = 'MapsHooks::onArticlePurge';
	$GLOBALS['wgHooks']['LinksUpdateConstructed'][]    = 'MapsHooks::onLinksUpdateConstructed';
	$GLOBALS['wgHooks']['ParserAfterTidy'][]           = 'MapsHooks::onParserAfterTidy';
	$GLOBALS['wgHooks']['ParserClearState'][]          = 'MapsHooks::onParserClearState';

	// Parser hooks

	// Required for #coordinates.
	$GLOBALS['wgHooks']['ParserFirstCallInit'][] = function( Parser &$parser ) {
		$instance = new MapsCoordinates();
		return $instance->init( $parser );
	};

	$GLOBALS['wgHooks']['ParserFirstCallInit'][] = function( Parser &$parser ) {
		$instance = new MapsDisplayMap();
		return $instance->init( $parser );
	};

	$GLOBALS['wgHooks']['ParserFirstCallInit'][] = function( Parser &$parser ) {
		$instance = new MapsDistance();
		return $instance->init( $parser );
	};

	$GLOBALS['wgHooks']['ParserFirstCallInit'][] = function( Parser &$parser ) {
		$instance = new MapsFinddestination();
		return $instance->init( $parser );
	};

	$GLOBALS['wgHooks']['ParserFirstCallInit'][] = function( Parser &$parser ) {
		$instance = new MapsGeocode();
		return $instance->init( $parser );
	};

	$GLOBALS['wgHooks']['ParserFirstCallInit'][] = function( Parser &$parser ) {
		$instance = new MapsGeodistance();
		return $instance->init( $parser );
	};

	$GLOBALS['wgHooks']['ParserFirstCallInit'][] = function( Parser &$parser ) {
		$instance = new MapsMapsDoc();
		return $instance->init( $parser );
	};

	$GLOBALS['wgHooks']['ParserFirstCallInit'][] = function( Parser &$parser ) {
		$instance = new MapsLayerDefinition();
		return $instance->init( $parser );
	};

	// Geocoders

	// Registration of the GeoNames service geocoder.
	$GLOBALS['wgHooks']['GeocoderFirstCallInit'][] = 'MapsGeonamesGeocoder::register';

	// Registration of the Google Geocoding (v2) service geocoder.
	$GLOBALS['wgHooks']['GeocoderFirstCallInit'][] = 'MapsGoogleGeocoder::register';

	// Registration of the geocoder.us service geocoder.
	$GLOBALS['wgHooks']['GeocoderFirstCallInit'][] = 'MapsGeocoderusGeocoder::register';

	// Layers

	// Registration of the image layer type.
	$GLOBALS['wgHooks']['MappingLayersInitialization'][] = 'MapsImageLayer::register';

	// Mapping services

	// Include the mapping services that should be loaded into Maps.
	// Commenting or removing a mapping service will make Maps completely ignore it, and so improve performance.

	// Google Maps API v3
	// TODO: improve loading mechanism
	include_once $mapsDir . 'includes/services/GoogleMaps3/GoogleMaps3.php';

	// OpenLayers API
	// TODO: improve loading mechanism
	include_once $mapsDir . 'includes/services/OpenLayers/OpenLayers.php';

	// Leaflet API
	// TODO: improve loading mechanism
	include_once $mapsDir . 'includes/services/Leaflet/Leaflet.php';


	require_once __DIR__ . '/Maps_Settings.php';

	define( 'Maps_NS_LAYER' , $GLOBALS['egMapsNamespaceIndex'] + 0 );
	define( 'Maps_NS_LAYER_TALK' , $GLOBALS['egMapsNamespaceIndex'] + 1 );

	$GLOBALS['wgAvailableRights'][] = 'geocode';

	// Users that can geocode. By default the same as those that can edit.
	foreach ( $GLOBALS['wgGroupPermissions'] as $group => $rights ) {
		if ( array_key_exists( 'edit' , $rights ) ) {
			$GLOBALS['wgGroupPermissions'][$group]['geocode'] = $GLOBALS['wgGroupPermissions'][$group]['edit'];
		}
	}

	$GLOBALS['wgParamDefinitions']['coordinate'] = array(
		'string-parser' => 'DataValues\Geo\Parsers\GeoCoordinateParser',
	);

	$GLOBALS['wgParamDefinitions']['mappingservice'] = array(
		'definition'=> 'Maps\ServiceParam',
	);

	$GLOBALS['wgParamDefinitions']['mapslocation'] = array(
		'string-parser' => 'Maps\LocationParser',
	);

	$GLOBALS['wgParamDefinitions']['mapsline'] = array(
		'string-parser' => 'Maps\LineParser',
	);

	$GLOBALS['wgParamDefinitions']['mapscircle'] = array(
		'string-parser' => 'Maps\CircleParser',
	);

	$GLOBALS['wgParamDefinitions']['mapsrectangle'] = array(
		'string-parser' => 'Maps\RectangleParser',
	);

	$GLOBALS['wgParamDefinitions']['mapspolygon'] = array(
		'string-parser' => 'Maps\PolygonParser',
	);

	$GLOBALS['wgParamDefinitions']['distance'] = array(
		'string-parser' => 'Maps\DistanceParser',
	);

	$GLOBALS['wgParamDefinitions']['wmsoverlay'] = array(
		'string-parser' => 'Maps\WmsOverlayParser',
	);

	$GLOBALS['wgParamDefinitions']['mapsimageoverlay'] = array(
		'string-parser' => 'Maps\ImageOverlayParser',
	);
} );
