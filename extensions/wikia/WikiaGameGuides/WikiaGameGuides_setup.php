<?php
/**
 * Wikia Game Guides mobile app modules
 *
 * @file
 * @ingroup Extensions
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @date 2010-11-15
 * @version 1.0
 * @copyright Copyright © 2010 Federico "Lox" Lucignano, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named WikiaGameGuides.\n";
	exit ( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaGameGuides',
	'version' => '1.0',
	'author' => array(
		'Federico "Lox" Lucignano'
	),
	'descriptionmsg' => 'wikiagameguides-desc'
);

$dir = dirname( __FILE__ ) . '/';

// classes
$wgAutoloadClasses[ 'WikiaGameGuidesWrongAPIVersionException' ] = "{$dir}exceptions/WikiaGameGuidesWrongAPIVersionException.class.php";
$wgAutoloadClasses[ 'WikiaGameGuidesWikisModel' ] = "{$dir}models/WikiaGameGuidesWikisModel.class.php";

// i18n
$wgExtensionMessagesFiles[ 'WikiaGameGuides' ] = "{$dir}WikiaGameGuides.i18n.php";

//EzAPI modules
wfRegisterEzApiModule( 'WikiaGameGuidesEzApiModule', "{$dir}ezapi/WikiaGameGuidesEzApiModule.class.php" );