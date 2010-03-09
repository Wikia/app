<?php
/*
KNOWN ISSUES:
- Only works with SVN revision 50605 or later of the
  Mediawiki core
*/

// Configuration

/**
 * This should point to either an HTTP-accessible Subversion repository containing
 * MediaWiki's 'phase3' and 'extensions' directory, *or* a local directory containing
 * checkouts of them:
 *
 * cd /path/to/mediawiki-trunk
 * svn co http://svn.wikimedia.org/svnroot/mediawiki/trunk/phase3
 * svn co http://svn.wikimedia.org/svnroot/mediawiki/trunk/extensions
 * $wgLocalisationUpdateSVNURL = '/path/to/mediawiki-trunk';
 */
$wgLocalisationUpdateSVNURL = "http://svn.wikimedia.org/svnroot/mediawiki/trunk";

$wgLocalisationUpdateRetryAttempts = 5;

/**
 * If you want to share LocalisationUpdate info between multiple wikis,
 * you can have them reference a central copy of the tables in a given
 * database. Must be accessible via the main database connection.
 *
 * Note that if your wikis have different extensions enabled, you may
 * wish to pass the --all option to LocalisationUpdate/update.php so it
 * pulls updates for all extensions present in the source tree instead
 * of just the ones you have enabled on the wiki you run it from.
 */
$wgLocalisationUpdateDatabase = false;

// Info about me!
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'LocalisationUpdate',
	'author'         => array( 'Tom Maaswinkel', 'Niklas Laxström' ),
	'version'        => '0.2',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:LocalisationUpdate',
	'description'    => 'Keeps the localised messages as up to date as possible',
	'descriptionmsg' => 'localisationupdate-desc',
);

// Use the right hook
$wgHooks['MessageNotInMwNs'][] = 'LocalisationUpdate::FindUpdatedMessage'; // MW <= 1.15
$wgHooks['LocalisationCacheRecache'][] = 'LocalisationUpdate::onRecache'; // MW 1.16+

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['LocalisationUpdate'] = $dir . 'LocalisationUpdate.i18n.php';
$wgAutoloadClasses['LocalisationUpdate'] = $dir . 'LocalisationUpdate.class.php';
$wgAutoloadClasses['LUDependency'] = $dir . 'LocalisationUpdate.class.php';
$wgAutoloadClasses['QuickArrayReader'] = $dir . 'QuickArrayReader.php';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'LocalisationUpdate::schemaUpdates';
$wgHooks['ParserTestTables'][] = 'LocalisationUpdate::parserTestTables';
