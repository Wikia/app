<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: SpecialWikiFactory.php 11926 2008-04-23 13:58:29Z eloy $
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named WikiFactory.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "WikiFactory",
    "description" => "Store MediaWiki settings in database",
	"version" => preg_replace( '/^.* (\d\d\d\d-\d\d-\d\d).*$/', '\1', '$Id: SpecialWikiFactory.php 11926 2008-04-23 13:58:29Z eloy $' ),
    "author" => "[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)]"
);

/**
 * messages file
 */
$wgExtensionMessagesFiles["WikiFactory"] = dirname(__FILE__) . '/SpecialWikiFactory.i18n.php';

/**
 * helper file
 */
require_once( dirname(__FILE__) . '/SpecialWikiFactory_ajax.php' );


/**
 * permissions
 */
$wgAvailableRights[] = 'wikifactory';
$wgGroupPermissions['staff']['wikifactory'] = true;
$wgGroupPermissions['wikifactory']['wikifactory'] = true;

extAddSpecialPage( dirname(__FILE__) . '/SpecialWikiFactory_body.php', 'WikiFactory', 'WikiFactoryPage' );
$wgSpecialPageGroups['WikiFactory'] = 'wikia';
