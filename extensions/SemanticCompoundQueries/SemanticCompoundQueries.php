<?php
/**
 * Initialization file for the SemanticCompoundQueries extension.
 *
 * @file SemanticCompoundQueries.php
 * @ingroup SemanticCompoundQueries
 * 
 * @author Yaron Koren
 */

/**
 * This documentation group collects source-code files belonging to
 * Semantic Compound Queries.
 *
 * @defgroup SemanticCompoundQueries SemanticCompoundQueries
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define( 'SCQ_VERSION', '0.3.2' );

$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'parserhook'][] = array(
	'path'  => __FILE__,
	'name'	=> 'Semantic Compound Queries',
	'version'	=> SCQ_VERSION,
	'author'	=> array( 'Yaron Koren' ),
	'url'	=> 'https://www.mediawiki.org/wiki/Extension:Semantic_Compound_Queries',
	'descriptionmsg' => 'semanticcompoundqueries-desc',
);

$wgExtensionMessagesFiles['SemanticCompoundQueries'] = dirname( __FILE__ ) . '/SemanticCompoundQueries.i18n.php';
$wgExtensionMessagesFiles['SemanticCompoundQueriesMagic'] = dirname( __FILE__ ) . '/SemanticCompoundQueries.i18n.magic.php';

$wgHooks['ParserFirstCallInit'][] = 'scqgRegisterParser';

$wgAutoloadClasses['SCQQueryProcessor'] = dirname( __FILE__ ) . '/SCQ_QueryProcessor.php';
$wgAutoloadClasses['SCQQueryResult'] = dirname( __FILE__ ) . '/SCQ_QueryResult.php';

function scqgRegisterParser( Parser &$parser ) {
	$parser->setFunctionHook( 'compound_query', array( 'SCQQueryProcessor', 'doCompoundQuery' ) );
	return true; // always return true, in order not to stop MW's hook processing!
}
