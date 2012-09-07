<?php
/**
 * @addtogroup SpecialPage
 *
 * @author Piotr Molski <moli@wikia.com>
 * @copyright Copyright © 2008, Piotr Molski
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * implements Special:MostPopularCategories
 * @addtogroup SpecialPage
 */


if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named MostPopularCategories.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "MostPopularCategories",
    "description" => "Get list of most popular categories",
    "author" => "Moli <moli at wikia.com>"
);

$wgHooks['wgQueryPages'][] = 'wfSetupMostPopularCategories';
$wgExtensionFunctions[] = 'wfSetupMostPopularCategories';
#--- messages file
$wgExtensionMessagesFiles["Mostpopularcategories"] = dirname(__FILE__) . '/SpecialMostPopularCategories.i18n.php';

// aliases
$wgExtensionMessagesFiles['MostpopularcategoriesAliases'] = __DIR__ . '/SpecialMostPopularCategories.aliases.php';

if ( !function_exists( 'extAddSpecialPage' ) ) {
    require_once( "$IP/extensions/ExtensionFunctions.php" );
}
extAddSpecialPage( dirname(__FILE__) . '/SpecialMostPopularCategories_body.php', 'Mostpopularcategories', 'MostpopularcategoriesSpecialPage' );

$wgSpecialPageGroups['Mostpopularcategories'] = 'highuse';

// macbre: fix fatal when accessing this special page via API
$wgAutoloadClasses['MostpopularcategoriesPage'] = dirname(__FILE__) . '/SpecialMostPopularCategories_body.php';

function wfSetupMostPopularCategories( &$queryPages = array() ) {
    $queryPages[] = array( 'MostpopularcategoriesPage', 'Mostpopularcategories');
    return true;
}
