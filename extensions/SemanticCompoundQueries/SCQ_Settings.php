<?php
/**
 * Initialization file for SemanticCompoundQueries
 *
 * @file
 * @ingroup SemanticCompoundQueries
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

define('SCQ_VERSION', '0.2.1');

$wgExtensionCredits['parserhook'][]= array(
	'name'	=> 'Semantic Compound Queries',
	'version'	=> SCQ_VERSION,
	'author'	=> 'Yaron Koren',
	'url'	=> 'http://www.mediawiki.org/wiki/Extension:Semantic_Compound_Queries',
	'description'	=>  'A parser function that displays multiple semantic queries at the same time',
);

$wgExtensionFunctions[] = 'scqgParserFunctions';
$wgHooks['LanguageGetMagic'][] = 'scqgLanguageGetMagic';

$scqIP = $IP . '/extensions/SemanticCompoundQueries';
$wgAutoloadClasses['SCQQueryProcessor'] = $scqIP . '/SCQ_QueryProcessor.php';
$wgAutoloadClasses['SCQQueryResult'] = $scqIP . '/SCQ_QueryResult.php';

function scqgParserFunctions() {
	global $wgHooks, $wgParser;
	if( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
		$wgHooks['ParserFirstCallInit'][] = 'scqgRegisterParser';
	} else {
		if ( class_exists( 'StubObject' ) && !StubObject::isRealObject( $wgParser ) ) {
			$wgParser->_unstub();
		}
		SCQQueryProcessor::registerParserFunctions( $wgParser );
	}
}

function scqgRegisterParser(&$parser) {
	$parser->setFunctionHook( 'compound_query', array('SCQQueryProcessor','doCompoundQuery') );
	return true; // always return true, in order not to stop MW's hook processing!
}

function scqgLanguageGetMagic( &$magicWords, $langCode = "en" ) {
	switch ( $langCode ) {
	default:
		$magicWords['compound_query'] = array ( 0, 'compound_query' );
	}
	return true;
}
