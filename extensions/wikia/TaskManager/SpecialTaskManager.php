<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
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
    "description" => "Display and manage background tasks",
    "url" => "http://www.wikia.com/",
    "author" => "Krzysztof Krzyżaniak (eloy)"
);

#--- base class for BatchTask
#--- add all task which should be visible here
require_once( dirname(__FILE__) . "/BatchTask.php" );
extAddBatchTask( dirname(__FILE__)."/Tasks/CloseWikiTask.php", "closewiki", "CloseWikiTask" );
extAddBatchTask( dirname(__FILE__)."/Tasks/MultiDeleteTask.php", "multidelete", "MultiDeleteTask" );
extAddBatchTask( dirname(__FILE__)."/Tasks/MultiWikiEditTask.php", "multiwikiedit", "MultiWikiEditTask" );
extAddBatchTask( dirname(__FILE__)."/Tasks/MultiRestoreTask.php", "multirestore", "MultiRestoreTask" );
extAddBatchTask( dirname(__FILE__)."/Tasks/ImageGrabberTask.php", "imagegrabber", "ImageGrabberTask" );
extAddBatchTask( dirname(__FILE__)."/Tasks/ImageImporterTask.php", "imageimporter", "ImageImporterTask" );
extAddBatchTask( dirname(__FILE__)."/Tasks/PageGrabberTask.php", "pagegrabber", "PageGrabberTask" );
extAddBatchTask( dirname(__FILE__)."/Tasks/PageGrabberDumpTask.php", "pagegrabberdump", "PageGrabberDumpTask" );
extAddBatchTask( dirname(__FILE__)."/Tasks/PageImporterTask.php", "pageimporter", "PageImporterTask" );
extAddBatchTask( dirname(__FILE__)."/Tasks/CreateWikiTask.php", "createwiki", "CreateWikiTask" );
extAddBatchTask( dirname(__FILE__)."/Tasks/SWMSendToGroupTask.php", "SWMSendToGroup", "SWMSendToGroupTask" );


#--- permissions
$wgAvailableRights[] = 'wikifactory';
$wgGroupPermissions['staff']['wikifactory'] = true;

/**
 * message file
 */
$wgExtensionMessagesFiles[ $sSpecialPage ] = dirname(__FILE__) . "/Special{$sSpecialPage}.i18n.php";

extAddSpecialPage( dirname(__FILE__) . "/Special{$sSpecialPage}_body.php", $sSpecialPage, "{$sSpecialPage}Page" );
$wgSpecialPageGroups[$sSpecialPage] = 'wiki';
