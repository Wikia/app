<?php

/**
 * lazy loader for Special:Our404Handler
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "Our404Handler",
    "description" => "Our 404 handler for making thumbs and other magic",
    "author" => "[http://inside.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyźaniak (eloy)]"
);

#--- messages file
$wgExtensionMessagesFiles["Our404Handler"] = dirname(__FILE__) . '/SpecialOur404Handler.i18n.php';

#--- register special page (MW 1.10 way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}
extAddSpecialPage( dirname(__FILE__) . '/SpecialOur404Handler_body.php', 'Our404Handler', 'Our404HandlerPage' );
