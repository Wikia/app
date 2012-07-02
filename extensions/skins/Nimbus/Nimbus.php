<?php
/**
 * Nimbus skin
 *
 * @file
 * @ingroup Skins
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Inez Korczyński <korczynski@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @copyright Copyright © 2008-2011 Aaron Wright, David Pean, Inez Korczyński, Jack Phoenix
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @date September 4, 2011
 *
 * To install place the Nimbus folder (the folder containing this file!) into
 * skins/ and add this line to your wiki's LocalSettings.php:
 * require_once("$IP/skins/Nimbus/Nimbus.php");
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not a valid entry point.' );
}

// Skin credits that will show up on Special:Version
$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Nimbus',
	'version' => '2.0',
	'author' => array( 'Aaron Wright', 'David Pean', 'Inez Korczyński', 'Jack Phoenix' ),
	'descriptionmsg' => 'nimbus-desc',
	'url' => 'http://www.mediawiki.org/wiki/Nimbus_skin',
);

// Autoload the skin class, make it a valid skin, set up i18n, set up CSS & JS
// (via ResourceLoader)
$skinID = basename( dirname( __FILE__ ) );
$dir = dirname( __FILE__ ) . '/';

// The first instance must be strtolower()ed so that useskin=nimbus works and
// so that it does *not* force an initial capital (i.e. we do NOT want
// useskin=Nimbus) and the second instance is used to determine the name of
// *this* file.
$wgValidSkinNames[strtolower( $skinID )] = 'Nimbus';

$wgAutoloadClasses['SkinNimbus'] = $dir . 'Nimbus.skin.php';
$wgExtensionMessagesFiles['SkinNimbus'] = $dir . 'Nimbus.i18n.php';
$wgResourceModules['skins.nimbus'] = array(
	'styles' => array( 'skins/Nimbus/nimbus/Nimbus.css' => array( 'media' => 'screen' ) ),
	'scripts' => 'skins/Nimbus/nimbus/Menu.js',
	'position' => 'top'
);