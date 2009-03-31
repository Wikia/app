<?php

/**
 * Some tags to access i18n function in language files
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Niklas Laxström
 */

if (!defined('MEDIAWIKI')) die();

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Parser i18n tags',
	'description' => 'Access the i18n functions for number formatting, ' .
		'grammar and plural in any available language',
	'descriptionmsg' => 'i18ntags-desc',
	'version' => '2.2',
	'author' => 'Niklas Laxström',
	'url' => 'http://www.mediawiki.org/wiki/Extension:I18nTags',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['I18nTags'] = $dir . 'I18nTags_body.php';
$wgExtensionMessagesFiles['I18nTags'] = $dir . 'I18nTags.i18n.php';

if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'efI18nTagsInit';
} else {
	$wgExtensionFunctions[] = 'efI18nTagsInit';
}


function efI18nTagsInit() {
	global $wgParser;
	$class = 'I18nTags';
	$wgParser->setHook( 'formatnum', array($class, 'formatNumber')  );
	$wgParser->setHook( 'grammar',   array($class, 'grammar') );
	$wgParser->setHook( 'plural',    array($class, 'plural') );
	$wgParser->setHook( 'linktrail', array($class, 'linktrail') );
	wfLoadExtensionMessages( 'I18nTags' );
	$wgParser->setFunctionHook( 'languagename',  array($class, 'languageName' ) );
	return true;
}
