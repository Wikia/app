<?php
/**
 * @addtogroup SpecialPage
 *
 * @author Piotr Molski <moli@wikia.com>
 * @copyright Copyright © 2008, Piotr Molski
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * implements Special:ScribeEvents
 * @addtogroup SpecialPage
 */


if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named ScribeEvents.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "Multi-Title Finder",
    "description" => "Staff tool to search for a specific title across Wikia ",
    "author" => "Moli <moli at wikia.com>"
);

#--- messages file
$wgExtensionMessagesFiles["Scribeevents"] = dirname(__FILE__) . '/SpecialScribeEvents.i18n.php';

$permname = "scribeevents";
$wgAvailableRights[] = $permname;
$wgGroupPermissions['staff'][$permname] = true;
$wgGroupPermissions['helper'][$permname] = true;
$wgGroupPermissions['vstf'][$permname] = true;

if ( !function_exists( 'extAddSpecialPage' ) ) {
    require_once ( "$IP/extensions/ExtensionFunctions.php" );
}

extAddSpecialPage( dirname(__FILE__) . '/SpecialScribeEvents_body.php', 'Scribeevents', 'ScribeeventsSpecialPage' );

$wgSpecialPageGroups['Scribeevents'] = 'pagetools';
