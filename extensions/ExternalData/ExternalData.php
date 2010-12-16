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
	'path'           => __FILE__,
	'name'           => 'External Data',
	'version'        => '0.9.2',
	'author'         => array( 'Yaron Koren', 'Michael Dale', 'David Macdonald' ),
	'url'            => 'http://www.mediawiki.org/wiki/Extension:External_Data',
	'description'    => 'Allows for retrieving structured data from external URLs, databases and other sources',
	'descriptionmsg' => 'externaldata-desc',
);
$edgIP = $IP . '/extensions/ExternalData';

$wgHooks['ParserFirstCallInit'][] = 'edgRegisterParser';
$wgExtensionMessagesFiles['ExternalData'] = $edgIP . '/ExternalData.i18n.php';

if( version_compare( $wgVersion, '1.16alpha', '>=' ) ) {
	$wgExtensionMessagesFiles['ExternalDataMagic'] = $edgIP . '/ExternalData.i18n.magic.php';
} else {
	// Pre 1.16alpha backward compatibility for magic words
	$wgHooks['LanguageGetMagic'][] = 'edgLanguageGetMagic';
}

// register all special pages and other classes
$wgAutoloadClasses['EDUtils'] = $edgIP . '/ED_Utils.php';
$wgAutoloadClasses['EDParserFunctions'] = $edgIP . '/ED_ParserFunctions.php';
$wgSpecialPages['GetData'] = 'EDGetData';
$wgAutoloadClasses['EDGetData'] = $edgIP . '/ED_GetData.php';
$wgSpecialPageGroups['GetData'] = 'pagetools';

$edgValues = array();
$edgStringReplacements = array();
$edgCacheTable = null;
$edgAllowSSL = false;

//(in seconds) set to one week:
$edgCacheExpireTime = 60*60*24 * 7;

$edgDBServer = array();
$edgDBServerType = array();
$edgDBName = array();
$edgDBUser = array();
$edgDBPass = array();

function edgRegisterParser(&$parser) {
	$parser->setFunctionHook( 'get_external_data', array('EDParserFunctions','doGetExternalData') );
	$parser->setFunctionHook( 'get_ldap_data', array('EDParserFunctions','doGetLDAPData') );
	$parser->setFunctionHook( 'get_db_data', array('EDParserFunctions','doGetDBData') );
	$parser->setFunctionHook( 'external_value', array('EDParserFunctions','doExternalValue') );
	$parser->setFunctionHook( 'for_external_table', array('EDParserFunctions','doForExternalTable') );

	return true; // always return true, in order not to stop MW's hook processing!
}

// Pre 1.16alpha backward compatibility for magic words
function edgLanguageGetMagic( &$magicWords, $langCode = "en" ) {
	switch ( $langCode ) {
	default:
		$magicWords['get_external_data'] = array ( 0, 'get_external_data' );
		$magicWords['get_ldap_data'] = array ( 0, 'get_ldap_data' );
		$magicWords['get_db_data'] = array ( 0, 'get_db_data' );
		$magicWords['external_value'] = array ( 0, 'external_value' );
		$magicWords['for_external_table'] = array ( 0, 'for_external_table' );
	}
	return true;
}
