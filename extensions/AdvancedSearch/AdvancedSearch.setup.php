<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Roan Kattouw <roan.kattouw@home.nl>
 * @copyright Copyright (C) 2008 Roan Kattouw 
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that allows for searching inside categories
 * Written for MixesDB <http://mixesdb.com> by Roan Kattouw <roan.kattouw@home.nl>
 * For information how to install and use this extension, see the README file.
 *
 */
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the extension file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install the AdvancedSearch extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/AdvancedSearch/AdvancedSearch.setup.php" );
EOT;
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'AdvancedSearch',
	'author' => 'Roan Kattouw',
	'url' => 'http://www.mediawiki.org/wiki/Extension:AdvancedSearch',
	'version' => '1.0',
	'description' => 'Allows for searching in categories',
	'descriptionmsg' => 'advancedsearch-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['AdvancedSearch'] = $dir . 'AdvancedSearch.i18n.php';
$wgAutoloadClasses['AdvancedSearch'] = $dir . 'AdvancedSearch.body.php';
$wgAutoloadClasses['AdvancedSearchPager'] = $dir . 'AdvancedSearchPager.php';
$wgAutoloadClasses['AdvancedSearchCategoryIntersector'] = $dir . 'AdvancedSearchCategoryIntersector.php';

$wgSpecialPages['AdvancedSearch'] = 'AdvancedSearch';
$wgHooks['LanguageGetSpecialPageAliases'][] = 'AdvancedSearchLocalizedPageName';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'AdvancedSearchSchemaUpdate';
$wgHooks['LinksUpdate'][] = 'AdvancedSearchCategoryIntersector::LinksUpdate';
$wgHooks['ArticleDeleteComplete'][] = 'AdvancedSearchCategoryIntersector::ArticleDeleteComplete';

function AdvancedSearchLocalizedPageName(&$specialPageArray, $code)
{
	wfLoadExtensionMessages('AdvancedSearch');
	$text = wfMsg('advancedsearch-pagename');

	$title = Title::newFromText($text);
	$specialPageArray['AdvancedSearch'][] = $title->getDBkey();
	return true;
}

function AdvancedSearchSchemaUpdate()
{
	global $wgExtNewTables;
	$dir = dirname(__FILE__) . '/';
	$wgExtNewTables[] = array('categorysearch', $dir . 'categorysearch.sql');
	return true;
}
