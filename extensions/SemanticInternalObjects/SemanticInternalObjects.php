<?php
/**
 * Initialization file for Semantic Internal Objects.
 *
 * @file
 * @ingroup SemanticInternalObjects
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define( 'SIO_VERSION', '0.6.8' );

$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'parserhook'][] = array(
	'path' => __FILE__,
	'name'	=> 'Semantic Internal Objects',
	'version' => SIO_VERSION,
	'author' => 'Yaron Koren',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Semantic_Internal_Objects',
	'descriptionmsg' => 'semanticinternalobjects-desc',
);

$wgHooks['ParserFirstCallInit'][] = 'siofRegisterParserFunctions';
$wgHooks['ParserClearState'][] = 'SIOHandler::clearState';
$wgHooks['SMWSQLStore2::updateDataAfter'][] = 'SIOHandler::updateData';
$wgHooks['SMWSQLStore2::deleteSubjectAfter'][] = 'SIOHandler::deleteData';
$wgHooks['smwUpdatePropertySubjects'][] = 'SIOHandler::handleUpdatingOfInternalObjects';
$wgHooks['TitleMoveComplete'][] = 'SIOHandler::handlePageMove';
$wgHooks['smwRefreshDataJobs'][] = 'SIOHandler::handleRefreshingOfInternalObjects';
$wgHooks['smwAddToRDFExport'][] = 'SIOSQLStore::createRDF';
$wgHooks['PageSchemasRegisterHandlers'][] = 'SIOPageSchemas::registerClass';

$siogIP = dirname( __FILE__ );
$wgExtensionMessagesFiles['SemanticInternalObjects'] = $siogIP . '/SemanticInternalObjects.i18n.php';
$wgExtensionMessagesFiles['SemanticInternalObjectsMagic'] = $siogIP . '/SemanticInternalObjects.i18n.magic.php';
$wgAutoloadClasses['SIOHandler'] = $siogIP . '/SemanticInternalObjects_body.php';
$wgAutoloadClasses['SIOSQLStore'] = $siogIP . '/SemanticInternalObjects_body.php';
if ( class_exists( 'SMWDIWikiPage' ) ) {
	// SMW >= 1.6
	$wgAutoloadClasses['SIOInternalObjectValue'] = $siogIP . '/SIO_RDFClasses2.php';
} else {
	$wgAutoloadClasses['SIOInternalObjectValue'] = $siogIP . '/SIO_RDFClasses.php';
}
$wgAutoloadClasses['SIOPageSchemas'] = $siogIP . '/SIO_PageSchemas.php';

function siofRegisterParserFunctions( &$parser ) {
	$parser->setFunctionHook( 'set_internal', array( 'SIOHandler', 'doSetInternal' ) );
	$parser->setFunctionHook( 'set_internal_recurring_event', array( 'SIOHandler', 'doSetInternalRecurringEvent' ) );
	return true; // always return true, in order not to stop MW's hook processing!
}
