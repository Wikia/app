<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named WikiEvents.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "WikiEvents",
    "description" => "Set system's events in database",
    "author" => "Piotr Molski (moli) <moli@wikia.com>"
);

#--- messages file
require_once( dirname(__FILE__) . '/SpecialWikiaEvents.i18n.php' );

#--- permissions
$wgAvailableRights[] = 'systemevents';
$wgGroupPermissions['staff']['systemevents'] = true;

#--- register special page (MW 1.10 way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}
extAddSpecialPage( dirname(__FILE__) . '/SpecialWikiaEvents_body.php', 'WikiEvents', 'WikiaEventsPage' );

?>
