<?php

/**
 * Main entry point for the SemanticResultFormats extension.
 * http://www.mediawiki.org/wiki/Extension:Semantic_Result_Formats
 * 
 * @file SemanticResultFormats.php
 * @ingroup SemanticResultFormats
 * 
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documentation group collects source code files belonging to SemanticResultFormats.
 * 
 * @defgroup SemanticResultFormats SemanticResultFormats
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.16', '<' ) ) {
	die( '<b>Error:</b> This version of Semantic Result Formats requires MediaWiki 1.16 or above; use SRF 1.6.x for older versions.' );
}

// Show a warning if Semantic MediaWiki is not loaded.
if ( ! defined( 'SMW_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://semantic-mediawiki.org/wiki/Semantic_MediaWiki">Semantic MediaWiki</a> installed in order to use <a href="https://www.mediawiki.org/wiki/Extension:Semantic Result Formats">Semantic Result Formats</a>.<br />' );
}

if ( version_compare( SMW_VERSION, '1.6.2 alpha', '<' ) ) {
	die( '<b>Error:</b> This version of Semantic Result Formats requires Semantic MediaWiki 1.7 or above; use Semantic Result Formats 1.6.1 for older versions of SMW.' );
}

define( 'SRF_VERSION', '1.7.1' );

// Require the settings file.
require dirname( __FILE__ ) . '/SRF_Settings.php';

if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
	require dirname( __FILE__ ) . '/SRF_Resources.php';
}

// Initialize the formats later on, so the $srfgFormats setting can be manipulated in LocalSettings.
$wgExtensionFunctions[] = 'srffInitFormats';

$wgExtensionMessagesFiles['SemanticResultFormats'] = dirname( __FILE__ ) . '/SRF_Messages.php';
$wgExtensionMessagesFiles['SemanticResultFormatsMagic'] = dirname( __FILE__ ) . '/SRF_Magic.php';

$srfgScriptPath = ( $wgExtensionAssetsPath === false ? $wgScriptPath . '/extensions' : $wgExtensionAssetsPath ) . '/SemanticResultFormats'; 
$srfgIP = dirname( __FILE__ );

$wgExtensionCredits['semantic'][] = array(
	'path' => __FILE__,
	'name' => 'Semantic Result Formats',
	'version' => SRF_VERSION,
	// At least 14 people have contributed formats to this extension, so
	// it would be prohibitive to list them all in the credits. Instead,
	// the current rule is to list anyone who has created, or contributed
	// significantly to, at least three formats, or the overall extension.
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
		'Yaron Koren',
		'[http://korrekt.org Markus Krötzsch]',
		'[http://simia.net Denny Vrandecic]',
		'...'
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Semantic_Result_Formats',
	'descriptionmsg' => 'srf-desc'
);

$formatDir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['SRFTimeline'] = $formatDir . 'Timeline/SRF_Timeline.php';
$wgAutoloadClasses['SRFvCard'] = $formatDir . 'vCard/SRF_vCard.php';
$wgAutoloadClasses['SRFiCalendar'] = $formatDir . 'iCalendar/SRF_iCalendar.php';
$wgAutoloadClasses['SRFBibTeX'] = $formatDir . 'BibTeX/SRF_BibTeX.php';
$wgAutoloadClasses['SRFCalendar'] = $formatDir . 'Calendar/SRF_Calendar.php';
$wgAutoloadClasses['SRFOutline'] = $formatDir . 'Outline/SRF_Outline.php';
$wgAutoloadClasses['SRFMath'] = $formatDir . 'Math/SRF_Math.php';
$wgAutoloadClasses['SRFExhibit'] = $formatDir . 'Exhibit/SRF_Exhibit.php';
$wgAutoloadClasses['SRFGoogleBar'] = $formatDir . 'GoogleCharts/SRF_GoogleBar.php';
$wgAutoloadClasses['SRFGooglePie'] = $formatDir . 'GoogleCharts/SRF_GooglePie.php';
$wgAutoloadClasses['SRFJitGraph'] = $formatDir . 'JitGraph/SRF_JitGraph.php';
$wgAutoloadClasses['SRFjqPlotPie'] = $formatDir . 'jqPlot/SRF_jqPlotPie.php';
$wgAutoloadClasses['SRFjqPlotBar'] = $formatDir . 'jqPlot/SRF_jqPlotBar.php';
$wgAutoloadClasses['SRFGraph'] = $formatDir . 'GraphViz/SRF_Graph.php';
$wgAutoloadClasses['SRFProcess'] = $formatDir . 'GraphViz/SRF_Process.php';
$wgAutoloadClasses['SRFPloticusVBar'] = $formatDir . 'Ploticus/SRF_PloticusVBar.php';
$wgAutoloadClasses['SRFGallery'] = $formatDir . 'Gallery/SRF_Gallery.php';
$wgAutoloadClasses['SRFTagCloud'] = $formatDir . 'TagCloud/SRF_TagCloud.php';
$wgAutoloadClasses['SRFArray'] = $formatDir . 'Array/SRF_Array.php';
$wgAutoloadClasses['SRFHash'] = $formatDir . 'Array/SRF_Array.php';
$wgAutoloadClasses['SRFValueRank'] = $formatDir . 'ValueRank/SRF_ValueRank.php';
$wgAutoloadClasses['SRFD3Line'] = $formatDir . 'D3/SRF_D3Line.php';
$wgAutoloadClasses['SRFD3Bar'] = $formatDir . 'D3/SRF_D3Bar.php';
$wgAutoloadClasses['SRFD3Treemap'] = $formatDir . 'D3/SRF_D3Treemap.php';  
$wgAutoloadClasses['SRFTree'] = $formatDir . 'Tree/SRF_Tree.php';  
$wgAutoloadClasses['SRFFiltered'] = $formatDir . 'Filtered/SRF_Filtered.php';  

unset( $formatDir );

$wgAutoloadClasses['SRFParserFunctions'] = $srfgIP . '/SRF_ParserFunctions.php';
$wgAutoloadClasses['SRFHooks'] = $srfgIP . '/SRF_Hooks.php';

$wgHooks['AdminLinks'][] = 'SRFHooks::addToAdminLinks';
$wgHooks['ParserFirstCallInit'][] = 'SRFParserFunctions::registerFunctions';

/**
 * Autoload the query printer classes and associate them with their formats in the $smwgResultFormats array.
 * 
 * @since 1.5.2
 */
function srffInitFormats() {
	global $srfgFormats, $smwgResultFormats, $smwgResultAliases, $wgAutoloadClasses;
	
	$formatClasses = array(
		'timeline' => 'SRFTimeline',
		'eventline' => 'SRFTimeline',
		'vcard' => 'SRFvCard',
		'icalendar' => 'SRFiCalendar',
		'bibtex' => 'SRFBibTeX',
		'calendar' => 'SRFCalendar',
		'outline' => 'SRFOutline',
		'sum' => 'SRFMath',
		'product' => 'SRFMath',
		'average' => 'SRFMath',
		'min' => 'SRFMath',
		'max' => 'SRFMath',
		'median' => 'SRFMath',
		'exhibit' => 'SRFExhibit',
		'googlebar' => 'SRFGoogleBar',
		'googlepie' => 'SRFGooglePie',
		'jitgraph' => 'SRFJitGraph',
		'jqplotpie' => 'SRFjqPlotPie',
		'jqplotbar' => 'SRFjqPlotBar',
		'graph' => 'SRFGraph',
		'process' => 'SRFProcess',
		'ploticusvbar' => 'SRFPloticusVBar',
		'gallery' => 'SRFGallery',
		'tagcloud' => 'SRFTagCloud',
		'valuerank' => 'SRFValueRank',
		'array' => 'SRFArray',
		'hash' => 'SRFHash',
		'D3Line' => 'SRFD3Line',
		'D3Bar' => 'SRFD3Bar',
		'D3Treemap' => 'SRFD3Treemap',
		'tree' => 'SRFTree',
		'ultree' => 'SRFTree',
		'oltree' => 'SRFTree',
		'filtered' => 'SRFFiltered',
	);

	$formatAliases = array(
		'tagcloud' => array( 'tag cloud' ),
		'valuerank' => array( 'value rank' )
	);
	
	foreach ( $srfgFormats as $format ) {
		if ( array_key_exists( $format, $formatClasses ) ) {
			$smwgResultFormats[$format] = $formatClasses[$format];
			
			if ( isset( $smwgResultAliases ) && array_key_exists( $format, $formatAliases ) ) {
				$smwgResultAliases[$format] = $formatAliases[$format];
			}
		}
		else {
			wfDebug( "There is not result format class associated with the format '$format'." );
		}
	}	
}
