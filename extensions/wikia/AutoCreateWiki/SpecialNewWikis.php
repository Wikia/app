<?php

/**
 * @addtogroup SpecialPage
 *
 * @author Piotr Molski <moli@wikia.com>
 * @copyright Copyright © 2009, Piotr Molski
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * implements Special:NewWikis
 * @addtogroup SpecialPage
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named NewWikis.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "NewWikis",
    "description" => "Get list of the newest Wikis",
    "author" => "Moli <moli at wikia.com>"
);

$wgHooks['wgQueryPages'][] = 'wfSetupNewWikis';

#--- messages file
$wgExtensionMessagesFiles["Newwikis"] = dirname(__FILE__) . '/AutoCreateWiki.i18n.php';

if ( !function_exists( 'extAddSpecialPage' ) ) {
    require_once ( "$IP/extensions/ExtensionFunctions.php" );
}

extAddSpecialPage( dirname(__FILE__) . '/SpecialNewWikis_body.php', 'Newwikis', 'NewWikisSpecialPage' );

$wgSpecialPageGroups['Newwikis'] = 'highuse';

$wgAvailableRights[] = 'newwikislist';
$wgGroupPermissions['*']['newwikislist'] = false;
$wgGroupPermissions['staff']['newwikislist'] = true;

/**
 * @param array $queryPages
 * @return bool
 */
function wfSetupNewWikis( &$queryPages ) {
    $queryPages[] = array( 'NewWikisPage', 'Newwikis');
    return true;
}
