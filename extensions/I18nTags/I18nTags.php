<?php

/**
 * Some tags to access i18n function in language files
 *
 * @file
 * @ingroup Extensions
 * @author Niklas Laxström
 */

if (!defined('MEDIAWIKI')) die();

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Parser i18n tags',
	'descriptionmsg' => 'i18ntags-desc',
	'version' => '2009-01-11',
	'author' => 'Niklas Laxström',
	'url' => 'https://www.mediawiki.org/wiki/Extension:I18nTags',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['I18nTags'] = $dir . 'I18nTags_body.php';
$wgExtensionMessagesFiles['I18nTags'] = $dir . 'I18nTags.i18n.php';
$wgExtensionMessagesFiles['I18nTagsMagic'] = $dir . 'I18nTags.magic.php';

$wgHooks['ParserFirstCallInit'][] = 'efI18nTagsInit';

/**
 * @param $parser Parser
 * @return bool
 */
function efI18nTagsInit( &$parser ) {
	$class = 'I18nTags';
	$parser->setHook( 'formatnum', array($class, 'formatNumber')  );
	$parser->setHook( 'grammar',   array($class, 'grammar') );
	$parser->setHook( 'plural',    array($class, 'plural') );
	$parser->setHook( 'linktrail', array($class, 'linktrail') );
	$parser->setFunctionHook( 'languagename',  array($class, 'languageName' ) );
	return true;
}
