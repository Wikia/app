<?php
/**
 * Initialization file for the Include WP extension.
 * 
 * Documentation:	 		http://www.mediawiki.org/wiki/Extension:Include_WP
 * Support					http://www.mediawiki.org/wiki/Extension_talk:Include_WP
 * Source code:             http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/IncludeWP
 *
 * @file IncludeWP.php
 * @ingroup IncludeWP
 *
 * @licence GNU GPL v3
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documenation group collects source code files belonging to Include WP.
 *
 * @defgroup IncludeWP Include WP
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.16', '<' ) ) {
	die( 'Include WP requires MediaWiki 1.16 or above.' );
}

// Include the Validator extension if that hasn't been done yet, since it's required for Include WP to work.
if ( !defined( 'Validator_VERSION' ) ) {
	@include_once( dirname( __FILE__ ) . '/../Validator/Validator.php' );
}

// Only initialize the extension when all dependencies are present.
if ( ! defined( 'Validator_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://www.mediawiki.org/wiki/Extension:Validator">Validator</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:SubPageList">SubPageList</a>.<br />' );
}

define( 'IncludeWP_VERSION', '0.2 alpha' );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Include WP',
	'version' => IncludeWP_VERSION,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Include_WP',
	'descriptionmsg' => 'includewp-desc'
);

$egIncWPScriptPath = $wgExtensionAssetsPath === false ? $wgScriptPath . '/extensions/IncludeWP' : $wgExtensionAssetsPath . '/IncludeWP';

$wgExtensionMessagesFiles['IncludeWP'] = dirname( __FILE__ ) . '/IncludeWP.i18n.php';
$wgExtensionMessagesFiles['IncludeWPMagic'] = dirname( __FILE__ ) . '/IncludeWP.i18n.magic.php';

$wgAutoloadClasses['IncludeWP'] = dirname( __FILE__ ) . '/IncludeWP.class.php';
$wgAutoloadClasses['ApiIncludeWP'] = dirname( __FILE__ ) . '/api/ApiIncludeWP.php';

$wgHooks['ParserFirstCallInit'][] = 'IncludeWP::staticInit';

$wgAPIModules['includewp'] = 'ApiIncludeWP';

$egIncWPJSMessages = array(
	'includewp-show-full-page',
	'includewp-loading-failed',
	'includewp-licence-notice',
	'includewp-show-fragment'
);

// For backward compatibility with MW < 1.17.
if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
	$moduleTemplate = array(
		'localBasePath' => dirname( __FILE__ ),
		'remoteBasePath' => $egIncWPScriptPath
	);
	
	$wgResourceModules['ext.incwp'] = $moduleTemplate + array(
		'scripts' => 'ext.incwp.js',
		'dependencies' => array(),
		'messages' => $egIncWPJSMessages
	);
}

require_once 'IncludeWP.settings.php';
