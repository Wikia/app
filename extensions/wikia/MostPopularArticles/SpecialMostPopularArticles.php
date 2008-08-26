<?php
/**
 * @addtogroup SpecialPage
 *
 * @author Piotr Molski <moli@wikia.com>
 * @copyright Copyright © 2008, Piotr Molski
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * implements Special:MostPopularArticles
 * @addtogroup SpecialPage
 */


if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named WikiFactory.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "MostPopularArticles",
    "description" => "Get list of most popular articles",
    "author" => "Moli <moli at wikia.com>"
);

$wgHooks['wgQueryPages'][] = 'wfSetupMostPopularArticles';
$wgExtensionFunctions[] = 'wfSetupMostPopularArticles';
#--- messages file
$wgExtensionMessagesFiles["Mostpopulararticles"] = dirname(__FILE__) . '/SpecialMostPopularArticles.i18n.php';

if ( !function_exists( 'extAddSpecialPage' ) ) {
    require_once ( "$IP/extensions/ExtensionFunctions.php" );
}

extAddSpecialPage( dirname(__FILE__) . '/SpecialMostPopularArticles_body.php', 'Mostpopulararticles', 'MostpopulararticlesSpecialPage' );


function wfSetupMostPopularArticles( $queryPages = array() ) {
    $queryPages[] = array( 'MostpopulararticlesPage', 'Mostpopulararticles');
    return true;
}

if (!function_exists('wfGetMostPopularArticlesFromCache')) {
    function wfGetMostPopularArticlesFromCache($limit, $offset) {
        $class = new MostpopulararticlesSpecialPage();
        $class->execute($limit, $offset, false);
        $data = $class->getResult();

        return $data;
    }
}
