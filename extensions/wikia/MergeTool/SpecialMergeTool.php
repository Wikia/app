<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named MergeTool.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "MergeTool",
    "description" => "Merge namespaces, databases",
    "author" => "Krzysztof Krzyżaniak (eloy) <eloy@wikia.com>"
);

#--- messages file
require_once( dirname(__FILE__) . '/SpecialMergeTool.i18n.php' );
#--- helper file
// require_once( dirname(__FILE__) . '/SpecialWikiFactory_helper.php' );



#--- register special page (MW 1.10 way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}
extAddSpecialPage( dirname(__FILE__) . '/SpecialMergeTool_body.php', 'MergeTool', 'MergeToolPage', true );

?>
