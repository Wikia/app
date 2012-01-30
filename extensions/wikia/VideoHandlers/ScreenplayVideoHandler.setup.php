<?php

/**
 * Screenplay handler
 *
 * @author William Lee <wlee at wikia-inc.com>
 * @date 2012-01-24
 * @copyright Copyright (C) 2012 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['media'][] = array(
	'name' => 'ScreenplayVideoHandler',
	'version' => '0.1',
	'author' => array(
		'William Lee' ),
	'descriptionmsg' => 'screenplay-videohandler-extension-desc'
);

$dir = dirname( __FILE__ );

$app->registerClass('ScreenplayVideoHandler', $dir . '/handlers/ScreenplayVideoHandler.class.php');
$app->registerClass('ScreenplayApiWrapper', $dir . '/apiwrappers/ScreenplayApiWrapper.class.php');

$wgMediaHandlers['video/screenplay'] = 'ScreenplayVideoHandler';