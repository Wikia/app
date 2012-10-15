<?php

/**
 * A terminology markup extension with a Semantic MediaWiki backend
 *
 * @defgroup SemanticGlossary Semantic Glossary
 * @author Stephan Gambke
 * @version 0.1
 */

/**
 * The main file of the SemanticGlossary extension
 *
 * @author Stephan Gambke
 *
 * @file
 * @ingroup SemanticGlossary
 */


if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is part of a MediaWiki extension, it is not a valid entry point.' );
}

if ( !defined( 'SMW_VERSION' ) ) {
	die( 'Semantic Glossary depends on the Semantic MediaWiki extension. You need to install Semantic MediaWiki first.' );
}

if ( !defined( 'LINGO_VERSION' ) ) {
	die( 'Semantic Glossary depends on the Lingo extension. You need to install Lingo first.' );
}

/**
 * The Semantic Glossary version
 */
define( 'SG_VERSION', '0.1' );

// register the extension
$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'other'][] = array(
	'path' => __FILE__,
	'name' => 'Semantic Glossary',
	'author' => '[http://www.mediawiki.org/wiki/User:F.trott Stephan Gambke]',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Semantic_Glossary',
	'descriptionmsg' => 'semanticglossary-desc',
	'version' => SG_VERSION,
);


// set SemanticGlossaryBackend as the backend to access the glossary
$wgexLingoBackend = 'SemanticGlossaryBackend';

// server-local path to this file
$dir = dirname( __FILE__ );

// register message file
$wgExtensionMessagesFiles['SemanticGlossary'] = $dir . '/SemanticGlossary.i18n.php';

// register class files with the Autoloader
$wgAutoloadClasses['SemanticGlossaryBackend'] = $dir . '/SemanticGlossaryBackend.php';

// register hook handlers
$wgHooks['smwInitProperties'][] = 'SemanticGlossaryRegisterProperties';
$wgHooks['smwInitDatatypes'][] = 'SemanticGlossaryRegisterPropertyAliases';

define( 'SG_PROP_GLT', 'Glossary-Term' );
define( 'SG_PROP_GLD', 'Glossary-Definition' );
define( 'SG_PROP_GLL', 'Glossary-Link' );

function SemanticGlossaryRegisterProperties() {
	SMWDIProperty::registerProperty( '___glt', '_str', SG_PROP_GLT, true );
	SMWDIProperty::registerProperty( '___gld', '_txt', SG_PROP_GLD, true );
	SMWDIProperty::registerProperty( '___gll', '_str', SG_PROP_GLL, true );
	return true;
}

function SemanticGlossaryRegisterPropertyAliases() {
	SMWDIProperty::registerPropertyAlias( '___glt', wfMsg( 'semanticglossary-prop-glt' ) );
	SMWDIProperty::registerPropertyAlias( '___gld', wfMsg( 'semanticglossary-prop-gld' ) );
	SMWDIProperty::registerPropertyAlias( '___gll', wfMsg( 'semanticglossary-prop-gll' ) );
	return true;
}
