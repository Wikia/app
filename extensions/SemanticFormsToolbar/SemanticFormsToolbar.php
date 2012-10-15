<?php

if ( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Semantic Forms Toolbar',
	'author'         => array( 'Andrew Garrett' ),
	'descriptionmsg' => 'sft-desc',
);

$wgAutoloadClasses['SemanticFormsToolbar'] = dirname(__FILE__).'/Body.php';
$wgAutoloadClasses['ApiSemanticFormsToolbar'] = dirname(__FILE__).'/APISemanticFormsToolbar.php';

// Semantic Forms Toolbar
$wgAPIModules['sftoolbar'] = 'ApiSemanticFormsToolbar';

$wgHooks['EditPage::showEditForm:initial'][] = 'efSFTEditForm';

// Resource modules for 1.17+
$wgResourceModules += array(
	'ext.sftoolbar' => array(
		'scripts' => 'ext.sftoolbar.js',
		'localBasePath' => dirname( __FILE__ ) . '/modules',
		'remoteExtPath' => 'SemanticFormsToolbar/modules',
		'group' => 'ext.sftoolbar',
	),
	'ext.sftoolbar.json' => array(
		'scripts' => 'ext.sftoolbar.json.js',
		'localBasePath' => dirname( __FILE__ ) . '/modules',
		'remoteExtPath' => 'SemanticFormsToolbar/modules',
		'group' => 'ext.sftoolbar',
	),
);

function efSFTEditForm() {
	global $wgOut;
	
	if ( is_callable( array($wgOut, 'addModules') ) ) {
		$wgOut->addModules( array('ext.sftoolbar', 'ext.sftoolbar.json') );
	} else {
		$prefix = $wgScriptPath . '/SemanticFormsToolbar/modules/';
		$wgOut->addScriptFile( $prefix.'ext.sftoolbar.json.js' );
		$wgOut->addScriptFile( $prefix.'ext.sftoolbar.js' );
	}

	return true;
}
