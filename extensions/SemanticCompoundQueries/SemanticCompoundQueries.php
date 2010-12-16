<?php
/**
 * Initialization file for SemanticCompoundQueries
 *
 * @file
 * @ingroup SemanticCompoundQueries
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define( 'SCQ_VERSION', '0.2.3' );

$wgExtensionCredits['parserhook'][] = array(
	'path'  => __FILE__,
	'name'	=> 'Semantic Compound Queries',
	'version'	=> SCQ_VERSION,
	'author'	=> 'Yaron Koren',
	'url'	=> 'http://www.mediawiki.org/wiki/Extension:Semantic_Compound_Queries',
	'description'	=>  'A parser function that displays multiple semantic queries at the same time',
	'descriptionmsg' => 'semanticcompoundqueries-desc',
);

$wgExtensionMessagesFiles['SemanticCompoundQueries'] = dirname( __FILE__ ) . '/SemanticCompoundQueries.i18n.php';


$wgHooks['ParserFirstCallInit'][] = 'scqgRegisterParser';
// FIXME: Can be removed when new style magic words are used (introduced in r52503)
$wgHooks['LanguageGetMagic'][] = 'scqgLanguageGetMagic';

$scqIP = $IP . '/extensions/SemanticCompoundQueries';
$wgAutoloadClasses['SCQQueryProcessor'] = $scqIP . '/SCQ_QueryProcessor.php';
$wgAutoloadClasses['SCQQueryResult'] = $scqIP . '/SCQ_QueryResult.php';

function scqgRegisterParser( &$parser ) {
	$parser->setFunctionHook( 'compound_query', array( 'SCQQueryProcessor', 'doCompoundQuery' ) );
	return true; // always return true, in order not to stop MW's hook processing!
}

// FIXME: Can be removed when new style magic words are used (introduced in r52503)
function scqgLanguageGetMagic( &$magicWords, $langCode = "en" ) {
	switch ( $langCode ) {
	default:
		$magicWords['compound_query'] = array ( 0, 'compound_query' );
	}
	return true;
}
