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

$dir = dirname(__FILE__);

#--- helper file
include( $dir . '/SpecialListusers_helper.php' );

#--- hooks file
include( $dir . '/SpecialListusers_ajax.php' );
global $wgAjaxExportList;
$wgAjaxExportList[] = "ListusersAjax::axShowUsers";

#--- hooks file
include( $dir . '/SpecialListusers_hooks.php' );
$wgHooks['SpecialPage_initList'][]	= 'ListusersHooks::Activeusers';
if( empty($wgDevelEnvironment) ){ // This tries to write to a database that the devboxes don't have write-permission for.
	$wgHooks['UserRights'][] 			= 'ListusersHooks::updateUserRights';
}

extAddSpecialPage( $dir . '/SpecialListusers_body.php', 'Listusers', 'Listusers' );
