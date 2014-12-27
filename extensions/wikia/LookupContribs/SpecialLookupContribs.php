<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Bartek Lapinski <bartek@wikia.com>, Piotr Molski <moli@wikia.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named LookupContribs.\n";
    exit( 1 ) ;
}
$wgExtensionCredits['specialpage'][] = array(
    "name" => "LookupContribs",
    "descriptionmsg" => "lookupcontribs-desc",
    "author" => array( "Bartek Lapinski", "Piotr Molski" ),
	"url" => "https://github.com/Wikia/app/tree/dev/extensions/wikia/LookupContribs",
);
define( "LC_TEST", 0 );
define( "LC_LIMIT", 25 );
$wgExtensionMessagesFiles["SpecialLookupContribs"] = dirname( __FILE__ ) . '/SpecialLookupContribs.i18n.php';
require_once( dirname( __FILE__ ) . '/SpecialLookupContribs_helper.php' );
require_once( dirname( __FILE__ ) . '/SpecialLookupContribs_hooks.php' );
require_once( dirname( __FILE__ ) . '/SpecialLookupContribs_ajax.php' );

global $wgAjaxExportList;
$wgAjaxExportList[] = "LookupContribsAjax::axData";

$wgAvailableRights[] = 'lookupcontribs';
$wgGroupPermissions['staff']['lookupcontribs'] = true;

extAddSpecialPage( dirname( __FILE__ ) . '/SpecialLookupContribs_body.php', 'LookupContribs', 'LookupContribsPage' );
$wgSpecialPageGroups['LookupContribs'] = 'users';
