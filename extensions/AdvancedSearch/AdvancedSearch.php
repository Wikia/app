<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Roan Kattouw <roan.kattouw@home.nl>
 * @copyright Copyright © 2008 Roan Kattouw
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that allows for searching inside categories
 * Written for MixesDB <http://mixesdb.com> by Roan Kattouw <roan.kattouw@home.nl>
 * For information how to install and use this extension, see the README file.
 */
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the extension file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the AdvancedSearch extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/AdvancedSearch/AdvancedSearch.setup.php" );
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'AdvancedSearch',
	'author' => 'Roan Kattouw',
	'url' => 'https://www.mediawiki.org/wiki/Extension:AdvancedSearch',
	'version' => '1.0',
	'descriptionmsg' => 'advancedsearch-desc',
);

// Autoload the new classes and set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['AdvancedSearch'] = $dir . 'AdvancedSearch.i18n.php';
$wgExtensionMessagesFiles['AdvancedSearchAlias'] = $dir . 'AdvancedSearch.alias.php';
$wgAutoloadClasses['AdvancedSearch'] = $dir . 'AdvancedSearch.body.php';
$wgAutoloadClasses['AdvancedSearchPager'] = $dir . 'AdvancedSearchPager.php';
$wgAutoloadClasses['AdvancedSearchCategoryIntersector'] = $dir . 'AdvancedSearchCategoryIntersector.php';

$wgSpecialPages['AdvancedSearch'] = 'AdvancedSearch';

// Hooked functions
$wgHooks['LoadExtensionSchemaUpdates'][] = 'AdvancedSearchSchemaUpdate';
$wgHooks['LinksUpdate'][] = 'AdvancedSearchCategoryIntersector::LinksUpdate';
$wgHooks['ArticleDeleteComplete'][] = 'AdvancedSearchCategoryIntersector::ArticleDeleteComplete';
$wgHooks['ParserTestTables'][] = 'AdvancedSearchAddTable';

function AdvancedSearchSchemaUpdate( $updater = null ) {
	$dir = dirname( __FILE__ ) . '/';
	if ( $updater === null ) {
		global $wgExtNewTables;
		$wgExtNewTables[] = array( 'categorysearch', $dir . 'categorysearch.sql' );
	} else {
		$updater->addExtensionUpdate( array( 'addTable', 'categorysearch', $dir . 'categorysearch.sql', true ) );
	}
	return true;
}

function AdvancedSearchAddTable( &$tables ) {
	$tables[] = 'categorysearch';
	return true;
}
