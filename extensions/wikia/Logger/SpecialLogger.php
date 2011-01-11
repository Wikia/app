<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named Logger.\n";
    exit( 1 ) ;
}
$wgExtensionCredits['specialpage'][] = array(
    "name" => "Logger",
    'descriptionmsg' => 'logger-desc',
    "author" => "Piotr Molski"
);

$wgExtensionMessagesFiles["Logger"] = dirname(__FILE__) . '/SpecialLogger.i18n.php';

$wgAvailableRights[] = 'logger';
$wgGroupPermissions['staff']['logger'] = true;

extAddSpecialPage( dirname(__FILE__) . '/SpecialLogger_body.php', 'Logger', 'LoggerPage' );
$wgSpecialPageGroups['Logger'] = 'maintenance';
