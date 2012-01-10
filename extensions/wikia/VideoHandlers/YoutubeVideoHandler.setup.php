<?php

/**
 * Prototype handler
 *
 * @author William Lee <wlee at wikia-inc.com>
 * @date 2012-01-05
 * @copyright Copyright (C) 2012 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['media'][] = array(
	'name' => 'YoutubeVideoHandler',
	'version' => '0.1',
	'author' => array(
		'Jakub Kurcek', 'William Lee' ),
	'descriptionmsg' => 'youtube-videohandler-extension-desc'
);

$dir = dirname( __FILE__ );

$app->registerClass('YoutubeVideoHandler', $dir . '/handlers/YoutubeVideoHandler.class.php');
$app->registerClass('YoutubeApiWrapper', $dir . '/apiwrappers/YoutubeApiWrapper.class.php');

$wgMediaHandlers['video/youtube'] = 'YoutubeVideoHandler';