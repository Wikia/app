<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named MultiWikiDelete.\n";
    exit( 1 ) ;
}

require_once ( dirname(__FILE__) . '/MultiTasksCore.php' );

$wgExtensionCredits['specialpage'][] = array(
    "name" => "Multi Wiki Delete",
    "descriptionmsg" => "multidelete-desc",
    "author" => "Bartek Łapiński, Piotr Molski",
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/MultiTasks'
);

$wgExtensionMessagesFiles["Multidelete"] = dirname(__FILE__) . '/MultiTasks.i18n.php';
$wgExtensionMessagesFiles['MultideleteAliases'] = __DIR__ . '/MultiTasks.aliases.php';

extAddSpecialPage( dirname(__FILE__) . '/SpecialMultiDelete_body.php', 'Multidelete', 'Multidelete' );

require_once( $IP . "/extensions/wikia/TaskManager/BatchTask.php" );

$wgSpecialPageGroups['Multidelete'] = 'pagetools';
