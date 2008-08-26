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
    echo "This is MediaWiki extension named WikiFactory.\n";
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

if ( !function_exists( 'extAddSpecialPage' ) ) {
    require_once( "$IP/extensions/ExtensionFunctions.php" );
}
extAddSpecialPage( dirname(__FILE__) . '/SpecialMostPopularCategories_body.php', 'Mostpopularcategories', 'MostpopularcategoriesSpecialPage' );

function wfSetupMostPopularCategories( $queryPages = array() ) {
    $queryPages[] = array( 'MostpopularcategoriesPage', 'Mostpopularcategories');
    return true;
}

if (!function_exists('wfGetMostPopularCategoriesFromCache')) {
    function wfGetMostPopularCategoriesFromCache($limit, $offset) {
        $class = new MostpopularcategoriesSpecialPage();
        $class->execute($limit, $offset, false);
        $data = $class->getResult();
        
        return $data;
    }
}
