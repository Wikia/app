<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007-2009, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: SpecialTaskManager.php 5982 2007-10-02 14:07:24Z eloy $
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

$sSpecialPage = "TaskManager";
$wgExtensionCredits['specialpage'][] = array(
	"name" => $sSpecialPage,
	"descriptionmsg" => "taskmanager-desc",
	"author" => "Krzysztof Krzyżaniak (eloy)",
	"url" => "https://github.com/Wikia/app/tree/dev/extensions/wikia/TaskManager"
);

$dir = __DIR__;

/**
 * add all task which should be visible here
 */
require_once( $dir . "/BatchTask.php" );
extAddBatchTask( $dir."/Tasks/PageImporterTask.php", "pageimporter", "PageImporterTask" );
extAddBatchTask( $dir."/Tasks/SWMSendToGroupTask.php", "SWMSendToGroup", "SWMSendToGroupTask" );
extAddBatchTask( $dir."/Tasks/LocalMaintenanceTask.php", "local-maintenance", "LocalMaintenanceTask" );
extAddBatchTask( $dir ."/Tasks/UpdateSpecialPagesTask.php", "update_special_pages", "UpdateSpecialPagesTask" );

/**
 * message file
 */
$wgExtensionMessagesFiles[ $sSpecialPage ] = $dir . "/Special{$sSpecialPage}.i18n.php";

/**
 * aliases file
 */
$wgExtensionMessagesFiles[ $sSpecialPage . 'Aliases' ] = $dir . "/Special{$sSpecialPage}.aliases.php";

extAddSpecialPage( $dir . "/Special{$sSpecialPage}_body.php", $sSpecialPage, "{$sSpecialPage}Page" );
$wgSpecialPageGroups[$sSpecialPage] = 'wikia';

/**
 * hooks
 */
$wgAutoloadClasses['TaskManagerHooks'] = $dir . '/hooks/TaskManagerHooks.class.php';
$wgHooks['APIQuerySiteInfoStatistics'][] = 'TaskManagerHooks::onAPIQuerySiteInfoStatistics';
