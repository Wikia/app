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
	'author' => array('Andrzej Łukaszewski'),
	'url' => 'http://www.wikia.com',
	'descriptionmsg' => 'wall-desc',
);

$dir = dirname(__FILE__);

$app->registerClass('WallDisabledHooksHelper', $dir . '/WallDisabledHooksHelper.class.php');

$app->registerHook('AfterEditPermissionErrors', 'WallDisabledHooksHelper', 'onAfterEditPermissionErrors');