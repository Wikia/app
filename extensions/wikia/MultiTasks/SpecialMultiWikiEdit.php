<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Bartek Lapinski for Wikia.com
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named MultiWikiEdit.\n";
    exit( 1 ) ;
}

require_once ( dirname(__FILE__) . '/MultiTasksCore.php' );

$wgExtensionCredits['specialpage'][] = array(
    "name" => "Multi Wiki Edit",
    "description" => "Special Multi Wiki Edit",
    "author" => "Bartek Łapiński, Piotr Molski"
);

$wgExtensionMessagesFiles["Multiwikiedit"] = dirname(__FILE__) . '/MultiTasks.i18n.php';
$wgExtensionMessagesFiles['MultiwikieditAliases'] = __DIR__ . '/MultiTasks.aliases.php';

$wgAvailableRights[] = 'multiwikiedit';
$wgGroupPermissions['staff']['multiwikiedit'] = true;
$wgGroupPermissions['helper']['multiwikiedit'] = true;

require_once( $IP . "/extensions/wikia/TaskManager/BatchTask.php" );
extAddBatchTask( dirname(__FILE__)."/Tasks/MultiWikiEditTask.php", "multiwikiedit", "MultiWikiEditTask" );

extAddSpecialPage( dirname(__FILE__) . '/SpecialMultiWikiEdit_body.php', 'Multiwikiedit', 'Multiwikiedit' );
$wgSpecialPageGroups['Multiwikiedit'] = 'pagetools';
