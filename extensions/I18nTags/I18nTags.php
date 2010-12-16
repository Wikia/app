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
	'path' => __FILE__,
	'name' => 'Parser i18n tags',
	'description' => 'Access the i18n functions for number formatting, ' .
	'grammar and plural in any available language',
	'descriptionmsg' => 'i18ntags-desc',
	'version' => '2009-01-11',
	'author' => 'Niklas Laxström',
	'url' => 'http://www.mediawiki.org/wiki/Extension:I18nTags',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['I18nTags'] = $dir . 'I18nTags_body.php';
$wgExtensionMessagesFiles['I18nTags'] = $dir . 'I18nTags.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'efI18nTagsInit';

function efI18nTagsInit( &$parser ) {
	global $wgParser;
	$class = 'I18nTags';
	$parser->setHook( 'formatnum', array($class, 'formatNumber')  );
	$parser->setHook( 'grammar',   array($class, 'grammar') );
	$parser->setHook( 'plural',    array($class, 'plural') );
	$parser->setHook( 'linktrail', array($class, 'linktrail') );
	wfLoadExtensionMessages( 'I18nTags' ); // FOR BC
	$parser->setFunctionHook( 'languagename',  array($class, 'languageName' ) );
	return true;
}
