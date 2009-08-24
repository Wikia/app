<?php
/**
 * Initialization file for the External Data extension
 *
 * @file
 * @ingroup ExternalData
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

$wgExtensionCredits['parserhook'][]= array(
	'name'           => 'External Data',
	'version'        => '0.5.2',
	'author'         => array( 'Yaron Koren', 'Michael Dale' ),
	'url'            => 'http://www.mediawiki.org/wiki/Extension:External_Data',
	'description'    => 'Allows for retrieving data in CSV, JSON and XML formats from both external URLs and local wiki pages',
	'descriptionmsg' => 'externaldata-desc',
);
$edgIP = $IP . '/extensions/ExternalData';

$wgExtensionFunctions[] = 'edgParserFunctions';
$wgExtensionMessagesFiles['ExternalData'] = $edgIP . '/ExternalData.i18n.php';
$wgHooks['LanguageGetMagic'][] = 'edgLanguageGetMagic';

// register all special pages and other classes
$wgAutoloadClasses['EDUtils'] = $edgIP . '/ED_Utils.php';
$wgAutoloadClasses['EDParserFunctions'] = $edgIP . '/ED_ParserFunctions.php';
$wgSpecialPages['GetData'] = 'EDGetData';
$wgAutoloadClasses['EDGetData'] = $edgIP . '/ED_GetData.php';
$wgSpecialPageGroups['GetData'] = 'pagetools';

$edgValues = array();
$edgStringReplacements = array();
$edgCacheTable = null;

function edgParserFunctions() {
	global $wgHooks, $wgParser;
	if( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
		$wgHooks['ParserFirstCallInit'][] = 'edgRegisterParser';
	} else {
		if ( class_exists( 'StubObject' ) && !StubObject::isRealObject( $wgParser ) ) {
			$wgParser->_unstub();
		}
		edgRegisterParser( $wgParser );
	}
}

function edgRegisterParser(&$parser) {
	$parser->setFunctionHook( 'get_external_data', array('EDParserFunctions','doGetExternalData') );
	$parser->setFunctionHook( 'external_value', array('EDParserFunctions','doExternalValue') );
	$parser->setFunctionHook( 'for_external_table', array('EDParserFunctions','doForExternalTable') );

	return true; // always return true, in order not to stop MW's hook processing!
}

function edgLanguageGetMagic( &$magicWords, $langCode = "en" ) {
	switch ( $langCode ) {
	default:
		$magicWords['get_external_data'] = array ( 0, 'get_external_data' );
		$magicWords['external_value'] = array ( 0, 'external_value' );
		$magicWords['for_external_table'] = array ( 0, 'for_external_table' );
	}
	return true;
}
