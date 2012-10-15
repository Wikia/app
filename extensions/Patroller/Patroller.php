<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Extension adds improved patrolling interface
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Patroller',
	'version' => '1.0rc3',
	'author' => 'Rob Church',
	'descriptionmsg' => 'patrol-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Patroller',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Patroller'] = $dir . 'Patroller.i18n.php';
$wgExtensionMessagesFiles['PatrollerAlias'] = $dir . 'Patroller.alias.php';
$wgAutoloadClasses['Patroller'] = $dir . 'Patroller.class.php';
$wgSpecialPages['Patrol'] = 'Patroller';

$wgAvailableRights[] = 'patroller';
$wgGroupPermissions['sysop']['patroller'] = true;
$wgGroupPermissions['patroller']['patroller'] = true;
