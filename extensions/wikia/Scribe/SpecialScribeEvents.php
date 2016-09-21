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
    'name' => 'Multi-Title Finder',
    'author' => "Moli <moli at wikia.com>",
    'descriptionmsg' => 'scribe-desc',
);

#--- messages file
$wgExtensionMessagesFiles["Scribeevents"] = dirname(__FILE__) . '/SpecialScribeEvents.i18n.php';
$wgExtensionMessagesFiles['ScribeeventsAliases'] = __DIR__ . '/SpecialScribeEvents.aliases.php';

if ( !function_exists( 'extAddSpecialPage' ) ) {
    require_once ( "$IP/extensions/ExtensionFunctions.php" );
}

extAddSpecialPage( dirname(__FILE__) . '/SpecialScribeEvents_body.php', 'Scribeevents', 'ScribeeventsSpecialPage' );

$wgSpecialPageGroups['Scribeevents'] = 'pagetools';
