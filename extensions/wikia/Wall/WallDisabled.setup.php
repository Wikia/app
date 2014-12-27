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
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Wall',
	'descriptionmsg' => 'wall-disabled-desc',
);

$dir = dirname( __FILE__ );

$wgExtensionMessagesFiles['Wall'] = $dir . '/Wall.i18n.php';
$wgAutoloadClasses['WallDisabledHooksHelper'] =  $dir . '/WallDisabledHooksHelper.class.php';

// don't let others edit wall messages after turning wall on and off
$wgHooks['AfterEditPermissionErrors'][] = 'WallDisabledHooksHelper::onAfterEditPermissionErrors';
include( $dir . '/WallNamespaces.php' );