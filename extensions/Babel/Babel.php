<?php

/**
 * Babel Extension
 *
 * Adds a parser function to allow automated generation of a babel userbox
 * column with the ability to include custom templates.
 *
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Babel
 *
 * @author Robert Leverington <minuteelectron@googlemail.com>
 * @copyright Copyright © 2008 - 2009 Robert Leverington.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// Ensure accessed via a valid entry point.
if( !defined( 'MEDIAWIKI' ) ) die( 'Invalid entry point.' );

// Register extension credits.
$wgExtensionCredits[ 'parserhook' ][] = array(
	'name'            => 'Babel',
	'version'         => '1.2.3',
	'author'          => 'Robert Leverington',
	'url'             => 'http://www.mediawiki.org/wiki/Extension:Babel',
	'description'     => 'Adds a parser function to allow automated generation of a babel userbox column with the ability to include custom templates.',
	'descriptionmsg'  => 'babel-desc',
);

// Register setup function.
if( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks[ 'ParserFirstCallInit' ][] = 'BabelStatic::Setup';
} else {
	$wgExtensionFunctions[] = 'BabelStatic::Setup';
}

// Register required hooks.
$wgHooks[ 'LanguageGetMagic' ][] = 'BabelStatic::Magic';
$wgHooks[ 'AbortNewAccount'  ][] = 'BabelAutoCreate::RegisterAbort';

$dir = dirname( __FILE__ );

// Register internationalisation file.
$wgExtensionMessagesFiles[ 'Babel' ] = $dir . '/Babel.i18n.php';

// Register autoload classes.
$wgAutoloadClasses[ 'Babel'              ] = $dir . '/Babel.class.php';
$wgAutoloadClasses[ 'BabelLanguageCodes' ] = $dir . '/BabelLanguageCodes.class.php';
$wgAutoloadClasses[ 'BabelStatic'        ] = $dir . '/BabelStatic.class.php';
$wgAutoloadClasses[ 'BabelAutoCreate'    ] = $dir . '/BabelAutoCreate.class.php';

// Configuration setttings.
$wgBabelUseLevelZeroCategory = false;
$wgBabelUseSimpleCategories  = false;
$wgBabelUseMainCategories    = true;
$wgBabelLanguageCodesFile    = $dir . '/codes.txt';
$wgBabelCachePrefix          = 'babel';
