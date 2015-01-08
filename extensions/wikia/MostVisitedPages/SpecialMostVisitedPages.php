<?php
/**
 * @addtogroup SpecialPage
 *
 * @author Piotr Molski <moli@wikia.com>
 * @copyright Copyright © 2008, Piotr Molski
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * implements Special:MostVisitedPages
 * @addtogroup SpecialPage
 */


if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named MostVisitedPages.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "MostVisitedPages",
    "descriptionmsg" => "mostvisitedpages-desc",
    "author" => "Moli <moli at wikia.com>",
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/MostVisitedPages'
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['MostvisitedpagesPage']  = $dir . 'SpecialMostVisitedPages_body.php';

#--- messages file
$wgExtensionMessagesFiles["Mostvisitedpages"] = $dir . 'SpecialMostVisitedPages.i18n.php';

if ( !function_exists( 'extAddSpecialPage' ) ) {
    require_once ( "$IP/extensions/ExtensionFunctions.php" );
}

extAddSpecialPage( dirname(__FILE__) . '/SpecialMostVisitedPages_body.php', 'Mostvisitedpages', 'MostvisitedpagesSpecialPage' );

$wgSpecialPageGroups['Mostvisitedpages'] = 'highuse';

