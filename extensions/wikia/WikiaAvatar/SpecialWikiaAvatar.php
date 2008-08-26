<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzy¿aniak <eloy@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "AvatarUpload",
    "description" => "Handle uploading and showing Avatars",
    "author" => "Krzysztof Krzyżaniak (eloy) <eloy@wikia.com>"
);

#--- messages file
require_once( dirname(__FILE__) . '/SpecialWikiaAvatar.i18n.php' );

#--- helper file (for example for WikiaAvatar Class
require_once( dirname(__FILE__) . '/SpecialWikiaAvatar_helper.php' );

#--- register special page (MW 1.10 way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}

extAddSpecialPage( dirname(__FILE__) . '/SpecialWikiaAvatar_body.php', 'AvatarUpload', 'WikiaAvatarUploadPage' );

?>
