<?php
/**
 * ResourceLoader Tests extension
 * 
 * @file
 * @ingroup Extensions
 * 
 * @author Trevor Parscal <trevor@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.1.0
 */

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ResourceLoaderTests',
	'author' => array( 'Trevor Parscal' ),
	'version' => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ResourceLoaderTests',
	'descriptionmsg' => 'resourceloadertests-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['ResourceLoaderTests'] = $dir . 'ResourceLoaderTests.i18n.php';
$wgExtensionMessagesFiles['ResourceLoaderTestsAlias'] = $dir . 'ResourceLoaderTests.alias.php';
$wgAutoloadClasses[ 'SpecialResourceLoaderTests' ] = $dir . 'ResourceLoaderTests.page.php';
$wgSpecialPages[ 'ResourceLoaderTests' ] = 'SpecialResourceLoaderTests';

$rltResourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'ResourceLoaderTests/modules',
	'group' => 'ext.resourceLoaderTests',
);
$wgResourceModules += array(
	'ext.resourceLoaderTests.a' => $rltResourceTemplate + array(
		'scripts' => 'ext.resourceLoaderTests.a.js',
		'styles' => 'ext.resourceLoaderTests.a.css',
	),
	'ext.resourceLoaderTests.b' => $rltResourceTemplate + array(
		'scripts' => 'ext.resourceLoaderTests.b.js',
		'styles' => 'ext.resourceLoaderTests.b.css',
		'dependencies' => 'ext.resourceLoaderTests.c',
	),
	'ext.resourceLoaderTests.c' => $rltResourceTemplate + array(
		'scripts' => 'ext.resourceLoaderTests.c.js',
		'styles' => 'ext.resourceLoaderTests.c.css',
	),
);
