<?php

/**
 * Prototype handler
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @date 2011-12-19
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['media'][] = array(
	'name' => 'PrototypeVideoHandler',
	'version' => '0.1',
	'author' => array(
		'Jakub Kurcek' ),
	'descriptionmsg' => 'prototype-videohandler-extension-desc'
);

$dir = dirname( __FILE__ );

$app->registerClass('PrototypeVideoHandler', $dir . '/handlers/PrototypeVideoHandler.class.php');

$wgMediaHandlers['video/prototype'] = 'PrototypeVideoHandler';