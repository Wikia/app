<?php
/**
 * A special page to create a new article, using wysiwig editor
 *
 */

if(!defined('MEDIAWIKI')) {
	die();
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Create Page',
	'author' => 'Bartek Lapinski, Adrian Wieczorek',
	'url' => 'http://www.wikia.com' ,
	'description' => 'Allows to create a new page using wikia\'s Wysiwyg editor'
);

/**
 * messages file
 */
$wgExtensionMessagesFiles['CreatePage'] = dirname(__FILE__) . '/CreatePage.i18n.php';

/**
 * Special pages
 */
extAddSpecialPage(dirname(__FILE__) . '/SpecialCreatePage.php', 'CreatePage', 'CreatePage');

include( dirname( __FILE__ ) . "/SpecialEditPage.php");
include( dirname( __FILE__ ) . "/SpecialCreatePage.php");
