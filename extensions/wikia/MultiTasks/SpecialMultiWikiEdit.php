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
    "descriptionmsg" => "multiwikiedit-desc",
    "author" => "Bartek Łapiński, Piotr Molski",
	"url" => "https://github.com/Wikia/app/tree/dev/extensions/wikia/MultiTasks"
);

$wgExtensionMessagesFiles["Multiwikiedit"] = dirname(__FILE__) . '/MultiTasks.i18n.php';
$wgExtensionMessagesFiles['MultiwikieditAliases'] = __DIR__ . '/MultiTasks.aliases.php';

require_once( $IP . "/extensions/wikia/TaskManager/BatchTask.php" );

extAddSpecialPage( dirname(__FILE__) . '/SpecialMultiWikiEdit_body.php', 'Multiwikiedit', 'Multiwikiedit' );
$wgSpecialPageGroups['Multiwikiedit'] = 'pagetools';
