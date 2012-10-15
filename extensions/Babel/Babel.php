<?php

/**
 * Babel Extension
 *
 * Adds a parser function to allow automated generation of a babel userbox
 * column with the ability to include custom templates.
 *
 * @file
 * @ingroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Babel
 *
 * @author Robert Leverington <robert@rhl.me.uk>
 * @copyright Copyright © 2008 - 2011 Robert Leverington.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) die( 'Invalid entry point.' );

$wgExtensionCredits['parserhook'][] = array(
	'path'            => __FILE__,
	'name'            => 'Babel',
	'version'         => '1.7.4',
	'author'          => 'Robert Leverington',
	'url'             => 'https://www.mediawiki.org/wiki/Extension:Babel',
	'descriptionmsg'  => 'babel-desc',
);

$wgHooks['ParserFirstCallInit'][] = 'BabelStatic::Setup';
$wgHooks['AbortNewAccount'][]     = 'BabelAutoCreate::RegisterAbort';

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['Babel']      = $dir . 'Babel.i18n.php';
$wgExtensionMessagesFiles['BabelMagic'] = $dir . 'Babel.i18n.magic.php';

$wgAutoloadClasses['Babel']              = $dir . 'Babel.class.php';
$wgAutoloadClasses['BabelLanguageCodes'] = $dir . 'BabelLanguageCodes.class.php';
$wgAutoloadClasses['BabelStatic']        = $dir . 'BabelStatic.class.php';
$wgAutoloadClasses['BabelAutoCreate']    = $dir . 'BabelAutoCreate.class.php';

$wgResourceModules['ext.babel'] = array(
	'styles' => 'Babel.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'Babel',
);

// Configuration setttings.
// Language names and codes constant database files, the defaults should suffice.
$wgBabelLanguageCodesCdb     = $dir . 'codes.cdb';
$wgBabelLanguageNamesCdb     = $dir . 'names.cdb';
// Array of possible levels, and their category name - variables: %code% %wikiname% %nativename%
// Set to false to disable categories for a particular level.
// Alphabetical levels should be in upper case.
$wgBabelCategoryNames = array(
	'0' => '%code%-0',
	'1' => '%code%-1',
	'2' => '%code%-2',
	'3' => '%code%-3',
	'4' => '%code%-4',
	'5' => '%code%-5',
	'N' => '%code%-N'
);
// Category name for the main (non-level) category of each language.
// Set to false to disable main category.
$wgBabelMainCategory = '%code%';
// Default level.
$wgBabelDefaultLevel = 'N';
// Use the viewing user's language for babel box header's and footer's
// May fragment parser cache, but otherwise shouldn't cause problems
$wgBabelUseUserLanguage = false;
// A boolean (true or false) indicating whether ISO 639-3 codes should be preferred over ISO 639-1 codes.
$wgBabelPreferISO639_3 = false; // Not yet used.

/* Other settings, to be made in-wiki:
MediaWiki:Babel-template
    The name format of template names used in the babel extension.
MediaWiki:Babel-portal
    The name format of the portal link for each language.
*/
