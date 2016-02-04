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
    "descriptionms" => "newwikis-desc",
    "author" => "Moli <moli at wikia.com>",
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialNewWikis'
);

#--- messages file
$wgExtensionMessagesFiles["Newwikis"] = __DIR__ . '/SpecialNewWikis.i18n.php';

#--- special pages
$wgSpecialPageGroups['Newwikis'] = 'highuse';
$wgSpecialPages['Newwikis'] = 'NewWikisSpecialPage';

#--- classes autoloading
$wgAutoloadClasses['NewWikisSpecialPage'] = __DIR__ . '/SpecialNewWikis_body.php';
$wgAutoloadClasses['NewWikisPage'       ] = __DIR__ . '/SpecialNewWikis_body.php';
