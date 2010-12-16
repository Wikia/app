<?php
/*
KNOWN ISSUES:
- Only works with SVN revision 50605 or later of the
  Mediawiki core
- Requires file cache (see $wgLocalisationUpdateDirectory)
*/

// Configuration

/**
 * Directory to store serialized cache files in. Defaults to $wgCacheDirectory.
 * It's OK to share this directory among wikis as long as the wiki you run
 * update.php on has all extensions the other wikis using the same directory 
 * have.
 * NOTE: If this variable and $wgCacheDirectory are both false, this extension
 *       WILL NOT WORK.
 */
$wgLocalisationUpdateDirectory = false;


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


// Info about me!
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'LocalisationUpdate',
	'author'         => array( 'Tom Maaswinkel', 'Niklas Laxström', 'Roan Kattouw' ),
	'version'        => '0.3',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:LocalisationUpdate',
	'description'    => 'Keeps the localised messages as up to date as possible',
	'descriptionmsg' => 'localisationupdate-desc',
);

$wgHooks['LocalisationCacheRecache'][] = 'LocalisationUpdate::onRecache';

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['LocalisationUpdate'] = $dir . 'LocalisationUpdate.i18n.php';
$wgAutoloadClasses['LocalisationUpdate'] = $dir . 'LocalisationUpdate.class.php';
$wgAutoloadClasses['QuickArrayReader'] = $dir . 'QuickArrayReader.php';
