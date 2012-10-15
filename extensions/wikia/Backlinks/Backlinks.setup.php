<?php

/**
 * Backlinks
 *
 * Writes backlink text to a custom database when rendering wikitext
 *
 * @author Robert Elwell <robert@wikia-inc.com>
 * @date 2012-09-01
 * @copyright Copyright (C) 2012 Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

// Extension credits
$wgExtensionCredits['other'][] = array(
	'name' => 'Backlinks',
	'version' => '1.0',
	'url' => 'http://www.wikia.com/wiki/c:help:Help:Backlinks',
	'author' => array('Robert Elwell'),
	'descriptionmsg' => 'backlinks-desc',
);


$dir = dirname(__FILE__);
$app = F::app();

// Interface code
include("$dir/Backlinks.php");

$app->registerClass("Backlinks", "$dir/Backlinks.class.php");

//@todo make a special page controller that lets you view all pointing to a given page
/**
 * * register class BacklinksController $dir/BacklinksController.class.php
 * * register special page Backlinks BacklinksController
 */

// i18n
$wgExtensionMessagesFiles['Backlinks'] = $dir.'/Backlinks.i18n.php';

// hooks
$wgHooks['LinkEnd'][] = 'Backlinks::storeBacklinkText';
$wgHooks['OutputPageParserOutput'][] = 'Backlinks::updateBacklinkText';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'Backlinks::onLoadExtensionSchemaUpdates';
