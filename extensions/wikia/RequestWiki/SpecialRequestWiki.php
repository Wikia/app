<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: SpecialRequestWiki.php 12549 2008-05-09 15:51:55Z emil $
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named RequestWiki.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
	"name" => "RequestWiki",
	"description" => "Request Wiki for creation",
	"version" => preg_replace( '/^.* (\d\d\d\d-\d\d-\d\d).*$/', '\1', '$Id: SpecialRequestWiki.php 12549 2008-05-09 15:51:55Z emil $' ),
	"author" => "[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)], [http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]"
);


/**
 * messages file
 */
$wgExtensionMessagesFiles["RequestWiki"] = dirname(__FILE__) . "/SpecialRequestWiki.i18n.php";

#--- helper file
require_once( dirname(__FILE__) . '/SpecialRequestWiki_helper.php' );


#--- permissions
$wgAvailableRights[] = 'requestwiki';
$wgGroupPermissions['*']['requestwiki'] = true;

#--- register special page (MW 1.10 way)
if( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}
extAddSpecialPage( dirname(__FILE__) . '/SpecialRequestWiki_body.php', 'RequestWiki', 'RequestWikiPage' );
$wgSpecialPageGroups['RequestWiki'] = 'wikia';
