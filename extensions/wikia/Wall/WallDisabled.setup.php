<?php
/**
 * Wall
 *
 * User Message Wall for MediaWiki
 *
 * @author Sean Colombo <sean@wikia-inc.com>, Christian Williams <christian@wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'User Wall - disabled',
	'author' => array( 'Tomek Odrobny', 'Andrzej Łukaszewski', 'Piotr Bablok' ),
	'url' => 'http://www.wikia.com',
	'descriptionmsg' => 'wall-disabled-desc',
);

$dir = dirname(__FILE__);

$app->registerClass('WallDisabledHooksHelper', $dir . '/WallDisabledHooksHelper.class.php');

// register task in task manager
if (function_exists( "extAddBatchTask" ) ) {
	extAddBatchTask(dirname(__FILE__)."/WallCopyFollowsTask.class.php", "wallcopyfollows", "WallCopyFollowsTask");
}

// Notifications are required on NonWall Wikis in order to show proper
// lower-left corner notification bubbles from Wall Wikis
$app->registerClass('WallHelper', $dir . '/WallHelper.class.php');
$app->registerClass('WallMessage', $dir . '/WallMessage.class.php');
include($dir . '/WallNotifications.setup.php');


//don't let others edit wall messages after turning wall on and off
$app->registerHook('AfterEditPermissionErrors', 'WallDisabledHooksHelper', 'onAfterEditPermissionErrors');

//add hook for displaying Notification Bubbles for NonWall wikis FROM Wall wikis
$app->registerHook('UserRetrieveNewTalks', 'WallDisabledHooksHelper', 'onUserRetrieveNewTalks');

//wikifactory/wikifeatures
//$app->registerHook('WikiFactoryChanged', 'WallDisabledHooksHelper', 'onWikiFactoryChanged');
$app->registerHook('DismissWikiaNewtalks', 'WallDisabledHooksHelper', 'onDismissWikiaNewtalks');


//watchlist
//$app->registerHook('WatchArticle', 'WallDisabledHooksHelper', 'onWatchArticle');
//$app->registerHook('UnwatchArticle', 'WallDisabledHooksHelper', 'onUnwatchArticle');

include($dir . '/WallNamespaces.php');