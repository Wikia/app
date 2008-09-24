<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "AvatarRemove",
    "description" => "Remove User's avatars",
    "author" => "Piotr Molski (moli) <moli@wikia.com>"
);

#--- messages file
require_once( dirname(__FILE__) . '/SpecialWikiaAvatar.i18n.php' );

#--- helper file (for example for WikiaAvatar Class
require_once( dirname(__FILE__) . '/SpecialWikiaAvatar_helper.php' );

#--- register special page (MW 1.10 way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}

#--- permissions
$wgAvailableRights[] = 'avatarremove';
$wgGroupPermissions['staff']['avatarremove'] = true;
$wgGroupPermissions['sysop']['avatarremove'] = true;
extAddSpecialPage( dirname(__FILE__) . '/SpecialWikiaAvatar_body.php', 'AvatarRemove', 'WikiaAvatarRemovePage' );
$wgSpecialPageGroups['AvatarRemove'] = 'users';
