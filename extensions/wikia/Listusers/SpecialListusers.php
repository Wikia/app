<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named Listusers.\n";
    exit( 1 ) ;
}
$wgExtensionCredits['specialpage'][] = array(
    "name" => "Local users",
    "description" => "Special list users",
    "author" => "Piotr Molski"
);

$wgExtensionMessagesFiles["Listusers"] = dirname(__FILE__) . '/SpecialListusers.i18n.php';

$wgAvailableRights[] = 'listusers';
#$wgGroupPermissions['staff']['listusers'] = true;
#$wgGroupPermissions['sysop']['listusers'] = true;

$wgSpecialPageGroups['Listusers'] = 'users';

#--- helper file
require_once( dirname(__FILE__) . '/SpecialListusers_helper.php' );

#--- hooks file
require_once( dirname(__FILE__) . '/SpecialListusers_ajax.php' );
global $wgAjaxExportList;
$wgAjaxExportList[] = "ListusersAjax::axShowUsers";

#--- hooks file
require_once( dirname(__FILE__) . '/SpecialListusers_hooks.php' );
$wgHooks['SpecialPage_initList'][]	= 'ListusersHooks::Activeusers';
$wgHooks['UserRights'][] 			= 'ListusersHooks::updateUserRights';

extAddSpecialPage( dirname(__FILE__) . '/SpecialListusers_body.php', 'Listusers', 'Listusers' );
