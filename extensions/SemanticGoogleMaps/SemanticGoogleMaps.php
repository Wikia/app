<?php

if (!defined('MEDIAWIKI')) die();

/**
 * An extension that allows users to add, edit and display coordinate
 * information stored by the Semantic MediaWiki extension using Google Maps
 *
 * @addtogroup Extensions
 *
 * @author Robert Buzink
 * @author Yaron Koren
 */

// credits
$wgExtensionCredits['parserhook'][] = array(
	'name'            => 'Semantic Google Maps',
	'version'         => '0.5',
	'author'          => array( 'Robert Buzink', 'Yaron Koren' ),
	'url'             => 'http://www.mediawiki.org/wiki/Extension:Semantic_Google_Maps',
	'description'     => 'Allows users to edit and display semantic coordinate data using Google Maps',
	'descriptionmsg'  => 'semanticgooglemaps-desc',
);

$wgExtensionFunctions[] = 'sgmSetup';

$wgHooks['LanguageGetMagic'][] = 'sgmFunctionMagic';

$wgExtensionMessagesFiles['SemanticGoogleMaps'] = dirname(__FILE__) . '/SemanticGoogleMaps.i18n.php';

$sgmgIP = $IP . '/extensions/SemanticGoogleMaps';
$wgAutoloadClasses['SGMUtils'] = $sgmgIP . '/SGM_Utils.inc';
$wgAutoloadClasses['SGMResultPrinter'] = $sgmgIP . '/SGM_QueryPrinter.php';

function sgmSetup() {
	global $wgParser, $wgExtensionCredits;

	// a hook to enable the '#semantic_google_map' parser function
	$wgParser->setFunctionHook( 'semantic_google_map', array('SGMUtils', 'functionRender' ));
	// add the 'googlemap' form input type, if Semantic Forms is installed
	global $sfgFormPrinter;
	if ($sfgFormPrinter) {
		$sfgFormPrinter->setInputTypeHook('googlemap', array('SGMUtils', 'formInputHTML'), array());
	}

	// global variable introduced in SMW 1.2.2
	global $smwgResultFormats;
	if (isset($smwgResultFormats))
		$smwgResultFormats['googlemap'] = 'SGMResultPrinter';
	else
		SMWQueryProcessor::$formats['googlemap'] = 'SGMResultPrinter';

}

function sgmFunctionMagic( &$magicWords, $langCode ) {
	$magicWords['semantic_google_map'] = array( 0, 'semantic_google_map' );
	// unless we return true, other parser functions won't get loaded
	return true;
}
