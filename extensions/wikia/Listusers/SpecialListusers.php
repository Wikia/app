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

extAddSpecialPage( dirname(__FILE__) . '/SpecialListusers_body.php', 'Listusers', 'Listusers' );
$wgSpecialPageGroups['Listusers'] = 'users';

global $wgAjaxExportList;
$wgAjaxExportList[] = "Listusers::axShowUsers";

$wgHooks['SpecialPage_initList'][] = 'Listusers::Activeusers';
$wgHooks['UserRights'][] = "Listusers::updateUserRights";
