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
    "descriptionmsg" => "multiwikifinder-desc",
    "author" => "Moli <moli at wikia.com>",
    "url" => "https://github.com/Wikia/app/tree/dev/extensions/wikia/MultiTasks"
);

#--- messages file
$wgExtensionMessagesFiles["Multiwikifinder"] = dirname(__FILE__) . '/MultiTasks.i18n.php';
$wgExtensionMessagesFiles['MultiwikifinderAliases'] = __DIR__ . '/MultiTasks.aliases.php';

if ( !function_exists( 'extAddSpecialPage' ) ) {
    require_once ( "$IP/extensions/ExtensionFunctions.php" );
}

extAddSpecialPage( dirname(__FILE__) . '/SpecialMultiWikiFinder_body.php', 'Multiwikifinder', 'MultiwikifinderSpecialPage' );

$wgSpecialPageGroups['Multiwikifinder'] = 'pagetools';
