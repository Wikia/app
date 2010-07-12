<?php
/**
 * @addtogroup SpecialPage
 *
 * @author Piotr Molski <moli@wikia.com>
 * @copyright Copyright © 2008, Piotr Molski
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * implements Special:MultiWikiFinder
 * @addtogroup SpecialPage
 */


if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named Multi-Title Finder.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "Multi-Title Finder",
    "description" => "Staff tool to search for a specific title across Wikia ",
    "author" => "Moli <moli at wikia.com>"
);

#--- messages file
$wgExtensionMessagesFiles["Multiwikifinder"] = dirname(__FILE__) . '/MultiTasks.i18n.php';

$wgAvailableRights[] = 'multiwikifinder';
$wgGroupPermissions['staff']['multiwikifinder'] = true;
$wgGroupPermissions['helper']['multiwikifinder'] = true;
$wgGroupPermissions['vstf']['multiwikifinder'] = true;

if ( !function_exists( 'extAddSpecialPage' ) ) {
    require_once ( "$IP/extensions/ExtensionFunctions.php" );
}

extAddSpecialPage( dirname(__FILE__) . '/SpecialMultiWikiFinder_body.php', 'Multiwikifinder', 'MultiwikifinderSpecialPage' );

$wgSpecialPageGroups['Multiwikifinder'] = 'pagetools';
