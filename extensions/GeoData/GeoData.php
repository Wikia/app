<?php
/**
 * GeoData extension. Initial author Max Semenik
 * License: WTFPL 2.0
 */
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'GeoData',
	'author' => array( 'Max Semenik' ),
	'url' => 'https://mediawiki.org/wiki/Extension:GeoData',
	'descriptionmsg' => 'geodata-desc',
);

$dir = dirname( __FILE__ );

$wgAutoloadClasses['ApiQueryCoordinates'] = "$dir/api/ApiQueryCoordinates.php";
$wgAutoloadClasses['ApiQueryGeoSearch'] = "$dir/api/ApiQueryGeoSearch.php";
$wgAutoloadClasses['ApiQueryAllPages_GeoData'] = "$dir/api/ApiQueryAllPages_GeoData.php";
$wgAutoloadClasses['ApiQueryCategoryMembers_GeoData'] = "$dir/api/ApiQueryCategoryMembers_GeoData.php";
$wgAutoloadClasses['GeoDataQueryExtender'] = "$dir/api/GeoDataQueryExtender.php";
$wgAutoloadClasses['Coord'] = "$dir/GeoData.body.php";
$wgAutoloadClasses['CoordinatesParserFunction'] = "$dir/CoordinatesParserFunction.php";
$wgAutoloadClasses['GeoData'] = "$dir/GeoData.body.php";
$wgAutoloadClasses['GeoDataHooks'] = "$dir/GeoDataHooks.php";
$wgAutoloadClasses['GeoMath'] = "$dir/GeoMath.php";
$wgAutoloadClasses['CoordinatesOutput'] = "$dir/CoordinatesParserFunction.php";

$wgExtensionMessagesFiles['GeoData'] = "$dir/GeoData.i18n.php";
$wgExtensionMessagesFiles['GeoDataMagic'] = "$dir/GeoData.i18n.magic.php";

$wgAPIListModules['geosearch'] = 'ApiQueryGeoSearch';
$wgAPIPropModules['coordinates'] = 'ApiQueryCoordinates';
$wgAPIListModules['geopages'] = 'ApiQueryAllPages_GeoData';
$wgAPIListModules['geopagesincategory'] = 'ApiQueryCategoryMembers_GeoData';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'GeoDataHooks::onLoadExtensionSchemaUpdates';
$wgHooks['ParserFirstCallInit'][] = 'GeoDataHooks::onParserFirstCallInit';
$wgHooks['UnitTestsList'][] = 'GeoDataHooks::onUnitTestsList';
$wgHooks['ArticleDeleteComplete'][] = 'GeoDataHooks::onArticleDeleteComplete';
$wgHooks['LinksUpdate'][] = 'GeoDataHooks::onLinksUpdate';

// =================== start configuration settings ===================

/**
 * Maximum radius for geospatial searches.
 * The greater this variable is, the louder your server ouches.
 */
$wgMaxGeoSearchRadius = 10000; // 10km

/**
 * Default value for the globe (planet/astral body the coordinate is on)
 */
$wgDefaultGlobe = 'earth';

/**
 * Maximum number of coordinates per page, -1 means no limit
 */
$wgMaxCoordinatesPerPage = 500;

/**
 * Conversion table type --> dim
 */
$wgTypeToDim = array(
	'country'        => 1000000,
	'satellite'      => 1000000,
	'state'          => 300000,
	'adm1st'         => 100000,
	'adm2nd'         => 30000,
	'adm3rd'         => 10000,
	'city'           => 10000,
	'isle'           => 10000,
	'mountain'       => 10000,
	'river'          => 10000,
	'waterbody'      => 10000,
	'event'          => 5000,
	'forest'         => 5000,
	'glacier'        => 5000,
	'airport'        => 3000,
	'railwaystation' => 1000,
	'edu'            => 1000,
	'pass'           => 1000,
	'camera'         => 1000,
	'landmark'       => 1000,
);

/**
 * Default value of dim if it is unknown
 */
$wgDefaultDim = 1000;

$earth = array( 'min' => -180, 'mid' => 0, 'max' => 180, 'abbr' => array( 'E' => +1, 'W' => -1 ), 'wrap' => false );
$east360 = array( 'min' => 0, 'mid' => 180, 'max' => 360, 'abbr' => array( 'E' => +1, 'W' => -1 ), 'wrap' => true );
$west360 = array( 'min' => 0, 'mid' => 180, 'max' => 360, 'abbr' => array( 'E' => -1, 'W' => +1 ), 'wrap' => true );

/**
 * Description of coordinate systems, mostly taken from http://planetarynames.wr.usgs.gov/TargetCoordinates
 */
$wgGlobes = array(
	'earth' => $earth,
	'mercury' => $west360,
	'venus' => $east360,
	'moon' => $earth,
	'mars' => $east360,
	'phobos' => $west360,
	'deimos' => $west360,
	//'ceres' => ???,
	//'vesta' => ???,
	'ganymede' => $west360,
	'callisto' => $west360,
	'io' => $west360,
	'europa' => $west360,
	'mimas' => $west360,
	'enceladus' => $west360,
	'tethys' => $west360,
	'dione' => $west360,
	'rhea' => $west360,
	'titan' => $west360,
	'hyperion' => $west360,
	'iapetus' => $west360,
	'phoebe' => $west360,
	'miranda' => $east360,
	'ariel' => $east360,
	'umbriel' => $east360,
	'titania' => $east360,
	'oberon' => $east360,
	'triton' => $east360,
	'pluto' => $east360, // ???
);

unset( $earth );
unset( $east360 );
unset( $west360 );

/**
 * Controls what GeoData should do when it encounters some problem.
 * Reaction type:
 *  - track - Add tracking category
 *  - fail - Consider the tag invalid, display message and add tracking category
 *  - none - Do nothing
 */
$wgGeoDataWarningLevel = array(
	'unknown type' => 'track',
	'unknown globe' => 'none',
	'invalid region' => 'track',
);
