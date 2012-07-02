<?php

/**
 * Initialization file for the PAMELA extension.
 * 
 * On MediaWiki.org: 		http://www.mediawiki.org/wiki/Extension:PAMELA
 * More on PAMELA:			http://hackerspaces.be/Pamela
 *
 * @file PAMELA.php
 * @ingroup PAMELA
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documenation group collects source code files belonging to PAMELA.
 *
 * Please do not use this group name for other code. If you have an extension to 
 * Semantic Maps, please use your own group definition.
 * 
 * @defgroup PAMELA PAMELA
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.17', '<' ) ) {
	die( '<b>Error:</b> PAMELA requires MediaWiki 1.17 or above.' );
}

// Include the Validator extension if that hasn't been done yet, since it's required for PAMELA to work.
if ( !defined( 'Validator_VERSION' ) ) {
	@include_once( dirname( __FILE__ ) . '/../Validator/Validator.php' );
}

// Only initialize the extension when all dependencies are present.
if ( ! defined( 'Validator_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://www.mediawiki.org/wiki/Extension:Validator">Validator</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:PAMELA">PAMELA</a>.<br />' );
}

define( 'PAMELA_VERSION', '0.1 alpha' );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'PAMELA',
	'version' => PAMELA_VERSION,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:PAMELA',
	'descriptionmsg' => 'pamela-desc'
);

$moduleTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/resources',
	'remoteBasePath' => ( isset( $wgExtensionAssetsPath ) && $wgExtensionAssetsPath ? $wgExtensionAssetsPath : $wgScriptPath . '/extensions' ) . '/PAMELA/resources',
	'group' => 'ext.pamela'
);

$wgResourceModules['ext.pam.common'] = $moduleTemplate + array(
	'scripts' => 'ext.pam.common.js',
	'dependencies' => array(),
	'messages' => array()
);

$wgResourceModules['ext.pam.listwidget'] = $moduleTemplate + array(
	'scripts' => 'ext.pam.listwidget.js',
	'styles' => 'ext.pam.listwidget.css',
	'dependencies' => array( 'ext.pam.common' ),
	'messages' => array(
		'pamela-list-message',
	)
);

$wgResourceModules['ext.pam.personwidget'] = $moduleTemplate + array(
	'scripts' => 'ext.pam.personwidget.js',
	'styles' => 'ext.pam.personwidget.css',
	'dependencies' => array( 'ext.pam.common' ),
	'messages' => array(
		'pamela-personwidget-online'
	)
);

$wgResourceModules['ext.pam.openwidget'] = $moduleTemplate + array(
	'scripts' => 'ext.pam.openwidget.js',
	'styles' => 'ext.pam.openwidget.css',
	'dependencies' => array( 'ext.pam.common' ),
	'messages' => array(
		'pamela-list-open',
	)
);

unset( $moduleTemplate );

$incDir = dirname( __FILE__ ) . '/includes/';

$wgAutoloadClasses['PAMELAListPeople'] 				= $incDir . 'PAMELA_ListPeople.php';
$wgAutoloadClasses['PAMELAPersonStatus'] 			= $incDir . 'PAMELA_PersonStatus.php';
$wgAutoloadClasses['PAMELAOpenWidget'] 				= $incDir . 'PAMELA_OpenWidget.php';

unset( $incDir );

# Required for #listpeople.
$wgHooks['ParserFirstCallInit'][] = 'PAMELAListPeople::staticInit';
# Required for #personstatus.
$wgHooks['ParserFirstCallInit'][] = 'PAMELAPersonStatus::staticInit';
# Required for #openwidget.
$wgHooks['ParserFirstCallInit'][] = 'PAMELAOpenWidget::staticInit';

$wgExtensionMessagesFiles['PAMELA'] = dirname( __FILE__ ) . '/PAMELA.i18n.php';
$wgExtensionMessagesFiles['PAMELAMagic'] = dirname( __FILE__ ) . '/PAMELA.i18n.magic.php';

require_once 'PAMELA.settings.php';
