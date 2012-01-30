<?php

/**
 * BlipTV Video handler
 *
 * @author Jacek Jursza <jacek at wikia-inc.com>
 * @date 2012-01-23
 * @copyright Copyright (C) 2012 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['media'][] = array(
	'name' => 'BliptvVideoHandler',
	'version' => '0.1',
	'author' => array(
		'Jacek Jursza' ),
	'descriptionmsg' => 'bliptv-videohandler-extension-desc'
);

$dir = dirname( __FILE__ );

$app->registerClass('BliptvVideoHandler', $dir . '/handlers/BliptvVideoHandler.class.php');
$app->registerClass('BliptvApiWrapper', $dir . '/apiwrappers/BliptvApiWrapper.class.php');

$wgMediaHandlers['video/bliptv'] = 'BliptvVideoHandler';