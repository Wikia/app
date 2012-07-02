<?php
/**
 * MediaWiki CongressLookup extension
 * http://www.mediawiki.org/wiki/Extension:CongressLookup
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * This program is distributed WITHOUT ANY WARRANTY.
 */

/**
 * @file
 * @ingroup Extensions
 * @author Ryan Kaldari
 */

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/CongressLookup/CongressLookup.php" );
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'CongressLookup',
	'version' => '1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CongressLookup',
	'author' => array( 'Ryan Kaldari' ),
	'descriptionmsg' => 'congresslookup-desc',
);

// Configurable variables for caching the special page
$wgCongressLookupSharedMaxAge = 1200; // 20 minutes server-side
$wgCongressLookupMaxAge = 600; // 10 minutes client-side

// Where to report errors (special page)
$wgCongressLookupErrorPage = 'CongressFail';

/**
 * Use black-on-white style or white-on-black
 * @var bool True = black on white style
 */
$wgCongressLookupBlackOnWhite = false;

$dir = dirname( __FILE__ ) . '/';

//API
$wgAutoloadClasses['ApiCongressLookup'] = $dir . 'ApiCongressLookup.php';
$wgAPIModules['congresslookup'] = 'ApiCongressLookup';

$wgAutoloadClasses['SpecialCongressLookup'] = $dir . 'SpecialCongressLookup.php';
$wgAutoloadClasses['SpecialCongressFail'] = $dir . 'SpecialCongressFail.php';
$wgAutoloadClasses['CongressLookupDB'] = $dir . 'CongressLookup.db.php';
$wgExtensionMessagesFiles['CongressLookup'] = $dir . 'CongressLookup.i18n.php';
$wgExtensionMessagesFiles['CongressLookupAlias'] = $dir . 'CongressLookup.alias.php';
$wgSpecialPages['CongressLookup'] = 'SpecialCongressLookup';
$wgSpecialPages['CongressFail'] = 'SpecialCongressFail';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'congressLookupSchemaUpdate';

/**
 * LoadExtensionSchemaUpdates hook handler
 * This function makes sure that the database schema is up to date.
 * @param $updater DatabaseUpdater|null
 * @return true
 */
function congressLookupSchemaUpdate( $updater = null ) {
	if ( $updater === null ) {
		global $wgExtNewTables;
		$wgExtNewTables[] = array( 'cl_senate', dirname( __FILE__ ) . '/patches/CongressLookup.sql' );
		$wgExtNewTables[] = array( 'cl_errors', dirname( __FILE__ ) . '/patches/CongressDataErrors.sql' );
	} else {
		$updater->addExtensionUpdate( array( 'addTable', 'cl_senate',
			dirname( __FILE__ ) . '/patches/CongressLookup.sql', true ) );
		$updater->addExtensionUpdate( array( 'addTable', 'cl_errors',
			dirname( __FILE__ ) . '/patches/CongressDataErrors.sql', true ) );
	}
	return true;
}
