<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CategoryMultisort',
	'author' => 'Liangent',
	'descriptionmsg' => 'categorymultisort-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CategoryMultisort',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['CategoryMultisortHooks'] = $dir . 'CategoryMultisort.hooks.php';
$wgAutoloadClasses['CategoryMultisortViewer'] = $dir . 'CategoryMultisort.class.php';

$wgExtensionMessagesFiles['CategoryMultisort'] = $dir . 'CategoryMultisort.i18n.php';
$wgExtensionMessagesFiles['CategoryMultisortMagic'] = $dir . 'CategoryMultisort.i18n.magic.php';

$wgCategoryMultisortHooks = new CategoryMultisortHooks();

$wgDefaultUserOptions['categorymultisort-sortkey'] = '';

$wgCategoryMultisortSortkeySettings = array();

function efCategoryMultisortIntegrate( $integrate = true ) {
	global $wgParserConf, $wgCategoryMultisortHooks;
	
	static $defaultParser = null;
	if ( is_null( $defaultParser ) ) {
		$defaultParser = $wgParserConf['class'];
	}
	
	$wgParserConf['class'] = $integrate ? 'Parser_LinkHooks' : $defaultParser;
	$wgCategoryMultisortHooks->setIntegrate( $integrate );
}
